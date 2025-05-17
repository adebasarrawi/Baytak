<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use App\Models\Area;
use App\Models\Governorate;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    /**
     * Check if user is admin
     *
     * @return bool
     */
    private function userIsAdmin()
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }
    
    /**
     * Check if user can manage the property
     *
     * @param Property $property
     * @return bool
     */
    private function canManageProperty(Property $property)
    {
        return Auth::id() === $property->user_id || $this->userIsAdmin();
    }

    /**
     * Display property listings with enhanced search capabilities
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Base query with eager loading for performance
        $query = Property::with(['type', 'area.governorate', 'images', 'features', 'user'])
            ->where('status', 'approved'); // Only show approved properties
        
        // Apply filters based on request parameters
        
        // Filter by property type
        if ($request->filled('property_type')) {
            $query->where('property_type_id', $request->property_type);
        }
        
        // Filter by purpose (sale or rent)
        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }
        
        // Filter by governorate
        if ($request->filled('governorate_id')) {
            $governorateId = $request->governorate_id;
            $query->whereHas('area', function($q) use ($governorateId) {
                $q->where('governorate_id', $governorateId);
            });
        }
        
        // Filter by area
        if ($request->filled('area_id')) {
            $query->where('area_id', $request->area_id);
        }
        
        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Filter by bedrooms
        if ($request->filled('bedrooms')) {
            $query->where('bedrooms', '>=', $request->bedrooms);
        }
        
        // Filter by bathrooms
        if ($request->filled('bathrooms')) {
            $query->where('bathrooms', '>=', $request->bathrooms);
        }
        
        // Filter by property size
        if ($request->filled('min_size')) {
            $query->where('size', '>=', $request->min_size);
        }
        
        if ($request->filled('max_size')) {
            $query->where('size', '<=', $request->max_size);
        }
        
        // Filter by year built
        if ($request->filled('year_built')) {
            $query->where('year_built', $request->year_built);
        }
        
        // Filter by features
        if ($request->filled('feature_id')) {
            $featureId = $request->feature_id;
            $query->whereHas('features', function($q) use ($featureId) {
                $q->where('features.id', $featureId);
            });
        }
        
        // Advanced search by keywords (title, description, address)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhereHas('area', function($subq) use ($search) {
                      $subq->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('area.governorate', function($subq) use ($search) {
                      $subq->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Sort properties (featured first, then by creation date)
        $query->orderBy('is_featured', 'desc')
              ->orderBy('created_at', 'desc');
        
        // Get paginated results
        $properties = $query->paginate(12);
        
        // Get data for filter dropdowns
        $propertyTypes = PropertyType::all();
        $governorates = Governorate::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();
        
        return view('public.properties', compact(
            'properties', 
            'propertyTypes', 
            'governorates', 
            'areas',
            'features'
        ));
    }
    
    /**
     * Show property details
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\View\View
     */
    public function show(Property $property)
    {
        // Load relationships for the property
        $property->load(['type', 'area.governorate', 'images', 'features', 'user']);
        
        // Only show approved properties to public
        if ($property->status !== 'approved' && !$this->canManageProperty($property)) {
            abort(404);
        }
        
        // Increment view counter
        $property->increment('views');
        
        // Get similar properties based on area and property type
        $similarProperties = Property::with(['images', 'area'])
            ->where('id', '!=', $property->id)
            ->where('status', 'approved')
            ->where(function($q) use ($property) {
                $q->where('area_id', $property->area_id)
                  ->orWhere('property_type_id', $property->property_type_id);
            })
            ->orderBy('is_featured', 'desc')
            ->take(3)
            ->get();
        
        return view('properties.show', compact('property', 'similarProperties'));
    }
    
    /**
     * Show form to create new property
     * 
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login', ['redirect' => 'properties/create'])
                ->with('error', 'You must be logged in to create a property listing.');
        }
        
        // Check if user is a seller
        if (Auth::user()->user_type !== 'seller') {
            // If user is regular user
            if (Auth::user()->user_type === 'user') {
                return redirect()->route('seller.payment')
                    ->with('info', 'To list properties, you need to complete your seller registration.');
            } 
            // If user is pending seller
            elseif (Auth::user()->user_type === 'pending_seller') {
                return redirect()->route('seller.payment')
                    ->with('info', 'You need to complete the payment to activate your seller account.');
            }
        }
        
        // Get data for form dropdowns
        $propertyTypes = PropertyType::all();
        $governorates = Governorate::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();
        
        return view('properties.create', compact('propertyTypes', 'governorates', 'areas', 'features'));
    }
    
    /**
     * Store new property in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to create a property listing.');
        }
        
        // Check if user is a seller
        if (Auth::user()->user_type !== 'seller') {
            return redirect()->route('seller.payment')
                ->with('error', 'You need to complete your seller registration first.');
        }
        
        // Validate request
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'size' => 'required|numeric',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'parking_spaces' => 'nullable|integer',
            'year_built' => 'nullable|integer|min:1900|max:' . date('Y'),
            'property_type_id' => 'required|exists:property_types,id',
            'area_id' => 'required|exists:areas,id',
            'address' => 'required|string',
            'purpose' => 'required|in:sale,rent',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create property
        $property = Property::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'size' => $validated['size'],
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'parking_spaces' => $request->parking_spaces,
            'year_built' => $request->year_built,
            'property_type_id' => $validated['property_type_id'],
            'area_id' => $validated['area_id'],
            'address' => $validated['address'],
            'purpose' => $validated['purpose'],
            'slug' => Str::slug($validated['title'] . '-' . uniqid()),
            'status' => 'pending', // Set status to pending
            'is_featured' => false
        ]);
        
        // Attach features if provided
        if ($request->has('features')) {
            $property->features()->attach($request->features);
        }
        
        // Process uploaded images - first image will be primary
        if ($request->hasFile('images')) {
            $this->uploadPropertyImages($property, $request->file('images'));
        }

        return redirect()->route('properties.my')
            ->with('success', 'Property submitted for approval. You will be notified once it is reviewed.');
    }
    
    /**
     * Show form to edit property
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit(Property $property)
    {
        // Check if current user is authorized to edit this property
        if (!$this->canManageProperty($property)) {
            return redirect()->route('properties.index')
                ->with('error', 'You are not authorized to edit this property.');
        }
        
        // Load property with its relationships
        $property->load(['features']);
        
        // Get data for form dropdowns
        $propertyTypes = PropertyType::all();
        $governorates = Governorate::orderBy('name')->get();
        $areas = Area::orderBy('name')->get();
        $features = Feature::orderBy('name')->get();
        
        // Get the property's current features IDs for pre-selection
        $selectedFeatures = $property->features->pluck('id')->toArray();
        
        return view('properties.edit', compact(
            'property', 
            'propertyTypes', 
            'governorates', 
            'areas', 
            'features',
            'selectedFeatures'
        ));
    }
    
    /**
     * Update property in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Property $property)
    {
        // Check if current user is authorized to update this property
        if (!$this->canManageProperty($property)) {
            return redirect()->route('properties.index')
                ->with('error', 'You are not authorized to update this property.');
        }
        
        // Validate request
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'size' => 'required|numeric',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'parking_spaces' => 'nullable|integer',
            'year_built' => 'nullable|integer|min:1900|max:' . date('Y'),
            'property_type_id' => 'required|exists:property_types,id',
            'area_id' => 'required|exists:areas,id',
            'address' => 'required|string',
            'purpose' => 'required|in:sale,rent',
            'features' => 'nullable|array',
            'features.*' => 'exists:features,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_image' => 'nullable|integer'
        ]);

        // Update property
        $property->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'size' => $validated['size'],
            'bedrooms' => $validated['bedrooms'],
            'bathrooms' => $validated['bathrooms'],
            'parking_spaces' => $request->parking_spaces,
            'year_built' => $request->year_built,
            'property_type_id' => $validated['property_type_id'],
            'area_id' => $validated['area_id'],
            'address' => $validated['address'],
            'purpose' => $validated['purpose'],
            'status' => $this->userIsAdmin() ? $property->status : 'pending', // Reset to pending only if not admin
        ]);
        
        // Update features (sync will remove old ones and add new ones)
        if ($request->has('features')) {
            $property->features()->sync($request->features);
        } else {
            // If no features selected, detach all
            $property->features()->detach();
        }
        
        // Handle new image uploads if provided
        if ($request->hasFile('images')) {
            $this->uploadPropertyImages($property, $request->file('images'));
        }
        
        // If only primary image was changed (no new uploads)
        elseif ($request->filled('primary_image')) {
            $this->updatePrimaryImage($property, $request->primary_image);
        }

        return redirect()->route('properties.my')
            ->with('success', 'Property updated successfully and is pending approval.');
    }
    
    /**
     * Show seller's properties
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function myProperties()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to view your properties.');
        }
        
        // Get all properties belonging to the current user
        $properties = Property::with(['type', 'area', 'images'])
                    ->where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->paginate(8);
        
        return view('properties.my', compact('properties'));
    }
    
    /**
     * Delete specific property
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Property $property)
    {
        // Check if current user is authorized to delete this property
        if (!$this->canManageProperty($property)) {
            return redirect()->route('properties.index')
                ->with('error', 'You are not authorized to delete this property.');
        }
        
        // Delete all associated images from storage
        foreach ($property->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }
        
        // Delete property (images will be cascade deleted due to foreign key constraints)
        $property->delete();
        
        return redirect()->route('properties.my')
            ->with('success', 'Property deleted successfully.');
    }
    
    /**
     * Delete specific image
     *
     * @param  int  $imageId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteImage($imageId)
    {
        $image = PropertyImage::findOrFail($imageId);
        
        // Check if current user owns this property
        $property = $image->property;
        
        if (!$this->canManageProperty($property)) {
            return redirect()->back()
                ->with('error', 'You are not authorized to delete this image.');
        }
        
        // Check if this is the only image
        if ($property->images->count() <= 1) {
            return redirect()->back()
                ->with('error', 'Cannot delete the only image. Properties must have at least one image.');
        }
        
        // Get file path
        $filePath = $image->image_path;
        
        // If this is the primary image, set another image as primary
        if ($image->is_primary) {
            $nextImage = $property->images()->where('id', '!=', $image->id)->first();
            if ($nextImage) {
                $nextImage->update(['is_primary' => true]);
            }
        }
        
        // Delete from storage if file exists
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
        
        // Delete from database
        $image->delete();
        
        return back()->with('success', 'Image deleted successfully.');
    }
    
    /**
     * Helper method to handle image uploads
     *
     * @param  \App\Models\Property  $property
     * @param  array  $images
     * @return void
     */
    private function uploadPropertyImages(Property $property, array $images)
    {
        // Determine if this is the first upload (no existing images)
        $isFirstUpload = $property->images->isEmpty();
        $i = $property->images->count();
        
        foreach ($images as $image) {
            // Generate a filename based on property ID and timestamp
            $filename = 'property_' . $property->id . '_' . time() . '_' . $i . '.' . $image->getClientOriginalExtension();
            
            // Store image in storage/app/public/properties/images
            $path = $image->storeAs('properties/images', $filename, 'public');
            
            // Create image record
            $property->images()->create([
                'image_path' => $path,
                'is_primary' => ($isFirstUpload && $i === 0), // First image is primary only if no images existed before
                'sort_order' => $i
            ]);
            
            $i++;
        }
    }
    
    /**
     * Helper method to update primary image
     *
     * @param  \App\Models\Property  $property
     * @param  int  $primaryImageId
     * @return void
     */
    private function updatePrimaryImage(Property $property, $primaryImageId)
    {
        // Reset all images to non-primary
        $property->images()->update(['is_primary' => false]);
        
        // Set selected image as primary
        if (is_numeric($primaryImageId)) {
            $property->images()->where('id', $primaryImageId)->update(['is_primary' => true]);
        }
    }
}
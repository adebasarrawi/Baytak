<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

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
     * Display property listings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Base query
        $query = Property::with(['type', 'area', 'images', 'features'])
            ->where('status', 'approved'); // Only show approved properties
        
        // Apply filters if provided
        if ($request->filled('property_type')) {
            $query->where('property_type_id', $request->property_type);
        }
        
        if ($request->filled('purpose')) {
            $query->where('purpose', $request->purpose);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        // Order properties
        $query->orderBy('is_featured', 'desc')
              ->orderBy('created_at', 'desc');
        
        // Get paginated results
        $properties = $query->paginate(12);
        
        // Get property types for filter
        $propertyTypes = PropertyType::all();
        
        return view('public.properties', compact('properties', 'propertyTypes'));
    }
    
    /**
     * Show property details
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\View\View
     */
    public function show(Property $property)
    {
        // Load relationships
        $property->load(['type', 'area', 'images', 'features', 'user']);
        
        // Only show approved properties to public
        if ($property->status !== 'approved' && !$this->canManageProperty($property)) {
            abort(404);
        }
        
        // Increment view counter
        $property->increment('views');
        
        return view('properties.show', compact('property'));
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
        
        $propertyTypes = PropertyType::all();
        $areas = Area::all();
        
        return view('properties.create', compact('propertyTypes', 'areas'));
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
            'property_type_id' => 'required|exists:property_types,id',
            'area_id' => 'required|exists:areas,id',
            'address' => 'required|string',
            'purpose' => 'required|in:sale,rent',
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
            'property_type_id' => $validated['property_type_id'],
            'area_id' => $validated['area_id'],
            'address' => $validated['address'],
            'purpose' => $validated['purpose'],
            'slug' => Str::slug($validated['title'] . '-' . uniqid()),
            'status' => 'pending', // Set status to pending
            'is_featured' => false
        ]);
        
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
        
        $propertyTypes = PropertyType::all();
        $areas = Area::all();
        
        return view('properties.edit', compact('property', 'propertyTypes', 'areas'));
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
            'property_type_id' => 'required|exists:property_types,id',
            'area_id' => 'required|exists:areas,id',
            'address' => 'required|string',
            'purpose' => 'required|in:sale,rent',
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
            'property_type_id' => $validated['property_type_id'],
            'area_id' => $validated['area_id'],
            'address' => $validated['address'],
            'purpose' => $validated['purpose'],
            'status' => 'pending', // Reset to pending when updated
        ]);
        
        // Handle new image uploads if provided
        if ($request->hasFile('images')) {
            $this->uploadPropertyImages($property, $request->file('images'));
        }
        
        // If only primary image was changed (no new uploads)
        elseif (isset($validated['primary_image'])) {
            $this->updatePrimaryImage($property, $validated['primary_image']);
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
        $properties = Property::where('user_id', Auth::id())
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
        
        // Get file path
        $filePath = $image->image_path;
        
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
        $i = 0;
        foreach ($images as $image) {
            // Store image in storage/app/public/properties/images
            $path = $image->store('properties/images', 'public');
            
            // Create image record
            $property->images()->create([
                'image_path' => $path,
                'is_primary' => ($i == 0), // First image will be primary
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
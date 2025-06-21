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
use Illuminate\Support\Facades\Log;

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
        $query = Property::with(['type', 'area.governorate', 'images', 'features', 'user'])
        ->where('status', 'approved')
        ->whereNotIn('status', ['archived', 'removed']);
        
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
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Find the property by ID
        $property = Property::findOrFail($id);
        
        // Load relationships for the property
        $property->load(['type', 'area.governorate', 'images', 'features', 'user']);
        
        // Only show approved properties to public
        if ($property->status !== 'approved' && !$this->canManageProperty($property)) {
            abort(404);
        }
        
        // Increment view counter
        $property->increment('views');
        
        // Get similar properties
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
        
        return view('public.property-single', compact('property', 'similarProperties'));
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
            'status' => 'pending',
            'is_featured' => false,
        ]);
        
        // Attach features if provided
        if ($request->has('features')) {
            $property->features()->attach($request->features);
        }
        
        // Process uploaded images
        if ($request->hasFile('images')) {
            $this->uploadPropertyImages($property, $request->file('images'));
        }

        return redirect()->route('properties.my')
            ->with('success', 'Property submitted for approval. You will be notified once it is reviewed.');
    }
    
    /**
     * Show form to edit property
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    

   
    
    public function edit($id)
    {
        try {
            // Find the property by ID
            $property = Property::findOrFail($id);
            
            Log::info('Editing property', [
                'property_id' => $id,
                'user_id' => Auth::id(),
                'property_user_id' => $property->user_id
            ]);
            
            // Check if current user is authorized to edit this property
            if (!$this->canManageProperty($property)) {
                return redirect()->route('properties.index')
                    ->with('error', 'You are not authorized to edit this property.');
            }
            
            // Load property with its relationships properly
            $property->load([
                'features',
                'images' => function($query) {
                    $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
                },
                'type',
                'area.governorate'
            ]);
            
            Log::info('Property loaded with relationships', [
                'features_count' => $property->features->count(),
                'images_count' => $property->images->count(),
                'images_details' => $property->images->map(function($img) {
                    return [
                        'id' => $img->id,
                        'path' => $img->image_path,
                        'is_primary' => $img->is_primary,
                        'sort_order' => $img->sort_order,
                        'file_exists' => Storage::disk('public')->exists($img->image_path)
                    ];
                })
            ]);
            
            // Get data for form dropdowns
            $propertyTypes = PropertyType::orderBy('name')->get();
            $governorates = Governorate::orderBy('name')->get();
            $areas = Area::orderBy('name')->get();
            $features = Feature::orderBy('name')->get();
            
            return view('properties.edit', compact(
                'property', 
                'propertyTypes', 
                'governorates', 
                'areas', 
                'features'
            ));
            
        } catch (\Exception $e) {
            Log::error('Error in edit method', [
                'property_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('properties.my')
                ->with('error', 'Error loading property for editing: ' . $e->getMessage());
        }
    }
    
    /**
     * Update property in database
     *
     
 * Update property in database
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\RedirectResponse
 */
public function update(Request $request, $id)
{
    try {
        Log::info('PropertyController update method called', [
            'property_id' => $id,
            'user_id' => Auth::id(),
            'has_files' => $request->hasFile('images')
        ]);
        
        // Find the property
        $property = Property::findOrFail($id);
        
        // Check authorization
        if (!$this->canManageProperty($property)) {
            return redirect()->route('properties.index')
                ->with('error', 'You are not authorized to update this property.');
        }
        
        // Save original status
        $originalStatus = $property->status;
        
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
        ]);
        
        // Determine new status
        $newStatus = $originalStatus;
        if (!$this->userIsAdmin()) {
            if (in_array($originalStatus, ['approved', 'rejected'])) {
                $newStatus = 'pending';
            }
        }
        
        // Start transaction - بدون foreign key manipulation
        DB::beginTransaction();
        
        try {
            // Update property using Eloquent
            $property->update([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'size' => $validated['size'],
                'bedrooms' => $validated['bedrooms'],
                'bathrooms' => $validated['bathrooms'],
                'parking_spaces' => $validated['parking_spaces'] ?? null,
                'year_built' => $validated['year_built'] ?? null,
                'property_type_id' => $validated['property_type_id'],
                'area_id' => $validated['area_id'],
                'address' => $validated['address'],
                'purpose' => $validated['purpose'],
                'status' => $newStatus,
            ]);
            
            Log::info('Property basic data updated');
            
            // Update features using sync - أسهل وأأمن طريقة
            if ($request->has('features') && is_array($request->features)) {
                $property->features()->sync($request->features);
                Log::info('Features synced', ['count' => count($request->features)]);
            } else {
                $property->features()->sync([]); // Remove all features
                Log::info('All features removed');
            }
            
            // Handle new images if provided
            if ($request->hasFile('images')) {
                $validImages = array_filter($request->file('images'), function($image) {
                    return $image && $image->isValid();
                });
                
                if (!empty($validImages)) {
                    $this->uploadPropertyImages($property, $validImages);
                    Log::info('New images uploaded', ['count' => count($validImages)]);
                }
            }
            
            DB::commit();
            Log::info('Transaction committed successfully');
            
            // Success message
            $statusMessage = '';
            if (!$this->userIsAdmin()) {
                if ($originalStatus === 'approved' && $newStatus === 'pending') {
                    $statusMessage = ' Your property is now pending approval due to the changes made.';
                } elseif ($originalStatus === 'rejected' && $newStatus === 'pending') {
                    $statusMessage = ' Your property is now pending approval after the updates.';
                }
            }
            
            return redirect()->route('properties.my')
                ->with('success', 'Property updated successfully.' . $statusMessage);
                
        } catch (\Exception $innerException) {
            DB::rollBack();
            throw $innerException;
        }
        
    } catch (\Exception $e) {
        Log::error('Property update failed', [
            'property_id' => $id,
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile()
        ]);
        
        return redirect()->back()
            ->with('error', 'An error occurred while updating the property: ' . $e->getMessage())
            ->withInput();
    }
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
        
        // Get all properties belonging to the current user (excluding archived and soft-deleted)
        $properties = Property::with(['type', 'area', 'images'])
                    ->where('user_id', Auth::id())
                    ->where('status', '!=', 'archived')
                    ->orderBy('created_at', 'desc')
                    ->paginate(8);
        
        return view('properties.my', compact('properties'));
    }
    
    /**
     * Delete specific property
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Find the property by ID
        $property = Property::findOrFail($id);
        
        if (!$this->canManageProperty($property)) {
            return redirect()->route('properties.index')
                ->with('error', 'You are not authorized to delete this property.');
        }
        
        try {
            DB::beginTransaction();
            
            // Delete all property images from storage
            foreach ($property->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }
            
            // Delete the property (this will cascade delete images and features due to foreign key constraints)
            $property->delete();
            
            DB::commit();
            
            return redirect()->route('properties.my')
                ->with('success', 'Property deleted successfully.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Property deletion failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'An error occurred while deleting the property. Please try again.');
        }
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
        
        try {
            DB::beginTransaction();
            
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
            
            DB::commit();
            
            return back()->with('success', 'Image deleted successfully.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Image deletion failed: ' . $e->getMessage());
            
            return back()->with('error', 'Failed to delete image. Please try again.');
        }
    }
    
    /**
     * Helper method to handle image uploads
     *
     * @param  \App\Models\Property  $property
     * @param  array  $images
     * @return void
     */
    

    /**
     * Helper method to handle image uploads
     *
    
     */
    /**
 * Helper method to handle image uploads
 *
 * @param  \App\Models\Property  $property
 * @param  array  $images
 * @return void
 */
private function uploadPropertyImages(Property $property, array $images)
{
    try {
        Log::info('Starting image upload', [
            'property_id' => $property->id,
            'new_images_count' => count($images)
        ]);
        
        // Get current images count للترتيب
        $currentImagesCount = $property->images()->count();
        $hasExistingImages = $currentImagesCount > 0;
        
        Log::info('Current property state', [
            'existing_images' => $currentImagesCount,
            'has_primary' => $property->images()->where('is_primary', true)->exists()
        ]);
        
        // Create directory if needed
        if (!Storage::disk('public')->exists('properties/images')) {
            Storage::disk('public')->makeDirectory('properties/images');
        }
        
        $uploadedCount = 0;
        
        foreach ($images as $index => $image) {
            if (!$image || !$image->isValid()) {
                Log::warning('Skipping invalid image', ['index' => $index]);
                continue;
            }
            
            // Generate unique filename
            $filename = 'property_' . $property->id . '_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            // Store image
            $path = $image->storeAs('properties/images', $filename, 'public');
            
            if (!$path) {
                Log::error('Failed to store image', ['filename' => $filename]);
                continue;
            }
            
            // Create image record
            $isPrimary = false;
            // Only set as primary if no existing images AND this is the first new image
            if (!$hasExistingImages && $index === 0) {
                $isPrimary = true;
            }
            
            $imageRecord = new PropertyImage([
                'property_id' => $property->id,
                'image_path' => $path,
                'is_primary' => $isPrimary,
                'sort_order' => $currentImagesCount + $uploadedCount
            ]);
            
            $imageRecord->save();
            
            Log::info('Image uploaded successfully', [
                'image_id' => $imageRecord->id,
                'path' => $path,
                'is_primary' => $isPrimary,
                'sort_order' => $imageRecord->sort_order
            ]);
            
            $uploadedCount++;
        }
        
        Log::info('Image upload completed', [
            'uploaded_count' => $uploadedCount,
            'total_images_now' => $property->images()->count()
        ]);
        
    } catch (\Exception $e) {
        Log::error('Image upload failed', [
            'property_id' => $property->id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        throw $e;
    }
}
    /**
     * Archive a property (mark as sold/not available)
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function archive($id)
    {
        // Find the property by ID
        $property = Property::findOrFail($id);
        
        // Check if current user is authorized to archive this property
        if (!$this->canManageProperty($property)) {
            return redirect()->route('properties.index')
                ->with('error', 'You are not authorized to archive this property.');
        }
        
        // Update property status to archived
        $property->update([
            'status' => 'archived',
            'archived_at' => now()
        ]);
        
        return redirect()->route('properties.my')
            ->with('success', 'Property has been archived successfully. It will no longer appear in public listings.');
    }
    
    /**
     * Unarchive a property (make available again)
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unarchive($id)
    {
        // Find the property by ID
        $property = Property::findOrFail($id);
        
        // Check if current user is authorized to unarchive this property
        if (!$this->canManageProperty($property)) {
            return redirect()->route('properties.index')
                ->with('error', 'You are not authorized to unarchive this property.');
        }
        
        // Update property status back to pending (will require admin approval again)
        $property->update([
            'status' => 'pending',
            'archived_at' => null
        ]);
        
        return redirect()->route('properties.my')
            ->with('success', 'Property has been unarchived and is now pending approval again.');
    }
    
    /**
     * Show seller's archived properties
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function archivedProperties()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'You must be logged in to view your archived properties.');
        }
        
        // Get all archived properties belonging to the current user
        $properties = Property::with(['type', 'area', 'images'])
                    ->where('user_id', Auth::id())
                    ->where('status', 'archived')
                    ->orderBy('archived_at', 'desc')
                    ->paginate(8);
        
        return view('properties.archived', compact('properties'));
    }
}
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

class PropertyController extends Controller
{
    /**
     * دالة للتحقق ما إذا كان المستخدم مدير النظام
     *
     * @return bool
     */
    private function userIsAdmin()
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }
    
    /**
     * دالة للتحقق ما إذا كان المستخدم مخول للتعديل على العقار
     *
     * @param Property $property
     * @return bool
     */
    private function canManageProperty(Property $property)
    {
        return Auth::id() === $property->user_id || $this->userIsAdmin();
    }

    public function index(Request $request)
    {
        // Create a query builder
        $query = Property::with(['type', 'area', 'images', 'features'])
            ->where('is_approved', true);
        
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
    
    public function show(Property $property)
    {
        // Load relationships
        $property->load(['type', 'area', 'images', 'features', 'user']);
        
        // Increment view count
        $property->increment('views');
        
        return view('properties.show', compact('property'));
    }
    
    public function create()
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a property listing.');
        }
        
        $propertyTypes = PropertyType::all();
        $areas = Area::all();
        
        return view('properties.create', compact('propertyTypes', 'areas'));
    }
    
    public function store(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a property listing.');
        }
        
        // Validate the request
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
            'primary_image' => 'required|integer|min:0'
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
            'is_approved' => false, // Needs admin approval
            'is_featured' => false
        ]);
        
        // Process uploaded images
        $this->uploadPropertyImages($property, $request->file('images'), $validated['primary_image']);

        return redirect()->route('properties.index')->with('success', 'Property created successfully and awaiting approval.');
    }
    
    public function edit(Property $property)
    {
        // Check if the current user is authorized to edit this property
        if (!$this->canManageProperty($property)) {
            return redirect()->route('properties.index')->with('error', 'You are not authorized to edit this property.');
        }
        
        $propertyTypes = PropertyType::all();
        $areas = Area::all();
        
        return view('properties.edit', compact('property', 'propertyTypes', 'areas'));
    }
    
    public function update(Request $request, Property $property)
    {
        // Check if the current user is authorized to update this property
        if (!$this->canManageProperty($property)) {
            return redirect()->route('properties.index')->with('error', 'You are not authorized to update this property.');
        }
        
        // Validate the request
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
        ]);
        
        // Handle image uploads if new images were provided
        if ($request->hasFile('images')) {
            $this->uploadPropertyImages($property, $request->file('images'), $validated['primary_image'] ?? null);
        }
        
        // If only primary image was changed (no new uploads)
        elseif (isset($validated['primary_image'])) {
            $this->updatePrimaryImage($property, $validated['primary_image']);
        }

        return redirect()->route('properties.show', $property)->with('success', 'Property updated successfully.');
    }
    
    // Helper method to handle image uploads
    private function uploadPropertyImages(Property $property, array $images, $primaryImageIndex)
    {
        $i = 0;
        foreach ($images as $image) {
            // Store the image in the storage/app/public/properties/images directory
            $path = $image->store('properties/images', 'public');
            
            // Create the image record
            $property->images()->create([
                'image_path' => $path,
                'is_primary' => ($i == $primaryImageIndex),
                'sort_order' => $i
            ]);
            
            $i++;
        }
    }
    
    // Helper method to update the primary image
    private function updatePrimaryImage(Property $property, $primaryImageId)
    {
        // Reset all images to non-primary
        $property->images()->update(['is_primary' => false]);
        
        // Set the selected image as primary
        if (is_numeric($primaryImageId)) {
            $property->images()->where('id', $primaryImageId)->update(['is_primary' => true]);
        }
    }
    
    // Method to delete a specific image
    public function deleteImage($imageId)
    {
        $image = PropertyImage::findOrFail($imageId);
        
        // Check if the current user is the owner of this property
        $property = $image->property;
        
        if (!$this->canManageProperty($property)) {
            return redirect()->back()->with('error', 'You are not authorized to delete this image.');
        }
        
        // Get the file path
        $filePath = $image->image_path;
        
        // Delete from storage if file exists
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
        
        // Delete from database
        $image->delete();
        
        return back()->with('success', 'Image deleted successfully.');
    }
    
    public function destroy(Property $property)
    {
        // Check if the current user is authorized to delete this property
        if (!$this->canManageProperty($property)) {
            return redirect()->route('properties.index')->with('error', 'You are not authorized to delete this property.');
        }
        
        // Delete all associated images from storage
        foreach ($property->images as $image) {
            if (Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }
        
        // Delete the property (will cascade delete images due to foreign key constraints)
        $property->delete();
        
        return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
    }
}
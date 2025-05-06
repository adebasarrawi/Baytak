<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PropertyImageController extends Controller
{
    /**
     * Display the property image management page
     */
    public function manage(Property $property)
    {
        // Check permissions
        if (Auth::id() !== $property->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('properties.show', $property)
                ->with('error', 'You do not have permission to manage images for this property');
        }
        
        return view('properties.manage-images', compact('property'));
    }
    
    /**
     * Upload new images to the property
     */
    public function upload(Request $request, Property $property)
    {
        // Check permissions
        if (Auth::id() !== $property->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('properties.show', $property)
                ->with('error', 'You do not have permission to manage images for this property');
        }
        
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'primary_image' => 'nullable|string'
        ]);
        
        // Upload new images
        $i = 0;
        foreach ($request->file('images') as $image) {
            // Store the image in the storage folder
            $path = $image->store('properties/images', 'public');
            
            // Create a new record in the PropertyImage table
            $property->images()->create([
                'image_path' => $path,
                'is_primary' => ($request->primary_image === 'new' && $i === 0), // First image is primary if "new" is selected
                'sort_order' => $property->images->count() + $i  // Sort new images after existing ones
            ]);
            
            $i++;
        }
        
        // Update primary image if required
        if ($request->primary_image !== 'new' && is_numeric($request->primary_image)) {
            // Reset all images to non-primary
            $property->images()->update(['is_primary' => false]);
            
            // Set the selected image as primary
            PropertyImage::find($request->primary_image)->update(['is_primary' => true]);
        }
        
        return redirect()->route('properties.show', $property)
            ->with('success', 'Images uploaded successfully');
    }
    
    /**
     * Delete a specific image
     */
    public function destroy(PropertyImage $image)
    {
        $property = $image->property;
        
        // Check permissions
        if (Auth::id() !== $property->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('properties.show', $property)
                ->with('error', 'You do not have permission to delete images from this property');
        }
        
        // Save the is_primary value before deletion
        $wasPrimary = $image->is_primary;
        
        // Delete the file from storage
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        // Delete the record from the database
        $image->delete();
        
        // If the deleted image was the primary one, set another one as primary
        if ($wasPrimary && $property->images->count() > 0) {
            $property->images->first()->update(['is_primary' => true]);
        }
        
        return redirect()->back()->with('success', 'Image deleted successfully');
    }
    
    /**
     * Set an image as the primary image
     */
    public function setPrimary(PropertyImage $image)
    {
        $property = $image->property;
        
        // Check permissions
        if (Auth::id() !== $property->user_id && Auth::user()->role !== 'admin') {
            return redirect()->route('properties.show', $property)
                ->with('error', 'You do not have permission to modify images for this property');
        }
        
        // Reset all images to non-primary
        $property->images()->update(['is_primary' => false]);
        
        // Set the selected image as primary
        $image->update(['is_primary' => true]);
        
        return redirect()->back()->with('success', 'Primary image set successfully');
    }
    
    /**
     * Update image order
     */
    public function updateOrder(Request $request, Property $property)
    {
        // Check permissions
        if (Auth::id() !== $property->user_id && Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:property_images,id'
        ]);
        
        // Update the order of each image
        foreach ($request->order as $index => $imageId) {
            PropertyImage::find($imageId)->update(['sort_order' => $index]);
        }
        
        return response()->json(['success' => true]);
    }
}
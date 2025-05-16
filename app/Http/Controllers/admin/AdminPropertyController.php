<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Models\PropertyType;
use App\Models\Area;
use Illuminate\Support\Facades\Mail;
use App\Mail\PropertyStatusChanged;
use Illuminate\Support\Facades\Log;

class AdminPropertyController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');
        
        $query = Property::query()
            ->with(['user', 'type', 'area', 'images'])
            ->orderBy('created_at', 'desc');
        
        if ($status) {
            $query->where('status', $status);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $properties = $query->paginate(10);
        
        $statusCounts = [
            'pending' => Property::where('status', 'pending')->count(),
            'approved' => Property::where('status', 'approved')->count(),
            'rejected' => Property::where('status', 'rejected')->count(),
        ];
        
        return view('admin.properties.index', compact('properties', 'statusCounts', 'status', 'search'));
    }
    
    public function edit(Property $property)
    {
        return view('admin.properties.edit', compact('property'));
    }
    
    public function updateStatus(Request $request, Property $property)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'rejection_reason' => 'nullable|required_if:status,rejected|string'
        ]);
    
        $oldStatus = $property->status;
        $property->update([
            'status' => $validated['status'],
            'rejection_reason' => $validated['rejection_reason'] ?? null,
            'is_approved' => $validated['status'] === 'approved' 
        ]);
    
     
        return redirect()->back()->with('success', 'Property status updated successfully');
    }
    
    public function destroy(Property $property)
    {
        $property->delete();
        
        return redirect()->route('admin.properties.index')
            ->with('success', 'Property deleted successfully');
    }
    
}
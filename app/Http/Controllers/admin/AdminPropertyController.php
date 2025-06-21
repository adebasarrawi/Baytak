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
use Illuminate\Support\Facades\Storage;


class AdminPropertyController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');
        
        // عرض العقارات غير المحذوفة فقط
        $query = Property::query()
            ->with(['user', 'type', 'area', 'images'])
            ->whereNull('deleted_at') // إضافة هذا الشرط
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
            'pending' => Property::whereNull('deleted_at')->where('status', 'pending')->count(),
            'approved' => Property::whereNull('deleted_at')->where('status', 'approved')->count(),
            'rejected' => Property::whereNull('deleted_at')->where('status', 'rejected')->count(),
        ];
        
        return view('admin.properties.index', compact('properties', 'statusCounts', 'status', 'search'));
    }
    
    // صفحة المحذوفات (Trash)
    public function trash(Request $request)
    {
        $search = $request->query('search');
        
        $query = Property::onlyTrashed()
            ->with(['user', 'type', 'area', 'images'])
            ->orderBy('deleted_at', 'desc');
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $properties = $query->paginate(10);
        
        $trashCount = Property::onlyTrashed()->count();
        
        return view('admin.properties.trash', compact('properties', 'trashCount', 'search'));
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

    // Soft Delete
    public function destroy(Property $property)
    {
        $property->delete(); // سيكون Soft Delete
        
        return redirect()->route('admin.properties.index')
            ->with('success', 'Property moved to trash successfully');
    }
    
    // استعادة العقار من المحذوفات
    public function restore($id)
    {
        $property = Property::onlyTrashed()->findOrFail($id);
        $property->restore();
        
        return redirect()->back()
            ->with('success', 'Property restored successfully');
    }
    
    // حذف نهائي
    public function forceDelete($id)
    {
        $property = Property::onlyTrashed()->findOrFail($id);
        
        // حذف الصور المرتبطة
        if ($property->images) {
            foreach ($property->images as $image) {
                // حذف الملف من التخزين
                Storage::delete('public/' . $image->image_path);
                $image->delete();
            }
        }
        
        $property->forceDelete(); // حذف نهائي
        
        return redirect()->back()
            ->with('success', 'Property permanently deleted');
    }
}
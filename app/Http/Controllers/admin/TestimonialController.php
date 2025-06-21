<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    // إظهار جميع التيستمونيال
    public function index()
    {
        $testimonials = Testimonial::with('area')->latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    // عرض تفاصيل التيستمونيال
    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    // تفعيل/تعطيل التيستمونيال
    public function toggleStatus(Testimonial $testimonial)
    {
        $testimonial->is_active = !$testimonial->is_active;
        $testimonial->save();

        $statusMessage = $testimonial->is_active ? 'approved' : 'unapproved';
        
        return redirect()->route('admin.testimonials.index')
            ->with('success', "Testimonial has been {$statusMessage} successfully.");
    }
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
    
        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial has been removed successfully.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use App\Models\Area;
use App\Models\Governorate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewTestimonialSubmitted;

class TestimonialController extends Controller
{
    /**
     * Display the testimonial submission form
     */
    public function showForm()
    {
        $governorates = Governorate::with('areas')->orderBy('name')->get();
        return view('public.testimonials.submit', compact('governorates'));
    }

    /**
     * Store a newly created testimonial from public
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'position' => 'nullable|string|max:255',
            'content' => 'required|string|min:10|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'area_id' => 'nullable|exists:areas,id',
            'image' => 'nullable|image|max:2048', // 2MB max
            'consent' => 'required|accepted',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('testimonials', 'public');
            $validated['image_path'] = $path;
        }

        // Set testimonial to inactive by default (needs admin approval)
        $validated['is_active'] = false;
        
        // Remove consent and email from database storage
        unset($validated['consent']);
        $email = $validated['email'];
        unset($validated['email']);
        
        // Create testimonial
        $testimonial = Testimonial::create($validated);

        // Send notification to admin
        try {
            // Get admin users or specific admin role
            $admins = \App\Models\User::where('role', 'admin')->get();
            
            // Check if there are admins to notify
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new NewTestimonialSubmitted($testimonial, $email));
            }
        } catch (\Exception $e) {
            // Log error but don't fail the testimonial submission
            \Illuminate\Support\Facades\Log::error('Failed to send testimonial notification: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Your testimonial has been submitted successfully and is awaiting approval. Thank you for sharing your experience!');
    }
}
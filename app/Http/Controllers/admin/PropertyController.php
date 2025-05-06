<?php
// app/Http/Controllers/Admin/PropertyController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Notifications\PropertyApproved;
use App\Notifications\PropertyRejected;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin'); // You should create an AdminMiddleware
    }

    /**
     * Display a listing of pending properties.
     *
     * @return \Illuminate\View\View
     */
    public function pendingProperties()
    {
        $properties = Property::where('is_approved', false)
            ->with('user', 'type', 'area')
            ->latest()
            ->paginate(15);
            
        return view('admin.properties.pending', compact('properties'));
    }

    /**
     * Approve a property.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approveProperty(Property $property)
    {
        $property->is_approved = true;
        $property->save();
        
        // Create the notifications first:
        // php artisan make:notification PropertyApproved
        // php artisan make:notification PropertyRejected
        
        // Send notification to seller
        $property->user->notify(new PropertyApproved($property));
        
        return back()->with('success', 'Property approved successfully.');
    }

    /**
     * Reject a property.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rejectProperty(Request $request, Property $property)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);
        
        $property->rejection_reason = $request->reason;
        $property->save();
        
        // Send notification to seller
        $property->user->notify(new PropertyRejected($property));
        
        return back()->with('success', 'Property rejected with feedback.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\PropertyAppraisal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PropertyAppraisalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Only bookAppointment requires authentication
        $this->middleware('auth', ['only' => ['bookAppointment', 'myAppointments']]);
    }

    /**
     * Display the property estimation page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('public.property-estimation');
    }

    /**
     * Store a new appraisal appointment request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bookAppointment(Request $request)
    {
        $validated = $request->validate([
            'appraiser_id' => 'required|integer',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'property_address' => 'required|string',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'additional_notes' => 'nullable|string',
        ]);

        // Add user_id if authenticated (should always be the case due to middleware)
        $validated['user_id'] = Auth::id();
        
        // Set initial status
        $validated['status'] = 'pending';

        // Create the appraisal record
        $appraisal = PropertyAppraisal::create($validated);

        // In a real application, you would send notifications here
        // - Email to the client
        // - Notification to the appraiser
        // - Internal notification to admin

        return response()->json([
            'success' => true,
            'message' => 'Your appointment request has been submitted successfully!',
            'appraisal' => $appraisal
        ]);
    }

    /**
     * List user's appraisal appointments.
     *
     * @return \Illuminate\Http\Response
     */
    public function myAppointments()
    {
        $appointments = PropertyAppraisal::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('appraisals.my-appointments', compact('appointments'));
    }
}
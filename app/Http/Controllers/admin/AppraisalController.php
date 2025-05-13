<?php

namespace App\Http\Controllers;

use App\Models\PropertyAppraisal;
use App\Models\Appraiser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class PropertyAppraisalController extends Controller
{
    /**
     * Display the property estimation page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all appraisers from appraisers table
        $appraisers = Appraiser::all();
        
        // If no appraisers exist, use default placeholders
        if ($appraisers->isEmpty()) {
            $appraisers = collect([
                [
                    'id' => 1,
                    'name' => 'John Smith',
                    'profile_image' => null,
                    'rating' => 4.5,
                    'specialty' => 'Senior Appraiser',
                    'bio' => 'Specializes in residential properties with over 15 years of experience.',
                    'certification' => 'Certified Appraiser'
                ],
                [
                    'id' => 2,
                    'name' => 'Sarah Johnson',
                    'profile_image' => null,
                    'rating' => 4.8,
                    'specialty' => 'Commercial Properties',
                    'bio' => 'Expert in commercial real estate valuation.',
                    'certification' => 'RICS Certified'
                ]
            ]);
        }
        
        return view('public.property-estimation', compact('appraisers'));
    }
    
    /**
     * Book a property appraisal appointment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bookAppointment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'appraiser_id' => 'required|exists:appraisers,id', // Changed to appraisers table
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'property_address' => 'required|string',
            'client_name' => 'required|string|max:255',
            'client_phone' => 'required|string|max:20',
            'client_email' => 'required|email|max:255',
            'property_type' => 'nullable|string',
            'property_area' => 'nullable|numeric',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'additional_notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $appraisal = new PropertyAppraisal();
            $appraisal->user_id = Auth::id();
            $appraisal->appraiser_id = $request->appraiser_id;
            $appraisal->client_name = $request->client_name;
            $appraisal->client_email = $request->client_email;
            $appraisal->client_phone = $request->client_phone;
            $appraisal->property_address = $request->property_address;
            $appraisal->appointment_date = $request->appointment_date;
            $appraisal->appointment_time = $request->appointment_time;
            $appraisal->property_type = $request->property_type;
            $appraisal->property_area = $request->property_area;
            $appraisal->bedrooms = $request->bedrooms;
            $appraisal->bathrooms = $request->bathrooms;
            $appraisal->additional_notes = $request->additional_notes;
            $appraisal->status = 'pending';
            $appraisal->save();

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully',
                'appointment' => $appraisal
            ]);
        } catch (\Exception $e) {
            Log::error('Error booking appointment: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error booking appointment',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Display the user's appraisal appointments.
     *
     * @return \Illuminate\Http\Response
     */
    public function myAppointments()
    {
        $appraisals = PropertyAppraisal::where('user_id', Auth::id())
            ->with(['appraiser' => function($query) {
                $query->select('id', 'name', 'profile_image', 'rating');
            }])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);
            
        return view('public.my-appraisals', compact('appraisals'));
    }
    
    /**
     * Cancel an appointment by the user.
     *
     * @param  \App\Models\PropertyAppraisal  $appraisal
     * @return \Illuminate\Http\Response
     */
    public function cancelAppointment(PropertyAppraisal $appraisal)
    {
        if ($appraisal->user_id !== Auth::id()) {
            return redirect()->route('property.appraisals.my')
                ->with('error', 'Unauthorized action.');
        }
        
        if ($appraisal->status === 'completed') {
            return redirect()->route('property.appraisals.my')
                ->with('error', 'Completed appointments cannot be cancelled.');
        }
        
        $appraisal->status = 'cancelled';
        $appraisal->save();
        
        return redirect()->route('property.appraisals.my')
            ->with('success', 'Appointment cancelled successfully.');
    }
}
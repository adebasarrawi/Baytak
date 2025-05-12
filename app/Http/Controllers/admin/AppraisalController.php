<?php

namespace App\Http\Controllers;

use App\Models\PropertyAppraisal;
use App\Models\User;
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
        // Get all appraisers for the booking form
        $appraisers = User::where('role', 'appraiser')->get();
        
        // إذا لم يكن هناك أي مخمنين، أضف بعض البيانات الافتراضية للعرض
        if ($appraisers->isEmpty()) {
            // إنشاء قائمة افتراضية من المخمنين
            $defaultAppraisers = [
                (object)[
                    'id' => 1,
                    'name' => 'John Smith',
                    'profile_image' => null,
                    'rating' => 4.5,
                    'specialty' => 'Senior Appraiser',
                    'bio' => 'Specializes in residential properties with over 15 years of experience in Amman\'s premium neighborhoods.',
                    'certification' => 'Certified by Jordan Engineers Association'
                ],
                (object)[
                    'id' => 2,
                    'name' => 'Sarah Johnson',
                    'profile_image' => null,
                    'rating' => 4.9,
                    'specialty' => 'Commercial Expert',
                    'bio' => 'Expert in commercial properties and investment analysis with international valuation experience.',
                    'certification' => 'RICS Certified Valuer'
                ],
                (object)[
                    'id' => 3,
                    'name' => 'Mohammed Al-Abdullah',
                    'profile_image' => null,
                    'rating' => 4.2,
                    'specialty' => 'Land Specialist',
                    'bio' => 'Specialized in land valuation and development potential assessment across Jordan.',
                    'certification' => 'Dept. of Lands Certified'
                ],
                (object)[
                    'id' => 4,
                    'name' => 'Layla Hassan',
                    'profile_image' => null,
                    'rating' => 4.6,
                    'specialty' => 'Luxury Properties',
                    'bio' => 'Specialized in luxury and high-end property valuations in Amman\'s elite neighborhoods.',
                    'certification' => 'International Valuation Standards'
                ],
            ];
            
            $appraisers = collect($defaultAppraisers);
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
        // Validate the request
        $validator = Validator::make($request->all(), [
            'appraiser_id' => 'required|exists:users,id',
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
            // Create the appointment
            $appraisal = new PropertyAppraisal();
            $appraisal->user_id = Auth::id(); // Currently logged in user
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
            $appraisal->status = 'pending'; // Default status is pending
            $appraisal->save();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully',
                'appointment' => $appraisal
            ]);
        } catch (\Exception $e) {
            // Log error
            Log::error('Error booking appointment: ' . $e->getMessage());

            
            // Return error response
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
            ->with('appraiser')
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
        // Check if the user owns this appointment
        if ($appraisal->user_id !== Auth::id()) {
            return redirect()->route('property.appraisals.my')
                ->with('error', 'Unauthorized action.');
        }
        
        // Check if the appointment can be cancelled (not completed)
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
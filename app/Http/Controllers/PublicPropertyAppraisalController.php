<?php

namespace App\Http\Controllers;

use App\Models\PropertyAppraisal;
use App\Models\Appraiser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PublicPropertyAppraisalController extends Controller
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
        Log::info('PropertyAppraisalController@index called');
        
        $appraisers = collect([]);
        
        try {
            $appraisers = Appraiser::with('user')->get();
            
            Log::info('Retrieved {count} appraisers from database', ['count' => $appraisers->count()]);
            
            $appraisers = $appraisers->map(function($appraiser) {
                return (object)[
                    'id' => $appraiser->id,
                    'name' => $appraiser->user->name ?? 'default name',
                    'profile_image' => $appraiser->user->profile_image ?? null,
                    'rating' => $appraiser->rating ?? 0,
                    'specialty' => $appraiser->specialty ?? '',
                    'bio' => $appraiser->user->bio ?? 'Professional appraiser with extensive experience.',
                    'certification' => $appraiser->license_number ?? ''
                ];
            });
        } catch (\Exception $e) {
            Log::error('Error fetching appraisers: ' . $e->getMessage());
            $appraisers = $this->getSampleAppraisers();
        }
        
        return view('public.property-estimation', compact('appraisers'));
    }
    /**
 * Check if an appointment slot is available.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 */
public function checkAvailability(Request $request)
{
    // Validate the request data
    $validated = $request->validate([
        'appraiser_id' => 'required|integer',
        'appointment_date' => 'required|date|after_or_equal:today',
        'appointment_time' => 'required',
    ]);
    
    // Convert the appointment time to a standard format for comparison
    $appointmentTime = date('H:i:s', strtotime($validated['appointment_time']));
    
    // Check if there's an existing appointment with the same appraiser, date, and time
    // that is either pending or confirmed (not cancelled)
    $conflictingAppointment = PropertyAppraisal::where('appraiser_id', $validated['appraiser_id'])
        ->where('appointment_date', $validated['appointment_date'])
        ->where('appointment_time', $appointmentTime)
        ->whereIn('status', ['pending', 'confirmed'])
        ->first();
    
    // Return JSON response with availability status
    return response()->json([
        'available' => $conflictingAppointment === null,
        'message' => $conflictingAppointment ? 
            'The selected time slot is already booked.' : 
            'The selected time slot is available.'
    ]);
}

    /**
     * Store a new appraisal appointment request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function bookAppointment(Request $request)
    {
        Log::info('Booking appointment request received', $request->all());
        
        try {
            $validated = $request->validate([
                'appraiser_id' => 'required|integer',
                'client_name' => 'required|string|max:255',
                'client_email' => 'required|email|max:255',
                'client_phone' => 'required|string|max:20',
                'property_address' => 'required|string',
                'property_type' => 'nullable|string', 
                'appointment_date' => 'required|date|after_or_equal:today',
                'appointment_time' => 'required',
                'additional_notes' => 'nullable|string',
              
            ]);
    
            // Add user_id if authenticated (should always be the case due to middleware)
            $validated['user_id'] = Auth::id();
             
            // Set initial status
            $validated['status'] = 'pending';
    
            // Log the data before creating the record
            Log::info('Attempting to create appointment with data:', $validated);
    
            // Create the appraisal record
            $appraisal = PropertyAppraisal::create($validated);
            
            Log::info('Appointment created successfully', ['id' => $appraisal->id]);
    
            return response()->json([
                'success' => true,
                'message' => 'Your appointment request has been submitted successfully!',
                'appraisal' => $appraisal
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating appointment: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'There was an error processing your request: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * List user's appraisal appointments.
     *
     * @return \Illuminate\Http\Response
     */
    public function myAppointments()
    {
        $appraisals = PropertyAppraisal::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10); 
    
        return view('public.my-appointments', compact('appraisals'));
    }

    public function cancelAppointment(PropertyAppraisal $appraisal)
{
    if (Auth::id() !== $appraisal->user_id) {
        return redirect()->back()->with('error', 'cannot cancel this appointment.');
    }

    $appraisal->status = 'cancelled';
    $appraisal->save();

    return redirect()->route('public.my-appointments')->with('success', 'Appointment cancelled successfully.');
}

    /**
     *
     * @return \Illuminate\Support\Collection
     */
}
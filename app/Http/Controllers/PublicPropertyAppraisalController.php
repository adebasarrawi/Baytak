<?php

namespace App\Http\Controllers;

use App\Models\PropertyAppraisal;
use App\Models\Appraiser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PublicPropertyAppraisalController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['only' => ['bookAppointment', 'myAppointments', 'cancelAppointment']]);
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
            // Get appraisers with their user data
            $appraisers = Appraiser::with('user')
                ->whereHas('user', function($query) {
                    $query->where('user_type', 'appraiser');
                })
                ->get();
            
            Log::info('Retrieved {count} appraisers with ratings', ['count' => $appraisers->count()]);
            
        } catch (\Exception $e) {
            Log::error('Error fetching appraisers: ' . $e->getMessage());
            $appraisers = collect([]);
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
        $validated = $request->validate([
            'appraiser_id' => 'required|integer',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
        ]);
        
        $appointmentTime = date('H:i:s', strtotime($validated['appointment_time']));
        
        $conflictingAppointment = PropertyAppraisal::where('appraiser_id', $validated['appraiser_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $appointmentTime)
            ->whereIn('status', ['pending', 'confirmed'])
            ->first();
        
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
                'appraiser_id' => 'required|integer|exists:users,id',
                'client_name' => 'required|string|max:255',
                'client_email' => 'required|email|max:255',
                'client_phone' => 'required|string|max:20',
                'property_address' => 'required|string',
                'property_type' => 'nullable|string', 
                'appointment_date' => 'required|date|after_or_equal:today',
                'appointment_time' => 'required',
                'additional_notes' => 'nullable|string',
            ]);

            $validated['user_id'] = Auth::id();
            $validated['status'] = 'pending';

            Log::info('Attempting to create appointment with data:', $validated);

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
        $appraisals = PropertyAppraisal::withTrashed()
            ->where('user_id', Auth::id())
            ->with(['appraiser' => function($query) {
                $query->where('user_type', 'appraiser');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10); 

        return view('public.my-appointments', compact('appraisals'));
    }

    /**
     * Cancel an appointment by the user.
     *
     * @param PropertyAppraisal $appraisal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelAppointment(PropertyAppraisal $appraisal)
    {
        if (Auth::id() !== $appraisal->user_id) {
            return redirect()->back()->with('error', 'You cannot cancel this appointment.');
        }

        if (!$appraisal->canBeCancelled()) {
            return redirect()->back()->with('error', 'This appointment cannot be cancelled.');
        }

        $appraisal->update([
            'status' => 'cancelled',
            'cancelled_by' => 'user',
            'cancelled_at' => Carbon::now()
        ]);

        $appraisal->delete();

        Log::info('Appointment cancelled by user', [
            'appointment_id' => $appraisal->id,
            'user_id' => Auth::id(),
            'cancelled_at' => $appraisal->cancelled_at
        ]);

        return redirect()->route('public.property.appraisals.my')
            ->with('success', 'Appointment cancelled successfully.');
    }
}
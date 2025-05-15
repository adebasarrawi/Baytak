<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyAppraisal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentStatusUpdated;
use Illuminate\Support\Facades\Log;
use App\Models\Appraiser;

class AdminAppraisalController extends Controller
{
    /**
     * Display a listing of the appraisal appointments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Code for index method remains unchanged
        $status = $request->query('status');
        $date = $request->query('date');
        $search = $request->query('search');
        
        $query = PropertyAppraisal::query()
            ->with(['user', 'appraiser'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc');
        
        if ($status) {
            $query->where('status', $status);
        }
        
        if ($date) {
            $query->whereDate('appointment_date', $date);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('client_name', 'like', "%{$search}%")
                  ->orWhere('client_email', 'like', "%{$search}%")
                  ->orWhere('client_phone', 'like', "%{$search}%")
                  ->orWhere('property_address', 'like', "%{$search}%");
            });
        }
        
        $appraisals = $query->paginate(10);
        
        $statusCounts = [
            'pending' => PropertyAppraisal::where('status', 'pending')->count(),
            'confirmed' => PropertyAppraisal::where('status', 'confirmed')->count(),
            'completed' => PropertyAppraisal::where('status', 'completed')->count(),
            'cancelled' => PropertyAppraisal::where('status', 'cancelled')->count(),
        ];
        
        $appraisers = User::where('role', 'appraiser')->get();
        
        return view('admin.appraisals.index', compact('appraisals', 'statusCounts', 'status', 'date', 'search', 'appraisers'));
    }
    
    /**
     * Show the form for creating a new appraisal.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Get all appraisers with their related user data
        $appraisers = Appraiser::with('user')->get();
        
        return view('admin.appraisals.create', compact('appraisers'));
    }
    
    /**
     * Store a newly created appraisal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'appraiser_id' => 'required|exists:users,id',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'property_address' => 'required|string',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'property_type' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);
        
        // Create new appraisal
        $appraisal = new PropertyAppraisal();
        $appraisal->appraiser_id = $request->appraiser_id;
        $appraisal->client_name = $request->client_name;
        $appraisal->client_email = $request->client_email;
        $appraisal->client_phone = $request->client_phone;
        $appraisal->property_address = $request->property_address;
        $appraisal->appointment_date = $request->appointment_date;
        $appraisal->appointment_time = $request->appointment_time;
        $appraisal->property_type = $request->property_type;
        $appraisal->additional_notes = $request->additional_notes;
        $appraisal->status = $request->status;
        $appraisal->user_id = $request->user_id ?? Auth::id(); // Associate with a user if provided, otherwise with admin
        $appraisal->save();
        
        // Send notification if status is confirmed
        if ($appraisal->status == 'confirmed') {
            try {
                Mail::to($appraisal->client_email)->send(new AppointmentStatusUpdated($appraisal));
            } catch (\Exception $e) {
                Log::error('Failed to send appointment confirmation email: ' . $e->getMessage());
            }
        }
        
        return redirect()->route('admin.appraisals.index')
            ->with('success', 'New appointment created successfully');
    }
    
    /**
     * Show the form for editing an appraisal.
     *
     * @param  \App\Models\PropertyAppraisal  $appraisal
     * @return \Illuminate\Http\Response
     */
    public function edit(PropertyAppraisal $appraisal)
    {
        // Get all appraisers
        $appraisers = Appraiser::with('user')->get();
        
        return view('admin.appraisals.edit', compact('appraisal', 'appraisers'));
    }
    
    /**
     * Update the specified appraisal status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PropertyAppraisal  $appraisal
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, PropertyAppraisal $appraisal)
    {
        // Code for updateStatus method remains unchanged
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);
        
        $oldStatus = $appraisal->status;
        $newStatus = $request->status;
        
        $appraisal->status = $newStatus;
        $appraisal->save();
        
        if ($oldStatus != $newStatus) {
            try {
                Mail::to($appraisal->client_email)->send(new AppointmentStatusUpdated($appraisal));
            } catch (\Exception $e) {
                Log::error('Failed to send appointment status email: ' . $e->getMessage());
            }
        }
        
        return redirect()->route('admin.appraisals.index')
            ->with('success', 'Appointment status updated successfully');
    }
    public function cancelAppointment(PropertyAppraisal $appraisal)
{
    if (Auth::id() !== $appraisal->user_id) {
        return redirect()->back()->with('error', 'You cannot cancel this appointment.');
    }

    $appraisal->status = 'cancelled';
    $appraisal->save();

    // تعديل هنا لاستخدام اسم الطريق المطابق لما هو في ملف العرض
    return redirect()->route('public.property.appraisals.my')->with('success', 'Appointment cancelled successfully.');
}
    
    /**
     * Update the specified appraisal in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PropertyAppraisal  $appraisal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PropertyAppraisal $appraisal)
    {
        $request->validate([
            'appraiser_id' => 'required|integer',
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'property_address' => 'required|string',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'property_type' => 'nullable|string',
            'additional_notes' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);
        
        // Check if status is changing
        $statusChanged = $appraisal->status != $request->status;
        
        // Update the appraisal with all fields except property_area, bedrooms, and bathrooms
        $appraisal->appraiser_id = $request->appraiser_id;
        $appraisal->client_name = $request->client_name;
        $appraisal->client_email = $request->client_email;
        $appraisal->client_phone = $request->client_phone;
        $appraisal->property_address = $request->property_address;
        $appraisal->appointment_date = $request->appointment_date;
        $appraisal->appointment_time = $request->appointment_time;
        $appraisal->property_type = $request->property_type;
        $appraisal->additional_notes = $request->additional_notes;
        $appraisal->status = $request->status;
        $appraisal->save();
        
        // Send notification if status changed to confirmed
        if ($statusChanged && $request->status == 'confirmed') {
            try {
                Mail::to($appraisal->client_email)->send(new AppointmentStatusUpdated($appraisal));
            } catch (\Exception $e) {
                Log::error('Failed to send appointment status email: ' . $e->getMessage());
            }
        }
        
        return redirect()->route('admin.appraisals.index')
            ->with('success', 'Appointment updated successfully');
    }
    
    // Rest of the controller methods remain unchanged
}

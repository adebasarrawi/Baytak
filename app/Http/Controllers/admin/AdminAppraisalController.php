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

class AppraisalController extends Controller
{
    /**
     * Display a listing of the appraisal appointments.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get query parameters for filtering
        $status = $request->query('status');
        $date = $request->query('date');
        $search = $request->query('search');
        
        // Build query
        $query = PropertyAppraisal::query()
            ->with(['user', 'appraiser'])
            ->orderBy('appointment_date', 'asc')
            ->orderBy('appointment_time', 'asc');
        
        // Apply filters
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
        
        // Get paginated results
        $appraisals = $query->paginate(10);
        
        // Get counts for each status for the dashboard
        $statusCounts = [
            'pending' => PropertyAppraisal::where('status', 'pending')->count(),
            'confirmed' => PropertyAppraisal::where('status', 'confirmed')->count(),
            'completed' => PropertyAppraisal::where('status', 'completed')->count(),
            'cancelled' => PropertyAppraisal::where('status', 'cancelled')->count(),
        ];
        
        // Get all appraisers for filtering
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
        // Get all appraisers
        $appraisers = User::where('role', 'appraiser')->get();
        
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
            'property_area' => 'nullable|numeric',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
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
        $appraisal->property_area = $request->property_area;
        $appraisal->bedrooms = $request->bedrooms;
        $appraisal->bathrooms = $request->bathrooms;
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
        $appraisers = User::where('role', 'appraiser')->get();
        
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
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);
        
        $oldStatus = $appraisal->status;
        $newStatus = $request->status;
        
        $appraisal->status = $newStatus;
        $appraisal->save();
        
        // Send notification email to client about status change
        if ($oldStatus != $newStatus) {
            try {
                Mail::to($appraisal->client_email)->send(new AppointmentStatusUpdated($appraisal));
            } catch (\Exception $e) {
                // Log error but don't stop the process
                Log::error('Failed to send appointment status email: ' . $e->getMessage());
            }
        }
        
        return redirect()->route('admin.appraisals.index')
            ->with('success', 'Appointment status updated successfully');
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
            'property_area' => 'nullable|numeric',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'additional_notes' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);
        
        // Check if status is changing
        $statusChanged = $appraisal->status != $request->status;
        
        // Update the appraisal
        $appraisal->update($request->all());
        
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
    
    /**
     * Remove the specified appraisal from storage.
     *
     * @param  \App\Models\PropertyAppraisal  $appraisal
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyAppraisal $appraisal)
    {
        $appraisal->delete();
        
        return redirect()->route('admin.appraisals.index')
            ->with('success', 'Appointment deleted successfully');
    }
    
    /**
     * Show the calendar view of appraisal appointments.
     *
     * @return \Illuminate\Http\Response
     */
    public function calendar()
    {
        // Get all appointments for calendar
        $appraisals = PropertyAppraisal::with('appraiser')->get();
        
        // Format appointments for fullcalendar
        $events = [];
        
        foreach ($appraisals as $appraisal) {
            // Determine color based on status
            $color = '';
            switch ($appraisal->status) {
                case 'pending':
                    $color = '#ffc107'; // yellow
                    break;
                case 'confirmed':
                    $color = '#28a745'; // green
                    break;
                case 'completed':
                    $color = '#0d6efd'; // blue
                    break;
                case 'cancelled':
                    $color = '#dc3545'; // red
                    break;
                default:
                    $color = '#6c757d'; // gray
            }
            
            // Format date and time
            $dateTime = $appraisal->appointment_date . ' ' . $appraisal->appointment_time;
            
            // Add to events array
            $events[] = [
                'id' => $appraisal->id,
                'title' => $appraisal->client_name,
                'start' => $dateTime,
                'url' => route('admin.appraisals.edit', $appraisal->id),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'status' => $appraisal->status,
                    'address' => $appraisal->property_address,
                    'phone' => $appraisal->client_phone,
                    'appraiser' => $appraisal->appraiser ? $appraisal->appraiser->name : 'Unassigned'
                ]
            ];
        }
        
        // Get all appraisers for filters
        $appraisers = User::where('role', 'appraiser')->get();
        
        return view('admin.appraisals.calendar', compact('events', 'appraisers'));
    }
    
    /**
     * Get calendar events as JSON for AJAX requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getEvents(Request $request)
    {
        // Get query parameters for filtering
        $start = $request->query('start');
        $end = $request->query('end');
        $status = $request->query('status');
        $appraiser = $request->query('appraiser');
        
        // Build query
        $query = PropertyAppraisal::query()->with('appraiser');
        
        // Apply date range filter
        if ($start && $end) {
            $query->whereBetween('appointment_date', [$start, $end]);
        }
        
        // Apply status filter
        if ($status) {
            $query->where('status', $status);
        }
        
        // Apply appraiser filter
        if ($appraiser) {
            $query->where('appraiser_id', $appraiser);
        }
        
        // Get results
        $appraisals = $query->get();
        
        // Format appointments for fullcalendar
        $events = [];
        
        foreach ($appraisals as $appraisal) {
            // Determine color based on status
            $color = '';
            switch ($appraisal->status) {
                case 'pending':
                    $color = '#ffc107'; // yellow
                    break;
                case 'confirmed':
                    $color = '#28a745'; // green
                    break;
                case 'completed':
                    $color = '#0d6efd'; // blue
                    break;
                case 'cancelled':
                    $color = '#dc3545'; // red
                    break;
                default:
                    $color = '#6c757d'; // gray
            }
            
            // Format date and time
            $dateTime = $appraisal->appointment_date . ' ' . $appraisal->appointment_time;
            
            // Add to events array
            $events[] = [
                'id' => $appraisal->id,
                'title' => $appraisal->client_name,
                'start' => $dateTime,
                'url' => route('admin.appraisals.edit', $appraisal->id),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'status' => $appraisal->status,
                    'address' => $appraisal->property_address,
                    'phone' => $appraisal->client_phone,
                    'appraiser' => $appraisal->appraiser ? $appraisal->appraiser->name : 'Unassigned'
                ]
            ];
        }
        
        return response()->json($events);
    }
}
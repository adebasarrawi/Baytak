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
use Carbon\Carbon;

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
        $status = $request->query('status');
        $date = $request->query('date');
        $search = $request->query('search');
        
        // Include soft deleted records to show cancelled appointments
        $query = PropertyAppraisal::withTrashed()
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
            'cancelled' => PropertyAppraisal::withTrashed()->where('status', 'cancelled')->count(),
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
        
        // Prepare data for creation
        $data = [
            'appraiser_id' => $request->appraiser_id,
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'property_address' => $request->property_address,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'property_type' => $request->property_type,
            'additional_notes' => $request->additional_notes,
            'status' => $request->status,
            'user_id' => $request->user_id ?? Auth::id(),
        ];

        // If creating as cancelled by admin
        if ($request->status === 'cancelled') {
            $data['cancelled_by'] = 'admin';
            $data['cancelled_at'] = Carbon::now();
        }

        // Create new appraisal
        $appraisal = PropertyAppraisal::create($data);

        // Soft delete if created as cancelled
        if ($request->status === 'cancelled') {
            $appraisal->delete();
        }
        
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
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);
        
        $oldStatus = $appraisal->status;
        $newStatus = $request->status;
        
        // Prepare update data
        $updateData = ['status' => $newStatus];
        
        // If changing TO cancelled status
        if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
            $updateData['cancelled_by'] = 'admin';
            $updateData['cancelled_at'] = Carbon::now();
        }
        
        // If changing FROM cancelled to another status
        if ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
            $updateData['cancelled_by'] = null;
            $updateData['cancelled_at'] = null;
        }
        
        $appraisal->update($updateData);
        
        // Handle soft delete/restore
        if ($newStatus === 'cancelled' && !$appraisal->trashed()) {
            $appraisal->delete(); // Soft delete
        } elseif ($newStatus !== 'cancelled' && $appraisal->trashed()) {
            $appraisal->restore(); // Restore from soft delete
        }
        
        // Send email notification if status changed
        if ($oldStatus != $newStatus) {
            try {
                Mail::to($appraisal->client_email)->send(new AppointmentStatusUpdated($appraisal));
            } catch (\Exception $e) {
                Log::error('Failed to send appointment status email: ' . $e->getMessage());
            }
        }
        
        Log::info('Appointment status updated by admin', [
            'appointment_id' => $appraisal->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'admin_id' => Auth::id(),
            'cancelled_by' => $appraisal->cancelled_by ?? null
        ]);
        
        return redirect()->route('admin.appraisals.index')
            ->with('success', 'Appointment status updated successfully');
    }

    /**
     * Cancel appointment by admin (separate method for clarity)
     *
     * @param PropertyAppraisal $appraisal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelAppointment(PropertyAppraisal $appraisal)
    {
        // Update appointment status and mark cancelled by admin
        $appraisal->update([
            'status' => 'cancelled',
            'cancelled_by' => 'admin',
            'cancelled_at' => Carbon::now()
        ]);

        // Soft delete the appointment
        $appraisal->delete();

        Log::info('Appointment cancelled by admin', [
            'appointment_id' => $appraisal->id,
            'admin_id' => Auth::id(),
            'cancelled_at' => $appraisal->cancelled_at
        ]);

        return redirect()->route('admin.appraisals.index')
            ->with('success', 'Appointment cancelled successfully.');
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
        $oldStatus = $appraisal->status;
        $newStatus = $request->status;
        $statusChanged = $oldStatus != $newStatus;
        
        // Prepare update data
        $updateData = [
            'appraiser_id' => $request->appraiser_id,
            'client_name' => $request->client_name,
            'client_email' => $request->client_email,
            'client_phone' => $request->client_phone,
            'property_address' => $request->property_address,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'property_type' => $request->property_type,
            'additional_notes' => $request->additional_notes,
            'status' => $newStatus,
        ];

        // Handle cancellation status changes
        if ($statusChanged) {
            if ($newStatus === 'cancelled' && $oldStatus !== 'cancelled') {
                $updateData['cancelled_by'] = 'admin';
                $updateData['cancelled_at'] = Carbon::now();
            } elseif ($oldStatus === 'cancelled' && $newStatus !== 'cancelled') {
                $updateData['cancelled_by'] = null;
                $updateData['cancelled_at'] = null;
            }
        }
        
        // Update the appraisal
        $appraisal->update($updateData);
        
        // Handle soft delete/restore based on status
        if ($statusChanged) {
            if ($newStatus === 'cancelled' && !$appraisal->trashed()) {
                $appraisal->delete(); // Soft delete
            } elseif ($newStatus !== 'cancelled' && $appraisal->trashed()) {
                $appraisal->restore(); // Restore from soft delete
            }
        }
        
        // Send notification if status changed to confirmed
        if ($statusChanged && $newStatus == 'confirmed') {
            try {
                Mail::to($appraisal->client_email)->send(new AppointmentStatusUpdated($appraisal));
            } catch (\Exception $e) {
                Log::error('Failed to send appointment status email: ' . $e->getMessage());
            }
        }
        
        Log::info('Appointment updated by admin', [
            'appointment_id' => $appraisal->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'admin_id' => Auth::id(),
            'cancelled_by' => $appraisal->cancelled_by ?? null
        ]);
        
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
        // Force delete (permanent deletion)
        $appraisal->forceDelete();
        
        Log::info('Appointment permanently deleted by admin', [
            'appointment_id' => $appraisal->id,
            'admin_id' => Auth::id()
        ]);
        
        return redirect()->route('admin.appraisals.index')
            ->with('success', 'Appointment deleted permanently');
    }

    /**
     * Display calendar view of appointments.
     *
     * @return \Illuminate\Http\Response
     */
    public function calendar()
    {
        return view('admin.appraisals.calendar');
    }

    /**
     * Get events for calendar view.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvents()
    {
        $appraisals = PropertyAppraisal::withTrashed()
            ->with(['user', 'appraiser'])
            ->get();

        $events = $appraisals->map(function ($appraisal) {
            $color = match($appraisal->status) {
                'pending' => '#ffc107',
                'confirmed' => '#28a745',
                'completed' => '#007bff',
                'cancelled' => '#dc3545',
                default => '#6c757d'
            };

            $title = $appraisal->client_name;
            if ($appraisal->status === 'cancelled' && $appraisal->cancelled_by) {
                $title .= ' (Cancelled by ' . ucfirst($appraisal->cancelled_by) . ')';
            }

            return [
                'id' => $appraisal->id,
                'title' => $title,
                'start' => $appraisal->appointment_date->format('Y-m-d') . 'T' . $appraisal->appointment_time->format('H:i:s'),
                'backgroundColor' => $color,
                'borderColor' => $color,
                'extendedProps' => [
                    'status' => $appraisal->status,
                    'cancelled_by' => $appraisal->cancelled_by,
                    'property_address' => $appraisal->property_address,
                    'appraiser' => $appraisal->appraiser ? $appraisal->appraiser->name : 'Not assigned'
                ]
            ];
        });

        return response()->json($events);
    }
}
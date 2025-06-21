@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title text-dark">Appraisal Calendar</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="fas fa-angle-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.appraisals.index') }}" class="text-decoration-none">Appraisals</a>
                </li>
                <li class="separator">
                    <i class="fas fa-angle-right"></i>
                </li>
                <li class="nav-item">
                    <span class="text-muted">Calendar</span>
                </li>
            </ul>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start">
                            <h4 class="card-title text-dark mb-3 mb-lg-0">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                Appraisal Schedule
                            </h4>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.appraisals.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-list me-2"></i>List View
                                </a>
                                <a href="{{ route('admin.appraisals.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus me-2"></i>Add Appointment
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Calendar Filters -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="calendarFilterStatus" class="form-label">Filter by Status</label>
                                    <select class="form-select" id="calendarFilterStatus">
                                        <option value="">All Statuses</option>
                                        <option value="pending">Pending</option>
                                        <option value="confirmed">Confirmed</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="calendarFilterAppraiser" class="form-label">Filter by Appraiser</label>
                                    <select class="form-select" id="calendarFilterAppraiser">
                                        <option value="">All Appraisers</option>
                                        {{-- Fixed: Check if appraisers variable exists --}}
                                        @if(isset($appraisers) && $appraisers->count() > 0)
                                            @foreach($appraisers as $appraiser)
                                                <option value="{{ $appraiser->id }}">{{ $appraiser->name }}</option>
                                            @endforeach
                                        @else
                                            <option value="" disabled>No appraisers available</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">Calendar Legend</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-warning">Pending</span>
                                        <span class="badge bg-success">Confirmed</span>
                                        <span class="badge bg-info">Completed</span>
                                        <span class="badge bg-danger">Cancelled</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Calendar Container -->
                        <div id="appraisalCalendar" data-events="{{ json_encode($events ?? []) }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Appointment Details Modal -->
<div class="modal fade" id="appointmentDetailsModal" tabindex="-1" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">
                    <i class="fas fa-calendar-check text-primary me-2"></i>
                    Appointment Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Client Name</label>
                            <p id="modalClientName" class="fw-bold"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Contact Information</label>
                            <div id="modalClientContact" class="mb-0"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Property Address</label>
                            <p id="modalPropertyAddress" class="fw-bold"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Status</label>
                            <div id="modalStatus"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label text-muted">Appointment Date</label>
                            <p id="modalDate" class="fw-bold"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Appointment Time</label>
                            <p id="modalTime" class="fw-bold"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Assigned Appraiser</label>
                            <p id="modalAppraiser" class="fw-bold"></p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted">Additional Notes</label>
                            <p id="modalNotes" class="text-muted"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex gap-2 flex-wrap">
                    <a href="#" id="modalEditBtn" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <button type="button" id="modalConfirmBtn" class="btn btn-success" data-status="confirmed">
                        <i class="fas fa-check-circle me-1"></i>Confirm
                    </button>
                    <button type="button" id="modalCompleteBtn" class="btn btn-info" data-status="completed">
                        <i class="fas fa-flag-checkered me-1"></i>Complete
                    </button>
                    <button type="button" id="modalCancelBtn" class="btn btn-danger" data-status="cancelled">
                        <i class="fas fa-times-circle me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Form -->
<form id="appointmentStatusForm" method="POST" style="display: none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="status" id="statusValue">
</form>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
<style>
    #appraisalCalendar {
        height: 700px;
    }
    
    .fc-event {
        cursor: pointer;
        border: none;
        padding: 2px 4px;
    }
    
    .fc-daygrid-event {
        white-space: normal;
    }
    
    /* Status colors for calendar events */
    .fc-event.status-pending {
        background-color: #ffc107;
        color: #000;
    }
    
    .fc-event.status-confirmed {
        background-color: #28a745;
        color: #fff;
    }
    
    .fc-event.status-completed {
        background-color: #17a2b8;
        color: #fff;
    }
    
    .fc-event.status-cancelled {
        background-color: #dc3545;
        color: #fff;
        text-decoration: line-through;
    }
    
    /* Calendar styling */
    .fc-header-toolbar {
        margin-bottom: 1.5rem;
    }
    
    .fc-button-group .fc-button {
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .fc-button-group .fc-button:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
    
    .fc-today-button {
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('appraisalCalendar');
    
    // Get events data from data attribute
    let eventsData = [];
    try {
        const eventsAttribute = calendarEl.dataset.events;
        if (eventsAttribute) {
            eventsData = JSON.parse(eventsAttribute);
        }
    } catch (e) {
        console.error("Error parsing events data:", e);
        eventsData = [];
    }
    
    // Initialize the calendar
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        events: eventsData,
        eventClassNames: function(arg) {
            return ['status-' + (arg.event.extendedProps.status || 'pending')];
        },
        eventClick: function(info) {
            showAppointmentDetails(info.event);
        },
        height: 'auto',
        displayEventTime: true,
        eventTimeFormat: {
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short'
        }
    });
    
    calendar.render();
    
    // Filter functions
    const statusFilter = document.getElementById('calendarFilterStatus');
    const appraiserFilter = document.getElementById('calendarFilterAppraiser');
    
    function filterEvents() {
        const statusValue = statusFilter.value;
        const appraiserValue = appraiserFilter.value;
        
        // Remove all events
        calendar.removeAllEvents();
        
        // Filter and add events back
        const filteredEvents = eventsData.filter(event => {
            const statusMatch = !statusValue || event.status === statusValue;
            const appraiserMatch = !appraiserValue || event.appraiser_id == appraiserValue;
            return statusMatch && appraiserMatch;
        });
        
        calendar.addEventSource(filteredEvents);
    }
    
    statusFilter.addEventListener('change', filterEvents);
    appraiserFilter.addEventListener('change', filterEvents);
    
    // Show appointment details in modal
    function showAppointmentDetails(event) {
        const modal = new bootstrap.Modal(document.getElementById('appointmentDetailsModal'));
        
        // Populate modal with event data
        document.getElementById('modalClientName').textContent = event.extendedProps.client_name || 'N/A';
        
        // Contact information
        const contactDiv = document.getElementById('modalClientContact');
        contactDiv.innerHTML = `
            <p class="mb-1">
                <i class="fas fa-envelope me-2 text-primary"></i>
                ${event.extendedProps.client_email || 'N/A'}
            </p>
            <p class="mb-0">
                <i class="fas fa-phone me-2 text-success"></i>
                ${event.extendedProps.client_phone || 'N/A'}
            </p>
        `;
        
        document.getElementById('modalPropertyAddress').textContent = event.extendedProps.property_address || 'N/A';
        
        // Status badge
        const statusDiv = document.getElementById('modalStatus');
        const statusConfig = {
            'pending': { class: 'warning', icon: 'clock' },
            'confirmed': { class: 'success', icon: 'check-circle' },
            'completed': { class: 'info', icon: 'flag-checkered' },
            'cancelled': { class: 'danger', icon: 'times-circle' }
        };
        const config = statusConfig[event.extendedProps.status] || { class: 'secondary', icon: 'question' };
        statusDiv.innerHTML = `
            <span class="badge bg-${config.class} rounded-pill">
                <i class="fas fa-${config.icon} me-1"></i>
                ${event.extendedProps.status ? event.extendedProps.status.charAt(0).toUpperCase() + event.extendedProps.status.slice(1) : 'Unknown'}
            </span>
        `;
        
        document.getElementById('modalDate').textContent = event.startStr ? new Date(event.startStr).toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        }) : 'N/A';
        
        document.getElementById('modalTime').textContent = event.startStr ? new Date(event.startStr).toLocaleTimeString('en-US', {
            hour: 'numeric',
            minute: '2-digit',
            hour12: true
        }) : 'N/A';
        
        document.getElementById('modalAppraiser').textContent = event.extendedProps.appraiser_name || 'Not assigned';
        document.getElementById('modalNotes').textContent = event.extendedProps.notes || 'No additional notes';
        
        // Set up action buttons
        const editBtn = document.getElementById('modalEditBtn');
        const confirmBtn = document.getElementById('modalConfirmBtn');
        const completeBtn = document.getElementById('modalCompleteBtn');
        const cancelBtn = document.getElementById('modalCancelBtn');
        
        if (event.extendedProps.id) {
            editBtn.href = `{{ url('admin/appraisals') }}/${event.extendedProps.id}/edit`;
            
            // Status update buttons
            [confirmBtn, completeBtn, cancelBtn].forEach(btn => {
                btn.onclick = function() {
                    updateAppointmentStatus(event.extendedProps.id, this.dataset.status);
                };
            });
            
            // Hide buttons based on current status
            const currentStatus = event.extendedProps.status;
            confirmBtn.style.display = currentStatus === 'pending' ? 'inline-block' : 'none';
            completeBtn.style.display = currentStatus === 'confirmed' ? 'inline-block' : 'none';
            cancelBtn.style.display = ['pending', 'confirmed'].includes(currentStatus) ? 'inline-block' : 'none';
        }
        
        modal.show();
    }
    
    // Update appointment status
    function updateAppointmentStatus(appointmentId, newStatus) {
        if (confirm(`Are you sure you want to ${newStatus} this appointment?`)) {
            const form = document.getElementById('appointmentStatusForm');
            form.action = `{{ url('admin/appraisals') }}/${appointmentId}/status`;
            document.getElementById('statusValue').value = newStatus;
            form.submit();
        }
    }
});
</script>
@endpush
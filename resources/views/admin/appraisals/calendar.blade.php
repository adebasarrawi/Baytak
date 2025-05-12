@extends('layouts.admin.app')

@section('content')
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Appraisal Calendar</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="fas fa-angle-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.appraisals.index') }}">Appraisals</a>
                </li>
                <li class="separator">
                    <i class="fas fa-angle-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Calendar</a>
                </li>
            </ul>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Appraisal Schedule</h4>
                            <div class="ml-auto">
                                <a href="{{ route('admin.appraisals.create') }}" class="btn btn-primary btn-round">
                                    <i class="fas fa-plus mr-2"></i>Add Appointment
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="calendarFilterStatus">Filter by Status</label>
                                    <select class="form-control" id="calendarFilterStatus">
                                        <option value="">All Statuses</option>
                                        <option value="pending">Pending</option>
                                        <option value="confirmed">Confirmed</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="calendarFilterAppraiser">Filter by Appraiser</label>
                                    <select class="form-control" id="calendarFilterAppraiser">
                                        <option value="">All Appraisers</option>
                                        @foreach($appraisers as $appraiser)
                                            <option value="{{ $appraiser->id }}">{{ $appraiser->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div id="appraisalCalendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Appointment Details Modal -->
<div class="modal fade" id="appointmentDetailsModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Client Name:</label>
                            <p id="modalClientName" class="font-weight-bold"></p>
                        </div>
                        <div class="form-group">
                            <label>Contact Information:</label>
                            <p id="modalClientContact" class="mb-0"></p>
                        </div>
                        <div class="form-group">
                            <label>Property Address:</label>
                            <p id="modalPropertyAddress" class="font-weight-bold"></p>
                        </div>
                        <div class="form-group">
                            <label>Status:</label>
                            <p id="modalStatus"></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Appointment Date:</label>
                            <p id="modalDate" class="font-weight-bold"></p>
                        </div>
                        <div class="form-group">
                            <label>Appointment Time:</label>
                            <p id="modalTime" class="font-weight-bold"></p>
                        </div>
                        <div class="form-group">
                            <label>Assigned Appraiser:</label>
                            <p id="modalAppraiser" class="font-weight-bold"></p>
                        </div>
                        <div class="form-group">
                            <label>Additional Notes:</label>
                            <p id="modalNotes"></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="button-group">
                    <a href="#" id="modalEditBtn" class="btn btn-primary">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <button type="button" id="modalConfirmBtn" class="btn btn-success" data-status="confirmed">
                        <i class="fas fa-check-circle mr-1"></i> Confirm
                    </button>
                    <button type="button" id="modalCompleteBtn" class="btn btn-info" data-status="completed">
                        <i class="fas fa-flag-checkered mr-1"></i> Complete
                    </button>
                    <button type="button" id="modalCancelBtn" class="btn btn-danger" data-status="cancelled">
                        <i class="fas fa-times-circle mr-1"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
    }
    
    .fc-daygrid-event {
        white-space: normal;
    }
    
    /* Status colors in modal */
    .status-badge {
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: bold;
        color: white;
    }
    
    .status-pending {
        background-color: #ffc107;
    }
    
    .status-confirmed {
        background-color: #28a745;
    }
    
    .status-completed {
        background-color: #0d6efd;
    }
    
    .status-cancelled {
        background-color: #dc3545;
        text-decoration: line-through;
    }
</style>
@endpush

@push('scripts')
<!-- In your calendar.blade.php view -->
<div id="calendar" data-events="{{ json_encode($events ?? []) }}"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    
    // Get events data from data attribute
    let eventsData = [];
    try {
        eventsData = JSON.parse(calendarEl.dataset.events);
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
        // ...rest of your calendar configuration
    });
    
    calendar.render();
    // ...rest of your function
});
</script>
@endpush
endsection


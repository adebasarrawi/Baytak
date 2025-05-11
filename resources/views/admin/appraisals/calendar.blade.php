@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Appointment Calendar</h4>
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
                    <a href="{{ route('admin.appraisals.index') }}">Appointments</a>
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
                            <h4 class="card-title">Appointment Calendar</h4>
                            <div class="ml-auto">
                                <a href="{{ route('admin.appraisals.index') }}" class="btn btn-primary btn-round">
                                    <i class="fas fa-list mr-2"></i>List View
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="legend-item">
                                    <span class="legend-color bg-warning"></span>
                                    <span class="legend-text">Pending</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="legend-item">
                                    <span class="legend-color bg-success"></span>
                                    <span class="legend-text">Confirmed</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="legend-item">
                                    <span class="legend-color bg-primary"></span>
                                    <span class="legend-text">Completed</span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="legend-item">
                                    <span class="legend-color bg-danger"></span>
                                    <span class="legend-text">Cancelled</span>
                                </div>
                            </div>
                        </div>
                        
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Appointment Detail Modal -->
<div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="appointmentModalLabel">Appointment Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="appointment-details">
                    <p><strong>Client:</strong> <span id="modal-client"></span></p>
                    <p><strong>Property:</strong> <span id="modal-address"></span></p>
                    <p><strong>Date & Time:</strong> <span id="modal-datetime"></span></p>
                    <p><strong>Status:</strong> <span id="modal-status"></span></p>
                    <p><strong>Phone:</strong> <span id="modal-phone"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" class="btn btn-primary" id="modal-edit-link">Edit Appointment</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- FullCalendar CSS -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" rel="stylesheet">
<style>
    #calendar {
        height: 700px;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    
    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 3px;
        margin-right: 10px;
    }
    
    .legend-text {
        font-size: 14px;
    }
    
    .fc-event {
        cursor: pointer;
    }
    
    .fc-event:hover {
        opacity: 0.9;
    }
    
    .fc-daygrid-event-dot {
        display: none;
    }
    
    .fc .fc-button-primary {
        background-color: #1572e8;
        border-color: #1572e8;
    }
    
    .fc .fc-button-primary:hover {
        background-color: #0d60c8;
        border-color: #0d60c8;
    }
    
    .fc .fc-button-primary:not(:disabled).fc-button-active, 
    .fc .fc-button-primary:not(:disabled):active {
        background-color: #0d60c8;
        border-color: #0d60c8;
    }
    
    .fc-event-time {
        font-weight: bold;
    }
    
    .appointment-details p {
        margin-bottom: 10px;
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


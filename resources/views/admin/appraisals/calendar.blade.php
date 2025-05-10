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
<!-- FullCalendar JS -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        
        // Initialize the calendar
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            events: {!! json_encode($events) !!},
            eventTimeFormat: {
                hour: 'numeric',
                minute: '2-digit',
                meridiem: 'short'
            },
            displayEventTime: true,
            eventClick: function(info) {
                showEventDetails(info.event);
                info.jsEvent.preventDefault(); // don't navigate to event.url
            },
            eventClassNames: function(arg) {
                // Add custom classes based on status
                return [`event-${arg.event.extendedProps.status}`];
            },
            dayMaxEvents: true, // allow "more" link when too many events
            themeSystem: 'bootstrap',
        });
        
        calendar.render();
        
        // Function to show event details in modal
        function showEventDetails(event) {
            // Populate modal with event details
            document.getElementById('modal-client').textContent = event.title;
            document.getElementById('modal-address').textContent = event.extendedProps.address;
            
            // Format the date time
            const date = new Date(event.start);
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: 'numeric',
                minute: '2-digit'
            };
            document.getElementById('modal-datetime').textContent = date.toLocaleDateString('en-US', options);
            
            // Set status with badge
            const statusBadges = {
                'pending': '<span class="badge badge-warning">Pending</span>',
                'confirmed': '<span class="badge badge-success">Confirmed</span>',
                'completed': '<span class="badge badge-primary">Completed</span>',
                'cancelled': '<span class="badge badge-danger">Cancelled</span>'
            };
            document.getElementById('modal-status').innerHTML = statusBadges[event.extendedProps.status] || '';
            
            // Set phone
            document.getElementById('modal-phone').textContent = event.extendedProps.phone || 'N/A';
            
            // Set edit link
            document.getElementById('modal-edit-link').href = event.url;
            
            // Show the modal
            $('#appointmentModal').modal('show');
        }
    });

</script>
@endpush
endsection


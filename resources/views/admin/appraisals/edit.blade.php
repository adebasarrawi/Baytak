@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Edit Appointment</h4>
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
                    <a href="#">Edit</a>
                </li>
            </ul>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Appointment Details</h4>
                            <div class="ml-auto">
                                <a href="{{ route('admin.appraisals.index') }}" class="btn btn-primary btn-round">
                                    <i class="fas fa-arrow-left mr-2"></i>Back to List
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.appraisals.update', $appraisal->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="appraiser_id">Assigned Appraiser</label>
                                        <select class="form-control" id="appraiser_id" name="appraiser_id" required>
                                            <option value="">Select Appraiser</option>
                                            @foreach($appraisers as $appraiser)
                                                <option value="{{ $appraiser->id }}" {{ $appraiser->id == $appraisal->appraiser_id ? 'selected' : '' }}>
                                                    {{ $appraiser->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="pending" {{ $appraisal->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $appraisal->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="completed" {{ $appraisal->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $appraisal->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="appointment_date">Appointment Date</label>
                                        <input type="date" class="form-control" id="appointment_date" name="appointment_date" value="{{ $appraisal->appointment_date }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="appointment_time">Appointment Time</label>
                                        <input type="time" class="form-control" id="appointment_time" name="appointment_time" value="{{ $appraisal->appointment_time }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="client_name">Client Name</label>
                                        <input type="text" class="form-control" id="client_name" name="client_name" value="{{ $appraisal->client_name }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="client_phone">Client Phone</label>
                                        <input type="text" class="form-control" id="client_phone" name="client_phone" value="{{ $appraisal->client_phone }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="client_email">Client Email</label>
                                <input type="email" class="form-control" id="client_email" name="client_email" value="{{ $appraisal->client_email }}" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="property_address">Property Address</label>
                                <textarea class="form-control" id="property_address" name="property_address" rows="2" required>{{ $appraisal->property_address }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="additional_notes">Additional Notes</label>
                                <textarea class="form-control" id="additional_notes" name="additional_notes" rows="3">{{ $appraisal->additional_notes }}</textarea>
                            </div>
                            
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-primary">Update Appointment</button>
                                <a href="{{ route('admin.appraisals.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <!-- Client Information Card -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title text-white mb-0">Quick Actions</h4>
                    </div>
                    <div class="card-body">
                        <div class="status-actions mb-4">
                            <h5>Change Status</h5>
                            <div class="btn-group-vertical w-100">
                                @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $status)
                                    @if($status != $appraisal->status)
                                    <form action="{{ route('admin.appraisals.update-status', $appraisal->id) }}" method="POST" class="mb-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="{{ $status }}">
                                        <button type="submit" class="btn btn-outline-{{ $status == 'pending' ? 'warning' : ($status == 'confirmed' ? 'success' : ($status == 'completed' ? 'primary' : 'danger')) }} btn-block">
                                            <i class="fas fa-{{ $status == 'pending' ? 'clock' : ($status == 'confirmed' ? 'check-circle' : ($status == 'completed' ? 'flag-checkered' : 'times-circle')) }} mr-2"></i>
                                            Mark as {{ ucfirst($status) }}
                                        </button>
                                    </form>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        
                        <hr>
                        
                        <!-- Delete -->
                        <h5>Danger Zone</h5>
                        <form action="{{ route('admin.appraisals.destroy', $appraisal->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this appointment? This action cannot be undone.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block">
                                <i class="fas fa-trash-alt mr-2"></i> Delete Appointment
                            </button>
                        </form>
                        
                        @if($appraisal->user)
                        <hr>
                        
                        <!-- User Information -->
                        <h5>User Information</h5>
                        <div class="user-info">
                            <p><strong>Name:</strong> {{ $appraisal->user->name }}</p>
                            <p><strong>Email:</strong> {{ $appraisal->user->email }}</p>
                            <p><strong>Phone:</strong> {{ $appraisal->user->phone ?? 'N/A' }}</p>
                            <p><strong>Member Since:</strong> {{ $appraisal->user->created_at->format('M d, Y') }}</p>
                        </div>
                        
                        <a href="{{ route('admin.users.show', $appraisal->user->id) }}" class="btn btn-secondary btn-block">
                            <i class="fas fa-user mr-2"></i> View User Profile
                        </a>
                        @endif
                    </div>
                </div>
                
                <!-- Appointment History -->
                @if($appraisal->created_at != $appraisal->updated_at)
                <div class="card mt-3">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Appointment History</h4>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-icon bg-success">
                                    <i class="fas fa-plus"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Created</h6>
                                    <p>{{ $appraisal->created_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-icon bg-primary">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Last Updated</h6>
                                    <p>{{ $appraisal->updated_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Timeline styles */
    .timeline {
        position: relative;
        padding: 10px 0;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        left: 18px;
        height: 100%;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-icon {
        position: absolute;
        left: 0;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        text-align: center;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .timeline-content {
        margin-left: 55px;
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 5px;
    }
    
    .timeline-content h6 {
        margin-bottom: 5px;
        font-weight: 600;
    }
    
    .timeline-content p {
        margin-bottom: 0;
        font-size: 0.9rem;
    }
    
    /* Status colors */
    .badge-pending {
        background-color: #ffad46;
    }
    
    .badge-confirmed {
        background-color: #31ce36;
    }
    
    .badge-completed {
        background-color: #1572e8;
    }
    
    .badge-cancelled {
        background-color: #f25961;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Format date and time inputs if needed
        if($('#appointment_date').length) {
            $('#appointment_date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        }
    });
</script>
@endpush
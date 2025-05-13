
@extends('layouts.public.app')

@section('title', 'My Appraisal Appointments')

@section('content')
<div class="hero page-inner overlay">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-9 text-center mt-5">
        <h1 class="heading" data-aos="fade-up">My Appointments</h1>
        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
          <ol class="breadcrumb text-center justify-content-center">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('profile') }}">My Profile</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">My Appointments</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>

<div class="section">
  <div class="container">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-lg-3 mb-5 mb-lg-0">
        <div class="profile-sidebar shadow rounded bg-white p-4">
          <div class="text-center mb-4">
            @if(Auth::user()->profile_image)
              <img src="{{ asset('storage/'.Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
            @else
              <img src="{{ asset('images/default-avatar.jpg') }}" alt="{{ Auth::user()->name }}" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
            @endif
            <h4>{{ Auth::user()->name }}</h4>
            <p class="text-muted small">{{ Auth::user()->email }}</p>
            @if(Auth::user()->user_type === 'seller')
              <div class="badge bg-primary py-2 px-3 mb-2">Seller Account</div>
            @endif
          </div>
          
          <div class="list-group">
            <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">
              <i class="fas fa-user me-2"></i> Account Information
            </a>
            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
              <i class="fas fa-edit me-2"></i> Edit Profile
            </a>
            @if(Auth::user()->user_type === 'seller')
              <a href="{{ route('properties.my') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-home me-2"></i> My Properties
              </a>
            @endif
            <a href="{{ route('favorites.index') }}" class="list-group-item list-group-item-action">
              <i class="fas fa-heart me-2"></i> Favorites
            </a>
            <a href="{{ url('/my-appraisals') }}" class="list-group-item list-group-item-action active">
              <i class="fas fa-calendar-check me-2"></i> My Appointments
            </a>
            <a href="{{ route('notifications.index') }}" class="list-group-item list-group-item-action">
              <i class="fas fa-bell me-2"></i> Notifications
            </a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action text-danger">
              <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </div>
      </div>
      
      <!-- Main Content -->
      <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="mb-0">My Appraisal Appointments</h2>
          <a href="{{ route('property.estimation') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Book New Appointment
          </a>
        </div>
        
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        
        @if($appraisals->isEmpty())
          <div class="card text-center py-5">
            <div class="card-body">
              <i class="fas fa-calendar-alt fa-4x text-muted mb-4"></i>
              <h4>No Appointments Yet</h4>
              <p class="text-muted">You haven't booked any property appraisal appointments yet.</p>
              <a href="{{ route('property.estimation') }}" class="btn btn-primary mt-3">
                <i class="fas fa-plus-circle me-2"></i> Book an Appointment
              </a>
            </div>
          </div>
        @else
          <div class="card shadow-sm">
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-hover mb-0">
                  <thead class="bg-light">
                    <tr>
                      <th>Appointment ID</th>
                      <th>Property Address</th>
                      <th>Date & Time</th>
                      <th>Appraiser</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($appraisals as $appraisal)
                      <tr>
                        <td>#{{ $appraisal->id }}</td>
                        <td>
                          <div class="text-wrap" style="max-width: 200px;">{{ $appraisal->property_address }}</div>
                        </td>
                        <td>
                          <div>{{ \Carbon\Carbon::parse($appraisal->appointment_date)->format('M d, Y') }}</div>
                          <div class="text-muted small">{{ \Carbon\Carbon::parse($appraisal->appointment_time)->format('h:i A') }}</div>
                        </td>
                        <td>
                          @if($appraisal->appraiser)
                            {{ $appraisal->appraiser->name }}
                          @else
                            Not Assigned
                          @endif
                        </td>
                        <td>
                          @php
                            $statusClasses = [
                              'pending' => 'bg-warning',
                              'confirmed' => 'bg-success',
                              'completed' => 'bg-primary',
                              'cancelled' => 'bg-danger'
                            ];
                            $statusClass = $statusClasses[$appraisal->status] ?? 'bg-secondary';
                          @endphp
                          <span class="badge {{ $statusClass }} py-2 px-3">{{ ucfirst($appraisal->status) }}</span>
                        </td>
                        <td>
                          <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#appointmentDetails-{{ $appraisal->id }}">
                            <i class="fas fa-eye me-1"></i> View
                          </button>
                          
                          @if($appraisal->status === 'pending')
                            <form action="{{ route('property.appraisal.cancel', $appraisal->id) }}" method="POST" class="d-inline">
                              @csrf
                              @method('PUT')
                              <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                <i class="fas fa-times-circle me-1"></i> Cancel
                              </button>
                            </form>
                          @endif
                        </td>
                      </tr>
                      
                      <!-- Appointment Details Modal -->
                      <div class="modal fade" id="appointmentDetails-{{ $appraisal->id }}" tabindex="-1" aria-labelledby="appointmentDetailsLabel-{{ $appraisal->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="appointmentDetailsLabel-{{ $appraisal->id }}">Appointment Details #{{ $appraisal->id }}</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                              <div class="row g-4">
                                <div class="col-md-6">
                                  <h6 class="text-primary">Appointment Information</h6>
                                  <div class="mb-3">
                                    <label class="fw-bold">Status:</label>
                                    <span class="badge {{ $statusClass }} py-2 px-3 ms-2">{{ ucfirst($appraisal->status) }}</span>
                                  </div>
                                  <div class="mb-3">
                                    <label class="fw-bold">Date:</label>
                                    <span>{{ \Carbon\Carbon::parse($appraisal->appointment_date)->format('F d, Y') }}</span>
                                  </div>
                                  <div class="mb-3">
                                    <label class="fw-bold">Time:</label>
                                    <span>{{ \Carbon\Carbon::parse($appraisal->appointment_time)->format('h:i A') }}</span>
                                  </div>
                                  <div class="mb-3">
                                    <label class="fw-bold">Created On:</label>
                                    <span>{{ $appraisal->created_at->format('F d, Y') }}</span>
                                  </div>
                                </div>
                                
                                <div class="col-md-6">
                                  <h6 class="text-primary">Property Information</h6>
                                  <div class="mb-3">
                                    <label class="fw-bold">Address:</label>
                                    <p class="mb-1">{{ $appraisal->property_address }}</p>
                                  </div>
                                  
                                  @if($appraisal->property_type)
                                    <div class="mb-3">
                                      <label class="fw-bold">Property Type:</label>
                                      <span>{{ ucfirst($appraisal->property_type) }}</span>
                                    </div>
                                  @endif
                                  
                                  @if($appraisal->property_area)
                                    <div class="mb-3">
                                      <label class="fw-bold">Property Area:</label>
                                      <span>{{ $appraisal->property_area }} sq.m</span>
                                    </div>
                                  @endif
                                  
                                  @if($appraisal->bedrooms || $appraisal->bathrooms)
                                    <div class="mb-3">
                                      <label class="fw-bold">Features:</label>
                                      <span>
                                        @if($appraisal->bedrooms)
                                          {{ $appraisal->bedrooms }} Bedrooms
                                        @endif
                                        @if($appraisal->bedrooms && $appraisal->bathrooms), @endif
                                        @if($appraisal->bathrooms)
                                          {{ $appraisal->bathrooms }} Bathrooms
                                        @endif
                                      </span>
                                    </div>
                                  @endif
                                </div>
                                
                                <div class="col-md-6">
                                  <h6 class="text-primary">Appraiser Information</h6>
                                  @if($appraisal->appraiser)
                                    <div class="mb-3">
                                      <label class="fw-bold">Name:</label>
                                      <span>{{ $appraisal->appraiser->name }}</span>
                                    </div>
                                    <div class="mb-3">
                                      <label class="fw-bold">Email:</label>
                                      <span>{{ $appraisal->appraiser->email }}</span>
                                    </div>
                                    <div class="mb-3">
                                      <label class="fw-bold">Phone:</label>
                                      <span>{{ $appraisal->appraiser->phone ?? 'Not available' }}</span>
                                    </div>
                                  @else
                                    <p class="text-muted">Appraiser not yet assigned</p>
                                  @endif
                                </div>
                                
                                <div class="col-md-6">
                                  <h6 class="text-primary">Additional Information</h6>
                                  <div class="mb-3">
                                    <label class="fw-bold">Notes:</label>
                                    <p class="mb-0">{{ $appraisal->additional_notes ?: 'No additional notes provided.' }}</p>
                                  </div>
                                </div>
                              </div>
                              
                              @if($appraisal->status === 'confirmed')
                                <div class="alert alert-info mt-3">
                                  <i class="fas fa-info-circle me-2"></i>
                                  <span>Your appointment has been confirmed. Please make sure to be available at the property location at the scheduled time.</span>
                                </div>
                              @elseif($appraisal->status === 'completed')
                                <div class="alert alert-success mt-3">
                                  <i class="fas fa-check-circle me-2"></i>
                                  <span>Your appointment has been completed. You will receive the appraisal report via email soon.</span>
                                </div>
                              @elseif($appraisal->status === 'cancelled')
                                <div class="alert alert-danger mt-3">
                                  <i class="fas fa-times-circle me-2"></i>
                                  <span>This appointment has been cancelled. If you still need an appraisal, please book a new appointment.</span>
                                </div>
                              @endif
                            </div>
                            <div class="modal-footer">
                              @if($appraisal->status === 'pending')
                                <form action="{{ route('property.appraisal.cancel', $appraisal->id) }}" method="POST" class="d-inline">
                                  @csrf
                                  @method('PUT')
                                  <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                    <i class="fas fa-times-circle me-2"></i> Cancel Appointment
                                  </button>
                                </form>
                              @endif
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
          <!-- Pagination -->
          <div class="d-flex justify-content-center mt-4">
            {{ $appraisals->links() }}
          </div>
        @endif
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
  .status-badge {
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
  }
  
  .table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
  }
  
  .table tbody tr {
    transition: all 0.2s ease;
  }
  
  .table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.04);
  }
  
  .appointment-card {
    transition: all 0.3s ease;
    border-radius: 8px;
    overflow: hidden;
  }
  
  .appointment-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
  }
</style>
@endpush
@endsection

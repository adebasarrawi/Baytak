@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Review Property</h4>
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
                    <a href="{{ route('admin.properties.index') }}">Properties</a>
                </li>
                <li class="separator">
                    <i class="fas fa-angle-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Review</a>
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
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Property Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>{{ $property->title }}</h3>
                                <p class="text-muted">{{ $property->address }}</p>
                                <hr>
                                
                                <div class="property-images mb-4">
                                    <div class="row">
                                        @foreach($property->images as $image)
                                        <div class="col-md-4 mb-3">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded" alt="Property Image">
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <div class="property-details mb-4">
                                    <h5>Description</h5>
                                    <p>{{ $property->description }}</p>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Type:</strong> {{ $property->type->name }}</p>
                                            <p><strong>Area:</strong> {{ $property->area->name }}</p>
                                            <p><strong>Purpose:</strong> {{ $property->purpose == 'sale' ? 'For Sale' : 'For Rent' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Price:</strong> {{ number_format($property->price) }} JOD</p>
                                            <p><strong>Size:</strong> {{ $property->size }} sq.ft</p>
                                            <p><strong>Bedrooms:</strong> {{ $property->bedrooms }}</p>
                                            <p><strong>Bathrooms:</strong> {{ $property->bathrooms }}</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="owner-details mb-4">
                                    <h5>Owner Information</h5>
                                    <div class="card">
                                        <div class="card-body">
                                            <p><strong>Name:</strong> {{ $property->user->name }}</p>
                                            <p><strong>Email:</strong> {{ $property->user->email }}</p>
                                            <p><strong>Phone:</strong> {{ $property->user->phone ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Approval Status</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.properties.update-status', $property->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label>Current Status</label>
                                <div class="alert alert-{{ 
                                    $property->status == 'pending' ? 'warning' : 
                                    ($property->status == 'approved' ? 'success' : 'danger') 
                                }}">
                                    {{ ucfirst($property->status) }}
                                    @if($property->status == 'rejected' && $property->rejection_reason)
                                        <hr>
                                        <strong>Reason:</strong> {{ $property->rejection_reason }}
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="status">Change Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="pending" {{ $property->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $property->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $property->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            
                            <?= ($property->status == 'rejected') ? 'required' : '' ?>
                                                            <label for="rejection_reason">Rejection Reason</label>
                                <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3"
                                    {{ $property->status == 'rejected' ? 'required' : '' }}>{{ $property->rejection_reason }}</textarea>
                                <small class="text-muted">Required when status is Rejected</small>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-save mr-2"></i> Update Status
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const reasonGroup = document.getElementById('rejection-reason-group');
        const reasonTextarea = document.getElementById('rejection_reason');
        
        function toggleReasonField() {
            if (statusSelect.value === 'rejected') {
                reasonGroup.style.display = 'block';
                reasonTextarea.setAttribute('required', 'required');
            } else {
                reasonGroup.style.display = 'none';
                reasonTextarea.removeAttribute('required');
            }
        }
        
        // Initial check
        toggleReasonField();
        
        // Event listener
        statusSelect.addEventListener('change', toggleReasonField);
    });
</script>
@endpush
@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Property Details</h1>
        <a href="{{ route('admin.properties.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Properties
        </a>
    </div>

    <!-- Property Status Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Property Status</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Property Actions:</div>
                    <a class="dropdown-item" href="{{ route('admin.properties.edit', $property->id) }}">
                        <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                        Edit Property
                    </a>
                    <div class="dropdown-divider"></div>
                    @if($property->is_approved === null)
                        <a class="dropdown-item text-success" href="{{ route('admin.properties.direct-update-status', ['id' => $property->id, 'status' => 'approved']) }}" onclick="return confirm('Are you sure you want to approve this property?')">
                            <i class="fas fa-check fa-sm fa-fw mr-2 text-success"></i>
                            Approve Property
                        </a>
                        <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#rejectModal">
                            <i class="fas fa-times fa-sm fa-fw mr-2 text-danger"></i>
                            Reject Property
                        </a>
                    @elseif($property->is_approved === true)
                        <a class="dropdown-item text-danger" href="{{ route('admin.properties.direct-update-status', ['id' => $property->id, 'status' => 'rejected']) }}" onclick="return confirm('Are you sure you want to reject this property?')">
                            <i class="fas fa-ban fa-sm fa-fw mr-2 text-danger"></i>
                            Change to Rejected
                        </a>
                    @else
                        <a class="dropdown-item text-success" href="{{ route('admin.properties.direct-update-status', ['id' => $property->id, 'status' => 'approved']) }}" onclick="return confirm('Are you sure you want to approve this property?')">
                            <i class="fas fa-check fa-sm fa-fw mr-2 text-success"></i>
                            Change to Approved
                        </a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#deleteModal">
                        <i class="fas fa-trash fa-sm fa-fw mr-2 text-danger"></i>
                        Delete Property
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h4 class="font-weight-bold">{{ $property->title }}</h4>
                    <p class="text-muted">
                        <i class="fas fa-map-marker-alt mr-1"></i> {{ $property->address }}
                    </p>
                    <p class="mb-2">
                        <span class="badge badge-primary">{{ ucfirst($property->purpose) }}</span>
                        <span class="badge badge-info">{{ $property->type->name ?? 'N/A' }}</span>
                        <span class="badge badge-secondary">{{ $property->area->name ?? 'N/A' }}</span>
                    </p>
                </div>
                <div class="col-md-4 text-md-right">
                    <div class="mb-2">
                        @if($property->is_approved === null)
                            <span class="badge badge-warning py-2 px-3">Pending Review</span>
                        @elseif($property->is_approved === true)
                            <span class="badge badge-success py-2 px-3">Approved</span>
                        @else
                            <span class="badge badge-danger py-2 px-3">Rejected</span>
                        @endif
                    </div>
                    <div class="mb-2">
                        <span class="h4 text-primary font-weight-bold">{{ number_format($property->price) }} JOD</span>
                    </div>
                    <div>
                        <small class="text-muted">
                            <i class="fas fa-calendar-alt mr-1"></i> 
                            Submitted: {{ $property->created_at->format('M d, Y') }}
                        </small>
                    </div>
                </div>
            </div>
            
            <!-- Rejection Reason (if rejected) -->
            @if($property->is_approved === false && $property->rejection_reason)
                <div class="alert alert-danger mt-3">
                    <h6 class="font-weight-bold">Rejection Reason:</h6>
                    <p class="mb-0">{{ $property->rejection_reason }}</p>
                </div>
            @endif
            
            <!-- Quick Action Buttons -->
            <div class="mt-3">
                @if($property->is_approved === null)
                    <div class="btn-group">
                        <a href="{{ route('admin.properties.direct-update-status', ['id' => $property->id, 'status' => 'approved']) }}" 
                           class="btn btn-success" 
                           onclick="return confirm('Are you sure you want to approve this property?')">
                            <i class="fas fa-check mr-1"></i> Approve Property
                        </a>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#rejectModal">
                            <i class="fas fa-times mr-1"></i> Reject Property
                        </button>
                    </div>
                @elseif($property->is_approved === true)
                    <a href="{{ route('admin.properties.direct-update-status', ['id' => $property->id, 'status' => 'rejected']) }}" 
                       class="btn btn-warning" 
                       onclick="return confirm('Are you sure you want to change this property status to rejected?')">
                        <i class="fas fa-undo mr-1"></i> Change to Rejected
                    </a>
                @else
                    <a href="{{ route('admin.properties.direct-update-status', ['id' => $property->id, 'status' => 'approved']) }}" 
                       class="btn btn-success" 
                       onclick="return confirm('Are you sure you want to change this property status to approved?')">
                        <i class="fas fa-undo mr-1"></i> Change to Approved
                    </a>
                @endif
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- Property Images -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Property Images</h6>
                </div>
                <div class="card-body">
                    @if($property->images->count() > 0)
                        <div id="propertyImagesCarousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach($property->images as $index => $image)
                                    <li data-target="#propertyImagesCarousel" data-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}"></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach($property->images as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="d-block w-100" alt="Property Image" style="height: 400px; object-fit: cover;">
                                        <div class="carousel-caption d-none d-md-block bg-dark-transparent py-1 px-2 rounded">
                                            <h5 class="mb-0">{{ $image->is_primary ? 'Primary Image' : 'Image ' . ($index + 1) }}</h5>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#propertyImagesCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#propertyImagesCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                        
                        <!-- Thumbnails -->
                        <div class="row mt-3">
                            @foreach($property->images as $index => $image)
                                <div class="col-md-2 col-sm-3 col-4 mb-2">
                                onclick="$('#propertyImagesCarousel').carousel({ index: {{ $index }} })"                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail {{ $image->is_primary ? 'border-primary' : '' }}" alt="Thumbnail" style="height: 80px; object-fit: cover;">
                                        @if($image->is_primary)
                                            <span class="badge badge-primary position-absolute" style="top: 5px; right: 20px;">Primary</span>
                                        @endif
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-images fa-3x text-gray-300 mb-3"></i>
                            <p class="text-gray-500">No images available for this property.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Property Description -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Property Description</h6>
                </div>
                <div class="card-body">
                    <div class="property-description mb-4">
                        {!! nl2br(e($property->description)) !!}
                    </div>
                    
                    <h6 class="font-weight-bold">Property Features:</h6>
                    <div class="row mb-3">
                        <div class="col-md-3 mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-ruler-combined fa-fw text-primary mr-2"></i>
                                <div>
                                    <small class="text-muted">Size</small>
                                    <div>{{ number_format($property->size) }} sq.ft</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-bed fa-fw text-primary mr-2"></i>
                                <div>
                                    <small class="text-muted">Bedrooms</small>
                                    <div>{{ $property->bedrooms ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-bath fa-fw text-primary mr-2"></i>
                                <div>
                                    <small class="text-muted">Bathrooms</small>
                                    <div>{{ $property->bathrooms ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-car fa-fw text-primary mr-2"></i>
                                <div>
                                    <small class="text-muted">Parking Spaces</small>
                                    <div>{{ $property->parking_spaces ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($property->features && $property->features->count() > 0)
                        <h6 class="font-weight-bold">Additional Features:</h6>
                        <div class="row">
                            @foreach($property->features as $feature)
                                <div class="col-md-4 mb-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success mr-2"></i>
                                        <div>{{ $feature->name }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Property Details Sidebar -->
        <div class="col-lg-4">
            <!-- Seller Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Seller Information</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        @if($property->user && $property->user->profile_image)
                            <img src="{{ asset('storage/' . $property->user->profile_image) }}" class="rounded-circle img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="bg-gray-200 rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <i class="fas fa-user fa-3x text-gray-500"></i>
                            </div>
                        @endif
                        <h5 class="mt-3 mb-0">{{ $property->user->name ?? 'Unknown User' }}</h5>
                        <p class="text-muted small">{{ $property->user->email ?? 'No email available' }}</p>
                    </div>
                    
                    <div class="list-group small">
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-5 text-muted">User ID:</div>
                                <div class="col-7 text-right">{{ $property->user->id ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-5 text-muted">Contact Phone:</div>
                                <div class="col-7 text-right">{{ $property->contact_phone ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-5 text-muted">Contact Email:</div>
                                <div class="col-7 text-right">{{ $property->contact_email ?? $property->user->email ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-5 text-muted">Registered On:</div>
                                <div class="col-7 text-right">{{ $property->user->created_at->format('M d, Y') ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="mailto:{{ $property->contact_email ?? $property->user->email ?? '' }}" class="btn btn-sm btn-primary btn-block">
                            <i class="fas fa-envelope mr-1"></i> Contact Seller
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Property Statistics -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Property Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="list-group small">
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-7 text-muted">Property ID:</div>
                                <div class="col-5 text-right">{{ $property->id }}</div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-7 text-muted">Property Type:</div>
                                <div class="col-5 text-right">{{ $property->type->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-7 text-muted">Area:</div>
                                <div class="col-5 text-right">{{ $property->area->name ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-7 text-muted">Purpose:</div>
                                <div class="col-5 text-right">{{ ucfirst($property->purpose) }}</div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-7 text-muted">Featured:</div>
                                <div class="col-5 text-right">
                                    @if($property->is_featured)
                                        <span class="badge badge-success">Yes</span>
                                    @else
                                        <span class="badge badge-secondary">No</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-7 text-muted">Views:</div>
                                <div class="col-5 text-right">{{ $property->views ?? 0 }}</div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-7 text-muted">Year Built:</div>
                                <div class="col-5 text-right">{{ $property->year_built ?? 'N/A' }}</div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-7 text-muted">Created:</div>
                                <div class="col-5 text-right">{{ $property->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-7 text-muted">Last Updated:</div>
                                <div class="col-5 text-right">{{ $property->updated_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <a href="{{ route('properties.show', $property->id) }}" target="_blank" class="btn btn-sm btn-info btn-block">
                            <i class="fas fa-external-link-alt mr-1"></i> View on Public Site
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Toggle Featured Status -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Featured Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.properties.update-featured', $property->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="custom-control custom-switch mb-3">
                            <input type="checkbox" class="custom-control-input" id="featuredSwitch" name="is_featured" value="1" {{ $property->is_featured ? 'checked' : '' }}>
                            <label class="custom-control-label" for="featuredSwitch">
                                Mark as Featured Property
                            </label>
                            <div class="small text-muted mt-1">
                                Featured properties will be highlighted and displayed prominently on the website.
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            Update Featured Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">Reject Property</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.properties.update-status', $property->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="rejected">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejection_reason">Reason for Rejection:</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" required>{{ $property->rejection_reason }}</textarea>
                        <small class="form-text text-muted">Please provide a clear explanation for why this property is being rejected. This reason will be visible to the seller.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Property</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">Delete Property</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this property? This action cannot be undone.</p>
                <p><strong>Title:</strong> {{ $property->title }}</p>
                <p class="text-danger">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Warning: This will permanently delete the property and all associated images from the system.
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Property</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.bg-dark-transparent {
    background-color: rgba(0, 0, 0, 0.5);
}
</style>
@endpush

@endsection
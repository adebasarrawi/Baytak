@extends('layouts.public.app')

@section('title', 'My Properties')

@section('content')
<div class="hero page-inner overlay">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-9 text-center mt-5">
        <h1 class="heading" data-aos="fade-up">My Properties</h1>
        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
          <ol class="breadcrumb text-center justify-content-center">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">My Properties</li>
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
            <div class="badge bg-primary py-2 px-3 mb-2">Seller Account</div>
          </div>
          
          <div class="list-group">
          <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">
          <i class="fas fa-user me-2"></i> Account Information
            </a>
            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
              <i class="fas fa-edit me-2"></i> Edit Profile
            </a>
            @if(Auth::user()->user_type === 'seller')
            <a href="{{ route('properties.my') }}" class="list-group-item list-group-item-action active">
              <i class="fas fa-home me-2"></i> My Properties
            </a>
            @endif
            <a href="{{ route('favorites.index') }}" class="list-group-item list-group-item-action">            </a>
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
          <h2 class="mb-0">My Properties</h2>
          <a href="{{ route('properties.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> Add New Property
          </a>
        </div>
        
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        
        <!-- Property Filters -->
        <div class="card shadow-sm mb-4">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="mb-0">Filter Properties</h5>
              <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse">
                <i class="fas fa-filter me-1"></i> Filters
              </button>
            </div>
            <div class="collapse" id="filterCollapse">
              <div class="row g-3">
                <div class="col-md-6">
                  <select class="form-select form-select-sm" id="statusFilter">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending Approval</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <select class="form-select form-select-sm" id="purposeFilter">
                    <option value="">All Purposes</option>
                    <option value="sale">For Sale</option>
                    <option value="rent">For Rent</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Property Listings -->
        <div class="row property-list">
          @forelse($properties as $property)
            <div class="col-md-6 mb-4 property-item" data-status="{{ $property->is_approved === null ? 'pending' : ($property->is_approved ? 'approved' : 'rejected') }}" data-purpose="{{ $property->purpose }}">
              <div class="card h-100 shadow-sm property-card">
                <div class="position-relative">
                  @php
                    $primaryImage = $property->images->where('is_primary', true)->first();
                    $fallbackImage = $property->images->first();
                    $imagePath = null;
                    
                    if ($primaryImage && file_exists(public_path('storage/' . $primaryImage->image_path))) {
                      $imagePath = asset('storage/' . $primaryImage->image_path);
                    } elseif ($fallbackImage && file_exists(public_path('storage/' . $fallbackImage->image_path))) {
                      $imagePath = asset('storage/' . $fallbackImage->image_path);
                    } else {
                      $imagePath = asset('images/default-property.jpg');
                    }
                  @endphp
                  <img src="{{ $imagePath }}" class="card-img-top" alt="{{ $property->title }}" style="height: 200px; object-fit: cover;">
                  <div class="property-status-badge position-absolute top-0 end-0 m-2">
                    @if($property->is_approved === null)
                      <span class="badge bg-warning">Pending Approval</span>
                    @elseif($property->is_approved)
                      <span class="badge bg-success">Approved</span>
                    @else
                      <span class="badge bg-danger">Rejected</span>
                    @endif
                  </div>
                  <div class="property-price-badge position-absolute bottom-0 start-0 m-2">
                    <span class="badge bg-primary p-2">{{ number_format($property->price) }} JOD</span>
                  </div>
                </div>
                <div class="card-body">
                  <h5 class="card-title">{{ $property->title }}</h5>
                  <p class="card-text text-muted small">
                    <i class="fas fa-map-marker-alt me-1"></i> {{ $property->address }}
                  </p>
                  <div class="property-features d-flex justify-content-between mb-3">
                    <span><i class="fas fa-bed text-primary me-1"></i> {{ $property->bedrooms ?? '0' }} Beds</span>
                    <span><i class="fas fa-bath text-primary me-1"></i> {{ $property->bathrooms ?? '0' }} Baths</span>
                    <span><i class="fas fa-ruler-combined text-primary me-1"></i> {{ $property->size }} sq.ft</span>
                  </div>
                  <div class="property-status mb-3">
                    @if($property->is_approved === null)
                      <div class="alert alert-warning py-1 px-2 mb-2 small">
                        <i class="fas fa-clock me-1"></i> Your property is pending approval. Our team will review it shortly.
                      </div>
                    @elseif(!$property->is_approved)
                      <div class="alert alert-danger py-1 px-2 mb-2 small">
                        <i class="fas fa-times-circle me-1"></i> Your property was rejected. Please contact support for more information.
                      </div>
                    @endif
                  </div>
                  <div class="property-buttons d-flex justify-content-between">
                    <a href="{{ route('properties.show', $property->id) }}" class="btn btn-sm btn-outline-primary">
                      <i class="fas fa-eye me-1"></i> View
                    </a>
                    <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-sm btn-outline-secondary">
                      <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $property->id }}">
                      <i class="fas fa-trash-alt me-1"></i> Delete
                    </button>
                  </div>
                </div>
                <div class="card-footer bg-white text-muted small">
                  <div class="d-flex justify-content-between">
                    <span><i class="fas fa-calendar-alt me-1"></i> Listed on: {{ $property->created_at->format('M d, Y') }}</span>
                    <span>
                      @if($property->is_featured)
                        <i class="fas fa-star text-warning me-1"></i> Featured
                      @endif
                    </span>
                  </div>
                </div>
              </div>
              
              <!-- Delete Confirmation Modal -->
              <div class="modal fade" id="deleteModal{{ $property->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $property->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                      <h5 class="modal-title" id="deleteModalLabel{{ $property->id }}">Confirm Deletion</h5>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <p>Are you sure you want to delete <strong>{{ $property->title }}</strong>? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <form action="{{ route('properties.destroy', $property->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Property</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <div class="alert alert-info" role="alert">
                <div class="text-center py-4">
                  <i class="fas fa-home fa-3x mb-3"></i>
                  <h4>No Properties Yet</h4>
                  <p>You haven't listed any properties yet. Click the button below to add your first property.</p>
                  <a href="{{ route('properties.create') }}" class="btn btn-primary mt-2">
                    <i class="fas fa-plus-circle me-2"></i> Add New Property
                  </a>
                </div>
              </div>
            </div>
          @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
          {{ $properties->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const statusFilter = document.getElementById('statusFilter');
    const purposeFilter = document.getElementById('purposeFilter');
    const propertyItems = document.querySelectorAll('.property-item');
    
    function applyFilters() {
      const statusValue = statusFilter.value;
      const purposeValue = purposeFilter.value;
      
      propertyItems.forEach(item => {
        const statusMatch = !statusValue || item.dataset.status === statusValue;
        const purposeMatch = !purposeValue || item.dataset.purpose === purposeValue;
        
        if (statusMatch && purposeMatch) {
          item.style.display = '';
        } else {
          item.style.display = 'none';
        }
      });
    }
    
    statusFilter.addEventListener('change', applyFilters);
    purposeFilter.addEventListener('change', applyFilters);
  });
</script>
@endpush
@endsection
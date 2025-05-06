@extends('layouts.public.app')

@section('title', 'My Favorites')

@section('content')
<div class="hero page-inner overlay">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-9 text-center mt-5">
        <h1 class="heading" data-aos="fade-up">My Favorite Properties</h1>
        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
          <ol class="breadcrumb text-center justify-content-center">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('profile.show') }}">My Profile</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">Favorites</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>

<div class="section">
  <div class="container">
    <div class="row mb-5 align-items-center">
      <div class="col-lg-6 text-center mx-auto">
        <h2 class="font-weight-bold text-primary heading">My Wishlist</h2>
      </div>
    </div>
    
    @if($favorites->count() > 0)
      <div class="row">
        @foreach($favorites as $property)
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="property-item h-100 overflow-hidden position-relative">
            <a href="{{ route('properties.show', $property->id) }}" class="img position-relative d-block">
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
              
              <img src="{{ $imagePath }}" alt="{{ $property->title }}" class="img-fluid w-100 property-image" style="height: 250px; object-fit: cover;">

              <div class="property-overlay">
                <span class="property-type">{{ $property->type->name ?? 'N/A' }}</span>
              </div>

              @if($property->is_featured)
                <span class="featured-badge">Featured</span>
              @endif
              
              <span class="purpose-badge {{ $property->purpose }}">
                {{ $property->purpose == 'sale' ? 'For Sale' : 'For Rent' }}
              </span>
            </a>

            <!-- Wishlist Heart Icon -->
            <button class="wishlist-button" type="button" data-property-id="{{ $property->id }}">
              <i class="fas fa-heart wishlist-icon active" id="wishlist-{{ $property->id }}"></i>
            </button>
            
            <div class="property-content p-4">
              <div class="price-area d-flex justify-content-between align-items-center mb-3">
                <div class="price">
                  <span class="fs-5 fw-bold text-primary">${{ number_format($property->price) }}</span>
                  @if($property->purpose == 'rent')
                    <span class="small text-muted">/month</span>
                  @endif
                </div>
                <div class="area">
                  <span class="badge bg-light text-dark">
                    <i class="fas fa-ruler-combined me-1"></i> {{ number_format($property->size) }} sq.ft
                  </span>
                </div>
              </div>
              
              <h3 class="h5 mb-2">
                <a href="{{ route('properties.show', $property->id) }}" class="text-decoration-none text-dark property-title">
                  {{ \Illuminate\Support\Str::limit($property->title, 40) }}
                </a>
              </h3>
              
              <div>
                <p class="mb-2 text-muted small">
                  <i class="fas fa-map-marker-alt me-1"></i> 
                  {{ \Illuminate\Support\Str::limit($property->address, 50) }}
                </p>
                <p class="city mb-3 small">
                  <i class="fas fa-map me-1"></i> 
                  {{ $property->area->name ?? 'N/A' }}
                </p>

                <div class="specs d-flex mb-3 justify-content-between border-top pt-3">
                  <span class="d-block d-flex align-items-center small">
                    <i class="fas fa-bed me-2 text-primary"></i>
                    <span class="caption">{{ $property->bedrooms ?? 'N/A' }} Beds</span>
                  </span>

                  <span class="d-block d-flex align-items-center small">
                    <i class="fas fa-bath me-2 text-primary"></i>
                    <span class="caption">{{ $property->bathrooms ?? 'N/A' }} Baths</span>
                  </span>
                  <span class="d-block d-flex align-items-center small">
                    <i class="fas fa-car me-2 text-primary"></i>
                    <span class="caption">{{ $property->parking_spaces ?? 'N/A' }} Parking</span>
                  </span>
                 
                </div>

                <div class="property-footer d-flex justify-content-between">
                  <a href="{{ route('properties.show', $property->id) }}" class="btn btn-outline-primary btn-sm">View Details</a>
                  <span class="property-date small text-muted align-self-center">
                    <i class="far fa-calendar-alt me-1"></i> {{ $property->created_at->diffForHumans() }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    @else
      <div class="col-12 text-center py-5">
        <div class="empty-state p-4 bg-light rounded">
          <i class="fas fa-heart-broken fa-3x text-muted mb-3"></i>
          <h3>Your wishlist is empty</h3>
          <p class="text-muted">You haven't added any properties to your wishlist yet.</p>
          <a href="{{ route('properties.index') }}" class="btn btn-primary mt-3">Browse Properties</a>
        </div>
      </div>
    @endif
    
    <!-- Pagination -->
    <div class="row align-items-center py-5">
      <div class="col-lg-12">
        <div class="custom-pagination">
          {{ $favorites->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Same styles and scripts as in the properties.blade.php -->
@push('styles')
<style>
  /* Copy all the styles from properties.blade.php */
</style>
@endpush

@push('scripts')
<script>
  // Function to toggle wishlist status
  function toggleWishlist(propertyId) {
    const button = document.querySelector(`[data-property-id="${propertyId}"]`);
    const icon = button.querySelector('.wishlist-icon');
    
    // Send AJAX request to toggle favorite
    fetch('/favorites/toggle', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({ property_id: propertyId })
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'added') {
        icon.classList.remove('far');
        icon.classList.add('fas', 'active');
        showNotification('Property added to favorites', 'success');
      } else if (data.status === 'removed') {
        icon.classList.remove('fas', 'active');
        icon.classList.add('far');
        showNotification('Property removed from favorites', 'info');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      showNotification('An error occurred. Please try again.', 'error');
    });
  }

  // Function to show notifications
  function showNotification(message, type = 'info') {
    // You can implement your preferred notification system here
    // For example, using Toastr, SweetAlert, or a custom notification
    alert(message); // Simple alert for now
  }

  // Add click event listeners to all wishlist buttons
  document.addEventListener('DOMContentLoaded', function() {
    const wishlistButtons = document.querySelectorAll('.wishlist-button');
    wishlistButtons.forEach(button => {
      button.addEventListener('click', function() {
        const propertyId = this.getAttribute('data-property-id');
        toggleWishlist(propertyId);
      });
    });
  });
</script>
@endpush
@endsection
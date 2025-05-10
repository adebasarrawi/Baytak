@extends('layouts.public.app')

@section('title', 'My Favorites')

@section('content')
<div class="hero page-inner overlay" >
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-9 text-center mt-5">
        <h1 class="heading" data-aos="fade-up">My Favorites</h1>
        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
          <ol class="breadcrumb text-center justify-content-center">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">My Favorites</li>
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
            <a href="{{ route('favorites.index') }}" class="list-group-item list-group-item-action active">
  <i class="fas fa-heart me-2"></i> Favorites
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
          <h2 class="mb-0">Favorite Properties</h2>
        </div>
        
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        
        <!-- Property Listings -->
        <div class="row">
          @forelse($favorites as $favorite)
            <div class="col-md-6 mb-4">
              <div class="card h-100 shadow-sm property-card">
                <div class="position-relative">
                  @php
                    $property = $favorite->property;
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
                  <div class="position-absolute top-0 end-0 m-2">
                    @if($property->purpose == 'sale')
                      <span class="badge bg-primary">For Sale</span>
                    @else
                      <span class="badge bg-info">For Rent</span>
                    @endif
                  </div>
                  <div class="position-absolute bottom-0 start-0 m-2">
                    <span class="badge bg-dark p-2">{{ number_format($property->price) }} JOD</span>
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
                  <div class="d-flex justify-content-between">
                    <a href="{{ route('properties.show', $property->id) }}" class="btn btn-sm btn-outline-primary">
                      <i class="fas fa-eye me-1"></i> View Details
                    </a>
                    <form action="{{ route('favorites.toggle') }}" method="POST">
                      @csrf
                      <input type="hidden" name="property_id" value="{{ $property->id }}">
                      <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fas fa-heart-broken me-1"></i> Remove
                      </button>
                    </form>
                  </div>
                </div>
                <div class="card-footer bg-white text-muted small">
                  <div class="d-flex justify-content-between">
                    <span><i class="fas fa-calendar-alt me-1"></i> Added: {{ $favorite->created_at->format('M d, Y') }}</span>
                    @if($property->is_featured)
                      <span><i class="fas fa-star text-warning me-1"></i> Featured</span>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <div class="card text-center py-5">
                <div class="card-body">
                  <i class="fas fa-heart fa-4x text-danger mb-4"></i>
                  <h4>No Favorites Yet</h4>
                  <p class="text-muted">You haven't added any properties to your favorites yet.</p>
                  <a href="{{ route('properties.index') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-search me-2"></i> Browse Properties
                  </a>
                </div>
              </div>
            </div>
          @endforelse
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
          {{ $favorites->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
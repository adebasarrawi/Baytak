@extends('layouts.public.app')

@section('title', $property->title)

@section('content')

<div class="hero page-inner overlay" >
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-9 text-center mt-5">
        <h1 class="heading" data-aos="fade-up">{{ $property->title }}</h1>
        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
          <ol class="breadcrumb text-center justify-content-center">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('properties.index') }}">Properties</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">{{ \Illuminate\Support\Str::limit($property->title, 20) }}</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>

<div class="section">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 mb-5">
        <!-- Property Title and Price Section - Mobile Only -->
        <div class="d-block d-lg-none mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0 fs-4">{{ $property->title }}</h2>
            <div class="price">
              <span class="fs-4 fw-bold text-primary">${{ number_format($property->price) }}</span>
              <span class="purpose-badge {{ $property->purpose }}">
                {{ $property->purpose == 'sale' ? 'For Sale' : 'For Rent' }}
              </span>
            </div>
          </div>
          
          <p class="text-muted">
            <i class="fas fa-map-marker-alt"></i> {{ $property->address }}
            @if($property->area)
              - {{ $property->area->name }}
            @endif
          </p>
        </div>
      
        <!-- Image Gallery -->
        <div class="property-image-gallery mb-4">
          @if($property->images->count() > 0)
            <!-- Main Image Carousel -->
            <div id="propertyImageCarousel" class="carousel slide mb-3" data-bs-ride="false">
              <div class="carousel-inner">
                @foreach($property->images as $index => $image)
                  @php
                    $imagePath = file_exists(public_path('storage/' . $image->image_path)) 
                      ? asset('storage/' . $image->image_path) 
                      : asset('images/default-property.jpg');
                  @endphp
                  <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ $imagePath }}" class="d-block w-100 rounded" 
                         alt="{{ $property->title }}" style="height: 500px; object-fit: cover;">
                  </div>
                @endforeach
              </div>
              
              <button class="carousel-control-prev" type="button" data-bs-target="#propertyImageCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#propertyImageCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
              
              <!-- Image Counter Badge -->
              <div class="image-counter">
                <span id="currentImageIndex">1</span>/<span>{{ $property->images->count() }}</span>
              </div>
            </div>
            
            <!-- Thumbnail Navigation -->
          
@if($property->images->count() > 1)
  <div class="thumbnail-images d-flex flex-wrap">
    @foreach($property->images as $index => $image)
      @php
        $thumbPath = file_exists(public_path('storage/' . $image->image_path)) 
          ? asset('storage/' . $image->image_path) 
          : asset('images/default-property.jpg');
      @endphp
      <div class="thumbnail-item mb-2 me-2" 
           data-bs-target="#propertyImageCarousel"
           data-bs-slide-to="{{ $index }}"
           data-index="{{ $index }}">
        <img src="{{ $thumbPath }}" 
             class="img-thumbnail {{ $index === 0 ? 'active-thumb' : '' }}"
             alt="{{ $property->title }}" 
             style="width: 80px; height: 60px; object-fit: cover; cursor: pointer;">
      </div>
    @endforeach
  </div>
@endif
          @else
            <img src="{{ asset('images/default-property.jpg') }}" class="img-fluid rounded" alt="{{ $property->title }}">
          @endif
        </div>
        
        <!-- Property Information -->
        <div class="property-info mb-5">
          <!-- Desktop Title and Price -->
          <div class="d-none d-lg-block">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h2 class="mb-0">{{ $property->title }}</h2>
              <div class="price">
                <span class="fs-4 fw-bold text-primary">{{ number_format($property->price) }} JOD</span>
                <span class="purpose-badge {{ $property->purpose }}">
                  {{ $property->purpose == 'sale' ? 'For Sale' : 'For Rent' }}
                </span>
              </div>
            </div>
            
            <p class="text-muted mb-4">
              <i class="fas fa-map-marker-alt"></i> {{ $property->address }}
              @if($property->area)
                - {{ $property->area->name }}
              @endif
            </p>
          </div>
          
          <div class="property-specs bg-light p-4 rounded my-4">
            <div class="row text-center">
              <div class="col-4 col-md-2 mb-3 mb-md-0">
                <div class="spec-item">
                  <i class="fas fa-ruler-combined fa-2x text-primary mb-2"></i>
                  <h5 class="fs-6">Area</h5>
                  <p class="mb-0">{{ number_format($property->size) }} sq.ft</p>
                </div>
              </div>
              <div class="col-4 col-md-2 mb-3 mb-md-0">
                <div class="spec-item">
                  <i class="fas fa-bed fa-2x text-primary mb-2"></i>
                  <h5 class="fs-6">Bedrooms</h5>
                  <p class="mb-0">{{ $property->bedrooms ?? 'N/A' }}</p>
                </div>
              </div>
              <div class="col-4 col-md-2 mb-3 mb-md-0">
                <div class="spec-item">
                  <i class="fas fa-bath fa-2x text-primary mb-2"></i>
                  <h5 class="fs-6">Bathrooms</h5>
                  <p class="mb-0">{{ $property->bathrooms ?? 'N/A' }}</p>
                </div>
              </div>
              <div class="col-4 col-md-2">
                <div class="spec-item">
                  <i class="fas fa-building fa-2x text-primary mb-2"></i>
                  <h5 class="fs-6">Type</h5>
                  <p class="mb-0">{{ $property->type->name ?? 'N/A' }}</p>
                </div>
              </div>
              <div class="col-4 col-md-2">
                <div class="spec-item">
                  <i class="fas fa-car fa-2x text-primary mb-2"></i>
                  <h5 class="fs-6">Parking</h5>
                  <p class="mb-0">{{ $property->parking_spaces ?? 'N/A' }}</p>
                </div>
              </div>
              <div class="col-4 col-md-2">
                <div class="spec-item">
                  <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                  <h5 class="fs-6">Year Built</h5>
                  <p class="mb-0">{{ $property->year_built ?? 'N/A' }}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Description -->
        <div class="property-description mb-5">
          <h3 class="border-bottom pb-3 mb-4">Description</h3>
          <p class="text-justify">{{ $property->description }}</p>
        </div>
        
        <!-- Features -->
        @if($property->features && $property->features->count() > 0)
        <div class="property-features mb-5">
          <h3 class="border-bottom pb-3 mb-4">Features</h3>
          <div class="row">
            @foreach($property->features as $feature)
              <div class="col-md-4 col-6 mb-3">
                <div class="d-flex align-items-center">
                  <i class="fas fa-check-circle text-primary me-2"></i>
                  <span>{{ $feature->name }}</span>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        @endif
        
        <!-- Map Location -->
        <div class="property-location mb-5">
          <h3 class="border-bottom pb-3 mb-4">Location</h3>
          <div class="map-container rounded overflow-hidden" style="height: 350px;">
            <!-- You can implement a map integration here using Google Maps or alternatives -->
            <div class="map-placeholder bg-light d-flex align-items-center justify-content-center h-100">
              <div class="text-center">
                <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                <h5>{{ $property->address }}</h5>
                <p class="mb-0 text-muted">
                  @if($property->latitude && $property->longitude)
                    Coordinates: {{ $property->latitude }}, {{ $property->longitude }}
                  @else
                    Exact location will be provided upon inquiry
                  @endif
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="col-lg-4">
        <!-- Contact Card -->
        <div class="contact-card card shadow-sm mb-4 sticky-top" style="top: 20px; z-index: 1;">
          <div class="card-body">
            <h4 class="card-title border-bottom pb-3">Contact Property Agent</h4>
            @if($property->user)
              <div class="owner-info d-flex align-items-center mb-4">
                <div class="avatar me-3">
                  @if($property->user->profile_image && file_exists(public_path('storage/' . $property->user->profile_image)))
                    <img src="{{ asset('storage/' . $property->user->profile_image) }}" 
                        class="rounded-circle" alt="{{ $property->user->name }}" width="60" height="60">
                  @else
                    <img src="{{ asset('images/default-avatar.jpg') }}" 
                        class="rounded-circle" alt="{{ $property->user->name }}" width="60" height="60">
                  @endif
                </div>
                <div>
                  <h5 class="mb-0">{{ $property->user->name }}</h5>
                  <p class="text-muted mb-0 small">Property Agent</p>
                </div>
              </div>
              
              <!-- Contact Form -->
              <form class="mb-3">
                <div class="mb-3">
                  <input type="text" class="form-control" placeholder="Your Name" required>
                </div>
                <div class="mb-3">
                  <input type="email" class="form-control" placeholder="Your Email" required>
                </div>
                <div class="mb-3">
                  <input type="tel" class="form-control" placeholder="Your Phone">
                </div>
                <div class="mb-3">
                  <textarea class="form-control" rows="3" placeholder="Hi, I am interested in this property. Please contact me." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Send Message</button>
              </form>
              
              <div class="contact-buttons">
                @if($property->user->phone)
                  <a href="tel:{{ $property->user->phone }}" class="btn btn-outline-primary w-100 mb-2">
                    <i class="fas fa-phone me-2"></i> Call Agent
                  </a>
                @endif
                
                @if($property->user->email)
                  <a href="mailto:{{ $property->user->email }}?subject=Inquiry about: {{ $property->title }}" class="btn btn-outline-secondary w-100">
                    <i class="fas fa-envelope me-2"></i> Email Agent
                  </a>
                @endif
              </div>
            @else
              <p class="text-center">Agent information not available</p>
            @endif
          </div>
        </div>
        
        <!-- Share Card -->
        <div class="share-card card shadow-sm mb-4">
          <div class="card-body">
            <h4 class="card-title border-bottom pb-3">Share This Property</h4>
            <div class="social-shares d-flex justify-content-between mt-3">
              <a href="#" class="btn btn-outline-primary" onclick="shareOnFacebook(); return false;">
                <i class="fab fa-facebook-f"></i>
              </a>
              <a href="#" class="btn btn-outline-info" onclick="shareOnTwitter(); return false;">
                <i class="fab fa-twitter"></i>
              </a>
              <a href="#" class="btn btn-outline-success" onclick="shareOnWhatsApp(); return false;">
                <i class="fab fa-whatsapp"></i>
              </a>
              <a href="#" class="btn btn-outline-secondary" onclick="copyToClipboard(); return false;" id="copyLink">
                <i class="fas fa-link"></i>
              </a>
            </div>
          </div>
        </div>
        
        <!-- Similar Properties -->
        <div class="similar-properties card shadow-sm">
          <div class="card-body">
            <h4 class="card-title border-bottom pb-3">Similar Properties</h4>
            
            <!-- Example similar property card (in a real implementation, you would loop through similar properties) -->
            <div class="card mb-3 border-0 shadow-sm">
              <div class="row g-0">
                <div class="col-4">
                  <img src="{{ asset('images/img_1.jpg') }}" class="img-fluid rounded" alt="Similar Property">
                </div>
                <div class="col-8">
                  <div class="card-body py-2 px-3">
                    <h5 class="card-title mb-1" style="font-size: 14px;">Modern Apartment</h5>
                    <p class="card-text mb-1"><small class="text-muted">$250,000</small></p>
                    <p class="card-text"><small class="text-muted">2 bed, 1 bath</small></p>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- Additional similar property cards would go here -->
            
            <a href="{{ route('properties.index') }}" class="btn btn-sm btn-outline-primary w-100 mt-2">
              View More Properties
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@push('styles')
<style>
  .purpose-badge {
    font-size: 12px;
    padding: 5px 12px;
    border-radius: 3px;
    margin-left: 10px;
    vertical-align: middle;
    font-weight: 600;
  }
  
  .purpose-badge.sale {
    background: #28a745;
    color: white;
  }
  
  .purpose-badge.rent {
    background: #007bff;
    color: white;
  }
  
  .thumbnail-item img {
    transition: all 0.2s ease;
    border: 2px solid transparent;
  }
  
  .thumbnail-item img:hover,
  .thumbnail-item img.active-thumb {
    border-color: #007bff;
    transform: scale(1.05);
  }
  
  .carousel-item img {
    width: 100%;
    height: 500px;
    object-fit: cover;
  }
  
  .image-counter {
    position: absolute;
    right: 10px;
    bottom: 10px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 5px 10px;
    border-radius: 3px;
    font-size: 12px;
  }
  
  @media (max-width: 768px) {
    .carousel-item img {
      height: 300px;
    }
  }
  
  .property-specs .spec-item {
    padding: 10px;
    transition: all 0.3s ease;
  }
  
  .property-specs .spec-item:hover {
    background-color: rgba(0, 123, 255, 0.1);
    border-radius: 5px;
  }
  
  .property-features .d-flex:hover {
    color: #007bff;
  }
  
  .map-container {
    border: 1px solid #e9ecef;
  }
  
  .contact-card, .share-card, .similar-properties {
    border: none;
    transition: all 0.3s ease;
  }
  
  .contact-card:hover, .share-card:hover, .similar-properties:hover {
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
  }
  
  .social-shares a {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
  }
  
  .social-shares a:hover {
    transform: translateY(-3px);
  }
</style>
@endpush

@push('scripts')
<script>
  // Update image counter when carousel slides
  document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('propertyImageCarousel');
    if (carousel) {
      carousel.addEventListener('slid.bs.carousel', function(event) {
        document.getElementById('currentImageIndex').textContent = event.to + 1;
        
        // Update thumbnail active state
        document.querySelectorAll('.thumbnail-item img').forEach(function(thumb) {
          thumb.classList.remove('active-thumb');
        });
        
        const activeThumb = document.querySelector(`.thumbnail-item[data-index="${event.to}"] img`);
        if (activeThumb) {
          activeThumb.classList.add('active-thumb');
        }
      });
    }
  });
  
  // Social sharing functions
  function shareOnFacebook() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent("{{ $property->title }}");
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&t=${title}`, '_blank');
  }
  
  function shareOnTwitter() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent("Check out this property: {{ $property->title }}");
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
  }
  
  function shareOnWhatsApp() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent("Check out this property: {{ $property->title }}");
    window.open(`https://wa.me/?text=${text} ${url}`, '_blank');
  }
  
  function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(() => {
      const button = document.getElementById('copyLink');
      button.classList.remove('btn-outline-secondary');
      button.classList.add('btn-success');
      
      setTimeout(() => {
        button.classList.remove('btn-success');
        button.classList.add('btn-outline-secondary');
      }, 2000);
    });
  }
</script>
@endpush
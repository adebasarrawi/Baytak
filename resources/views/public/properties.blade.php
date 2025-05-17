@extends('layouts.public.app')

@section('title', 'Properties')

@section('content')
@php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
@endphp

<div class="hero page-inner overlay">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-9 text-center mt-5">
        <h1 class="heading" data-aos="fade-up">Properties</h1>
        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
          <ol class="breadcrumb text-center justify-content-center">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">Properties</li>
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
        <h2 class="font-weight-bold text-primary heading">Available Properties</h2>
      </div>
    </div>
    
    <div class="row mb-5">
      <div class="col-12">
        <form class="property-search-form p-4 bg-light rounded shadow-sm" action="{{ route('properties.index') }}" method="GET">
          <div class="row g-3">
            <div class="col-md-3">
              <label class="form-label small text-muted">Property Type</label>
              <select class="form-select" name="property_type">
                <option value="">All Property Types</option>
                @foreach($propertyTypes as $type)
                  <option value="{{ $type->id }}" {{ request('property_type') == $type->id ? 'selected' : '' }}>
                    {{ $type->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label small text-muted">Purpose</label>
              <select class="form-select" name="purpose">
                <option value="">All Purposes</option>
                <option value="sale" {{ request('purpose') == 'sale' ? 'selected' : '' }}>For Sale</option>
                <option value="rent" {{ request('purpose') == 'rent' ? 'selected' : '' }}>For Rent</option>
              </select>
            </div>
            
            <div class="col-md-4">
              <label class="form-label small text-muted">Search Keywords</label>
              <input type="text" class="form-control" name="search" placeholder="Location, Title, Address..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
              <button type="submit" class="btn btn-primary w-100 py-2">
                <i class="fa fa-search me-1"></i> Search
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    
    <!-- Display success message if any -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
    @if($properties->count() > 0)
  <div class="row">
    @foreach($properties as $property)
    <div class="col-md-6 col-lg-4 mb-4">
      <div class="card h-100 shadow-sm property-card">
        <div class="position-relative">
          @php
            $primaryImage = $property->images->where('is_primary', true)->first();
            $fallbackImage = $property->images->first();
            $imagePath = asset('images/default-property.jpg');
            
            if ($primaryImage && $primaryImage->image_path) {
              $imagePath = asset('storage/' . $primaryImage->image_path);
            } elseif ($fallbackImage && $fallbackImage->image_path) {
              $imagePath = asset('storage/' . $fallbackImage->image_path);
            }
          @endphp
          
          <img src="{{ $imagePath }}" class="card-img-top" alt="{{ $property->title }}" style="height: 200px; object-fit: cover;">
          <!-- This will display for both logged in and logged out users with the same styling -->
<div style="position: absolute; top: 15px; right: 15px; z-index: 5;">
  @if(Auth::check())
    @php
      $isFavorite = DB::table('favorites')
        ->where('user_id', Auth::id())
        ->where('property_id', $property->id)
        ->exists();
    @endphp
    <form action="{{ route('favorites.toggle') }}" method="POST" class="favorite-form">
      @csrf
      <input type="hidden" name="property_id" value="{{ $property->id }}">
      <button type="submit" class="btn btn-light rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
        @if($isFavorite)
          <i class="fas fa-heart text-danger"></i>
        @else
          <i class="far fa-heart"></i>
        @endif
      </button>
    </form>
  @else
    <a href="{{ route('login') }}" class="btn btn-light rounded-circle p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
      <i class="far fa-heart"></i>
    </a>
  @endif
</div>
          
          <div class="position-absolute bottom-0 start-0 m-2">
            <span class="badge  p-2" style="background-color:rgb(166, 0, 0); ">{{ number_format($property->price) }} JOD</span>
          </div>
          
            <div class="position-absolute top-0 start-0 m-2">
            @if($property->purpose == 'sale')
              <span class="badge bg-primary">For Sale</span>
            @else
              <span class="badge bg-info">For Rent</span>
            @endif
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
            <span class="property-date small text-muted align-self-center">
              <i class="far fa-calendar-alt me-1"></i> {{ $property->created_at->diffForHumans() }}
            </span>
          </div>
        </div>
        
        <div class="card-footer bg-white text-muted small">
          <div class="d-flex justify-content-between">
            <span><i class="fas fa-map me-1"></i> {{ $property->area->name ?? 'N/A' }}</span>
            @if($property->is_featured)
              <span><i class="fas fa-star text-warning me-1"></i> Featured</span>
            @endif
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
@else
  <div class="col-12 text-center py-5">
    <div class="empty-state p-4 bg-light rounded">
      <i class="fas fa-search fa-3x text-muted mb-3"></i>
      <h3>No properties found</h3>
      <p class="text-muted">Try adjusting your search criteria or check back later for new listings.</p>
      <a href="{{ route('properties.index') }}" class="btn btn-primary mt-3">Clear filters</a>
    </div>
  </div>
@endif
    
    <!-- Pagination -->
    <div class="row align-items-center py-5">
      <div class="col-lg-12">
        <div class="custom-pagination">
          {{ $properties->withQueryString()->links() }}
        </div>
      </div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

@push('styles')
<style>


  /* Wishlist button styles */
  .wishlist-button {
    position: absolute;
    background-color: rgba(255, 255, 255, 0.8) !important;
    top: 15px;
    right: 15px;
    background: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    z-index: 3;
    transition: all 0.3s ease;
    opacity: 1 !important; /* جعل الزر مرئي دائمًا للاختبار */
    transform: translateY(-10px);
  }

  .property-item:hover .wishlist-button {
    opacity: 1;
    transform: translateY(0);
  }

  .wishlist-icon {
    color: #888;
    font-size: 18px;
    transition: all 0.3s ease;
  }

  .wishlist-button:hover .wishlist-icon,
  .wishlist-icon.active {
    color: #fd4d40;
  }

  .wishlist-button .wishlist-icon.active {
    opacity: 1;
  }

  .property-item .wishlist-button.has-favorite {
    opacity: 1;
    transform: translateY(0);
  }

  /* تنسيق نموذج المفضلة */
  .favorite-form {
    margin: 0;
    padding: 0;
  }

  /* باقي التنسيقات كما هي */
  .property-search-form {
    background-color: rgba(255, 255, 255, 0.95);
    border-radius: 8px;
    margin-bottom: 30px;
  }
  
  .property-item {
    transition: all 0.3s ease;
    border-radius: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    border: none;
    overflow: hidden;
    background-color: white;
  }
  
  .property-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
  }
  
  .property-image {
    transition: transform 0.5s ease;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
  }
  
  .property-item:hover .property-image {
    transform: scale(1.05);
  }
  
  .property-title {
    font-weight: 600;
    transition: color 0.3s ease;
  }
  
  .property-title:hover {
    color: #007bff !important;
  }
  
  .featured-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: #fd4d40;
    color: white;
    padding: 5px 12px;
    border-radius: 25px;
    font-size: 12px;
    font-weight: 600;
    z-index: 2;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }
  
  .purpose-badge {
    position: absolute;
    bottom: 15px;
    left: 15px;
    font-size: 12px;
    padding: 5px 12px;
    border-radius: 25px;
    font-weight: 600;
    z-index: 2;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  }
  
  .purpose-badge.sale {
    background: #28a745;
    color: white;
  }
  
  .purpose-badge.rent {
    background: #007bff;
    color: white;
  }
  
  .property-overlay {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 2;
  }
  
  .property-type {
    display: inline-block;
    background: rgba(0, 0, 0, 0.6);
    color: white;
    padding: 5px 12px;
    border-radius: 25px;
    font-size: 12px;
    font-weight: 600;
  }
  
  .property-footer {
    margin-top: 15px;
  }
  
  .specs .fas {
    color: #007bff;
  }
  
  .price-area .price {
    line-height: 1;
  }
  
  /* Pagination styling */
  .custom-pagination .pagination {
    justify-content: center;
  }
  
  .custom-pagination .page-item .page-link {
    color: #007bff;
    border-color: #dee2e6;
    margin: 0 3px;
    border-radius: 4px;
  }
  
  .custom-pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
  }
  
  .empty-state {
    padding: 50px 20px;
    text-align: center;
    border-radius: 8px;
  }
</style>
@endpush

@endsection
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

    @if($properties->count() > 0)
      <div class="row">
        @foreach($properties as $property)
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
              <i class="far fa-heart wishlist-icon" id="wishlist-{{ $property->id }}"></i>
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
  
  /* Wishlist Button */
  .wishlist-button {
    position: absolute;
    top: 15px;
    right: 15px;
    background: white;
    border: none;
    border-radius: 50%;
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    z-index: 3;
    transition: all 0.3s ease;
  }
  
  .wishlist-button:hover {
    transform: scale(1.1);
  }
  
  .wishlist-icon {
    color: #ccc;
    font-size: 18px;
    transition: all 0.3s ease;
  }
  
  .wishlist-button:hover .wishlist-icon {
    color: #fd4d40;
  }
  
  .wishlist-icon.active {
    color: #fd4d40;
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

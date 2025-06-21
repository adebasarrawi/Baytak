@extends('layouts.public.app')

@section('title', 'Properties')

@section('content')
@php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
@endphp

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
    line-height: 1.6;
    color: #2c3e50;
    background: #f8fafc;
}

.properties-section {
    background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
    padding: 30px 0;
    min-height: 100vh;
}

.section-header {
    text-align: center;
    margin-bottom: 40px;
}

.section-title {
    font-size: clamp(2rem, 4vw, 2.5rem);
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 16px;
}

.section-subtitle {
    font-size: 1.125rem;
    color: #6b7280;
    max-width: 600px;
    margin: 0 auto;
}

.search-form-container {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 30px 90px rgba(0, 0, 0, 0.15);
    margin-bottom: 50px;
    position: relative;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.form-control, .form-select {
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.95rem;
    color: #1f2937;
    background: white;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.2s ease;
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 25px rgba(59, 130, 246, 0.4);
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}

.property-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    transition: all 0.4s ease;
    border: 2px solid transparent;
    position: relative;
    display: flex;
    flex-direction: column;
}

.property-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
    border-color: #3b82f6;
}

.property-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.property-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.property-card:hover .property-image {
    transform: scale(1.1);
}

.property-badges {
    position: absolute;
    top: 15px;
    left: 15px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    z-index: 2;
}

.badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.badge-sale {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.badge-rent {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.badge-featured {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.property-price {
    position: absolute;
    bottom: 15px;
    left: 15px;
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.9), rgba(30, 41, 59, 0.9));
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 1rem;
    z-index: 2;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
}

.favorite-btn {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 3;
}

.favorite-btn:hover {
    background: white;
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
}

.favorite-btn i {
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.favorite-btn.active i,
.favorite-btn i.text-danger {
    color: #ef4444 !important;
}

.property-content {
    padding: 25px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.property-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
    line-height: 1.3;
    transition: color 0.3s ease;
}

.property-title:hover {
    color: #3b82f6;
}

.property-address {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.property-features {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding: 15px;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
    color: #374151;
    font-weight: 500;
}

.feature-item i {
    color: #3b82f6;
    font-size: 1rem;
}

.property-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    flex-wrap: wrap;
    gap: 10px;
}

.btn-outline-primary {
    background: transparent;
    color: #3b82f6;
    border: 2px solid #3b82f6;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    text-decoration: none;
}

.property-date {
    color: #6b7280;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 4px;
}

.card-footer {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%) !important;
    border-top: 1px solid #e5e7eb;
    padding: 15px 25px;
    font-size: 0.85rem;
    color: #6b7280;
}

.empty-state {
    text-align: center;
    padding: 80px 40px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
}

.empty-state i {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 12px;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 30px;
    font-size: 1rem;
}

/* Enhanced Pagination Styles */
.custom-pagination {
    display: flex;
    justify-content: center;
    margin-top: 50px;
}

.pagination-container {
    display: flex;
    align-items: center;
    gap: 12px;
}

.pagination-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 10px;
    font-weight: 600;
    color: #4b5563;
    text-decoration: none;
    transition: all 0.2s ease;
    border: 1px solid #e5e7eb;
    background: white;
}

.pagination-link:hover {
    background: #f3f4f6;
    color: #1f2937;
}

.pagination-link.active {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border-color: transparent;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.pagination-link.disabled {
    opacity: 0.5;
    pointer-events: none;
    background: #f3f4f6;
}

.pagination-arrow {
    width: auto;
    padding: 0 16px;
    gap: 6px;
}

.pagination-arrow i {
    font-size: 0.9rem;
}

.pagination-dots {
    pointer-events: none;
    border: none;
    background: transparent;
}

@media (max-width: 991.98px) {
    .properties-section {
        padding: 20px 0;
    }
    
    .search-form-container {
        padding: 25px;
        margin-bottom: 40px;
    }
    
    .section-title {
        font-size: 2rem;
            margin-top: 120px !important;

    }
    
    .property-image-container {
        height: 220px;
    }
}

@media (max-width: 767.98px) {
    .properties-section {
        padding: 15px 0;
    }
    
    .search-form-container {
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 30px;
    }
    
    .section-title {
        font-size: 1.8rem;
            margin-top: 120px !important;

    }
    
    .property-image-container {
        height: 200px;
    }
    
    .property-content {
        padding: 20px;
    }
    
    .property-features {
        flex-direction: column;
        gap: 8px;
        padding: 12px;
    }
    
    .feature-item {
        min-width: auto;
        justify-content: flex-start;
    }
    
    .property-footer {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }
    
    .btn-outline-primary {
        text-align: center;
        justify-content: center;
    }
    
    .property-date {
        justify-content: center;
    }
    
    .pagination-container {
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .pagination-link {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
    }
    
    .pagination-arrow {
        padding: 0 12px;
    }
}

@media (max-width: 575.98px) {
    .properties-section {
        padding: 10px 0;
    }
    
    .search-form-container {
        padding: 15px;
        margin-bottom: 25px;
    }
    
    .section-header {
        margin-bottom: 30px;
    }
    
    .section-title {
        font-size: 1.6rem;
            margin-top: 120px !important;

    }
    
    .section-subtitle {
        font-size: 1rem;
    }
    
    .property-image-container {
        height: 180px;
    }
    
    .property-content {
        padding: 15px;
    }
    
    .property-title {
        font-size: 1.1rem;
    }
    
    .favorite-btn {
        width: 40px;
        height: 40px;
    }
    
    .favorite-btn i {
        font-size: 1rem;
    }
    
    .property-price {
        font-size: 0.9rem;
        padding: 6px 12px;
    }
    
    .card-footer {
        padding: 12px 15px;
        font-size: 0.8rem;
    }
    
    .pagination-link {
        width: 32px;
        height: 32px;
        font-size: 0.85rem;
    }
    
    .pagination-arrow {
        padding: 0 10px;
        font-size: 0.85rem;
    }
}

.fade-in {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease;
}

.fade-in.visible {
    opacity: 1;
    transform: translateY(0);
}

html {
    scroll-behavior: smooth;
}

.property-card {
    cursor: pointer;
}

.property-card:hover .property-title {
    color: #3b82f6;
}

.btn-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none !important;
}

.btn-primary.loading {
    position: relative;
    color: transparent;
}

.btn-primary.loading:after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    top: 50%;
    left: 50%;
    margin-left: -10px;
    margin-top: -10px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>

<div class="properties-section">
    <div class="container">
        <div class="section-header fade-in">
            <h2 class="section-title " style="margin-top: 150px;">Available Properties</h2>
            <p class="section-subtitle">Discover your perfect home among our premium collection of properties</p>
        </div>

        <div class="search-form-container fade-in">
            <form action="{{ route('properties.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Property Type</label>
                        <select class="form-select" name="property_type">
                            <option value="">All Property Types</option>
                            @foreach($propertyTypes as $type)
                                <option value="{{ $type->id }}" {{ request('property_type') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Purpose</label>
                        <select class="form-select" name="purpose">
                            <option value="">All Purposes</option>
                            <option value="sale" {{ request('purpose') == 'sale' ? 'selected' : '' }}>For Sale</option>
                            <option value="rent" {{ request('purpose') == 'rent' ? 'selected' : '' }}>For Rent</option>
                        </select>
                    </div>
                    <div class="col-lg-4 col-md-8">
                        <label class="form-label">Search Keywords</label>
                        <input type="text" class="form-control" name="search" placeholder="Location, Title, Address..." value="{{ request('search') }}">
                    </div>
                    <div class="col-lg-2 col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show fade-in" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($properties->count() > 0)
            <div class="row g-4">
                @foreach($properties as $property)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="property-card fade-in">
                            <div class="property-image-container">
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
                                <img src="{{ $imagePath }}" alt="{{ $property->title }}" class="property-image">
                                <div class="property-badges">
                                    <span class="badge {{ $property->purpose == 'sale' ? 'badge-sale' : 'badge-rent' }}">
                                        @if($property->purpose == 'sale')
                                            <i class="fas fa-tag me-1"></i>For Sale
                                        @else
                                            <i class="fas fa-key me-1"></i>For Rent
                                        @endif
                                    </span>
                                    @if($property->is_featured)
                                        <span class="badge badge-featured">
                                            <i class="fas fa-star me-1"></i>Featured
                                        </span>
                                    @endif
                                </div>
                                <div class="property-price">
                                    {{ number_format($property->price) }} JOD
                                </div>
                                @if(Auth::check())
                                    @php
                                        $isFavorite = DB::table('favorites')
                                            ->where('user_id', Auth::id())
                                            ->where('property_id', $property->id)
                                            ->exists();
                                    @endphp
                                    <form action="{{ route('favorites.toggle') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                                        <button type="submit" class="favorite-btn {{ $isFavorite ? 'active' : '' }}">
                                            @if($isFavorite)
                                                <i class="fas fa-heart text-danger"></i>
                                            @else
                                                <i class="far fa-heart"></i>
                                            @endif
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="favorite-btn">
                                        <i class="far fa-heart"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="property-content">
                                <h5 class="property-title">{{ $property->title }}</h5>
                                <p class="property-address">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $property->address }}
                                </p>
                                <div class="property-features">
                                    <div class="feature-item">
                                        <i class="fas fa-bed"></i>
                                        <span>{{ $property->bedrooms ?? '0' }} Beds</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-bath"></i>
                                        <span>{{ $property->bathrooms ?? '0' }} Baths</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="fas fa-ruler-combined"></i>
                                        <span>{{ $property->size }} sq.ft</span>
                                    </div>
                                </div>
                                <div class="property-footer">
                                    <a href="{{ route('properties.show', $property->id) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-eye"></i>View Details
                                    </a>
                                    <span class="property-date">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $property->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="custom-pagination fade-in">
                @if ($properties->hasPages())
                    <div class="pagination-container">
                        {{-- Previous Page Link --}}
                        @if ($properties->onFirstPage())
                            <span class="pagination-link pagination-arrow disabled">
                                <i class="fas fa-chevron-left"></i> 
                            </span>
                        @else
                            <a href="{{ $properties->previousPageUrl() }}" class="pagination-link pagination-arrow">
                                <i class="fas fa-chevron-left"></i> 
                            </a>
                        @endif

                        {{-- First Page Link --}}
                        @if($properties->currentPage() > 3)
                            <a href="{{ $properties->url(1) }}" class="pagination-link">1</a>
                        @endif

                        {{-- Dots after first page --}}
                        @if($properties->currentPage() > 4)
                            <span class="pagination-link pagination-dots">...</span>
                        @endif

                        {{-- Array Of Links --}}
                        @foreach(range(1, $properties->lastPage()) as $i)
                            @if($i >= $properties->currentPage() - 2 && $i <= $properties->currentPage() + 2)
                                @if ($i == $properties->currentPage())
                                    <span class="pagination-link active">{{ $i }}</span>
                                @else
                                    <a href="{{ $properties->url($i) }}" class="pagination-link">{{ $i }}</a>
                                @endif
                            @endif
                        @endforeach

                        {{-- Dots before last page --}}
                        @if($properties->currentPage() < $properties->lastPage() - 3)
                            <span class="pagination-link pagination-dots">...</span>
                        @endif

                        {{-- Last Page Link --}}
                        @if($properties->currentPage() < $properties->lastPage() - 2)
                            <a href="{{ $properties->url($properties->lastPage()) }}" class="pagination-link">{{ $properties->lastPage() }}</a>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($properties->hasMorePages())
                            <a href="{{ $properties->nextPageUrl() }}" class="pagination-link pagination-arrow">
                                 <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="pagination-link pagination-arrow disabled">
                                Next <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        @else
            <div class="empty-state fade-in">
                <i class="fas fa-home"></i>
                <h3>No Properties Found</h3>
                <p>We couldn't find any properties matching your search criteria. Try adjusting your filters or search terms.</p>
                <a href="{{ route('properties.index') }}" class="btn btn-primary">
                    <i class="fas fa-refresh me-2"></i>View All Properties
                </a>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => { entry.target.classList.add('visible'); }, index * 100);
            }
        });
    }, observerOptions);
    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

    const propertyCards = document.querySelectorAll('.property-card');
    propertyCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-10px)';
            card.style.borderColor = '#3b82f6';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
            card.style.borderColor = 'transparent';
        });
    });

    const favoriteButtons = document.querySelectorAll('.favorite-btn');
    favoriteButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.tagName === 'BUTTON') {
                const icon = this.querySelector('i');
                icon.style.transform = 'scale(1.3)';
                setTimeout(() => { icon.style.transform = 'scale(1)'; }, 200);
                const ripple = document.createElement('div');
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(59, 130, 246, 0.6)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s linear';
                ripple.style.left = '50%';
                ripple.style.top = '50%';
                ripple.style.width = '20px';
                ripple.style.height = '20px';
                ripple.style.marginLeft = '-10px';
                ripple.style.marginTop = '-10px';
                this.appendChild(ripple);
                setTimeout(() => { ripple.remove(); }, 600);
            }
        });
    });

    const searchForm = document.querySelector('form');
    const searchButton = document.querySelector('button[type="submit"]');
    if (searchForm && searchButton) {
        searchForm.addEventListener('submit', () => {
            searchButton.classList.add('loading');
            searchButton.disabled = true;
            setTimeout(() => {
                searchButton.classList.remove('loading');
                searchButton.disabled = false;
            }, 5000);
        });
    }

    document.querySelectorAll('.pagination-link:not(.disabled)').forEach(link => {
        link.addEventListener('click', () => {
            link.style.opacity = '0.7';
            link.style.pointerEvents = 'none';
            setTimeout(() => { window.scrollTo({ top: 0, behavior: 'smooth' }); }, 100);
        });
    });

    propertyCards.forEach(card => {
        const image = card.querySelector('.property-image');
        const title = card.querySelector('.property-title');
        card.addEventListener('mouseenter', () => {
            if(image) image.style.transform = 'scale(1.1)';
            if(title) title.style.color = '#3b82f6';
        });
        card.addEventListener('mouseleave', () => {
            if(image) image.style.transform = 'scale(1)';
            if(title) title.style.color = '#1f2937';
        });
        card.addEventListener('click', e => {
            if(e.target.closest('button') || e.target.closest('a')) return;
            const ripple = document.createElement('div');
            const rect = card.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            ripple.style.position = 'absolute';
            ripple.style.borderRadius = '50%';
            ripple.style.background = 'rgba(59, 130, 246, 0.3)';
            ripple.style.transform = 'scale(0)';
            ripple.style.animation = 'ripple 0.6s linear';
            ripple.style.pointerEvents = 'none';
            card.style.position = 'relative';
            card.style.overflow = 'hidden';
            card.appendChild(ripple);
            setTimeout(() => ripple.remove(), 600);
        });
    });

    document.querySelectorAll('.form-control, .form-select').forEach(input => {
        input.addEventListener('focus', () => {
            input.style.borderColor = '#3b82f6';
            input.style.boxShadow = '0 0 0 3px rgba(59, 130, 246, 0.1)';
        });
        input.addEventListener('blur', () => {
            if(!input.value) {
                input.style.borderColor = '#e5e7eb';
                input.style.boxShadow = 'none';
            }
        });
    });

    document.querySelectorAll('.property-image').forEach(img => {
        img.addEventListener('load', () => {
            img.style.opacity = '0';
            img.style.transition = 'opacity 0.3s ease';
            setTimeout(() => { img.style.opacity = '1'; }, 100);
        });
    });

    if ('ontouchstart' in window) {
        propertyCards.forEach(card => {
            card.addEventListener('touchstart', () => { card.style.transform = 'scale(0.98)'; });
            card.addEventListener('touchend', () => {
                card.style.transform = 'scale(1)';
                setTimeout(() => { card.style.transform = 'translateY(-10px)'; }, 100);
            });
        });
    }

    document.addEventListener('keydown', e => {
        if(e.key === 'Enter' && e.target.matches('.form-control, .form-select')) {
            searchForm.submit();
        }
    });

    document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    let ticking = false;
    function updateOnScroll() { ticking = false; }
    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(updateOnScroll);
            ticking = true;
        }
    });

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

    const searchInput = document.querySelector('input[name="search"]');
    if(searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', () => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => { console.log('Search term:', searchInput.value); }, 300);
        });
    }
});

const style = document.createElement('style');
style.textContent = `
    @keyframes ripple {
        to { transform: scale(4); opacity: 0; }
    }
    @keyframes heartbeat {
        0% { transform: scale(1); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    .favorite-btn.active {
        animation: heartbeat 0.6s ease-in-out;
    }
    .property-card { will-change: transform; }
    .property-image { will-change: transform; }
    .property-image-container::before {
        content: '';
        position: absolute;
        top: 50%; left: 50%;
        width: 40px; height: 40px;
        margin: -20px 0 0 -20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #3b82f6;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        z-index: 1;
    }
    .property-image-container img {
        position: relative;
        z-index: 2;
    }
`;
document.head.appendChild(style);
</script>

@endsection
@extends('layouts.public.app')

@section('title', 'My Favorites')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
}

.custom-hero {
    background:linear-gradient(to right, #1a1c20, #2c3e50);
    padding: 120px 0 80px;
    position: relative;
    overflow: hidden;
}

.custom-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    z-index: 1;
}

.custom-hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
    color: white;
}

.hero-title {
    font-size: 40px;
    font-weight: 700;
    margin-bottom: 20px;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    letter-spacing: -0.02em;
}

.hero-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 30px;
    font-weight: 300;
}

.custom-breadcrumb {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 50px;
    padding: 12px 30px;
    display: inline-flex;
    align-items: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.custom-breadcrumb .breadcrumb {
    margin: 0;
    padding: 0;
    background: none;
}

.custom-breadcrumb .breadcrumb-item {
    font-size: 0.9rem;
    font-weight: 500;
}

.custom-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: rgba(255, 255, 255, 0.6);
    font-weight: 600;
}

.custom-breadcrumb .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.2s ease;
}

.custom-breadcrumb .breadcrumb-item a:hover {
    color: white;
    text-decoration: underline;
}

.custom-breadcrumb .breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.7);
}

.hero-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    animation: float 3s ease-in-out infinite;
}

.hero-icon i {
    font-size: 2rem;
    color: white;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-up {
    animation: fadeInUp 0.8s ease-out;
}

.fade-up.delay-1 {
    animation-delay: 0.2s;
    animation-fill-mode: both;
}

.fade-up.delay-2 {
    animation-delay: 0.4s;
    animation-fill-mode: both;
}

.profile-section {
    padding: 50px 0;
    background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
}

.sidebar-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    margin-bottom: 30px;
    transition: all 0.3s ease;
    position: sticky;
    top: 20px;
}

.sidebar-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.profile-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 4px solid #3b82f6;
    object-fit: cover;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.profile-avatar:hover {
    transform: scale(1.05);
    border-color: #2563eb;
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 5px;
}

.profile-email {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 15px;
}

.badge-seller {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 20px;
    display: inline-block;
}

.nav-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-item {
    margin-bottom: 8px;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    color: #374151;
    text-decoration: none;
    border-radius: 12px;
    transition: all 0.2s ease;
    font-size: 0.95rem;
    font-weight: 500;
}

.nav-link:hover {
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    color: #1f2937;
    text-decoration: none;
    transform: translateX(5px);
}

.nav-link.active {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.nav-link.text-danger:hover {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    color: #dc2626;
}

.nav-link i {
    width: 20px;
    margin-right: 10px;
}

/* Property Card Styles */
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
    cursor: pointer;
    margin-bottom: 30px;
    width: 400px;
    max-width: 100%;
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

.btn-remove {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 10px 20px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 6px;
}

.btn-remove:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
}

.property-date {
    color: #6b7280;
    font-size: 0.8rem;
    display: flex;
    align-items: center;
    gap: 4px;
}

.empty-state {
    text-align: center;
    padding: 80px 40px;
    background: white;
    border-radius: 20px;
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

.success-alert {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 15px;
    padding: 15px 20px;
    margin-bottom: 25px;
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    animation: slideInDown 0.5s ease-out;
}

@keyframes slideInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.success-alert .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.fade-in {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease;
}

.fade-in.visible {
    opacity: 1;
    transform: translateY(0);
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

/* Responsive Design */
@media (max-width: 991.98px) {
    .profile-section {
        padding: 30px 0;
    }
    
    .custom-hero {
        padding: 100px 0 60px;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .property-image-container {
        height: 220px;
    }
    
    .sidebar-card {
        margin-bottom: 20px;
        position: relative;
        top: auto;
    }
}

@media (max-width: 767.98px) {
    .custom-hero {
        padding: 80px 0 50px;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-icon {
        width: 60px;
        height: 60px;
        margin-bottom: 15px;
    }
    
    .hero-icon i {
        font-size: 1.5rem;
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
    
    .property-footer {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }
}

@media (max-width: 575.98px) {
    .custom-hero {
        padding: 60px 0 40px;
    }
    
    .hero-title {
        font-size: 1.8rem;
    }
    
    .hero-subtitle {
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
}
</style>

<!-- Hero Section -->
<div class="custom-hero">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <div class="hero-content">
                 
                    <h1 class="hero-title fade-up delay-1" style="margin-top: 50px;">My Favorites</h1>
                    <p class="hero-subtitle fade-up delay-2">Your saved properties for easy access</p>
                  
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Favorites Section -->
<div class="profile-section">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-4 col-md-4 mb-4">
                <div class="sidebar-card fade-in">
                    <div class="text-center">
                        @if(Auth::user()->profile_image)
                            <img src="{{ asset('storage/'.Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}" class="profile-avatar">
                        @else
                            <img src="{{ asset('images/default-avatar.jpg') }}" alt="{{ Auth::user()->name }}" class="profile-avatar">
                        @endif
                        <h4 class="profile-name">{{ Auth::user()->name }}</h4>
                        <p class="profile-email">{{ Auth::user()->email }}</p>
                        @if(Auth::user()->user_type === 'seller')
                            <div class="badge-seller">Seller Account</div>
                        @endif
                    </div>
                    
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="{{ route('profile') }}" class="nav-link">
                                <i class="fas fa-user"></i> Account Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('profile.edit') }}" class="nav-link">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                        </li>
                        @if(Auth::user()->user_type === 'seller')
                            <li class="nav-item">
                                <a href="{{ route('properties.my') }}" class="nav-link">
                                    <i class="fas fa-home"></i> My Properties
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('favorites.index') }}" class="nav-link active">
                                <i class="fas fa-heart"></i> Favorites
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/my-appraisals') }}" class="nav-link">
                                <i class="fas fa-calendar-check"></i> My Appointments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-6 col-md-8">
                @if(session('success'))
                    <div class="alert success-alert alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <div class="d-flex justify-content-between align-items-center mb-4 fade-in">
                    <h2 class="mb-0" style="margin-left: 70px !important;">Favorite Properties</h2>
                </div>
                
                <!-- Property Listings -->
                <div class="d-flex flex-column align-items-center fade-in">
                    @forelse($favorites as $favorite)
                        @php
                            $property = $favorite->property;
                            $primaryImage = $property->images->where('is_primary', true)->first();
                            $fallbackImage = $property->images->first();
                            $imagePath = asset('images/default-property.jpg');
                            
                            if ($primaryImage && $primaryImage->image_path) {
                                $imagePath = asset('storage/' . $primaryImage->image_path);
                            } elseif ($fallbackImage && $fallbackImage->image_path) {
                                $imagePath = asset('storage/' . $fallbackImage->image_path);
                            }
                        @endphp
                        
                        <div class="mb-4">
                            <div class="property-card">
                                <div class="property-image-container">
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
                                    <form action="{{ route('favorites.toggle') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="property_id" value="{{ $property->id }}">
                                        <button type="submit" class="favorite-btn active">
                                            <i class="fas fa-heart text-danger"></i>
                                        </button>
                                    </form>
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
                                        <form action="{{ route('favorites.toggle') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                                            <button type="submit" class="btn-remove">
                                                <i class="fas fa-heart-broken me-1"></i>Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-state">
                                <i class="fas fa-heart"></i>
                                <h3>No Favorites Yet</h3>
                                <p>You haven't added any properties to your favorites yet.</p>
                                <a href="{{ route('properties.index') }}" class="btn  btn-outline-primary" style="margin-left: 130px ;">
                                    <i class=" me-2"></i>Browse Properties
                                </a>
                            </div>
                        </div>
                    @endforelse
                </div>
                
                <!-- Pagination -->
                @if($favorites->hasPages())
                    <div class="custom-pagination fade-in">
                        @if ($favorites->onFirstPage())
                            <span class="pagination-link pagination-arrow disabled">
                                <i class="fas fa-chevron-left"></i> 
                            </span>
                        @else
                            <a href="{{ $favorites->previousPageUrl() }}" class="pagination-link pagination-arrow">
                                <i class="fas fa-chevron-left"></i> 
                            </a>
                        @endif

                        @if($favorites->currentPage() > 3)
                            <a href="{{ $favorites->url(1) }}" class="pagination-link">1</a>
                        @endif

                        @if($favorites->currentPage() > 4)
                            <span class="pagination-link pagination-dots">...</span>
                        @endif

                        @foreach(range(1, $favorites->lastPage()) as $i)
                            @if($i >= $favorites->currentPage() - 2 && $i <= $favorites->currentPage() + 2)
                                @if ($i == $favorites->currentPage())
                                    <span class="pagination-link active">{{ $i }}</span>
                                @else
                                    <a href="{{ $favorites->url($i) }}" class="pagination-link">{{ $i }}</a>
                                @endif
                            @endif
                        @endforeach

                        @if($favorites->currentPage() < $favorites->lastPage() - 3)
                            <span class="pagination-link pagination-dots">...</span>
                        @endif

                        @if($favorites->currentPage() < $favorites->lastPage() - 2)
                            <a href="{{ $favorites->url($favorites->lastPage()) }}" class="pagination-link">{{ $favorites->lastPage() }}</a>
                        @endif

                        @if ($favorites->hasMorePages())
                            <a href="{{ $favorites->nextPageUrl() }}" class="pagination-link pagination-arrow">
                                 <i class="fas fa-chevron-right"></i>
                            </a>
                        @else
                            <span class="pagination-link pagination-arrow disabled">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fade in animations
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });
    
    document.querySelectorAll('.fade-in').forEach(function(el) {
        observer.observe(el);
    });
    
    // Auto-hide alerts
    document.querySelectorAll('.success-alert').forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Property card hover effects
    const propertyCards = document.querySelectorAll('.property-card');
    propertyCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            const image = card.querySelector('.property-image');
            const title = card.querySelector('.property-title');
            if(image) image.style.transform = 'scale(1.1)';
            if(title) title.style.color = '#3b82f6';
        });
        card.addEventListener('mouseleave', () => {
            const image = card.querySelector('.property-image');
            const title = card.querySelector('.property-title');
            if(image) image.style.transform = 'scale(1)';
            if(title) title.style.color = '#1f2937';
        });
    });

    // Favorite button animation
    document.querySelectorAll('.favorite-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const icon = this.querySelector('i');
            icon.style.transform = 'scale(1.3)';
            setTimeout(() => { icon.style.transform = 'scale(1)'; }, 200);
        });
    });
});
</script>

@endsection
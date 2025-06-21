@extends('layouts.public.app')

@section('title', $property->title)

@section('content')
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

.property-hero {
    position: relative;
    overflow: hidden;
}

.property-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.7);
    z-index: 1;
}

.property-hero-content {
    position: relative;
    z-index: 2;
}

.property-hero-title {
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 16px;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    justify-content: center;
}

.breadcrumb-item a {
    color: #3b82f6;
    text-decoration: none;
    transition: all 0.3s ease;
}

.breadcrumb-item a:hover {
    color: #2563eb;
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: #6b7280;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: #9ca3af;
}

.property-container {
    padding: 50px 0;
}

.property-main {
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 30px;
}

.property-header {
    padding: 25px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
}

.property-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0;
}

.property-price {
    font-size: 1.5rem;
    font-weight: 700;
    color: #3b82f6;
}

.property-badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 6px 12px;
    border-radius: 20px;
    margin-left: 10px;
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

.property-address {
    color: #6b7280;
    font-size: 0.95rem;
    display: flex;
    align-items: center;
    gap: 6px;
    margin-top: 10px;
}

.property-gallery {
    position: relative;
}

.main-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    transition: all 0.3s ease;
}

.thumbnail-container {
    display: flex;
    gap: 10px;
    padding: 15px;
    overflow-x: auto;
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
}

.thumbnail {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.thumbnail:hover, .thumbnail.active {
    border-color: #3b82f6;
    transform: scale(1.05);
}

.property-details {
    padding: 25px;
}

.section-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e5e7eb;
}

.property-description {
    color: #4b5563;
    line-height: 1.7;
    margin-bottom: 30px;
}

.property-features {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
    margin-bottom: 30px;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.95rem;
    color: #374151;
}

.feature-item i {
    color: #3b82f6;
    font-size: 1rem;
}

.property-map {
    height: 350px;
    border-radius: 15px;
    overflow: hidden;
    margin-top: 20px;
    border: 1px solid #e5e7eb;
}

.sidebar-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    padding: 25px;
    margin-bottom: 30px;
}

.agent-card {
    text-align: center;
}

.agent-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto 20px;
    border: 3px solid #e5e7eb;
}

.agent-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 5px;
}

.agent-title {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 20px;
}

.contact-form textarea {
    min-height: 120px;
    resize: vertical;
}

.contact-btn {
    width: 100%;
    margin-bottom: 10px;
}

.similar-property {
    display: flex;
    gap: 15px;
    margin-bottom: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e5e7eb;
}

.similar-property:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.similar-property-image {
    width: 80px;
    height: 80px;
    border-radius: 10px;
    object-fit: cover;
}

.similar-property-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 5px;
}

.similar-property-price {
    font-size: 0.9rem;
    font-weight: 700;
    color: #3b82f6;
    margin-bottom: 5px;
}

.similar-property-details {
    font-size: 0.8rem;
    color: #6b7280;
}

.share-buttons {
    display: flex;
    gap: 10px;
    margin-top: 15px;
}

.share-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    transition: all 0.3s ease;
}

.share-btn:hover {
    transform: translateY(-3px);
}

.facebook {
    background: #3b5998;
}

.twitter {
    background: #1da1f2;
}

.whatsapp {
    background: #25d366;
}

.link {
    background: #6b7280;
}

@media (max-width: 991.98px) {
    .main-image {
        height: 400px;
    }
    
    .property-header {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .property-title {
        font-size: 1.3rem;
    }
    
    .property-price {
        font-size: 1.3rem;
    }
}

@media (max-width: 767.98px) {
    .property-hero {
        padding: 80px 0 40px;
    }
    
    .main-image {
        height: 350px;
    }
    
    .property-features {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
}

@media (max-width: 575.98px) {
    .property-hero {
        padding: 60px 0 30px;
    }
    
    .main-image {
        height: 300px;
    }
    
    .property-title {
        font-size: 1.2rem;
    }
    
    .property-price {
        font-size: 1.2rem;
    }
    
    .property-features {
        grid-template-columns: 1fr;
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

.property-card {
    cursor: pointer;
    transition: all 0.3s ease;
}

.property-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
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

.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 3px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
    margin-left: 10px;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>


<div class="property-container" style="margin-top: 150px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="property-main fade-in">
                    <div class="property-header">
                        <div>
                            <h1 class="property-title">{{ $property->title }}</h1>
                            <p class="property-address">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $property->address }}
                                @if($property->area)
                                    - {{ $property->area->name }}
                                @endif
                            </p>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="property-price">{{ number_format($property->price) }} JOD</span>
                            <span class="property-badge {{ $property->purpose == 'sale' ? 'badge-sale' : 'badge-rent' }}">
                                {{ $property->purpose == 'sale' ? 'For Sale' : 'For Rent' }}
                            </span>
                            @if($property->is_featured)
                                <span class="property-badge badge-featured">
                                    Featured
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="property-gallery">
                        @if($property->images->count() > 0)
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
                            <img src="{{ $imagePath }}" alt="{{ $property->title }}" class="main-image" id="mainImage">
                            
                            @if($property->images->count() > 1)
                                <div class="thumbnail-container">
                                    @foreach($property->images as $image)
                                        @php
                                            $thumbPath = asset('storage/' . $image->image_path);
                                        @endphp
                                        <img src="{{ $thumbPath }}" alt="Thumbnail" class="thumbnail {{ $loop->first ? 'active' : '' }}" 
                                             data-full="{{ $thumbPath }}" onclick="changeMainImage(this)">
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <img src="{{ asset('images/default-property.jpg') }}" alt="{{ $property->title }}" class="main-image">
                        @endif
                    </div>

                    <div class="property-details">
                        <h3 class="section-title">Description</h3>
                        <div class="property-description">
                            {{ $property->description }}
                        </div>

                        <h3 class="section-title">Property Details</h3>
                        <div class="property-features">
                            <div class="feature-item">
                                <i class="fas fa-ruler-combined"></i>
                                <span>Size: {{ number_format($property->size) }} sq.ft</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-bed"></i>
                                <span>Bedrooms: {{ $property->bedrooms ?? 'N/A' }}</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-bath"></i>
                                <span>Bathrooms: {{ $property->bathrooms ?? 'N/A' }}</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-building"></i>
                                <span>Type: {{ $property->type->name ?? 'N/A' }}</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-car"></i>
                                <span>Parking: {{ $property->parking_spaces ?? 'N/A' }}</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Year Built: {{ $property->year_built ?? 'N/A' }}</span>
                            </div>
                        </div>

                        @if($property->features && $property->features->count() > 0)
                            <h3 class="section-title">Features</h3>
                            <div class="property-features">
                                @foreach($property->features as $feature)
                                    <div class="feature-item">
                                        <i class="fas fa-check-circle"></i>
                                        <span>{{ $feature->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <h3 class="section-title">Location</h3>
                        <div class="property-map">
                            <iframe 
                                src="https://maps.google.com/maps?q={{ urlencode($property->address . ', ' . $property->city) }}&t=&z=13&ie=UTF8&iwloc=&output=embed" 
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sidebar-card fade-in" style="position: sticky; top: 20px;">
                    <div class="agent-card">
                        @if($property->user && $property->user->profile_image && file_exists(public_path('storage/' . $property->user->profile_image)))
                            <img src="{{ asset('storage/' . $property->user->profile_image) }}" alt="Agent" class="agent-avatar">
                        @else
                            <img src="{{ asset('images/default-avatar.jpg') }}" alt="Agent" class="agent-avatar">
                        @endif
                        <h3 class="agent-name">{{ $property->user->name ?? 'Property Agent' }}</h3>
                        <p class="agent-title">Real Estate Agent</p>
                        
                        @auth
                            <form id="contactForm" action="{{ route('messages.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $property->user_id }}">
                                <input type="hidden" name="property_id" value="{{ $property->id }}">
                                
                                <div class="mb-3">
                                    <textarea name="message" class="form-control" rows="4" placeholder="Hi, I'm interested in this property..." required></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary contact-btn" id="submitBtn">
                                    <i class="fas fa-paper-plane me-2"></i> Send Message
                                </button>
                            </form>
                            
                            @if($property->user && $property->user->phone)
                                <a href="tel:{{ $property->user->phone }}" class="btn btn-outline-primary contact-btn">
                                    <i class="fas fa-phone-alt me-2"></i> Call Agent
                                </a>
                            @endif
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Please <a href="{{ route('login') }}" class="alert-link">login</a> to contact the agent
                            </div>
                        @endauth
                    </div>
                </div>

              

                <div class="sidebar-card fade-in">
                    <h3 class="section-title">Similar Properties</h3>
                    
                    @if(isset($similarProperties) && $similarProperties->count() > 0)
                        @foreach($similarProperties->take(3) as $similar)
                            <a href="{{ route('properties.show', $similar->id) }}" class="similar-property property-card">
                                @php
                                    $similarImage = $similar->images->first();
                                    $similarThumb = $similarImage ? asset('storage/' . $similarImage->image_path) : asset('images/default-property.jpg');
                                @endphp
                                <img src="{{ $similarThumb }}" alt="{{ $similar->title }}" class="similar-property-image">
                                <div>
                                    <h4 class="similar-property-title">{{ \Illuminate\Support\Str::limit($similar->title, 30) }}</h4>
                                    <p class="similar-property-price">{{ number_format($similar->price) }} JOD</p>
                                    <p class="similar-property-details">
                                        {{ $similar->bedrooms ?? 'N/A' }} beds, {{ $similar->bathrooms ?? 'N/A' }} baths, {{ number_format($similar->size) }} sq.ft
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <p class="text-muted">No similar properties found</p>
                    @endif
                    
                    <a href="{{ route('properties.index') }}" class="btn btn-outline-primary mt-3 w-100">
                        View All Properties
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for fade-in animations
    const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => { entry.target.classList.add('visible'); }, index * 100);
            }
        });
    }, observerOptions);
    document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));

    // Form submission loading state
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="loading-spinner"></span> Sending...';
        });
    }

    // Property card hover effects
    const propertyCards = document.querySelectorAll('.property-card');
    propertyCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-5px)';
            card.style.boxShadow = '0 10px 30px rgba(0, 0, 0, 0.15)';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
            card.style.boxShadow = 'none';
        });
    });
});

// Change main image when thumbnail is clicked
function changeMainImage(thumbnail) {
    const mainImage = document.getElementById('mainImage');
    mainImage.src = thumbnail.dataset.full;
    
    // Update active thumbnail
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.classList.remove('active');
    });
    thumbnail.classList.add('active');
}

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
        const button = document.getElementById('copyLinkBtn');
        button.innerHTML = '<i class="fas fa-check"></i>';
        button.style.background = '#10b981';
        
        setTimeout(() => {
            button.innerHTML = '<i class="fas fa-link"></i>';
            button.style.background = '#6b7280';
        }, 2000);
    });
}
</script>

@endsection
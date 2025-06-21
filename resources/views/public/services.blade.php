@extends('layouts.public.app')

@section('title', 'Our Services')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
.services-section {
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
    margin-top: 20px;
}

.section-subtitle {
    font-size: 1.125rem;
    color: #6b7280;
    max-width: 600px;
    margin: 0 auto;
}

.service-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    transition: all 0.4s ease;
    border: 2px solid transparent;
    position: relative;
    height: 100%;
    padding: 30px;
    text-align: center;
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
    border-color: #3b82f6;
}

.service-icon {
    font-size: 3rem;
    color: #3b82f6;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.service-card:hover .service-icon {
    transform: scale(1.2);
    color: #2563eb;
}

.service-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 15px;
}

.service-description {
    color: #6b7280;
    font-size: 0.95rem;
    margin-bottom: 20px;
}

.learn-more {
    color: #3b82f6;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.2s ease;
}

.learn-more:hover {
    color: #2563eb;
    text-decoration: underline;
}

.learn-more i {
    transition: transform 0.2s ease;
}

.learn-more:hover i {
    transform: translateX(3px);
}

/* Refined Testimonial Section */
.testimonial-section {
    padding: 80px 0;
}

.testimonial-card {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
    height: 100%;
    margin: 0 10px;
    position: relative;
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.testimonial-card::before {
    content: '"';
    position: absolute;
    top: 30px;
    left: 30px;
    font-size: 5rem;
    color: rgba(59, 130, 246, 0.08);
    font-family: serif;
    line-height: 1;
    z-index: 0;
}

.testimonial-content {
    position: relative;
    z-index: 1;
}

.testimonial-header {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-bottom: 25px;
}

.avatar-circle {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    font-weight: bold;
    margin-bottom: 20px;
}

.testimonial-rating {
    margin-bottom: 15px;
}

.testimonial-rating i {
    font-size: 1.2rem;
    color: #FFC107;
    margin: 0 2px;
}

.testimonial-name {
    font-weight: 700;
    color: #1f2937;
    font-size: 1.25rem;
    margin-bottom: 10px;
    text-align: center;
    letter-spacing: 0.5px;
}

.testimonial-area {
    margin-bottom: 20px;
}

.testimonial-area span {
    background: linear-gradient(135deg, #2ecc71, #27ae60);
    color: white;
    padding: 6px 18px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
}

.testimonial-text {
    color: #555;
    line-height: 1.8;
    font-style: italic;
    margin-bottom: 25px;
    font-size: 1.05rem;
    position: relative;
}

.testimonial-footer {
    color: #3498db;
    font-weight: 600;
    font-size: 0.95rem;
    text-align: center;
}

.carousel-control-prev,
.carousel-control-next {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    top: 50%;
    transform: translateY(-50%);
    opacity: 1;
    margin: 0 15px;
    transition: all 0.3s ease;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 5px 15px rgba(59, 130, 246, 0.3);
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    width: 1.5rem;
    height: 1.5rem;
}

.carousel-indicators {
    bottom: -50px;
}

.carousel-indicators [data-bs-target] {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin: 0 6px;
    background-color: rgba(59, 130, 246, 0.4);
    border: none;
    transition: all 0.3s ease;
}

.carousel-indicators .active {
    background-color: #3b82f6;
    transform: scale(1.2);
}

.testimonial-cta {
    text-align: center;
    margin-top: 70px;
}

.testimonial-cta .lead {
    font-size: 1.3rem;
    color: #4b5563;
    margin-bottom: 25px;
    font-weight: 400;
}

.testimonial-cta .btn {
    background: linear-gradient(135deg, #2c3e50 0%, #1a1c20 100%);
    color: white;
    border-radius: 30px;
    font-weight: 600;
    box-shadow: 0 8px 25px rgba(44, 62, 80, 0.2);
    padding: 12px 35px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    border: none;
    font-size: 1rem;
}

.testimonial-cta .btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(44, 62, 80, 0.3);
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

@media (max-width: 1199.98px) {
    .testimonial-card {
        padding: 35px;
    }
}

@media (max-width: 991.98px) {
    .testimonial-section {
        padding: 60px 0;
    }
    
    .testimonial-card {
        padding: 30px;
    }
    
    .testimonial-card::before {
        font-size: 4.5rem;
        top: 25px;
        left: 25px;
    }
    
    .avatar-circle {
        width: 65px;
        height: 65px;
        font-size: 1.5rem;
    }
}

@media (max-width: 767.98px) {
    .testimonial-section {
        padding: 50px 0;
    }
    
    .testimonial-card {
        padding: 25px;
    }
    
    .testimonial-card::before {
        font-size: 4rem;
        top: 20px;
        left: 20px;
    }
    
    .testimonial-text {
        font-size: 1rem;
    }
    
    .carousel-control-prev,
    .carousel-control-next {
        width: 40px;
        height: 40px;
        margin: 0 10px;
    }
}

@media (max-width: 575.98px) {
    .testimonial-card {
        padding: 20px 15px;
    }
    
    .testimonial-card::before {
        font-size: 3.5rem;
        top: 15px;
        left: 15px;
    }
    
    .avatar-circle {
        width: 60px;
        height: 60px;
        font-size: 1.4rem;
        margin-bottom: 15px;
    }
    
    .testimonial-name {
        font-size: 1.15rem;
    }
    
    .testimonial-area span {
        font-size: 0.85rem;
        padding: 5px 15px;
    }
    
    .testimonial-cta .lead {
        font-size: 1.15rem;
    }
}
</style>

<div class="services-section">
    <div class="container">
        <div class="section-header fade-in" style="margin-top: 150px;">
            <h2 class="section-title">Our Comprehensive Services</h2>
            <p class="section-subtitle">Everything you need for your real estate journey in one place</p>
        </div>

        <div class="row g-4">
            <!-- Service Cards (unchanged from original) -->
            <div class="col-xl-3 col-lg-4 col-md-6 fade-in">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h3 class="service-title">Property Listings</h3>
                    <p class="service-description">
                        Browse thousands of properties including apartments, villas, farms, lands, and commercial buildings across Jordan.
                    </p>
                   
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 fade-in">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h3 class="service-title">Seller Dashboard</h3>
                    <p class="service-description">
                        Full control panel for property owners to list, manage, and update their properties with real-time statistics.
                    </p>
                  
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 fade-in">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h3 class="service-title">Direct Communication</h3>
                    <p class="service-description">
                        Instant messaging system connecting buyers directly with sellers for quick responses and negotiations.
                    </p>
                  
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 fade-in">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-search-dollar"></i>
                    </div>
                    <h3 class="service-title">Property Valuation</h3>
                    <p class="service-description">
                        AI-powered estimation tool combined with professional appraisers to determine your property's market value.
                    </p>
                 
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 fade-in">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="service-title">Appraisal Booking</h3>
                    <p class="service-description">
                        Schedule professional property valuation at your preferred time with our certified appraisers.
                    </p>
                  
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 fade-in">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="service-title">24/7 Support</h3>
                    <p class="service-description">
                        Dedicated customer service team available round the clock to assist with any issues or questions.
                    </p>
                   
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 fade-in">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-filter"></i>
                    </div>
                    <h3 class="service-title">Advanced Search</h3>
                    <p class="service-description">
                        Powerful filtering options to find exactly what you're looking for with customizable search criteria.
                    </p>
                    
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-6 fade-in">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-bell"></i>
                    </div>
                    <h3 class="service-title">Price Alerts</h3>
                    <p class="service-description">
                        Get notified immediately when properties matching your criteria become available or change price.
                    </p>
                  
                </div>
            </div>
        </div>

        <!-- Refined Testimonial Section -->
        <div class="testimonial-section fade-in">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">What Our Clients Say</h2>
                    <p class="section-subtitle">Trusted by thousands of satisfied customers across Jordan</p>
                </div>

                <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner px-lg-5">
                        @php
                            $testimonials = App\Models\Testimonial::with('area')
                                ->where('is_active', true)
                                ->latest()
                                ->take(6)
                                ->get();
                        @endphp

                        @forelse($testimonials as $index => $testimonial)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <div class="testimonial-header">
                                            <div class="avatar-circle">
                                                {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                            </div>
                                        
                                            <div class="testimonial-rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                @endfor
                                            </div>
                                        
                                            <div class="testimonial-name">{{ $testimonial->name }}</div>
                                            
                                            @if($testimonial->area)
                                                <div class="testimonial-area">
                                                    <span>
                                                        <i class="fas fa-map-marker-alt me-1"></i> {{ $testimonial->area->name }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="testimonial-text">
                                            <p>{{ $testimonial->content }}</p>
                                        </div>
                                        
                                        <div class="testimonial-footer">
                                            @if($testimonial->position)
                                                <div>{{ $testimonial->position }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="carousel-item active">
                                <div class="testimonial-card">
                                    <div class="testimonial-content">
                                        <div class="testimonial-header">
                                            <div class="avatar-circle">A</div>
                                            <div class="testimonial-rating">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-warning"></i>
                                                @endfor
                                            </div>
                                            <div class="testimonial-name">Ahmad Hassan</div>
                                            <div class="testimonial-area">
                                                <span>
                                                    <i class="fas fa-map-marker-alt me-1"></i> Abdoun
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="testimonial-text">
                                            <p>Finding our family home was made so much easier through this platform. The search filters helped us narrow down exactly what we were looking for, and the neighborhood information was spot on.</p>
                                        </div>
                                        
                                        <div class="testimonial-footer">
                                            <div>Business Owner</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforelse
                    </div>
                    
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <i class="fas fa-chevron-left"></i>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <i class="fas fa-chevron-right"></i>
                        <span class="visually-hidden">Next</span>
                    </button>
                    
                    <div class="carousel-indicators">
                        @for($i = 0; $i < min(count($testimonials), 6); $i++)
                            <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="{{ $i }}" class="{{ $i === 0 ? 'active' : '' }}"></button>
                        @endfor
                    </div>
                </div>
                
                <div class="testimonial-cta">
                    <p class="lead">Had a great experience with us? Share your story!</p>
                    <a href="{{ route('testimonials.form') }}" class="btn">
                        <i class="fas fa-comment-alt"></i> Share Your Experience
                    </a>
                </div>
            </div>
        </div>
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

    const serviceCards = document.querySelectorAll('.service-card');
    serviceCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-10px)';
            card.style.borderColor = '#3b82f6';
        });
        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)';
            card.style.borderColor = 'transparent';
        });
    });
});
</script>

@endsection
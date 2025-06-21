@extends('layouts.public.app')

@section('title', 'Home')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>What Our Clients Say - Testimonials</title>






<style>
/* === GLOBAL STYLES === */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
    line-height: 1.6;
    color: #2c3e50;
    overflow-x: hidden;
}

/* === HERO SECTION === */
.hero {
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(30, 41, 59, 0.8) 50%, rgba(51, 65, 85, 0.8) 100%), 
                url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?q=80&w=2070&auto=format&fit=crop') center/cover no-repeat;
    min-height: 100vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
    padding: 150px 0 80px;
}

.hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 80%, rgba(52, 152, 219, 0.4) 0%, transparent 60%),
        radial-gradient(circle at 80% 20%, rgba(46, 204, 113, 0.4) 0%, transparent 60%),
        radial-gradient(circle at 40% 40%, rgba(155, 89, 182, 0.3) 0%, transparent 50%);
    animation: dynamicBackground 25s ease-in-out infinite;
    z-index: 1;
}

@keyframes dynamicBackground {
    0% { transform: scale(1) rotate(0deg); }
    50% { transform: scale(1.1) rotate(-2deg); }
    100% { transform: scale(1) rotate(0deg); }
}

.hero .container {
    position: relative;
    z-index: 2;
}

.hero-content h1 {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 1.5rem;
    line-height: 1.2;
    text-align: center;
}

.hero-content p {
    font-size: clamp(1rem, 2.5vw, 1.25rem);
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 3rem;
    text-align: center;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* === SEARCH SECTION === */
.search-section {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 30px 90px rgba(0, 0, 0, 0.4);
    max-width: 100%;
    margin: 0 auto;
    position: relative;
}

.search-tabs {
    display: flex;
    background: rgba(59, 130, 246, 0.1);
    border-radius: 15px;
    padding: 8px;
    margin-bottom: 32px;
    gap: 8px;
}

.search-tab {
    flex: 1;
    background: transparent;
    border: none;
    padding: 15px 20px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
    color: rgba(59, 130, 246, 0.8);
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.search-tab.active {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.form-input {
    width: 100%;
    padding: 16px 20px 16px 48px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    font-size: 1rem;
    color: #1f2937;
    background: white;
    transition: all 0.2s ease;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #3b82f6;
    font-size: 1.125rem;
    pointer-events: none;
    z-index: 2;
}

.price-inputs {
    display: flex;
    gap: 12px;
    align-items: center;
}

.price-input {
    flex: 1;
    padding: 16px 12px;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    text-align: center;
    font-size: 1rem;
    transition: all 0.2s ease;
}

.price-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.search-btn {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border: none;
    padding: 16px;
    border-radius: 16px;
    font-size: 1.25rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
    min-height: 56px;
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.4);
}

/* === PROPERTY TYPES === */
.property-types {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    padding: 100px 0;
    position: relative;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
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

.properties-slider-container {
    position: relative;
    overflow: hidden;
    padding: 0 60px;
    max-width: 1400px;
    margin: 0 auto;
}

.properties-slider {
    display: flex;
    gap: 30px;
    transition: transform 0.5s ease;
    padding: 20px 0;
}

.property-card {
    flex: 0 0 320px;
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    transition: all 0.4s ease;
    cursor: pointer;
    height: 380px;
    border: 2px solid transparent;
}

.property-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
    border-color: #3b82f6;
}

.property-image {
    height: 200px;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.property-icon {
    font-size: 4rem;
    color: white;
    z-index: 2;
    position: relative;
    transition: transform 0.3s ease;
}

.property-card:hover .property-icon {
    transform: scale(1.1) rotate(5deg);
}

.gradient-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    opacity: 0.9;
}

/* تصاميم جديدة وجميلة للعقارات */
.apartment-gradient { background: linear-gradient(135deg, #667eea, #764ba2); }
.villa-gradient { background: linear-gradient(135deg, #f093fb, #f5576c); }
.land-gradient { background: linear-gradient(135deg, #4facfe, #00f2fe); }
.commercial-gradient { background: linear-gradient(135deg, #43e97b, #38f9d7); }
.shop-gradient { background: linear-gradient(135deg, #fa709a, #fee140); }
.warehouse-gradient { background: linear-gradient(135deg, #a8edea, #fed6e3); }
.residential-gradient { background: linear-gradient(135deg, #ffecd2, #fcb69f); }
.studio-gradient { background: linear-gradient(135deg, #ff8a80, #ea4c89); }
.commercial-building-gradient { background: linear-gradient(135deg, #8fd3f4, #84fab0); }
.chalet-gradient { background: linear-gradient(135deg, #a18cd1, #fbc2eb); }
.office-gradient { background: linear-gradient(135deg, #74b9ff, #0984e3); }
.factory-gradient { background: linear-gradient(135deg, #fd79a8, #fdcb6e); }
.camp-gradient { background: linear-gradient(135deg, #ff9a9e, #fecfef); }
.cabin-gradient { background: linear-gradient(135deg, #96fbc4, #f9f586); }
.agricultural-gradient { background: linear-gradient(135deg, #81c784, #4caf50); }
.farm-gradient { background: linear-gradient(135deg, #ffb74d, #ff8a65); }

.property-content {
    padding: 24px;
    text-align: center;
}

.property-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 8px;
}

.property-desc {
    color: #6b7280;
    font-size: 0.875rem;
}

.slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid rgba(59, 130, 246, 0.3);
    color: #3b82f6;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
}

.slider-btn:hover {
    background: #3b82f6;
    color: white;
}

.slider-btn-prev { left: 15px; }
.slider-btn-next { right: 15px; }

/* === STATS === */
.stats {
    background: linear-gradient(135deg, #1e293b, #0f172a);
    padding: 80px 0;
    color: white;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 40px;
    text-align: center;
}

.stat-number {
    font-size: 3rem;
    font-weight: 700;
    color: #3b82f6;
    display: block;
    margin-bottom: 8px;
}

.stat-label {
    font-size: 1.125rem;
    color: rgba(255, 255, 255, 0.8);
}

/* === CTA SECTION === */
.cta-section {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    padding: 80px 0;
}

.cta-card {
    background: white;
    border-radius: 24px;
    padding: 48px;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.cta-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 16px;
}

.cta-desc {
    color: #6b7280;
    font-size: 1.125rem;
    margin-bottom: 32px;
}

.cta-btn {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 16px 32px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s ease;
    box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
}

.cta-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.4);
    color: white;
    text-decoration: none;
}

/* === FEATURES === */
.features {
    padding: 100px 0;
    background: white;
}

.features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 40px;
    max-width: 1000px;
    margin: 0 auto;
}

.feature-card {
    text-align: center;
    padding: 40px 24px;
    border-radius: 20px;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(59, 130, 246, 0.15);
    border-color: #3b82f6;
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    margin: 0 auto 24px;
    box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
}

.feature-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 12px;
}

.feature-desc {
    color: #6b7280;
    line-height: 1.6;
}

/* === RESPONSIVE === */
@media (max-width: 1024px) {
    .hero {
        padding: 120px 0 60px;
    }
    
    .search-section {
        padding: 25px;
        margin: 0 15px;
    }
    
    .properties-slider-container {
        padding: 0 40px;
    }
    
    .property-card {
        flex: 0 0 280px;
        height: 350px;
    }
}

@media (max-width: 768px) {
    .hero {
        padding: 100px 0 40px;
        min-height: 90vh;
    }
    
    .hero-content p {
        margin-bottom: 2rem;
    }
    
    .search-section {
        padding: 20px;
        margin: 0 10px;
        border-radius: 15px;
    }
    
    .search-tabs {
        margin-bottom: 20px;
    }
    
    .form-input {
        padding: 14px 16px 14px 40px;
        font-size: 0.9rem;
    }
    
    .form-icon {
        left: 12px;
        font-size: 1rem;
    }
    
    .search-btn {
        height: 52px;
        font-size: 1.1rem;
    }
    
    .properties-slider-container {
        padding: 0 20px;
    }
    
    .property-card {
        flex: 0 0 260px;
        height: 320px;
    }
    
    .slider-btn {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .cta-card {
        padding: 32px 20px;
    }
    
    .features-grid {
        grid-template-columns: 1fr;
        gap: 30px;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 24px;
    }
}

@media (max-width: 576px) {
    .hero {
        padding: 90px 0 30px;
    }
    
    .search-section {
        padding: 15px;
        margin: 0 5px;
    }
    
    .search-tabs {
        flex-direction: column;
        gap: 8px;
        margin-bottom: 15px;
    }
    
    .search-tab {
        padding: 12px 16px;
        font-size: 0.85rem;
    }
    
    .form-input {
        padding: 12px 14px 12px 36px;
        font-size: 0.85rem;
    }
    
    .form-icon {
        left: 10px;
        font-size: 0.9rem;
    }
    
    .price-input {
        padding: 12px 8px;
        font-size: 0.85rem;
    }
    
    .search-btn {
        height: 48px;
        font-size: 1rem;
        margin-top: 10px;
    }
    
    .stat-number {
        font-size: 2.5rem;
    }
}

/* === ANIMATIONS === */
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
</style>

<div class="hero">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center hero-content">
                <h1 class="fade-in mt-5">Find Your Perfect Home</h1>
                <p class="fade-in  " style="margin-left: 160px;">Discover premium properties across Jordan with our advanced search tools and expert guidance</p>
                
                <!-- Search Section -->
                <div class="search-section fade-in">
                    <!-- Search Tabs -->
                    <div class="search-tabs">
                        <button type="button" class="search-tab" data-purpose="sale">
                            <i class="fas fa-home"></i>
                            <span>Buy Property</span>
                        </button>
                        <button type="button" class="search-tab active" data-purpose="rent">
                            <i class="fas fa-key"></i>
                            <span>Rent Property</span>
                        </button>
                    </div>

                    <form action="{{ route('properties.index') }}" method="GET" class="search-form">
                        <input type="hidden" name="purpose" id="searchPurpose" value="rent">
                        
                        <!-- Location -->
                        <div class="form-group">
                            <label class="form-label">Location</label>
                            <div style="position: relative;">
                                <i class="fas fa-map-marker-alt form-icon"></i>
                                <select name="governorate_id" id="governorate" class="form-input">
                                    <option value="">Select location...</option>
                                    @php
                                        $governorates = App\Models\Governorate::orderBy('name')->get();
                                    @endphp
                                    @foreach($governorates as $governorate)
                                        <option value="{{ $governorate->id }}">{{ $governorate->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Property Type -->
                        <div class="form-group">
                            <label class="form-label">Property Type</label>
                            <div style="position: relative;">
                                <i class="fas fa-building form-icon"></i>
                                <select name="property_type" class="form-input">
                                    <option value="">All types...</option>
                                    @php
                                        $propertyTypes = App\Models\PropertyType::all();
                                    @endphp
                                    @foreach($propertyTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Price Range -->
                        <div class="form-group">
                            <label class="form-label">Price Range (JOD)</label>
                            <div class="price-inputs">
                                <input type="number" name="min_price" placeholder="Min" min="0" class="price-input">
                                <span style="color: #6b7280;">-</span>
                                <input type="number" name="max_price" placeholder="Max" min="0" class="price-input">
                            </div>
                        </div>

                        <!-- Search Button -->
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Property Types Section -->
<section class="property-types">
    <div class="container">
        <div class="section-header fade-in">
            <h2 class="section-title">Explore Property Types</h2>
            <p class="section-subtitle">Discover our diverse range of premium properties across Jordan</p>
        </div>
        
        <div class="properties-slider-container">
            <button class="slider-btn slider-btn-prev" onclick="slideProperties('prev')">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <div class="properties-slider" id="propertySlider">
                <!-- Apartment -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay apartment-gradient"></div>
                        <i class="property-icon fas fa-building"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Apartment</h3>
                        <p class="property-desc">Modern living spaces with premium amenities</p>
                    </div>
                </div>

                <!-- Villa -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay villa-gradient"></div>
                        <i class="property-icon fas fa-home"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Villa</h3>
                        <p class="property-desc">Spacious family homes with private gardens</p>
                    </div>
                </div>

                <!-- Land -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay land-gradient"></div>
                        <i class="property-icon fas fa-mountain"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Land</h3>
                        <p class="property-desc">Investment opportunities in prime locations</p>
                    </div>
                </div>

                <!-- Commercial -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay commercial-gradient"></div>
                        <i class="property-icon fas fa-store"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Commercial</h3>
                        <p class="property-desc">Prime retail and business locations</p>
                    </div>
                </div>

                <!-- Shop -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay shop-gradient"></div>
                        <i class="property-icon fas fa-shopping-bag"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Shop</h3>
                        <p class="property-desc">Retail spaces for your business needs</p>
                    </div>
                </div>

                <!-- Warehouse -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay warehouse-gradient"></div>
                        <i class="property-icon fas fa-warehouse"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Warehouse</h3>
                        <p class="property-desc">Industrial storage and distribution centers</p>
                    </div>
                </div>

                <!-- Residential Building -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay residential-gradient"></div>
                        <i class="property-icon fas fa-city"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Residential Building</h3>
                        <p class="property-desc">Multi-unit residential complexes</p>
                    </div>
                </div>

                <!-- Studio -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay studio-gradient"></div>
                        <i class="property-icon fas fa-bed"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Studio</h3>
                        <p class="property-desc">Compact and efficient living spaces</p>
                    </div>
                </div>

                <!-- Commercial Building -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay commercial-building-gradient"></div>
                        <i class="property-icon fas fa-building-columns"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Commercial Building</h3>
                        <p class="property-desc">Large-scale business complexes</p>
                    </div>
                </div>

                <!-- Chalet -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay chalet-gradient"></div>
                        <i class="property-icon fas fa-tree"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Chalet</h3>
                        <p class="property-desc">Vacation homes and mountain retreats</p>
                    </div>
                </div>

                <!-- Office -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay office-gradient"></div>
                        <i class="property-icon fas fa-briefcase"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Office</h3>
                        <p class="property-desc">Professional workspace solutions</p>
                    </div>
                </div>

                <!-- Factory -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay factory-gradient"></div>
                        <i class="property-icon fas fa-industry"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Factory</h3>
                        <p class="property-desc">Manufacturing and production facilities</p>
                    </div>
                </div>

                <!-- Camp -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay camp-gradient"></div>
                        <i class="property-icon fas fa-campground"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Camp</h3>
                        <p class="property-desc">Recreational and temporary accommodations</p>
                    </div>
                </div>

                <!-- Cabin -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay cabin-gradient"></div>
                        <i class="property-icon fas fa-house-chimney"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Cabin</h3>
                        <p class="property-desc">Cozy retreats in natural settings</p>
                    </div>
                </div>

                <!-- Agricultural Land -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay agricultural-gradient"></div>
                        <i class="property-icon fas fa-seedling"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Agricultural Land</h3>
                        <p class="property-desc">Fertile land for farming and cultivation</p>
                    </div>
                </div>

                <!-- Farm -->
                <div class="property-card fade-in">
                    <div class="property-image">
                        <div class="gradient-overlay farm-gradient"></div>
                        <i class="property-icon fas fa-tractor"></i>
                    </div>
                    <div class="property-content">
                        <h3 class="property-title">Farm</h3>
                        <p class="property-desc">Complete agricultural properties with facilities</p>
                    </div>
                </div>
            </div>
            
            <button class="slider-btn slider-btn-next" onclick="slideProperties('next')">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats">
    <div class="container">
        <div class="stats-grid">
            <div class="fade-in">
                <span class="stat-number">2,500+</span>
                <div class="stat-label">Properties Listed</div>
            </div>
            <div class="fade-in">
                <span class="stat-number">1,800+</span>
                <div class="stat-label">Happy Clients</div>
            </div>
            <div class="fade-in">
                <span class="stat-number">4.9</span>
                <div class="stat-label">Average Rating</div>
            </div>
            <div class="fade-in">
                <span class="stat-number">5+</span>
                <div class="stat-label">Years Experience</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="cta-card fade-in">
                    <h2 class="cta-title">Ready to List Your Property?</h2>
                    <p class="cta-desc">Join thousands of property owners who trust us to showcase their properties to the right buyers</p>
                    @if(Auth::check())
                        @if(Auth::user()->user_type === 'seller')
                            <a href="{{ url('/properties/create') }}" class="cta-btn">
                                <i class="fas fa-plus"></i>
                                Add New Property
                            </a>
                        @else
                            <a href="{{ url('/seller-register') }}" class="cta-btn">
                                <i class="fas fa-user-plus"></i>
                                Become a Seller
                            </a>
                        @endif
                    @else
                        <a href="{{ url('/register') }}" class="cta-btn">
                            <i class="fas fa-user-plus"></i>
                            Register to List Property
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features">
    <div class="container">
        <div class="section-header fade-in">
            <h2 class="section-title">Why Choose Baytak?</h2>
            <p class="section-subtitle">We provide comprehensive real estate services with professional expertise</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-home"></i>
                </div>
                <h3 class="feature-title">Buy & Rent Properties</h3>
                <p class="feature-desc">Extensive collection of properties for sale and rent including apartments, villas, commercial spaces, and land across Jordan.</p>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-search-plus"></i>
                </div>
                <h3 class="feature-title">Easy Property Search</h3>
                <p class="feature-desc">Advanced search filters make it simple to find your perfect property by location, price, size, type, and specific amenities.</p>
            </div>

            <div class="feature-card fade-in">
                <div class="feature-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <h3 class="feature-title">Property Valuation & Listing</h3>
                <p class="feature-desc">Get preliminary property estimates, list your properties easily, and book appointments with expert appraisers for accurate valuations.</p>
            </div>
        </div>
    </div>
</section>

<script>
// Property slider functionality
let currentSlide = 0;
let slidesToShow = 4;

function slideProperties(direction) {
    const slider = document.getElementById('propertySlider');
    const cards = slider.children;
    const totalCards = cards.length;
    const maxSlide = Math.max(0, totalCards - slidesToShow);
    
    if (direction === 'next') {
        currentSlide = Math.min(currentSlide + 1, maxSlide);
    } else {
        currentSlide = Math.max(currentSlide - 1, 0);
    }
    
    const translateX = -(currentSlide * (320 + 30)); // card width + gap
    slider.style.transform = `translateX(${translateX}px)`;
}

// Auto-slide functionality
let autoSlideInterval;

function startAutoSlide() {
    autoSlideInterval = setInterval(() => {
        const slider = document.getElementById('propertySlider');
        const cards = slider.children;
        const totalCards = cards.length;
        const maxSlide = Math.max(0, totalCards - slidesToShow);
        
        if (currentSlide >= maxSlide) {
            currentSlide = 0;
        } else {
            currentSlide++;
        }
        
        const translateX = -(currentSlide * (320 + 30));
        slider.style.transform = `translateX(${translateX}px)`;
    }, 4000);
}

function stopAutoSlide() {
    clearInterval(autoSlideInterval);
}

document.addEventListener('DOMContentLoaded', function() {
    // Start auto-slide
    startAutoSlide();
    
    // Stop auto-slide on hover
    const sliderContainer = document.querySelector('.properties-slider-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', stopAutoSlide);
        sliderContainer.addEventListener('mouseleave', startAutoSlide);
    }
    
    // Adjust slides based on screen size
    function updateSlidesToShow() {
        const screenWidth = window.innerWidth;
        if (screenWidth <= 768) {
            slidesToShow = 1;
        } else if (screenWidth <= 1024) {
            slidesToShow = 2;
        } else if (screenWidth <= 1200) {
            slidesToShow = 3;
        } else {
            slidesToShow = 4;
        }
        
        // Reset slider position
        currentSlide = 0;
        const slider = document.getElementById('propertySlider');
        if (slider) {
            slider.style.transform = 'translateX(0px)';
        }
    }
    
    updateSlidesToShow();
    window.addEventListener('resize', updateSlidesToShow);
    // Search tabs functionality
    const searchTabs = document.querySelectorAll('.search-tab');
    const searchPurposeInput = document.getElementById('searchPurpose');
    
    searchTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            searchTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            searchPurposeInput.value = this.dataset.purpose;
        });
    });

    // Advanced filters toggle
    const advancedToggle = document.getElementById('advancedToggle');
    const advancedFilters = document.getElementById('advancedFilters');

    // Governorate-Area dynamic dropdown
    const governorateSelect = document.getElementById('governorate');
    const areaSelect = document.querySelector('select[name="area_id"]');
    
    if (governorateSelect && areaSelect) {
        governorateSelect.addEventListener('change', function() {
            // You can implement dynamic area loading here
            console.log('Governorate changed:', this.value);
        });
    }

    // Prevent negative values in number inputs
    const numberInputs = document.querySelectorAll('input[type="number"]');
    numberInputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.value < 0) {
                this.value = 0;
            }
        });
    });

    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, index * 100);
            }
        });
    }, observerOptions);
    
    // Observe elements for animation
    const animateElements = document.querySelectorAll('.fade-in');
    animateElements.forEach(element => {
        observer.observe(element);
    });

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add loading state to search button
    const searchBtns = document.querySelectorAll('.search-btn, .cta-btn');
    searchBtns.forEach(btn => {
        if (btn.type === 'submit') {
            btn.addEventListener('click', function() {
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                
                setTimeout(() => {
                    this.innerHTML = originalContent;
                }, 2000);
            });
        }
    });

    // Property card click animation
    const propertyCards = document.querySelectorAll('.property-card');
    propertyCards.forEach(card => {
        card.addEventListener('click', function() {
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    // Feature cards hover effect
    const featureCards = document.querySelectorAll('.feature-card');
    featureCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const icon = this.querySelector('.feature-icon');
            icon.style.transform = 'rotate(5deg) scale(1.1)';
        });
        
        card.addEventListener('mouseleave', function() {
            const icon = this.querySelector('.feature-icon');
            icon.style.transform = 'rotate(0deg) scale(1)';
        });
    });

    // Parallax effect for hero section
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.hero');
        if (hero) {
            hero.style.transform = `translateY(${scrolled * 0.5}px)`;
        }
    });

    // Counter animation for stats
    const counters = document.querySelectorAll('.stat-number');
    const animateCounter = (counter) => {
        const target = parseInt(counter.textContent.replace(/[+,]/g, ''));
        const increment = target / 100;
        let current = 0;
        
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                counter.textContent = counter.dataset.original || counter.textContent;
                clearInterval(timer);
            } else {
                counter.textContent = Math.floor(current).toLocaleString();
            }
        }, 20);
    };

    // Store original values and animate when visible
    counters.forEach(counter => {
        counter.dataset.original = counter.textContent;
        
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        counterObserver.observe(counter);
    });
});

// Handle window resize
window.addEventListener('resize', function() {
    // Reset any position-dependent elements
    const advancedFilters = document.getElementById('advancedFilters');
    if (advancedFilters && advancedFilters.classList.contains('show')) {
        // Adjust position if needed
    }
});
</script>

@endsection
@extends('layouts.public.app')

@section('title', 'Add New Property')

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
    background: linear-gradient(to right, #1a1c20, #2c3e50);
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

.form-section {
    padding: 50px 0;
    background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
}

.form-container {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    margin-bottom: 30px;
    transition: all 0.3s ease;
}

.form-container:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.section-title {
    color: #3b82f6;
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 25px;
    padding-bottom: 10px;
    border-bottom: 2px solid #e5e7eb;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 60px;
    height: 2px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.form-control, .form-select {
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    padding: 12px 15px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: #fafafa;
}

.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background: white;
}

.input-group-text {
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    border: 2px solid #e5e7eb;
    border-right: none;
    color: #3b82f6;
    font-weight: 600;
}

.input-group .form-control,
.input-group .form-select {
    border-left: none;
}

.input-group:focus-within .input-group-text {
    border-color: #3b82f6;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
}

.required-star {
    color: #ef4444;
    font-weight: 700;
}

.form-check-input:checked {
    background-color: #3b82f6;
    border-color: #3b82f6;
}

.form-check-input:focus {
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.features-container {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-radius: 15px;
    padding: 25px;
    border: 1px solid #e5e7eb;
}

.feature-item {
    background: white;
    border-radius: 10px;
    padding: 10px 15px;
    margin-bottom: 10px;
    border: 1px solid #e5e7eb;
    transition: all 0.2s ease;
}

.feature-item:hover {
    background: #f8fafc;
    border-color: #3b82f6;
    transform: translateX(2px);
}

.feature-item .form-check-input:checked + .form-check-label {
    color: #3b82f6;
    font-weight: 600;
}

.image-preview-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.image-preview-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 2px solid #e5e7eb;
    transition: all 0.3s ease;
}

.image-preview-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    border-color: #3b82f6;
}

.preview-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.preview-info {
    padding: 12px 15px;
    text-align: center;
}

.primary-badge {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 15px;
}

.additional-badge {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 15px;
}

.terms-container {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    border: 2px solid #93c5fd;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 30px;
}

.terms-container .form-check-label {
    color: #1e40af;
    font-weight: 500;
}

.submit-btn {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
    padding: 15px 40px;
    border-radius: 15px;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
}

.submit-btn:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(59, 130, 246, 0.4);
    color: white;
}

.success-alert {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 15px;
    padding: 20px 25px;
    margin-bottom: 30px;
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    animation: slideInDown 0.5s ease-out;
}

.danger-alert {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border: none;
    border-radius: 15px;
    padding: 20px 25px;
    margin-bottom: 30px;
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
    animation: slideInDown 0.5s ease-out;
}

@keyframes slideInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.success-alert .btn-close,
.danger-alert .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.alert-heading {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.form-text {
    color: #6b7280;
    font-size: 0.9rem;
    margin-top: 8px;
}

/* Custom Popup Styles */
.custom-popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    z-index: 9999;
    display: none;
    justify-content: center;
    align-items: center;
    animation: fadeIn 0.3s ease;
}

.custom-popup-overlay.show {
    display: flex;
}

.custom-popup {
    background: white;
    border-radius: 20px;
    padding: 0;
    max-width: 500px;
    width: 90%;
    box-shadow: 0 25px 70px rgba(0, 0, 0, 0.3);
    position: relative;
    animation: popupSlideIn 0.4s ease;
    overflow: hidden;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes popupSlideIn {
    from { 
        opacity: 0;
        transform: scale(0.8) translateY(-50px);
    }
    to { 
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.popup-header {
    padding: 25px 30px 20px;
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    position: relative;
}

.popup-close {
    position: absolute;
    top: 15px;
    right: 20px;
    background: rgba(255, 255, 255, 0.2);
    border: none;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    color: white;
    font-size: 18px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.popup-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: rotate(90deg);
}

.popup-title {
    font-size: 1.3rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 10px;
}

.popup-title i {
    font-size: 1.5rem;
}

.popup-body {
    padding: 30px 30px 25px;
    text-align: center;
}

.popup-icon {
    font-size: 4rem;
    color: #10b981;
    margin-bottom: 20px;
}

.popup-message {
    font-size: 1.2rem;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 15px;
}

.popup-description {
    font-size: 1rem;
    color: #6b7280;
    margin-bottom: 25px;
    line-height: 1.6;
}

.popup-footer {
    padding: 0 30px 30px;
    display: flex;
    gap: 15px;
    justify-content: center;
}

.popup-btn {
    padding: 12px 25px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}

.popup-btn-primary {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.popup-btn-primary:hover {
    background: linear-gradient(135deg, #059669, #047857);
    transform: translateY(-1px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    color: white;
    text-decoration: none;
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

/* Responsive Design */
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
    
    .form-container {
        padding: 25px 20px;
    }

    .popup-body, .popup-footer {
        padding-left: 20px;
        padding-right: 20px;
    }

    .popup-header {
        padding-left: 20px;
        padding-right: 20px;
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

    .popup-footer {
        flex-direction: column;
        gap: 10px;
    }

    .popup-btn {
        width: 100%;
        justify-content: center;
    }

    .image-preview-container {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
    }
}
</style>

<!-- Hero Section -->
<div class="custom-hero">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <div class="hero-content">
                    <h1 class="hero-title fade-up delay-1" style="margin-top: 50px;">List Your Property</h1>
                    <p class="hero-subtitle fade-up delay-2">Add your property to our marketplace and reach thousands of potential buyers</p>
                 
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Form Section -->
<div class="form-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert success-alert alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading"><i class="fas fa-check-circle me-2"></i> Property Submitted!</h4>
                        <p>{{ session('success') }}</p>
                        <p class="mb-0">Your property listing has been submitted and is pending approval. Our team will review your listing and it will be published soon.</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert danger-alert alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading"><i class="fas fa-exclamation-circle me-2"></i> Please Fix These Errors</h4>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="form-container fade-in">
                    <form action="{{ route('properties.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Basic Information -->
                        <h2 class="section-title">Property Information</h2>
                        
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">Property Title <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-home"></i>
                                    </span>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. Modern Villa with Pool">
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="property_type" class="form-label">Property Type <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-building"></i>
                                    </span>
                                    <select class="form-select" id="property_type" name="property_type_id" required>
                                        <option value="">Select Property Type</option>
                                        @foreach(App\Models\PropertyType::all() as $type)
                                            <option value="{{ $type->id }}" {{ old('property_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="purpose" class="form-label">Purpose <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-tag"></i>
                                    </span>
                                    <select class="form-select" id="purpose" name="purpose" required>
                                        <option value="">Select Purpose</option>
                                        <option value="sale" {{ old('purpose') == 'sale' ? 'selected' : '' }}>For Sale</option>
                                        <option value="rent" {{ old('purpose') == 'rent' ? 'selected' : '' }}>For Rent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Location Details -->
                        <h4 class="section-title">Location Details</h4>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="area_id" class="form-label">Area <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <select class="form-select" id="area_id" name="area_id" required>
                                        <option value="">Select Area</option>
                                        @foreach(App\Models\Area::all() as $area)
                                            <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Full Address <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-location-dot"></i>
                                    </span>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required placeholder="e.g. 123 Main Street, Apt 4B">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Property Details -->
                        <h4 class="section-title">Property Details</h4>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="price" class="form-label">Price (JOD) <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-money-bill"></i>
                                    </span>
                                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}" required min="0" step="0.01" placeholder="e.g. 150000">
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="size" class="form-label">Size (sq.ft) <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-ruler-combined"></i>
                                    </span>
                                    <input type="number" class="form-control" id="size" name="size" value="{{ old('size') }}" required min="0" placeholder="e.g. 1500">
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="bedrooms" class="form-label">Bedrooms</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-bed"></i>
                                    </span>
                                    <input type="number" class="form-control" id="bedrooms" name="bedrooms" value="{{ old('bedrooms') }}" min="0" placeholder="e.g. 3">
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="bathrooms" class="form-label">Bathrooms</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-bath"></i>
                                    </span>
                                    <input type="number" class="form-control" id="bathrooms" name="bathrooms" value="{{ old('bathrooms') }}" min="0" placeholder="e.g. 2">
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="parking_spaces" class="form-label">Parking Spaces</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-car"></i>
                                    </span>
                                    <input type="number" class="form-control" id="parking_spaces" name="parking_spaces" value="{{ old('parking_spaces') }}" min="0" placeholder="e.g. 1">
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="year_built" class="form-label">Year Built</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    <select class="form-select" id="year_built" name="year_built">
                                        <option value="">Select Year Built</option>
                                        @for($year = date('Y'); $year >= 1950; $year--)
                                            <option value="{{ $year }}" {{ old('year_built') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="is_featured" class="form-label">Featured Property</label>
                                <div class="form-check form-switch p-3 mt-2 bg-light rounded">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">Mark as featured (appears in spotlight sections)</label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Features -->
                        <h4 class="section-title">Property Features</h4>
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Select Features</label>
                                <div class="features-container">
                                    <div class="row">
                                        @foreach(App\Models\Feature::all() as $feature)
                                            <div class="col-md-4 mb-2">
                                                <div class="feature-item">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="feature_{{ $feature->id }}" name="features[]" value="{{ $feature->id }}" {{ (is_array(old('features')) && in_array($feature->id, old('features'))) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="feature_{{ $feature->id }}">{{ $feature->name }}</label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <h4 class="section-title">Property Description</h4>
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">Description <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-align-left"></i>
                                    </span>
                                    <textarea class="form-control" id="description" name="description" rows="6" required placeholder="Provide a detailed description of your property...">{{ old('description') }}</textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Property Images -->
                        <h4 class="section-title">Property Images</h4>
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label for="images" class="form-label">Upload Images <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-images"></i>
                                    </span>
                                    <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*" required>
                                </div>
                                <div class="form-text">You can upload multiple images. The first image will be set as primary image automatically.</div>
                            </div>
                            <div class="col-md-12">
                                <div id="image-previews" class="image-preview-container"></div>
                            </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <h4 class="section-title">Contact Information</h4>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="contact_name" class="form-label">Contact Name</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" class="form-control" id="contact_name" name="contact_name" value="{{ old('contact_name', Auth::user()->name ?? '') }}" placeholder="Your name">
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="contact_phone" class="form-label">Contact Phone <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <input type="tel" class="form-control" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', Auth::user()->phone ?? '') }}" required placeholder="Your phone number">
                                </div>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="contact_email" class="form-label">Contact Email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <input type="email" class="form-control" id="contact_email" name="contact_email" value="{{ old('contact_email', Auth::user()->email ?? '') }}" placeholder="Your email address">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Terms -->
                        <div class="terms-container">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                <label class="form-check-label" for="terms">
                                    I confirm that all information provided is accurate and I have the right to list this property.
                                </label>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="submit-btn">
                                <i class="fas fa-paper-plane me-2"></i> Submit Property
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Popup -->
<div class="custom-popup-overlay" id="successPopupOverlay">
    <div class="custom-popup">
        <div class="popup-header">
            <h5 class="popup-title">
                <i class="fas fa-check-circle"></i>
                Property Submitted
            </h5>
            <button class="popup-close" onclick="hideSuccessPopup()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="popup-body">
            <div class="popup-icon">
                <i class="fas fa-building"></i>
            </div>
            <h4 class="popup-message">Thank You!</h4>
            <p class="popup-description">Your property listing has been submitted successfully and is pending approval. Our team will review your listing and it will be published soon.</p>
        </div>
        <div class="popup-footer">
            <a href="{{ route('profile') }}" class="popup-btn popup-btn-primary">
                <i class="fas fa-user"></i>
                Go to My Profile
            </a>
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

    // Show success popup if there's a success message
    if (document.querySelector('.success-alert')) {
        setTimeout(function() {
            showSuccessPopup();
        }, 1000);
    }
    
    // Image preview handler
    document.getElementById('images').addEventListener('change', function(event) {
        // Clear previous previews
        document.getElementById('image-previews').innerHTML = '';
        
        // Create preview for each selected image
        for (let i = 0; i < event.target.files.length; i++) {
            const file = event.target.files[i];
            if (file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.className = 'image-preview-card';
                    preview.innerHTML = `
                        <img src="${e.target.result}" class="preview-image" alt="Preview">
                        <div class="preview-info">
                            ${i === 0 ? '<span class="primary-badge">Primary Image</span>' : '<span class="additional-badge">Additional Image</span>'}
                        </div>
                    `;
                    document.getElementById('image-previews').appendChild(preview);
                }
                reader.readAsDataURL(file);
            }
        }
    });
    
    // Validate file input before form submission
    document.querySelector('form').addEventListener('submit', function(event) {
        const imageInput = document.getElementById('images');
        if (imageInput.files.length === 0) {
            event.preventDefault();
            alert('Please select at least one image for your property.');
            imageInput.focus();
            // Scroll to images section
            document.getElementById('images').scrollIntoView({ behavior: 'smooth' });
        }
    });

    // Auto-hide alerts
    document.querySelectorAll('.success-alert, .danger-alert').forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 8000);
    });

    // Form validation enhancements
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.style.borderColor = '#ef4444';
            } else {
                this.style.borderColor = '#10b981';
            }
        });

        input.addEventListener('focus', function() {
            this.style.borderColor = '#3b82f6';
        });
    });

    // Price formatting
    const priceInput = document.getElementById('price');
    priceInput.addEventListener('input', function() {
        // Remove non-numeric characters except decimal point
        this.value = this.value.replace(/[^0-9.]/g, '');
        
        // Ensure only one decimal point
        const parts = this.value.split('.');
        if (parts.length > 2) {
            this.value = parts[0] + '.' + parts.slice(1).join('');
        }
    });

    // Phone number formatting
    const phoneInput = document.getElementById('contact_phone');
    phoneInput.addEventListener('input', function() {
        // Basic phone number formatting for Jordan
        let value = this.value.replace(/\D/g, ''); // Remove non-digits
        if (value.length > 0) {
            if (value.startsWith('962')) {
                // International format
                if (value.length <= 12) {
                    this.value = value.replace(/(\d{3})(\d{1})(\d{4})(\d{4})/, '+$1 $2 $3 $4');
                }
            } else if (value.startsWith('07')) {
                // Local format
                if (value.length <= 10) {
                    this.value = value.replace(/(\d{2})(\d{4})(\d{4})/, '$1 $2 $3');
                }
            } else {
                this.value = value;
            }
        }
    });
});

// Success Popup Functions
function showSuccessPopup() {
    document.getElementById('successPopupOverlay').classList.add('show');
    document.body.style.overflow = 'hidden';
}

function hideSuccessPopup() {
    document.getElementById('successPopupOverlay').classList.remove('show');
    document.body.style.overflow = 'auto';
}

// Close popup when clicking on overlay
document.getElementById('successPopupOverlay').addEventListener('click', function(e) {
    if (e.target === this) {
        hideSuccessPopup();
    }
});

// Close popup with escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideSuccessPopup();
    }
});
</script>

@endsection
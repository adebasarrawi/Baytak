@extends('layouts.public.app')

@section('title', 'Edit Property')

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

.new-badge {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    font-size: 0.75rem;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 15px;
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

.btn-back {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    color: white;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: linear-gradient(135deg, #4b5563, #374151);
    transform: translateY(-1px);
    color: white;
    text-decoration: none;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 600;
}

.status-approved {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.status-pending {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.status-rejected {
    background: linear-gradient(135deg, #ef4444, #dc2626);
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

.warning-alert {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    border: none;
    border-radius: 15px;
    padding: 20px 25px;
    margin-bottom: 30px;
    box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
    animation: slideInDown 0.5s ease-out;
}

.info-alert {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border: none;
    border-radius: 15px;
    padding: 20px 25px;
    margin-bottom: 30px;
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    animation: slideInDown 0.5s ease-out;
}

@keyframes slideInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.success-alert .btn-close,
.danger-alert .btn-close,
.warning-alert .btn-close,
.info-alert .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.alert-heading {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 15px;
}

.images-card {
    background: white;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
    margin-bottom: 25px;
}

.images-header {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    margin: -25px -25px 20px -25px;
    padding: 15px 25px;
    border-bottom: 1px solid #e5e7eb;
    border-radius: 20px 20px 0 0;
}

.image-item {
    position: relative;
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    border: 2px solid #e5e7eb;
    transition: all 0.3s ease;
}

.image-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    border-color: #3b82f6;
}

.delete-image-btn {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    border: none;
    color: white;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 600;
    transition: all 0.2s ease;
}

.delete-image-btn:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    transform: translateY(-1px);
    color: white;
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
    max-width: 450px;
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
    background: linear-gradient(135deg, #ef4444, #dc2626);
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
}

.popup-message {
    font-size: 1rem;
    color: #374151;
    margin-bottom: 25px;
    line-height: 1.6;
}

.popup-footer {
    padding: 0 30px 30px;
    display: flex;
    gap: 15px;
    justify-content: flex-end;
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
}

.popup-btn-cancel {
    background: #f3f4f6;
    color: #374151;
}

.popup-btn-cancel:hover {
    background: #e5e7eb;
    transform: translateY(-1px);
}

.popup-btn-confirm {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.popup-btn-confirm:hover {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    transform: translateY(-1px);
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
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
    
    .images-card {
        padding: 20px;
    }
    
    .images-header {
        margin: -20px -20px 15px -20px;
        padding: 12px 20px;
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
                    <h1 class="hero-title fade-up delay-1" style="margin-top: 50px;">Edit Property</h1>
                    <p class="hero-subtitle fade-up delay-2">Update your property information and details</p>
                   
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
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="alert success-alert alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading"><i class="fas fa-check-circle me-2"></i> Success!</h4>
                        <p class="mb-0">{{ session('success') }}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert danger-alert alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading"><i class="fas fa-exclamation-circle me-2"></i> Error!</h4>
                        <p class="mb-0">{{ session('error') }}</p>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

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
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="section-title mb-0">Edit Property</h2>
                        <a href="{{ route('properties.my') }}" class="btn-back">
                            <i class="fas fa-arrow-left me-2"></i> Back to My Properties
                        </a>
                    </div>
                    
                    <!-- Status Information -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center">
                            <span class="me-2">Current Status:</span>
                            @if($property->status == 'approved')
                                <span class="status-badge status-approved">Approved</span>
                            @elseif($property->status == 'rejected')
                                <span class="status-badge status-rejected">Rejected</span>
                            @elseif($property->status == 'pending')
                                <span class="status-badge status-pending">Pending Approval</span>
                            @else
                                <span class="status-badge status-pending">{{ ucfirst($property->status) }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Status Alerts -->
                    @if(Auth::user()->role !== 'admin')
                        @if($property->status == 'approved')
                            <div class="alert info-alert" role="alert">
                                <h4 class="alert-heading"><i class="fas fa-info-circle me-2"></i> Note!</h4>
                                <p class="mb-0">Your property is currently <strong>approved</strong>. Any changes you make will set its status back to <strong>pending</strong> for admin review.</p>
                            </div>
                        @elseif($property->status == 'rejected')
                            <div class="alert warning-alert" role="alert">
                                <h4 class="alert-heading"><i class="fas fa-exclamation-circle me-2"></i> Property Rejected!</h4>
                                <p>Your property was <strong>rejected</strong>. After making your changes and clicking <strong>Update Property</strong>, it will be set to <strong>pending</strong> for admin review.</p>
                                <p class="mb-0"><strong>Please review and update the required information before submitting.</strong></p>
                            </div>
                        @elseif($property->status == 'pending')
                            <div class="alert warning-alert" role="alert">
                                <h4 class="alert-heading"><i class="fas fa-clock me-2"></i> Pending Review!</h4>
                                <p class="mb-0">This property is currently <strong>pending admin approval</strong>. You can still make changes, and it will remain pending until reviewed.</p>
                            </div>
                        @endif
                    @endif
                    
                    <form action="{{ route('properties.update', $property->id) }}" method="POST" enctype="multipart/form-data" id="propertyEditForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information -->
                        <h4 class="section-title">Property Information</h4>
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">Property Title <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-home"></i>
                                    </span>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $property->title) }}" 
                                           required placeholder="e.g. Modern Villa with Pool">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="property_type_id" class="form-label">Property Type <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-building"></i>
                                    </span>
                                    <select class="form-select @error('property_type_id') is-invalid @enderror" 
                                            id="property_type_id" name="property_type_id" required>
                                        <option value="">Select Property Type</option>
                                        @foreach($propertyTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('property_type_id', $property->property_type_id) == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('property_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="purpose" class="form-label">Purpose <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-tag"></i>
                                    </span>
                                    <select class="form-select @error('purpose') is-invalid @enderror" 
                                            id="purpose" name="purpose" required>
                                        <option value="">Select Purpose</option>
                                        <option value="sale" {{ old('purpose', $property->purpose) == 'sale' ? 'selected' : '' }}>For Sale</option>
                                        <option value="rent" {{ old('purpose', $property->purpose) == 'rent' ? 'selected' : '' }}>For Rent</option>
                                    </select>
                                    @error('purpose')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                    <select class="form-select @error('area_id') is-invalid @enderror" 
                                            id="area_id" name="area_id" required>
                                        <option value="">Select Area</option>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}" {{ old('area_id', $property->area_id) == $area->id ? 'selected' : '' }}>
                                                {{ $area->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('area_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Full Address <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-location-dot"></i>
                                    </span>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror" 
                                           id="address" name="address" value="{{ old('address', $property->address) }}" 
                                           required placeholder="e.g. 123 Main Street, Apt 4B">
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
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
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                           id="price" name="price" value="{{ old('price', $property->price) }}" 
                                           required min="0" step="0.01" placeholder="e.g. 150000">
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="size" class="form-label">Size (sq.ft) <span class="required-star">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-ruler-combined"></i>
                                    </span>
                                    <input type="number" class="form-control @error('size') is-invalid @enderror" 
                                           id="size" name="size" value="{{ old('size', $property->size) }}" 
                                           required min="0" placeholder="e.g. 1500">
                                    @error('size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="bedrooms" class="form-label">Bedrooms</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-bed"></i>
                                    </span>
                                    <input type="number" class="form-control @error('bedrooms') is-invalid @enderror" 
                                           id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" 
                                           min="0" placeholder="e.g. 3">
                                    @error('bedrooms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="bathrooms" class="form-label">Bathrooms</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-bath"></i>
                                    </span>
                                    <input type="number" class="form-control @error('bathrooms') is-invalid @enderror" 
                                           id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" 
                                           min="0" placeholder="e.g. 2">
                                    @error('bathrooms')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="parking_spaces" class="form-label">Parking Spaces</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-car"></i>
                                    </span>
                                    <input type="number" class="form-control @error('parking_spaces') is-invalid @enderror" 
                                           id="parking_spaces" name="parking_spaces" value="{{ old('parking_spaces', $property->parking_spaces) }}" 
                                           min="0" placeholder="e.g. 1">
                                    @error('parking_spaces')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="year_built" class="form-label">Year Built</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    <select class="form-select @error('year_built') is-invalid @enderror" 
                                            id="year_built" name="year_built">
                                        <option value="">Select Year Built</option>
                                        @for($year = date('Y'); $year >= 1950; $year--)
                                            <option value="{{ $year }}" {{ old('year_built', $property->year_built) == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('year_built')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="is_featured" class="form-label">Featured Property</label>
                                <div class="form-check form-switch p-3 mt-2 bg-light rounded">
                                    <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured', $property->is_featured) ? 'checked' : '' }}>
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
                                        @foreach($features as $feature)
                                            <div class="col-md-4 mb-2">
                                                <div class="feature-item">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="feature_{{ $feature->id }}" 
                                                               name="features[]" value="{{ $feature->id }}" 
                                                               {{ (is_array(old('features', $property->features->pluck('id')->toArray())) && 
                                                                   in_array($feature->id, old('features', $property->features->pluck('id')->toArray()))) ? 'checked' : '' }}>
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
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="6" required 
                                              placeholder="Provide a detailed description of your property...">{{ old('description', $property->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Property Images -->
                        <h4 class="section-title">Property Images</h4>
                        <div class="row mb-4">
                            <div class="col-md-12 mb-3">
                                <div class="images-card">
                                    <div class="images-header">
                                        <h5 class="mb-0">Current Images ({{ $property->images->count() }})</h5>
                                    </div>
                                    
                                    <div class="row">
                                        @forelse($property->images as $image)
                                            <div class="col-md-3 mb-3" id="image-container-{{ $image->id }}">
                                                <div class="image-item">
                                                    <img src="{{ asset('storage/'.$image->image_path) }}" 
                                                         class="preview-image" 
                                                         alt="Property Image">
                                                    <div class="preview-info">
                                                        <div class="mb-2">
                                                            @if($image->is_primary)
                                                                <span class="primary-badge">Primary Image</span>
                                                            @else
                                                                <span class="additional-badge">Additional Image</span>
                                                            @endif
                                                        </div>
                                                        @if($property->images->count() > 1)
                                                            <button type="button" 
                                                                    class="delete-image-btn w-100" 
                                                                    onclick="showDeleteImagePopup('{{ $image->id }}')">
                                                                <i class="fas fa-trash-alt me-1"></i> Delete
                                                            </button>
                                                        @else
                                                            <small class="text-muted">Last image cannot be deleted</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <div class="alert warning-alert mb-0">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                    No images available for this property. Please upload at least one image.
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="images" class="form-label">Upload New Images</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-images"></i>
                                    </span>
                                    <input type="file" 
                                           class="form-control @error('images') is-invalid @enderror" 
                                           id="images" 
                                           name="images[]" 
                                           multiple 
                                           accept="image/*">
                                    @error('images')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    You can upload additional images. 
                                    @if($property->images->isEmpty())
                                        First image will be set as primary.
                                    @else
                                        New images will be added as additional images.
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div id="image-previews" class="image-preview-container"></div>
                            </div>
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="submit-btn" id="updateButton">
                                <i class="fas fa-save me-2"></i> Update Property
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Image Popup -->
<div class="custom-popup-overlay" id="deleteImagePopupOverlay">
    <div class="custom-popup">
        <div class="popup-header">
            <h5 class="popup-title">
                <i class="fas fa-trash-alt"></i>
                Delete Image
            </h5>
            <button class="popup-close" onclick="hideDeleteImagePopup()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="popup-body">
            <p class="popup-message">Are you sure you want to delete this image? This action cannot be undone.</p>
        </div>
        <div class="popup-footer">
            <button type="button" class="popup-btn popup-btn-cancel" onclick="hideDeleteImagePopup()">
                <i class="fas fa-times"></i>
                Cancel
            </button>
            <button type="button" class="popup-btn popup-btn-confirm" id="confirmDeleteBtn">
                <i class="fas fa-trash-alt"></i>
                Delete Image
            </button>
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

    const form = document.getElementById('propertyEditForm');
    const updateButton = document.getElementById('updateButton');
    const imageInput = document.getElementById('images');
    const imagePreviewsContainer = document.getElementById('image-previews');
    
    // Form submission handling
    if (form && updateButton) {
        form.addEventListener('submit', function(e) {
            console.log('Form is being submitted...');
            
            updateButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Updating Property...';
            updateButton.disabled = true;
            
            const csrfToken = form.querySelector('input[name="_token"]');
            if (!csrfToken) {
                console.error('CSRF token missing');
                e.preventDefault();
                alert('Security token missing. Please refresh the page.');
                updateButton.innerHTML = '<i class="fas fa-save me-2"></i> Update Property';
                updateButton.disabled = false;
                return false;
            }
        });
    }
    
    // Image preview handler
    if (imageInput && imagePreviewsContainer) {
        imageInput.addEventListener('change', function(e) {
            imagePreviewsContainer.innerHTML = '';
            const files = Array.from(e.target.files);
            
            if (files.length > 0) {
                files.forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            const div = document.createElement('div');
                            div.className = 'image-preview-card';
                            div.innerHTML = `
                                <img src="${event.target.result}" class="preview-image" alt="New Image ${index + 1}">
                                <div class="preview-info">
                                    <span class="new-badge">New Image ${index + 1}</span>
                                    <br><small class="text-muted">${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                                </div>
                            `;
                            imagePreviewsContainer.appendChild(div);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    }

    // Auto-hide alerts
    document.querySelectorAll('.success-alert, .danger-alert, .warning-alert, .info-alert').forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 8000);
    });

    // Form validation enhancements
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
});

let currentImageId = null;

// Delete Image Popup Functions
function showDeleteImagePopup(imageId) {
    currentImageId = imageId;
    document.getElementById('deleteImagePopupOverlay').classList.add('show');
    document.body.style.overflow = 'hidden';
    
    // Set up confirm button
    document.getElementById('confirmDeleteBtn').onclick = function() {
        deleteImage(imageId);
    };
}

function hideDeleteImagePopup() {
    document.getElementById('deleteImagePopupOverlay').classList.remove('show');
    document.body.style.overflow = 'auto';
    currentImageId = null;
}

function deleteImage(imageId) {
    hideDeleteImagePopup();
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/properties/images/' + imageId;
    form.style.display = 'none';
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (csrfToken) {
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken.getAttribute('content');
        form.appendChild(csrfInput);
    }
    
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'DELETE';
    form.appendChild(methodInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Close popup when clicking on overlay
document.getElementById('deleteImagePopupOverlay').addEventListener('click', function(e) {
    if (e.target === this) {
        hideDeleteImagePopup();
    }
});

// Close popup with escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideDeleteImagePopup();
    }
});
</script>

@endsection
@extends('layouts.public.app')

@section('title', 'Estimate Your Property')

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

.main-section {
    padding: 50px 0;
    background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
}

.main-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
    margin-bottom: 30px;
}

.main-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.sidebar-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    margin-bottom: 30px;
    transition: all 0.3s ease;
}

.sidebar-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.property-estimation-tabs {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
}

.property-estimation-tabs .nav-tabs {
    border-bottom: 1px solid #e5e7eb;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    padding: 20px 20px 0 20px;
    margin-bottom: 0;
}

.property-estimation-tabs .nav-link {
    font-weight: 600;
    padding: 15px 25px;
    color: #6b7280;
    border-radius: 15px 15px 0 0;
    border: none;
    background: transparent;
    transition: all 0.3s ease;
}

.property-estimation-tabs .nav-link:hover {
    color: #3b82f6;
    background: rgba(59, 130, 246, 0.1);
}

.property-estimation-tabs .nav-link.active {
    color: #3b82f6;
    background: white;
    border: 1px solid #e5e7eb;
    border-bottom: 1px solid white;
    margin-bottom: -1px;
    font-weight: 700;
}

.tab-content {
    background: white;
    padding: 30px;
    min-height: 600px;
}

.form-section {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-radius: 15px;
    padding: 25px;
    margin-bottom: 25px;
    border: 1px solid #e5e7eb;
}

.form-section-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
}

.form-section-title i {
    margin-right: 10px;
    color: #3b82f6;
}

.form-control, .form-select {
    border: 1px solid #d1d5db;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    background: white;
}

.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
    background: white;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
    border-radius: 12px;
    color: white;
    padding: 15px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
    text-decoration: none;
    font-size: 1rem;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
}

.btn-outline-primary {
    color: #3b82f6;
    border: 2px solid #3b82f6;
    background: transparent;
    border-radius: 12px;
    padding: 15px 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-color: transparent;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
}

#estimationResult {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 2px solid #10b981;
    margin-bottom: 30px;
    animation: slideInUp 0.5s ease-out;
}

@keyframes slideInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.display-4 {
    font-size: 3rem;
    font-weight: 700;
    color: #1f2937;
}

.alert {
    border-radius: 15px;
    border: none;
    padding: 20px;
    margin-bottom: 25px;
}

.alert-info {
    background: linear-gradient(135deg, #e0f2fe, #b3e5fc);
    color: #0277bd;
    border: 1px solid #81d4fa;
}

.alert-success {
    background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
    color: #2e7d32;
    border: 1px solid #a5d6a7;
}

.appraiser-card {
    transition: all 0.3s ease;
    border: 2px solid #e5e7eb;
    border-radius: 15px;
    overflow: hidden;
    margin-bottom: 20px;
    background: white;
    cursor: pointer;
}

.appraiser-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border-color: #3b82f6;
}

.appraiser-card.border-primary {
    border-color: #3b82f6 !important;
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.2);
}

.appraiser-card label {
    display: flex;
    flex-direction: column;
    height: 100%;
    cursor: pointer;
    padding: 25px;
    margin-bottom: 0;
}

.form-check {
    margin-bottom: 10px;
}

.form-check-input:checked {
    background-color: #3b82f6;
    border-color: #3b82f6;
}

.accordion {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
}

.accordion-item {
    border: none;
    margin-bottom: 15px;
    border-radius: 15px !important;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
}

.accordion-button {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border: none;
    padding: 20px 25px;
    font-weight: 600;
    color: #1f2937;
    border-radius: 15px !important;
}

.accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    box-shadow: none;
}

.accordion-body {
    padding: 25px;
    background: white;
}

.service-card {
    background: white;
    border-radius: 20px;
    padding: 40px 30px;
    text-align: center;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
    height: 100%;
    margin-bottom: 30px;
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
}

.icon-wrap {
    margin-bottom: 25px;
}

.icon-bg {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #e0f2fe, #b3e5fc) !important;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.service-card:hover .icon-bg {
    background: linear-gradient(135deg, #3b82f6, #2563eb) !important;
    transform: scale(1.1);
}

.service-card:hover .icon-bg i {
    color: white !important;
}

.login-required-message {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-radius: 20px;
    padding: 50px;
    text-align: center;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
}

#bookingConfirmation {
    background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
    border: 2px solid #10b981;
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    animation: slideInUp 0.5s ease-out;
}

.testimonial {
    padding: 20px 0;
    border-bottom: 1px solid #e5e7eb;
}

.testimonial:last-child {
    border-bottom: none;
    padding-bottom: 0;
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
@media (max-width: 991.98px) {
    .main-section {
        padding: 30px 0;
    }
    
    .custom-hero {
        padding: 100px 0 60px;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .sidebar-card {
        margin-bottom: 20px;
    }
    
    .tab-content {
        padding: 25px;
    }
    
    .form-section {
        padding: 20px;
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
    
    .custom-breadcrumb {
        padding: 10px 20px;
        font-size: 0.85rem;
    }
    
    .sidebar-card {
        padding: 20px;
    }
    
    .tab-content {
        padding: 20px;
    }
    
    .form-section {
        padding: 15px;
    }
    
    .service-card {
        padding: 25px 20px;
    }
    
    .display-4 {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .custom-hero {
        padding: 60px 0 40px;
    }
    
    .hero-title {
        font-size: 1.8rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .custom-breadcrumb {
        padding: 8px 16px;
        font-size: 0.8rem;
    }
    
    .sidebar-card {
        padding: 15px;
    }
    
    .tab-content {
        padding: 15px;
    }
    
    .form-section {
        padding: 15px;
    }
    
    .service-card {
        padding: 20px 15px;
    }
}
</style>

<!-- Hero Section -->
<div class="custom-hero">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <div class="hero-content">
                 
                    <h1 class="hero-title fade-up delay-1" style="margin-top: 50px;">Estimate Your Property</h1>
                    <p class="hero-subtitle fade-up delay-2 " >Get an instant estimate of your property value</p>
                  
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Section -->
<div class="main-section">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-12">
                <div class="property-estimation-tabs fade-in">
                    <ul class="nav nav-tabs nav-fill" id="estimationTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="estimate-tab" data-bs-toggle="tab" data-bs-target="#estimate-tab-pane" type="button" role="tab" aria-controls="estimate-tab-pane" aria-selected="true">
                                <i class="fas fa-calculator me-2"></i> Instant Estimate
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="booking-tab" data-bs-toggle="tab" data-bs-target="#booking-tab-pane" type="button" role="tab" aria-controls="booking-tab-pane" aria-selected="false">
                                <i class="fas fa-calendar-check me-2"></i> Book a Professional Appraiser
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="estimationTabContent">
                        <!-- Estimation Form Tab -->
                        <div class="tab-pane fade show active" id="estimate-tab-pane" role="tabpanel" aria-labelledby="estimate-tab" tabindex="0">
                            <div class="row">
                                <div class="col-lg-7">
                                    <form id="estimationForm">
                                        <div class="form-section">
                                            <h4 class="form-section-title">
                                                <i class="fas fa-home"></i>Property Information
                                            </h4>
                                            
                                            <div class="row g-3">
                                                <div class="col-md-6 mb-3">
                                                    <label for="propertyType" class="form-label">Property Type</label>
                                                    <select class="form-select" id="propertyType" required>
                                                        <option value="">Choose...</option>
                                                        <option value="apartment">Apartment</option>
                                                        <option value="house">House</option>
                                                        <option value="villa">Villa</option>
                                                        <option value="commercial">Commercial</option>
                                                        <option value="land">Land</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <label for="neighborhood" class="form-label">Neighborhood/Area</label>
                                                    <select class="form-select" id="neighborhood" required>
                                                        <option value="">Choose Area...</option>
                                                        
                                                        <!-- Amman - Premium Areas -->
                                                        <optgroup label="Amman - Premium Areas">
                                                            <option value="abdoun">Abdoun (1000-1500 JD/m²)</option>
                                                            <option value="jabal_amman">Jabal Amman (1200-1600 JD/m²)</option>
                                                            <option value="um_uthaina">Um Uthaina (1200-1500 JD/m²)</option>
                                                            <option value="deir_ghbar">Deir Ghbar (900-1300 JD/m²)</option>
                                                        </optgroup>
                                                        
                                                        <!-- Amman - Upscale Areas -->
                                                        <optgroup label="Amman - Upscale Areas">
                                                            <option value="dabouq">Dabouq (800-1200 JD/m²)</option>
                                                            <option value="shmisani">Shmeisani (850-1000 JD/m²)</option>
                                                            <option value="sweifieh">Sweifieh (700-1100 JD/m²)</option>
                                                            <option value="khalda">Khalda (700-1100 JD/m²)</option>
                                                            <option value="tla_ali">Tla'a Al-Ali (650-850 JD/m²)</option>
                                                            <option value="rabieh">Rabieh (800-1200 JD/m²)</option>
                                                            <option value="kursi">Al-Kursi (700-1000 JD/m²)</option>
                                                        </optgroup>
                                                        
                                                        <!-- Amman - Mid-Upper Areas -->
                                                        <optgroup label="Amman - Mid-Upper Areas">
                                                            <option value="dwar_7">7th Circle (800-950 JD/m²)</option>
                                                            <option value="medina_munawara">Medina Munawara Street (850-1000 JD/m²)</option>
                                                            <option value="jubeiha">Jubeiha (650-800 JD/m²)</option>
                                                            <option value="sweileh">Sweileh (600-750 JD/m²)</option>
                                                            <option value="university_street">University Street (750-900 JD/m²)</option>
                                                            <option value="abu_nsair">Abu Nsair (550-700 JD/m²)</option>
                                                            <option value="shafa_badran">Shafa Badran (500-650 JD/m²)</option>
                                                        </optgroup>
                                                        
                                                        <!-- Amman - Middle Class Areas -->
                                                        <optgroup label="Amman - Middle Class Areas">
                                                            <option value="gardens">Gardens (600-800 JD/m²)</option>
                                                            <option value="kharabat_suka">Kharabat Suka (750-900 JD/m²)</option>
                                                            <option value="rajm_amish">Rajm Amish (600-800 JD/m²)</option>
                                                            <option value="naoor">Naoor (450-650 JD/m²)</option>
                                                            <option value="marj_hamam">Marj Al-Hamam (400-600 JD/m²)</option>
                                                            <option value="abu_alanda">Abu Alanda (300-500 JD/m²)</option>
                                                            <option value="dahiat_rashid">Dahiat Al-Rashid (400-600 JD/m²)</option>
                                                        </optgroup>
                                                        
                                                        <!-- Amman - Popular Areas -->
                                                        <optgroup label="Amman - Popular Areas">
                                                            <option value="tabarbour">Tabarbour (400-650 JD/m²)</option>
                                                            <option value="dahiat_muhandiseen">Dahiat Al-Muhandiseen (600-700 JD/m²)</option>
                                                            <option value="jabal_hussein">Jabal Hussein (500-700 JD/m²)</option>
                                                            <option value="jabal_taj">Jabal Al-Taj (450-650 JD/m²)</option>
                                                            <option value="jabal_nuzha">Jabal Al-Nuzha (400-600 JD/m²)</option>
                                                            <option value="downtown">Downtown (350-550 JD/m²)</option>
                                                            <option value="ras_ain">Ras Al-Ain (300-500 JD/m²)</option>
                                                        </optgroup>
                                                        
                                                        <!-- Irbid Governorate -->
                                                        <optgroup label="Irbid Governorate">
                                                            <option value="irbid_center">Irbid Center (350-450 JD/m²)</option>
                                                            <option value="irbid_dwar_dorra">Irbid - Dwar Al-Dorra (380-480 JD/m²)</option>
                                                            <option value="ramtha">Ramtha (250-350 JD/m²)</option>
                                                            <option value="mafraq">Mafraq (200-300 JD/m²)</option>
                                                            <option value="jerash">Jerash (200-350 JD/m²)</option>
                                                            <option value="ajloun">Ajloun (180-280 JD/m²)</option>
                                                        </optgroup>
                                                        
                                                        <!-- Zarqa Governorate -->
                                                        <optgroup label="Zarqa Governorate">
                                                            <option value="zarqa_center">Zarqa Center (300-500 JD/m²)</option>
                                                            <option value="russeifa">Russeifa (250-400 JD/m²)</option>
                                                            <option value="hashimiya">Hashimiya (200-350 JD/m²)</option>
                                                            <option value="dhuleil">Dhuleil (180-300 JD/m²)</option>
                                                        </optgroup>
                                                        
                                                        <!-- Balqa Governorate -->
                                                        <optgroup label="Balqa Governorate">
                                                            <option value="salt">Salt (250-400 JD/m²)</option>
                                                            <option value="fuheis">Fuheis (300-450 JD/m²)</option>
                                                            <option value="mahis">Mahis (200-350 JD/m²)</option>
                                                            <option value="madaba">Madaba (200-350 JD/m²)</option>
                                                        </optgroup>
                                                        
                                                        <!-- Karak Governorate -->
                                                        <optgroup label="Karak Governorate">
                                                            <option value="karak_center">Karak Center (150-250 JD/m²)</option>
                                                            <option value="tafilah">Tafilah (120-200 JD/m²)</option>
                                                            <option value="maan">Ma'an (100-180 JD/m²)</option>
                                                        </optgroup>
                                                        
                                                        <!-- Aqaba Governorate -->
                                                        <optgroup label="Aqaba Governorate">
                                                            <option value="aqaba_center">Aqaba Center (300-500 JD/m²)</option>
                                                            <option value="aqaba_tourist">Aqaba Tourist Area (400-600 JD/m²)</option>
                                                        </optgroup>
                                                        
                                                        <!-- Other Areas -->
                                                        <optgroup label="Other Areas">
                                                            <option value="other_areas">Other Areas (200-400 JD/m²)</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <label for="propertyAge" class="form-label">Property Age (Years)</label>
                                                    <input type="number" class="form-control" id="propertyAge" min="0" max="100" required>
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <label for="area" class="form-label">Total Area (sqm)</label>
                                                    <input type="number" class="form-control" id="area" min="1" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-section">
                                            <h4 class="form-section-title">
                                                <i class="fas fa-cog"></i>Property Details
                                            </h4>
                                            
                                            <div class="row g-3">
                                                <div class="col-md-4 mb-3">
                                                    <label for="bedrooms" class="form-label">Bedrooms</label>
                                                    <input type="number" class="form-control" id="bedrooms" min="0">
                                                </div>
                                                
                                                <div class="col-md-4 mb-3">
                                                    <label for="bathrooms" class="form-label">Bathrooms</label>
                                                    <input type="number" class="form-control" id="bathrooms" min="0">
                                                </div>
                                                
                                                <div class="col-md-4 mb-3">
                                                    <label for="floors" class="form-label">Number of Floors</label>
                                                    <input type="number" class="form-control" id="floors" min="1" value="1">
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="form-label">Additional Features</label>
                                                <div class="row g-2">
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="hasGarage">
                                                            <label class="form-check-label" for="hasGarage">Garage/Parking</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="hasGarden">
                                                            <label class="form-check-label" for="hasGarden">Garden</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="hasSwimmingPool">
                                                            <label class="form-check-label" for="hasSwimmingPool">Swimming Pool</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="hasBalcony">
                                                            <label class="form-check-label" for="hasBalcony">Balcony</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="hasElevator">
                                                            <label class="form-check-label" for="hasElevator">Elevator</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="isFurnished">
                                                            <label class="form-check-label" for="isFurnished">Furnished</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-section">
                                            <h4 class="form-section-title">
                                                <i class="fas fa-file-contract"></i>Land & Legal Information
                                            </h4>
                                            
                                            <div class="row g-3">
                                                <div class="col-md-6 mb-3">
                                                    <label for="landClassification" class="form-label">Land Classification</label>
                                                    <select class="form-select" id="landClassification">
                                                        <option value="">Choose...</option>
                                                        <option value="residential">Residential</option>
                                                        <option value="commercial">Commercial</option>
                                                        <option value="industrial">Industrial</option>
                                                        <option value="agricultural">Agricultural</option>
                                                        <option value="mixed">Mixed Use</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <label for="registrationType" class="form-label">Registration Type</label>
                                                    <select class="form-select" id="registrationType">
                                                        <option value="">Choose...</option>
                                                        <option value="tabu">Tabu (Title Deed)</option>
                                                        <option value="mushtarak">Mushtarak (Shared)</option>
                                                        <option value="ifrazi">Ifrazi (Segregated)</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="text-center mt-4">
                                            <button type="button" id="calculateEstimateBtn" class="btn btn-primary btn-lg px-5 py-3">
                                                <i class="fas fa-calculator me-2"></i> Calculate Estimate
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="col-lg-5">
                                    <div id="estimationResult" class="d-none">
                                        <h3 class="text-center mb-4">Estimated Property Value</h3>
                                        
                                        <div class="text-center mb-4">
                                            <span class="display-4 text-primary fw-bold" id="estimatedValue">JOD 0</span>
                                            <p class="text-muted">Estimated Market Value</p>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between mb-3">
                                            <span>Value Range:</span>
                                            <span class="fw-bold" id="valueRange">JOD 0 - JOD 0</span>
                                        </div>
                                        
                                        <div class="d-flex justify-content-between mb-3">
                                            <span>Price per sqm:</span>
                                            <span class="fw-bold" id="pricePerSqm">JOD 0</span>
                                        </div>
                                        
                                        <hr>
                                        
                                        <div class="alert alert-info mb-4">
                                            <div class="d-flex">
                                                <div class="me-3">
                                                    <i class="fas fa-info-circle fa-2x text-primary"></i>
                                                </div>
                                                <div>
                                                    <h5 class="alert-heading">This is a preliminary estimate</h5>
                                                    <p class="mb-0">For a comprehensive and accurate valuation, we recommend booking a professional property appraiser.</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="text-center">
                                            <button type="button" class="btn btn-outline-primary btn-lg book-appraiser-btn" data-bs-toggle="tab" data-bs-target="#booking-tab-pane">
                                                <i class="fas fa-user-tie me-2"></i> Book a Professional Appraiser
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="sidebar-card">
                                        <h4 class="mb-3 text-primary">Why Get a Professional Valuation?</h4>
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex mb-3">
                                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                                <div>
                                                    <strong>Accuracy:</strong> Get a precise valuation based on a thorough inspection.
                                                </div>
                                            </li>
                                            <li class="d-flex mb-3">
                                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                                <div>
                                                    <strong>Expertise:</strong> Our appraisers have extensive knowledge of the local market.
                                                </div>
                                            </li>
                                            <li class="d-flex mb-3">
                                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                                <div>
                                                    <strong>Documentation:</strong> Receive an official valuation report for legal purposes.
                                                </div>
                                            </li>
                                            <li class="d-flex mb-3">
                                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                                <div>
                                                    <strong>Negotiation:</strong> Strong position when selling or refinancing.
                                                </div>
                                            </li>
                                            <li class="d-flex">
                                                <i class="fas fa-check-circle text-success me-3 mt-1"></i>
                                                <div>
                                                    <strong>Investment:</strong> Make informed decisions based on accurate data.
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Booking Tab -->
                        <div class="tab-pane fade" id="booking-tab-pane" role="tabpanel" aria-labelledby="booking-tab" tabindex="0">
                            <div class="row">
                                <div class="col-lg-7">
                                    @if(Auth::check())
                                    <!-- User is logged in, show booking form -->
                                    <form id="bookingForm">
                                        @csrf
                                        <div class="form-section">
                                            <h4 class="form-section-title">
                                                <i class="fas fa-user-tie"></i>Select an Appraiser
                                            </h4>
                                            
                                            <div class="appraiser-selection mb-4">
                                                <div class="row g-3">
                                                    @forelse($appraisers as $appraiser)
                                                    <div class="col-md-6 mb-3">
                                                        <div class="appraiser-card h-100">
                                                            <input type="radio" name="appraiser_id" id="appraiser{{ $appraiser->id }}"
                                                                   value="{{ $appraiser->id }}" class="d-none appraiser-radio">
                                                            <label for="appraiser{{ $appraiser->id }}" class="d-flex flex-column h-100 cursor-pointer">
                                                                <div class="d-flex align-items-center mb-3">
                                                                    <img src="{{ $appraiser->user->profile_image ? asset('storage/' . $appraiser->user->profile_image) : asset('images/default-avatar.jpg') }}"
                                                                         alt="{{ $appraiser->user->name }}" 
                                                                         class="rounded-circle me-3" 
                                                                         width="60" 
                                                                         height="60"
                                                                         style="object-fit: cover;"
                                                                       >
                                                                    <div>
                                                                        <h5 class="card-title mb-0">{{ $appraiser->user->name }}</h5>
                                                                        <div class="text-warning mb-1">
                                                                            @for($i = 1; $i <= 5; $i++)
                                                                                @if($i <= floor($appraiser->rating ?? 0))
                                                                                    <i class="fas fa-star"></i>
                                                                                @elseif($i - 0.5 <= ($appraiser->rating ?? 0))
                                                                                    <i class="fas fa-star-half-alt"></i>
                                                                                @else
                                                                                    <i class="far fa-star"></i>
                                                                                @endif
                                                                            @endfor
                                                                            <span class="text-muted ms-1">({{ number_format($appraiser->rating ?? 0, 1) }})</span>
                                                                        </div>
                                                                        <span class="badge bg-primary">General Appraiser</span>
                                                                    </div>
                                                                </div>
                                                                <p class="card-text bio flex-grow-1">Professional property appraiser with years of experience.</p>
                                                                <div class="text-muted small mb-2">
                                                                    <i class="fas fa-certificate text-success me-1"></i>
                                                                    Certified Property Appraiser
                                                                </div>
                                                                <div class="text-muted small mb-2">
                                                                    <i class="fas fa-clock text-primary me-1"></i>
                                                                    {{ $appraiser->experience_years ?? 0 }} years experience
                                                                </div>
                                                                <div class="text-muted small">
                                                                    <i class="fas fa-envelope text-info me-1"></i>
                                                                    {{ $appraiser->user->email }}
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @empty
                                                    <div class="col-12 text-center py-4">
                                                        <div class="alert alert-info">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            No appraisers currently available. Please contact us for more information.
                                                        </div>
                                                    </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-section">
                                            <h4 class="form-section-title">
                                                <i class="fas fa-calendar-alt"></i>Schedule Appointment
                                            </h4>
                                            
                                            <div class="row g-3">
                                                <div class="col-md-6 mb-3">
                                                    <label for="appointment_date" class="form-label">Preferred Date</label>
                                                    <input type="date" class="form-control" id="appointment_date" name="appointment_date" min="{{ date('Y-m-d') }}" required>
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <label for="appointment_time" class="form-label">Preferred Time</label>
                                                    <select class="form-select" id="appointment_time" name="appointment_time" required>
                                                        <option value="">Choose...</option>
                                                        <optgroup label="Morning">
                                                            <option value="09:00">9:00 AM</option>
                                                            <option value="10:00">10:00 AM</option>
                                                            <option value="11:00">11:00 AM</option>
                                                            <option value="12:00">12:00 PM</option>
                                                        </optgroup>
                                                        <optgroup label="Afternoon">
                                                            <option value="13:00">1:00 PM</option>
                                                            <option value="14:00">2:00 PM</option>
                                                            <option value="15:00">3:00 PM</option>
                                                            <option value="16:00">4:00 PM</option>
                                                        </optgroup>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-12 mb-3">
                                                    <label for="property_address" class="form-label">Property Address</label>
                                                    <textarea class="form-control" id="property_address" name="property_address" rows="3" required></textarea>
                                                </div>
                                                
                                                <div class="col-md-12 mb-3">
                                                    <label for="property_type" class="form-label">Property Type</label>
                                                    <select class="form-select" id="property_type" name="property_type">
                                                        <option value="">-- Select Property Type --</option>
                                                        <option value="apartment">Apartment</option>
                                                        <option value="house">House</option>
                                                        <option value="villa">Villa</option>
                                                        <option value="commercial">Commercial</option>
                                                        <option value="land">Land</option>
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <label for="client_name" class="form-label">Your Name</label>
                                                    <input type="text" class="form-control" id="client_name" name="client_name" value="{{ Auth::user()->name }}" required>
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <label for="client_phone" class="form-label">Phone Number</label>
                                                    <input type="tel" class="form-control" id="client_phone" name="client_phone" value="{{ Auth::user()->phone ?? '' }}" required>
                                                </div>
                                                
                                                <div class="col-md-12 mb-3">
                                                    <label for="client_email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" id="client_email" name="client_email" value="{{ Auth::user()->email }}" required>
                                                </div>
                                                
                                                <!-- Hidden fields for property details from the instant estimate -->
                                                <input type="hidden" id="property_area" name="property_area" value="">
                                                <input type="hidden" id="bedrooms_count" name="bedrooms" value="">
                                                <input type="hidden" id="bathrooms_count" name="bathrooms" value="">
                                                
                                                <div class="col-md-12 mb-3">
                                                    <label for="additional_notes" class="form-label">Additional Notes (Optional)</label>
                                                    <textarea class="form-control" id="additional_notes" name="additional_notes" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="text-center mt-4">
                                            <button type="button" id="bookAppointmentBtn" class="btn btn-primary btn-lg px-5 py-3">
                                                <i class="fas fa-calendar-check me-2"></i> Book Appointment
                                            </button>
                                        </div>
                                    </form>
                                    @else
                                    <!-- User is not logged in, show login prompt -->
                                    <div class="login-required-message">
                                        <div class="mb-4">
                                            <i class="fas fa-user-lock fa-4x text-primary mb-3"></i>
                                            <h4>Authentication Required</h4>
                                            <p class="text-muted">You need to be logged in to book an appointment with our professional appraisers.</p>
                                        </div>
                                        <div class="d-flex justify-content-center gap-3">
                                            <a href="{{ route('login') }}?redirect=property.estimation" class="btn btn-primary px-4 py-2">
                                                <i class="fas fa-sign-in-alt me-2"></i> Login
                                            </a>
                                            <a href="{{ route('register') }}?redirect=property.estimation" class="btn btn-outline-primary px-4 py-2">
                                                <i class="fas fa-user-plus me-2"></i> Register
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                                <div class="col-lg-5">
                                    <div id="bookingConfirmation" class="d-none">
                                        <div class="text-center mb-4">
                                            <div class="mb-3">
                                                <i class="fas fa-check-circle text-success fa-3x"></i>
                                            </div>
                                            <h3>Appointment Requested</h3>
                                            <p class="text-muted">Your appointment request has been submitted successfully!</p>
                                        </div>
                                        
                                        <div class="booking-details">
                                            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                                <span>Appraiser:</span>
                                                <span class="fw-bold" id="confirmedAppraiser">Not selected</span>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                                <span>Date & Time:</span>
                                                <span class="fw-bold" id="confirmedDateTime">Not selected</span>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                                <span>Property Address:</span>
                                                <span class="fw-bold" id="confirmedAddress">Not provided</span>
                                            </div>
                                        </div>
                                        
                                        <div class="alert alert-info mb-4">
                                            <div class="d-flex">
                                                <div class="me-3">
                                                    <i class="fas fa-info-circle fa-2x text-primary"></i>
                                                </div>
                                                <div>
                                                    <h5 class="alert-heading">What happens next?</h5>
                                                    <p class="mb-0">Our team will review your request and contact you within 24 hours to confirm your appointment. You'll also receive a confirmation email with all the details.</p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="text-center mt-3">
                                            <a href="{{ url('/my-appraisals') }}" class="btn btn-primary">
                                                <i class="fas fa-calendar me-2"></i> View My Appointments
                                            </a>
                                        </div>
                                    </div>
                                    
                                    <div class="sidebar-card">
                                        <h4 class="mb-3 text-primary">Our Valuation Services</h4>
                                        <ul class="list-unstyled mb-0">
                                            <li class="d-flex mb-3">
                                                <span class="badge bg-primary me-3 mt-1 p-2">1</span>
                                                <div>
                                                    <strong>Residential Valuation</strong>
                                                    <p class="mb-0 text-muted">Comprehensive assessment of houses, apartments, and villas.</p>
                                                </div>
                                            </li>
                                            <li class="d-flex mb-3">
                                                <span class="badge bg-primary me-3 mt-1 p-2">2</span>
                                                <div>
                                                    <strong>Commercial Property Assessment</strong>
                                                    <p class="mb-0 text-muted">Detailed valuation of office spaces, retail properties, and business premises.</p>
                                                </div>
                                            </li>
                                            <li class="d-flex mb-3">
                                                <span class="badge bg-primary me-3 mt-1 p-2">3</span>
                                                <div>
                                                    <strong>Land Valuation</strong>
                                                    <p class="mb-0 text-muted">Expert assessment of land value and development potential.</p>
                                                </div>
                                            </li>
                                            <li class="d-flex mb-3">
                                                <span class="badge bg-primary me-3 mt-1 p-2">4</span>
                                                <div>
                                                    <strong>Investment Property Analysis</strong>
                                                    <p class="mb-0 text-muted">Evaluation of income-generating properties with ROI calculations.</p>
                                                </div>
                                            </li>
                                            <li class="d-flex">
                                                <span class="badge bg-primary me-3 mt-1 p-2">5</span>
                                                <div>
                                                    <strong>Legal & Banking Valuation</strong>
                                                    <p class="mb-0 text-muted">Certified reports accepted by courts and financial institutions.</p>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    
                                    <div class="sidebar-card">
                                        <h4 class="mb-3 text-primary">Client Testimonials</h4>
                                        <div class="testimonial mb-3 pb-3 border-bottom">
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="text-warning me-2">
                                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                                </div>
                                                <span class="fw-bold">Ahmad N.</span>
                                            </div>
                                            <p class="mb-0 fst-italic">"The valuation service was excellent. The appraiser was thorough and professional, providing valuable insights about my property's market value."</p>
                                        </div>
                                        <div class="testimonial">
                                            <div class="d-flex align-items-center mb-2">
                                            <div class="text-warning me-2">
                                                <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                                              </div>
                                              <span class="fw-bold">Laila M.</span>
                                            </div>
                                            <p class="mb-0 fst-italic">"I needed a valuation report for a bank loan, and the service exceeded my expectations. The report was detailed and delivered promptly, which helped me secure the financing."</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- FAQ Section -->
        <div class="row fade-in" style="margin-top: 50px;">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="font-weight-bold text-primary">Frequently Asked Questions</h2>
                </div>
                
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                How accurate is the online property estimation?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>The online estimation provides a preliminary value based on the information you provide and our proprietary valuation algorithm that uses historical data from similar properties in Jordan. While it's a good starting point, the accuracy can vary depending on unique features of your property and current market conditions.</p>
                                <p class="mb-0">For a comprehensive and legally valid valuation, we recommend booking a professional appraiser who will conduct an in-person assessment and provide a detailed report.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                What information do I need to prepare for the professional appraisal?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>To expedite the professional appraisal process, it's helpful to have these documents ready:</p>
                                <ul>
                                    <li>Property title deed (Sanad Tasjeel)</li>
                                    <li>Recent property tax assessment</li>
                                    <li>Floor plans or architectural drawings (if available)</li>
                                    <li>Details of any recent renovations or improvements</li>
                                    <li>Recent utility bills</li>
                                    <li>Building permits for any additions or modifications</li>
                                    <li>Rental agreements (if the property is currently leased)</li>
                                </ul>
                                <p class="mb-0">Don't worry if you don't have all these documents. Our appraisers can still conduct a thorough valuation with basic property information.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                How long does the professional property valuation take?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>The on-site inspection typically takes 1-2 hours, depending on the size and complexity of the property. After the inspection, our appraisers will conduct market research and prepare a comprehensive report.</p>
                                <p class="mb-0">You can expect to receive the final valuation report within 3-5 business days after the inspection. For urgent requests, we also offer expedited services at an additional fee.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Is the property valuation report accepted by banks and legal authorities?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>Yes, our professional valuation reports are prepared in accordance with International Valuation Standards (IVS) and are accepted by:</p>
                                <ul>
                                    <li>All major banks and financial institutions in Jordan</li>
                                    <li>Courts and legal authorities</li>
                                    <li>The Department of Lands and Survey</li>
                                    <li>Insurance companies</li>
                                    <li>Tax authorities</li>
                                </ul>
                                <p class="mb-0">Our appraisers are certified by the relevant professional bodies, ensuring that the reports meet all regulatory requirements.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFive">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                What factors affect my property's value in Jordan?
                            </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                <p>Multiple factors influence property values in the Jordanian market:</p>
                                <ul>
                                    <li><strong>Location:</strong> Neighborhood desirability, proximity to amenities, schools, and access to transportation</li>
                                    <li><strong>Property Size and Layout:</strong> Total area, number of rooms, and efficient use of space</li>
                                    <li><strong>Age and Condition:</strong> Year built, maintenance status, and quality of construction</li>
                                    <li><strong>Land Classification:</strong> Zoning regulations and permitted usage</li>
                                    <li><strong>Infrastructure:</strong> Access to utilities, water supply, and internet connectivity</li>
                                    <li><strong>Market Trends:</strong> Current supply and demand in the specific area</li>
                                    <li><strong>Economic Factors:</strong> Interest rates, inflation, and overall economic stability</li>
                                </ul>
                                <p class="mb-0">Our professional appraisers consider all these factors and more to provide an accurate valuation of your property.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Why Choose Our Services Section -->
        <div class="row fade-in" style="margin-top: 50px;">
            <div class="col-12">
                <div class="text-center mb-5">
                    <h2 class="font-weight-bold text-primary">Why Choose Our Valuation Services</h2>
                </div>
                
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div class="service-card">
                            <div class="icon-wrap">
                                <span class="icon-bg">
                                    <i class="fas fa-certificate fa-2x text-primary"></i>
                                </span>
                            </div>
                            <h3 class="mb-3">Certified Experts</h3>
                            <p>Our team consists of professionally certified appraisers with extensive experience in the Jordanian property market.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 mb-4">
                        <div class="service-card">
                            <div class="icon-wrap">
                                <span class="icon-bg">
                                    <i class="fas fa-chart-line fa-2x text-primary"></i>
                                </span>
                            </div>
                            <h3 class="mb-3">Market Insights</h3>
                            <p>Gain valuable insights into current market trends and factors affecting your property's value in today's dynamic market.</p>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 mb-4">
                        <div class="service-card">
                            <div class="icon-wrap">
                                <span class="icon-bg">
                                    <i class="fas fa-file-alt fa-2x text-primary"></i>
                                </span>
                            </div>
                            <h3 class="mb-3">Comprehensive Reports</h3>
                            <p>Receive detailed valuation reports that are recognized by banks, courts, and government agencies throughout Jordan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

    // Comprehensive area prices (JD per square meter)
    const areaPrices = {
        // Amman - Premium Areas
        'abdoun': { min: 1000, max: 1500, avg: 1250 },
        'jabal_amman': { min: 1200, max: 1600, avg: 1400 },
        'um_uthaina': { min: 1200, max: 1500, avg: 1350 },
        'deir_ghbar': { min: 900, max: 1300, avg: 1100 },
        
        // Amman - Upscale Areas
        'dabouq': { min: 800, max: 1200, avg: 1000 },
        'shmisani': { min: 850, max: 1000, avg: 925 },
        'sweifieh': { min: 700, max: 1100, avg: 900 },
        'khalda': { min: 700, max: 1100, avg: 900 },
        'tla_ali': { min: 650, max: 850, avg: 750 },
        'rabieh': { min: 800, max: 1200, avg: 1000 },
        'kursi': { min: 700, max: 1000, avg: 850 },
        
        // Amman - Mid-Upper Areas
        'dwar_7': { min: 800, max: 950, avg: 875 },
        'medina_munawara': { min: 850, max: 1000, avg: 925 },
        'jubeiha': { min: 650, max: 800, avg: 725 },
        'sweileh': { min: 600, max: 750, avg: 675 },
        'university_street': { min: 750, max: 900, avg: 825 },
        'abu_nsair': { min: 550, max: 700, avg: 625 },
        'shafa_badran': { min: 500, max: 650, avg: 575 },
        
        // Amman - Middle Class Areas
        'gardens': { min: 600, max: 800, avg: 700 },
        'kharabat_suka': { min: 750, max: 900, avg: 825 },
        'rajm_amish': { min: 600, max: 800, avg: 700 },
        'naoor': { min: 450, max: 650, avg: 550 },
        'marj_hamam': { min: 400, max: 600, avg: 500 },
        'abu_alanda': { min: 300, max: 500, avg: 400 },
        'dahiat_rashid': { min: 400, max: 600, avg: 500 },
        
        // Amman - Popular Areas
        'tabarbour': { min: 400, max: 650, avg: 525 },
        'dahiat_muhandiseen': { min: 600, max: 700, avg: 650 },
        'jabal_hussein': { min: 500, max: 700, avg: 600 },
        'jabal_taj': { min: 450, max: 650, avg: 550 },
        'jabal_nuzha': { min: 400, max: 600, avg: 500 },
        'downtown': { min: 350, max: 550, avg: 450 },
        'ras_ain': { min: 300, max: 500, avg: 400 },
        
        // Irbid Governorate
        'irbid_center': { min: 350, max: 450, avg: 400 },
        'irbid_dwar_dorra': { min: 380, max: 480, avg: 430 },
        'ramtha': { min: 250, max: 350, avg: 300 },
        'mafraq': { min: 200, max: 300, avg: 250 },
        'jerash': { min: 200, max: 350, avg: 275 },
        'ajloun': { min: 180, max: 280, avg: 230 },
        
        // Zarqa Governorate
        'zarqa_center': { min: 300, max: 500, avg: 400 },
        'russeifa': { min: 250, max: 400, avg: 325 },
        'hashimiya': { min: 200, max: 350, avg: 275 },
        'dhuleil': { min: 180, max: 300, avg: 240 },
        
        // Balqa Governorate
        'salt': { min: 250, max: 400, avg: 325 },
        'fuheis': { min: 300, max: 450, avg: 375 },
        'mahis': { min: 200, max: 350, avg: 275 },
        'madaba': { min: 200, max: 350, avg: 275 },
        
        // Karak Governorate
        'karak_center': { min: 150, max: 250, avg: 200 },
        'tafilah': { min: 120, max: 200, avg: 160 },
        'maan': { min: 100, max: 180, avg: 140 },
        
        // Aqaba Governorate
        'aqaba_center': { min: 300, max: 500, avg: 400 },
        'aqaba_tourist': { min: 400, max: 600, avg: 500 },
        
        // Legacy areas (for backward compatibility)
        'abdali': { min: 1000, max: 1400, avg: 1200 },
        
        // Other Areas
        'other_areas': { min: 200, max: 400, avg: 300 }
    };

    // Property type multipliers
    const propertyTypeMultipliers = {
        'apartment': 1.0,      // Base reference
        'house': 0.9,          // Houses slightly cheaper
        'villa': 1.3,          // Villas more expensive
        'commercial': 1.1,     // Commercial slightly higher
        'land': 0.7           // Land cheaper (no building)
    };

    // Age multipliers
    const ageMultipliers = {
        new: 1.0,        // 0-3 years
        recent: 0.95,    // 4-7 years  
        medium: 0.85,    // 8-15 years
        old: 0.7,        // 16-25 years
        very_old: 0.55   // 25+ years
    };

    // Feature prices (JD)
    const featurePrices = {
        hasGarage: 3000,
        hasGarden: 5000,
        hasSwimmingPool: 12000,
        hasBalcony: 2000,
        hasElevator: 1500,
        isFurnished: 8000
    };

    // Land classification multipliers (for land only)
    const landClassificationMultipliers = {
        'residential': 1.0,
        'commercial': 1.5,
        'industrial': 1.2,
        'agricultural': 0.6,
        'mixed': 1.3
    };

    // Registration type multipliers (for land only)
    const registrationTypeMultipliers = {
        'tabu': 1.0,        // Full ownership
        'mushtarak': 0.85,  // Shared ownership
        'ifrazi': 0.9,      // Segregated
        'other': 0.8        // Other types
    };
    
    // DOM Elements
    const calculateEstimateBtn = document.getElementById('calculateEstimateBtn');
    const estimationResult = document.getElementById('estimationResult');
    const estimatedValue = document.getElementById('estimatedValue');
    const valueRange = document.getElementById('valueRange');
    const pricePerSqm = document.getElementById('pricePerSqm');
    
    // Booking functionality
    const bookAppointmentBtn = document.getElementById('bookAppointmentBtn');
    const bookingConfirmation = document.getElementById('bookingConfirmation');
    const confirmedAppraiser = document.getElementById('confirmedAppraiser');
    const confirmedDateTime = document.getElementById('confirmedDateTime');
    const confirmedAddress = document.getElementById('confirmedAddress');
    
    // Appraiser selection styling
    const appraiserCards = document.querySelectorAll('.appraiser-card');
    appraiserCards.forEach(card => {
      const radio = card.querySelector('.appraiser-radio');
      card.addEventListener('click', function() {
        // Remove active class from all cards
        appraiserCards.forEach(c => c.classList.remove('border-primary'));
        // Add active class to clicked card
        card.classList.add('border-primary');
        // Check the radio
        radio.checked = true;
      });
    });
    
    // Book appraiser link in estimation tab
    const bookAppraiserBtns = document.querySelectorAll('.book-appraiser-btn');
    bookAppraiserBtns.forEach(btn => {
      btn.addEventListener('click', function() {
        document.getElementById('booking-tab').click();
        
        // Transfer values from estimation to booking form
        const propertyType = document.getElementById('propertyType').value;
        const area = document.getElementById('area').value;
        const bedrooms = document.getElementById('bedrooms').value;
        const bathrooms = document.getElementById('bathrooms').value;
        
        // Set hidden fields
        if (document.getElementById('property_type')) {
            document.getElementById('property_type').value = propertyType;
        }
        if (document.getElementById('property_area')) {
            document.getElementById('property_area').value = area;
        }
        if (document.getElementById('bedrooms_count')) {
            document.getElementById('bedrooms_count').value = bedrooms;
        }
        if (document.getElementById('bathrooms_count')) {
            document.getElementById('bathrooms_count').value = bathrooms;
        }
      });
    });
    
    // Property value calculation function
    function calculatePropertyValue() {
        // Get form data
        const area = parseFloat(document.getElementById('area').value) || 0;
        const propertyType = document.getElementById('propertyType').value;
        const neighborhood = document.getElementById('neighborhood').value;
        const propertyAge = parseInt(document.getElementById('propertyAge').value) || 0;
        const bedrooms = parseInt(document.getElementById('bedrooms').value) || 0;
        const bathrooms = parseInt(document.getElementById('bathrooms').value) || 0;
        const landClassification = document.getElementById('landClassification')?.value || '';
        const registrationType = document.getElementById('registrationType')?.value || '';
        
        // Validate required fields
        if (!area || !propertyType || !neighborhood) {
            alert('Please fill in all required fields (Area, Property Type, Location)');
            return;
        }
        
        // Get base price for the area
        const areaData = areaPrices[neighborhood] || areaPrices['other_areas'];
        let basePrice = areaData.avg;
        
        // Adjust for property type
        const typeMultiplier = propertyTypeMultipliers[propertyType] || 1.0;
        basePrice *= typeMultiplier;
        
        // Adjust for age
        let ageCategory;
        if (propertyAge <= 3) ageCategory = 'new';
        else if (propertyAge <= 7) ageCategory = 'recent';
        else if (propertyAge <= 15) ageCategory = 'medium';
        else if (propertyAge <= 25) ageCategory = 'old';
        else ageCategory = 'very_old';
        
        basePrice *= ageMultipliers[ageCategory];
        
        // Special adjustments for land
        if (propertyType === 'land') {
            if (landClassification && landClassificationMultipliers[landClassification]) {
                basePrice *= landClassificationMultipliers[landClassification];
            }
            
            if (registrationType && registrationTypeMultipliers[registrationType]) {
                basePrice *= registrationTypeMultipliers[registrationType];
            }
        }
        
        // Calculate total value
        let totalValue = basePrice * area;
        
        // Add feature values (for non-land properties)
        if (propertyType !== 'land') {
            const features = ['hasGarage', 'hasGarden', 'hasSwimmingPool', 'hasBalcony', 'hasElevator', 'isFurnished'];
            features.forEach(feature => {
                if (document.getElementById(feature) && document.getElementById(feature).checked) {
                    totalValue += featurePrices[feature];
                }
            });
            
            // Room count adjustments
            if (propertyType === 'apartment') {
                if (bedrooms >= 4) totalValue *= 1.1;
                if (bathrooms >= 3) totalValue *= 1.05;
            } else if (propertyType === 'villa') {
                if (bedrooms >= 5) totalValue *= 1.15;
                if (bathrooms >= 4) totalValue *= 1.1;
            }
        }
        
        // Calculate range (larger margin for remote areas)
        const remoteAreas = ['maan', 'tafilah', 'karak_center', 'ajloun', 'mafraq'];
        const isRemoteArea = remoteAreas.includes(neighborhood);
        const errorMargin = isRemoteArea ? 0.25 : 0.15;
        
        const minValue = totalValue * (1 - errorMargin);
        const maxValue = totalValue * (1 + errorMargin);
        
        // Display results
        displayResults(totalValue, minValue, maxValue, basePrice, neighborhood);
    }

    function displayResults(estimatedValue, minValue, maxValue, pricePerSqm, neighborhood) {
        // Format numbers
        const formatPrice = (price) => {
            return 'JOD ' + Math.round(price).toLocaleString();
        };
        
        // Update display values
        document.getElementById('estimatedValue').textContent = formatPrice(estimatedValue);
        document.getElementById('valueRange').textContent = 
            `${formatPrice(minValue)} - ${formatPrice(maxValue)}`;
        document.getElementById('pricePerSqm').textContent = formatPrice(pricePerSqm);
        
        // Add warning for remote areas
        let warningText = 'This is a preliminary price estimate.';
        const remoteAreas = ['maan', 'tafilah', 'karak_center', 'ajloun', 'mafraq'];
        if (remoteAreas.includes(neighborhood)) {
            warningText += ' Due to the property location, actual prices may vary more significantly.';
        }
        
        // Show results
        document.getElementById('estimationResult').classList.remove('d-none');
        
        // Update warning text if element exists
        const alertElement = document.querySelector('#estimationResult .alert-info p:last-child');
        if (alertElement) {
            alertElement.textContent = warningText + ' For an accurate assessment, we recommend booking a professional property appraiser.';
        }
        
        // Scroll to results
        document.getElementById('estimationResult').scrollIntoView({ 
            behavior: 'smooth' 
        });
    }
    
    // Calculate estimate event listener
    if (calculateEstimateBtn) {
        calculateEstimateBtn.addEventListener('click', calculatePropertyValue);
    }
    
    // Book appointment functionality
    if (bookAppointmentBtn) {
      bookAppointmentBtn.addEventListener('click', function() {
        // Get form values
        const appraiserRadios = document.querySelectorAll('input[name="appraiser_id"]');
        let selectedAppraiser = null;
        let appraiserName = '';
        
        for (const radio of appraiserRadios) {
          if (radio.checked) {
            selectedAppraiser = radio.value;
            appraiserName = radio.closest('.appraiser-card').querySelector('.card-title').textContent;
            break;
          }
        }
        
        const appointmentDate = document.getElementById('appointment_date').value;
        const appointmentTime = document.getElementById('appointment_time').value;
        const propertyAddress = document.getElementById('property_address').value;
        const clientName = document.getElementById('client_name').value;
        const clientPhone = document.getElementById('client_phone').value;
        const clientEmail = document.getElementById('client_email').value;
        
        // Simple validation
        if (!selectedAppraiser || !appointmentDate || !appointmentTime || !propertyAddress 
            || !clientName || !clientPhone || !clientEmail) {
          alert('Please fill in all required fields.');
          return;
        }
        
        // Show loading state
        bookAppointmentBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Checking availability...';
        bookAppointmentBtn.disabled = true;
        
        // First check if the appointment slot is available
        fetch('/property-appraisal/check-availability', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
          },
          body: JSON.stringify({
            appraiser_id: selectedAppraiser,
            appointment_date: appointmentDate,
            appointment_time: appointmentTime
          })
        })
        .then(response => {
          console.log('Availability check response status:', response.status);
          return response.json();
        })
        .then(data => {
          console.log('Availability check result:', data);
          if (data.available) {
            // Slot is available, proceed with booking
            submitBookingForm(selectedAppraiser, appointmentDate, appointmentTime, 
                              propertyAddress, clientName, clientPhone, clientEmail,
                              appraiserName);
          } else {
            // Slot is not available
            bookAppointmentBtn.innerHTML = '<i class="fas fa-calendar-check me-2"></i> Book Appointment';
            bookAppointmentBtn.disabled = false;
            
            // Show conflict popup
            Swal.fire({
              icon: 'warning',
              title: 'Time Slot Not Available',
              text: 'The selected time slot is already booked. Please choose another time or date.',
              confirmButtonText: 'Choose Another Time',
              confirmButtonColor: '#3b82f6'
            });
          }
        })
        .catch(error => {
          console.error('Error checking availability:', error);
          bookAppointmentBtn.innerHTML = '<i class="fas fa-calendar-check me-2"></i> Book Appointment';
          bookAppointmentBtn.disabled = false;
          alert('There was an error checking appointment availability. Please try again.');
        });
      });
    }

    // Function to submit the booking form after availability check
    function submitBookingForm(appraiser_id, appointment_date, appointment_time, 
                              property_address, client_name, client_phone, client_email,
                              appraiserName) {
      
      // Get other form fields
      const propertyType = document.getElementById('property_type')?.value || '';
      const propertyArea = document.getElementById('property_area')?.value || '';
      const bedrooms = document.getElementById('bedrooms_count')?.value || '';
      const bathrooms = document.getElementById('bathrooms_count')?.value || '';
      const additionalNotes = document.getElementById('additional_notes')?.value || '';
      
      // Get CSRF token
      const token = document.querySelector('input[name="_token"]')?.value;
      console.log('CSRF Token available:', !!token);
      
      // Prepare form data
      const formData = {
        _token: token,
        appraiser_id: appraiser_id,
        appointment_date: appointment_date,
        appointment_time: appointment_time,
        property_address: property_address,
        client_name: client_name,
        client_phone: client_phone,
        client_email: client_email,
        property_type: propertyType,
        property_area: propertyArea,
        bedrooms: bedrooms,
        bathrooms: bathrooms,
        additional_notes: additionalNotes
      };
      
      // Debug: Log the data being sent
      console.log('Booking form data to submit:', formData);
      
      // Update button to indicate booking in progress
      bookAppointmentBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Booking your appointment...';
      
      // Send AJAX request to book appointment
      fetch('/property-appraisal/book', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
      })
      .then(response => {
        console.log('Booking response status:', response.status);
        if (!response.ok) {
          console.error('Response not OK:', response.statusText);
        }
        return response.json();
      })
      .then(data => {
        console.log('Booking response data:', data);
        if (data.success) {
          // Format date and time
          const formattedDate = new Date(appointment_date);
          const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
          const formattedDateTime = `${formattedDate.toLocaleDateString('en-US', options)} at ${formatTime(appointment_time)}`;
          
          // Update confirmation
          if (confirmedAppraiser) confirmedAppraiser.textContent = appraiserName;
          if (confirmedDateTime) confirmedDateTime.textContent = formattedDateTime;
          if (confirmedAddress) confirmedAddress.textContent = property_address;
          
          // Show confirmation
          if (bookingConfirmation) {
              bookingConfirmation.classList.remove('d-none');
              bookingConfirmation.scrollIntoView({ behavior: 'smooth' });
          }
          
          // Reset form
          const bookingForm = document.getElementById('bookingForm');
          if (bookingForm) bookingForm.reset();
        } else {
          // Show error message
          console.error('Booking error:', data);
          Swal.fire({
            icon: 'error',
            title: 'Booking Error',
            text: data.message || 'There was an error booking your appointment. Please try again.',
            confirmButtonColor: '#3b82f6'
          });
        }
      })
      .catch(error => {
        console.error('Fetch error:', error);
        Swal.fire({
          icon: 'error',
          title: 'Connection Error',
          text: 'There was a problem connecting to the server. Please try again later.',
          confirmButtonColor: '#3b82f6'
        });
      })
      .finally(() => {
        // Reset button state
        bookAppointmentBtn.innerHTML = '<i class="fas fa-calendar-check me-2"></i> Book Appointment';
        bookAppointmentBtn.disabled = false;
      });
    }
    
    // Helper function to format time
    function formatTime(timeString) {
      const [hours, minutes] = timeString.split(':');
      const hour = parseInt(hours);
      return hour > 12 ? `${hour - 12}:${minutes} PM` : `${hour}:${minutes} AM`;
    }
});
</script>

@endsection
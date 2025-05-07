@extends('layouts.public.app')

@section('title', 'estimate')

@section('content')

<div class="valuation-container">
    <div class="valuation-hero">
        <div class="hero-overlay">
            <h1 class="hero-title">Smart Property Valuation</h1>
            <p class="hero-subtitle">Get an instant preliminary estimate of your property's value in minutes</p>
        </div>
    </div>

    <div class="container valuation-content py-5">
        <div class="row">
            <!-- Estimation Calculator -->
            <div class="col-lg-7 pe-lg-4">
                <div class="valuation-card card-hover">
                    <div class="card-header bg-primary text-white">
                        <h2><i class="fas fa-calculator me-2"></i> Instant Valuation Tool</h2>
                    </div>
                    <div class="card-body">
                        <form id="valuationForm" class="needs-validation" novalidate>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="propertyType" class="form-label">Property Type*</label>
                                    <select class="form-select" id="propertyType" required>
                                        <option value="" selected disabled>Select type</option>
                                        <option value="apartment">Apartment</option>
                                        <option value="villa">Villa</option>
                                        <option value="townhouse">Townhouse</option>
                                        <option value="commercial">Commercial</option>
                                        <option value="land">Land</option>
                                    </select>
                                    <div class="invalid-feedback">Please select property type</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="propertyArea" class="form-label">Area (sqm)*</label>
                                    <input type="number" class="form-control" id="propertyArea" required>
                                    <div class="invalid-feedback">Please enter valid area</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="propertyLocation" class="form-label">Location*</label>
                                    <select class="form-select" id="propertyLocation" required>
                                        <option value="" selected disabled>Select location</option>
                                        <option value="downtown">Downtown</option>
                                        <option value="suburban">Suburban</option>
                                        <option value="waterfront">Waterfront</option>
                                        <option value="rural">Rural</option>
                                    </select>
                                    <div class="invalid-feedback">Please select location</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="bedrooms" class="form-label">Bedrooms</label>
                                    <input type="number" class="form-control" id="bedrooms" min="0">
                                </div>

                                <div class="col-md-6">
                                    <label for="bathrooms" class="form-label">Bathrooms</label>
                                    <input type="number" class="form-control" id="bathrooms" min="0">
                                </div>

                                <div class="col-md-6">
                                    <label for="yearBuilt" class="form-label">Year Built</label>
                                    <input type="number" class="form-control" id="yearBuilt" min="1900" max="{{ date('Y') }}">
                                </div>

                                <div class="col-12 mt-3">
                                    <button class="btn btn-primary w-100 py-3 calculate-btn" type="submit">
                                        <i class="fas fa-calculator me-2"></i> Calculate Estimate
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div id="valuationResult" class="valuation-result mt-4">
                            <div class="result-header">
                                <h4>Preliminary Valuation</h4>
                                <div class="confidence-level">
                                    <span class="badge bg-info">75% Confidence</span>
                                </div>
                            </div>
                            <div class="result-value">
                                <span class="currency">$</span>
                                <span id="estimatedValue">0</span>
                            </div>
                            <div class="result-disclaimer">
                                <p class="text-muted"><small>This automated valuation is based on market trends and the information provided. For a precise valuation, please book an appointment with our certified appraiser.</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointment Booking -->
            <div class="col-lg-5 ps-lg-4">
                <div class="valuation-card card-hover">
                    <div class="card-header bg-success text-white">
                        <h2><i class="far fa-calendar-alt me-2"></i> Professional Appraisal</h2>
                    </div>
                    <div class="card-body">
                        <div class="appraisal-benefits mb-4">
                            <h5 class="mb-3">Why get a professional appraisal?</h5>
                            <ul class="benefits-list">
                                <li><i class="fas fa-check-circle text-success me-2"></i> Accurate market valuation</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Detailed property analysis</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Certified appraisal report</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Legal documentation support</li>
                            </ul>
                        </div>

                        <form id="appointmentForm" class="needs-validation" novalidate>
                            <div class="mb-3">
                                <label for="appointmentDate" class="form-label">Preferred Date*</label>
                                <input type="datetime-local" class="form-control" id="appointmentDate" required>
                                <div class="invalid-feedback">Please select appointment date</div>
                            </div>

                            <div class="mb-3">
                                <label for="clientName" class="form-label">Full Name*</label>
                                <input type="text" class="form-control" id="clientName" required>
                                <div class="invalid-feedback">Please enter your name</div>
                            </div>

                            <div class="mb-3">
                                <label for="clientEmail" class="form-label">Email*</label>
                                <input type="email" class="form-control" id="clientEmail" required>
                                <div class="invalid-feedback">Please enter valid email</div>
                            </div>

                            <div class="mb-3">
                                <label for="clientPhone" class="form-label">Phone*</label>
                                <input type="tel" class="form-control" id="clientPhone" required>
                                <div class="invalid-feedback">Please enter phone number</div>
                            </div>

                            <div class="mb-3">
                                <label for="propertyAddress" class="form-label">Property Address</label>
                                <textarea class="form-control" id="propertyAddress" rows="2"></textarea>
                            </div>

                            <div class="d-grid mt-4">
                                <button class="btn btn-success btn-lg py-3" type="submit">
                                    <i class="far fa-calendar-check me-2"></i> Book Appointment
                                </button>
                            </div>
                        </form>

                        <div id="appointmentSuccess" class="alert alert-success mt-3 d-none">
                            <i class="fas fa-check-circle me-2"></i>
                            <span>Your appointment request has been submitted successfully! Our team will contact you within 24 hours to confirm your booking.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.valuation-container {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.valuation-hero {
    
    background-size: cover;
    background-position: center;
    height: 350px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
    margin-bottom: 40px;
}

.hero-overlay {
    max-width: 800px;
    padding: 20px;
}

.hero-title {
    font-weight: 700;
    font-size: 2.8rem;
    margin-bottom: 15px;
    text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
}

.hero-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
}

.valuation-card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    margin-bottom: 30px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.12);
}

.valuation-card .card-header {
    border-radius: 10px 10px 0 0 !important;
    padding: 20px;
}

.valuation-card .card-header h2 {
    font-size: 1.5rem;
    margin-bottom: 0;
}

.valuation-card .card-body {
    padding: 30px;
}

.valuation-result {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    border-left: 4px solid #0d6efd;
}

.result-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.result-header h4 {
    font-weight: 600;
    margin-bottom: 0;
}

.result-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: #0d6efd;
    margin: 10px 0;
}

.currency {
    font-size: 1.8rem;
    vertical-align: top;
    margin-right: 5px;
}

.benefits-list {
    list-style: none;
    padding-left: 0;
}

.benefits-list li {
    padding: 8px 0;
    font-size: 0.95rem;
}

.calculate-btn, .appointment-btn {
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.calculate-btn:hover, .appointment-btn:hover {
    transform: translateY(-2px);
}

@media (max-width: 991.98px) {
    .valuation-content .col-lg-7 {
        padding-right: 15px !important;
    }
    
    .valuation-content .col-lg-5 {
        padding-left: 15px !important;
    }
    
    .hero-title {
        font-size: 2.2rem;
    }
}

@media (max-width: 767.98px) {
    .valuation-hero {
        height: 280px;
    }
    
    .hero-title {
        font-size: 1.8rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
}
</style>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Enable form validation
    (function() {
        'use strict'
        
        var forms = document.querySelectorAll('.needs-validation')
        
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    
                    form.classList.add('was-validated')
                }, false)
            })
    })()
    
    // Handle valuation form submission
    $('#valuationForm').submit(function(e) {
        e.preventDefault()
        
        if (this.checkValidity()) {
            // Simulate calculation (replace with actual AJAX call)
            setTimeout(function() {
                var randomValue = Math.floor(Math.random() * 2000000) + 500000
                $('#estimatedValue').text(randomValue.toLocaleString())
                $('#valuationResult').fadeIn()
                
                // Scroll to result
                $('html, body').animate({
                    scrollTop: $('#valuationResult').offset().top - 100
                }, 500)
            }, 800)
        }
    })
    
    // Handle appointment form submission
    $('#appointmentForm').submit(function(e) {
        e.preventDefault()
        
        if (this.checkValidity()) {
            // Simulate submission (replace with actual AJAX call)
            setTimeout(function() {
                $('#appointmentForm').fadeOut(function() {
                    $('#appointmentSuccess').removeClass('d-none').hide().fadeIn()
                })
            }, 800)
        }
    })
    
    // Initialize date picker
    $('#appointmentDate').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        minDate: moment().add(1, 'day'),
        locale: {
            format: 'YYYY-MM-DD hh:mm A'
        }
    })
})
</script>
@endsection
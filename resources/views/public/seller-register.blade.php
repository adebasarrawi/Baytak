@extends('layouts.public.app')
@section('title', 'Seller Registration')
@php
    $step = $force_step ?? session()->get('step', 1);
@endphp

@section('content')



<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white py-4">
                    <h3 class="mb-0 text-center">{{ __('Seller Registration') }}</h3>
                </div>

                <div class="card-body px-5 py-4">
                    <!-- Progress Steps -->
                    <div class="steps mb-5">
                        <div class="step-progress">
                            <div class="step-progress-bar" role="progressbar"></div>
                        </div>
                        <div class="step active" data-step="1">
                            <div class="step-icon">1</div>
                            <div class="step-label">Basic Info</div>
                        </div>
                        <div class="step" data-step="2">
                            <div class="step-icon">2</div>
                            <div class="step-label">Subscription</div>
                        </div>
                        <div class="step" data-step="3">
                            <div class="step-icon">3</div>
                            <div class="step-label">Payment</div>
                        </div>
                    </div>

                    <form id="sellerRegistrationForm">
<input type="hidden" id="currentStep" value="{{ $step }}">
                        <!-- Step 1: Basic Information -->
                        <div id="step1-container" class="step-content">
                            <h4 class="mb-4 text-primary">Registration</h4>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" required>
                                        <label for="name">{{ __('Full Name') }}</label>
                                        <div class="invalid-feedback">Please enter your name</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
                                        <label for="email">{{ __('Email Address') }}</label>
                                        <div class="invalid-feedback">Please enter a valid email</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                        <label for="password">{{ __('Password') }}</label>
                                        <div class="invalid-feedback">Password must be at least 8 characters</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Confirm Password" required>
                                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                        <div class="invalid-feedback">Passwords must match</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="shop_name" name="shop_name" placeholder="Shop Name" required>
                                        <label for="shop_name">{{ __('Shop Name') }}</label>
                                        <div class="invalid-feedback">Please enter your shop name</div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number" required>
                                        <label for="phone">{{ __('Phone Number') }}</label>
                                        <div class="invalid-feedback">Please enter a valid phone number</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary px-4 py-2" onclick="nextStep()">
                                    {{ __('Continue to Subscription') }} <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Subscription Plans -->
                        <div id="step2-container" class="step-content" style="display:none;">
                            <h4 class="mb-4 text-primary">Choose Your Subscription Plan</h4>
                            <p class="text-muted mb-4">Select the plan that works best for your business</p>
                            
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="plan-card" data-plan="monthly">
                                        <div class="plan-header">
                                            <h5>Monthly</h5>
                                            <div class="price"><sup>$</sup>9.99<small>/month</small></div>
                                        </div>
                                        <ul class="plan-features">
                                            <li><i class="fas fa-check text-success me-2"></i> All basic features</li>
                                            <li><i class="fas fa-check text-success me-2"></i> 100 product listings</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Basic analytics</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Email support</li>
                                        </ul>
                                        <div class="plan-footer">
                                            <button type="button" class="btn btn-outline-primary select-plan">Select Plan</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="plan-card recommended" data-plan="yearly">
                                        <div class="recommended-badge">Best Value</div>
                                        <div class="plan-header">
                                            <h5>Yearly</h5>
                                            <div class="price"><sup>$</sup>99<small>/year</small></div>
                                            <div class="text-success">Save 17%</div>
                                        </div>
                                        <ul class="plan-features">
                                            <li><i class="fas fa-check text-success me-2"></i> All premium features</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Unlimited listings</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Advanced analytics</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Priority support</li>
                                        </ul>
                                        <div class="plan-footer">
                                            <button type="button" class="btn btn-primary select-plan">Select Plan</button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="plan-card" data-plan="lifetime">
                                        <div class="plan-header">
                                            <h5>Lifetime</h5>
                                            <div class="price"><sup>$</sup>499<small>one time</small></div>
                                        </div>
                                        <ul class="plan-features">
                                            <li><i class="fas fa-check text-success me-2"></i> All premium features</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Unlimited listings</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Premium analytics</li>
                                            <li><i class="fas fa-check text-success me-2"></i> 24/7 VIP support</li>
                                        </ul>
                                        <div class="plan-footer">
                                            <button type="button" class="btn btn-outline-primary select-plan">Select Plan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <input type="hidden" id="selected_plan" name="plan" value="">
                            
                            <div class="d-flex justify-content-between mt-5">
                                <button type="button" class="btn btn-outline-secondary px-4 py-2" onclick="prevStep()">
                                    <i class="fas fa-arrow-left me-2"></i> {{ __('Back') }}
                                </button>
                                <button type="button" class="btn btn-primary px-4 py-2" id="continue-to-payment" disabled onclick="nextStep()">
                                    {{ __('Continue to Payment') }} <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Payment -->
                        <div id="step3-container" class="step-content" style="display:none;">
                            <h4 class="mb-4 text-primary">Payment Information</h4>
                            
                            <div class="row">
                                <div class="col-lg-7">
                                    <div class="card payment-card">
                                        <div class="card-body p-4">
                                            <div class="payment-card-icons mb-4">
                                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/visa/visa-original.svg" alt="Visa">
                                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mastercard/mastercard-original.svg" alt="Mastercard">
                                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/apple/apple-original.svg" alt="Apple Pay">
                                                <img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/paypal/paypal-original.svg" alt="PayPal">
                                            </div>
                                            
                                            <div class="mb-4">
                                                <label class="form-label">Card Number</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="card_number" name="card_number" placeholder="1234 5678 9012 3456" required>
                                                    <span class="input-group-text"><i class="far fa-credit-card"></i></span>
                                                </div>
                                                <div class="invalid-feedback">Please enter a valid card number</div>
                                            </div>
                                            
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Expiration Date</label>
                                                    <input type="text" class="form-control" id="card_expiry" name="card_expiry" placeholder="MM/YY" required>
                                                    <div class="invalid-feedback">Please enter expiration date</div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Security Code</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="card_cvc" name="card_cvc" placeholder="CVC" required>
                                                        <span class="input-group-text" data-bs-toggle="tooltip" title="3-digit code on back of card">
                                                            <i class="fas fa-question-circle"></i>
                                                        </span>
                                                    </div>
                                                    <div class="invalid-feedback">Please enter security code</div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-check mt-4">
                                                <input class="form-check-input" type="checkbox" id="save_card" checked>
                                                <label class="form-check-label" for="save_card">Save card for future payments</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-5">
                                    <div class="card summary-card">
                                        <div class="card-body p-4">
                                            <h5 class="card-title mb-4">Order Summary</h5>
                                            
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Plan:</span>
                                                <strong id="summary-plan">Yearly ($99/year)</strong>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Subtotal:</span>
                                                <strong>$99.00</strong>
                                            </div>
                                            
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Tax:</span>
                                                <strong>$8.91</strong>
                                            </div>
                                            
                                            <hr>
                                            
                                            <div class="d-flex justify-content-between mb-3">
                                                <span>Total:</span>
                                                <strong class="text-primary">$107.91</strong>
                                            </div>
                                            
                                            <button type="button" class="btn btn-success w-100 py-3 mt-3" onclick="submitForm()">
                                                <i class="fas fa-lock me-2"></i> Complete Payment
                                            </button>
                                            
                                            <div class="text-center mt-3">
                                                <small class="text-muted">Secure payment processing</small>
                                                <div class="mt-2">
                                                    <i class="fas fa-shield-alt text-success me-2"></i>
                                                    <i class="fas fa-lock text-success me-2"></i>
                                                    <i class="fas fa-check-circle text-success"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-4">
                                <button type="button" class="btn btn-outline-secondary px-4 py-2" onclick="prevStep()">
                                    <i class="fas fa-arrow-left me-2"></i> {{ __('Back') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Success Modal -->
<div class="modal fade" id="paymentSuccessModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <div class="success-animation mb-4">
                    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                        <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                        <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                    </svg>
                </div>
                <h3 class="mb-3">Payment Successful!</h3>
                <p class="mb-4">Your seller account has been created successfully. You can now start adding products to your store.</p>
                <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">Go to Dashboard</button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Progress Steps */
    .steps {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-bottom: 30px;
    }
    
    .step-progress {
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 4px;
        background-color: #e9ecef;
        z-index: 1;
    }
    
    .step-progress-bar {
        height: 100%;
        background-color: #0d6efd;
        width: 0%;
        transition: width 0.3s ease;
    }
    
    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
    }
    
    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }
    
    .step-label {
        color: #6c757d;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .step.active .step-icon {
        background-color: #0d6efd;
        color: white;
    }
    
    .step.active .step-label {
        color: #0d6efd;
        font-weight: 500;
    }
    
    /* Plan Cards */
    .plan-card {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 25px;
        height: 100%;
        transition: all 0.3s ease;
        position: relative;
    }
    
    .plan-card:hover {
        border-color: #0d6efd;
        transform: translateY(-5px);
    }
    
    .plan-card.recommended {
        border: 2px solid #0d6efd;
        background-color: #f8f9fa;
    }
    
    .recommended-badge {
        position: absolute;
        top: -10px;
        right: 20px;
        background-color: #0d6efd;
        color: white;
        padding: 3px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }
    
    .plan-header {
        text-align: center;
        margin-bottom: 20px;
    }
    
    .plan-header h5 {
        font-weight: 600;
    }
    
    .price {
        font-size: 32px;
        font-weight: bold;
        margin: 10px 0;
    }
    
    .price small {
        font-size: 16px;
        font-weight: normal;
        color: #6c757d;
    }
    
    .plan-features {
        list-style: none;
        padding: 0;
        margin-bottom: 25px;
    }
    
    .plan-features li {
        padding: 5px 0;
    }
    
    /* Payment Card */
    .payment-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }
    
    .payment-card-icons {
        display: flex;
        gap: 15px;
    }
    
    .payment-card-icons img {
        height: 30px;
        width: auto;
    }
    
    /* Summary Card */
    .summary-card {
        background-color: #f8f9fa;
        border-radius: 10px;
        border: 1px solid #dee2e6;
    }
    
    /* Success Animation */
    .success-animation {
        margin: 0 auto;
        width: 100px;
    }
    
    .checkmark {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: block;
        stroke-width: 2;
        stroke: #4bb71b;
        stroke-miterlimit: 10;
        box-shadow: inset 0px 0px 0px #4bb71b;
        animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
    }
    
    .checkmark__circle {
        stroke-dasharray: 166;
        stroke-dashoffset: 166;
        stroke-width: 2;
        stroke-miterlimit: 10;
        stroke: #4bb71b;
        fill: none;
        animation: stroke .6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    
    .checkmark__check {
        transform-origin: 50% 50%;
        stroke-dasharray: 48;
        stroke-dashoffset: 48;
        animation: stroke .3s cubic-bezier(0.65, 0, 0.45, 1) .8s forwards;
    }
    
    @keyframes stroke {
        100% {
            stroke-dashoffset: 0;
        }
    }
    
    @keyframes scale {
        0%, 100% {
            transform: none;
        }
        50% {
            transform: scale3d(1.1, 1.1, 1);
        }
    }
    
    @keyframes fill {
        100% {
            box-shadow: inset 0px 0px 0px 30px #4bb71b;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });

    // Global variables
    let currentStep = 1;
    const totalSteps = 3;
    let selectedPlan = null;

    // Initialize the form
    function initForm() {
        updateProgressBar();
        setupPlanSelection();
    }

    // Update progress bar
    function updateProgressBar() {
        const progressPercentage = ((currentStep - 1) / (totalSteps - 1)) * 100;
        document.querySelector('.step-progress-bar').style.width = `${progressPercentage}%`;
        
        // Update step indicators
        document.querySelectorAll('.step').forEach(step => {
            const stepNumber = parseInt(step.dataset.step);
            if (stepNumber < currentStep) {
                step.classList.add('completed');
            } else if (stepNumber === currentStep) {
                step.classList.add('active');
                step.classList.remove('completed');
            } else {
                step.classList.remove('active', 'completed');
            }
        });
    }

    // Plan selection functionality
    function setupPlanSelection() {
        document.querySelectorAll('.plan-card').forEach(card => {
            card.addEventListener('click', function() {
                // Remove selected class from all cards
                document.querySelectorAll('.plan-card').forEach(c => {
                    c.classList.remove('selected');
                });
                
                // Add selected class to clicked card
                this.classList.add('selected');
                
                // Get the plan type
                selectedPlan = this.dataset.plan;
                document.getElementById('selected_plan').value = selectedPlan;
                
                // Enable continue button
                document.getElementById('continue-to-payment').disabled = false;
                
                // Update summary
                updateOrderSummary();
            });
        });
    }

    // Update order summary
    function updateOrderSummary() {
        let planName, subtotal;
        
        switch(selectedPlan) {
            case 'monthly':
                planName = 'Monthly ($9.99/month)';
                subtotal = 9.99;
                break;
            case 'yearly':
                planName = 'Yearly ($99/year)';
                subtotal = 99;
                break;
            case 'lifetime':
                planName = 'Lifetime ($499 one time)';
                subtotal = 499;
                break;
            default:
                planName = 'No plan selected';
                subtotal = 0;
        }
        
        const tax = subtotal * 0.09; // 9% tax
        const total = subtotal + tax;
        
        document.getElementById('summary-plan').textContent = planName;
        document.querySelector('.summary-card .d-flex:nth-of-type(2) strong').textContent = `$${subtotal.toFixed(2)}`;
        document.querySelector('.summary-card .d-flex:nth-of-type(3) strong').textContent = `$${tax.toFixed(2)}`;
        document.querySelector('.summary-card .text-primary').textContent = `$${total.toFixed(2)}`;
    }

    // Form navigation
    function nextStep() {
        if (validateCurrentStep()) {
            document.getElementById(`step${currentStep}-container`).style.display = 'none';
            currentStep++;
            document.getElementById('currentStep').value = currentStep;
            document.getElementById(`step${currentStep}-container`).style.display = 'block';
            updateProgressBar();
            
            // Scroll to top of form
            window.scrollTo({top: 0, behavior: 'smooth'});
        }
    }

    function prevStep() {
        document.getElementById(`step${currentStep}-container`).style.display = 'none';
        currentStep--;
        document.getElementById('currentStep').value = currentStep;
        document.getElementById(`step${currentStep}-container`).style.display = 'block';
        updateProgressBar();
        
        // Scroll to top of form
        window.scrollTo({top: 0, behavior: 'smooth'});
    }

    // Form validation
    function validateCurrentStep() {
        let isValid = true;
        
        if (currentStep === 1) {
            // Validate step 1 fields
            const requiredFields = ['name', 'email', 'password', 'password_confirmation', 'shop_name', 'phone'];
            
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            // Validate password match
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password-confirm').value;
            
            if (password !== confirmPassword) {
                document.getElementById('password').classList.add('is-invalid');
                document.getElementById('password-confirm').classList.add('is-invalid');
                isValid = false;
            }
            
            // Validate email format
            const email = document.getElementById('email').value;
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                document.getElementById('email').classList.add('is-invalid');
                isValid = false;
            }
            
        } else if (currentStep === 2) {
            // Validate plan selection
            if (!selectedPlan) {
                alert('Please select a subscription plan');
                isValid = false;
            }
        }
        
        return isValid;
    }

    // Form submission
    function submitForm() {
        if (validateCurrentStep()) {
            // Validate payment fields
            const paymentFields = ['card_number', 'card_expiry', 'card_cvc'];
            let paymentValid = true;
            
            paymentFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    paymentValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (paymentValid) {
                // In a real app, you would process payment here
                // For demo, we'll show success modal
                const modal = new bootstrap.Modal(document.getElementById('paymentSuccessModal'));
                modal.show();
                
                // Reset form after success
                setTimeout(() => {
                    // document.getElementById('sellerRegistrationForm').reset();
                    // currentStep = 1;
                    // document.getElementById('currentStep').value = currentStep;
                    // document.getElementById(`step3-container`).style.display = 'none';
                    // document.getElementById(`step1-container`).style.display = 'block';
                    // updateProgressBar();
                }, 3000);
            }
        }
console.log("Script loaded");
console.log("Current step:", currentStep);
console.log("Step 1 container:", document.getElementById('step1-container'));
console.log("Step 2 container:", document.getElementById('step2-container'));
    }

    // Initialize the form when page loads
    window.onload = initForm;
</script>
@endsection
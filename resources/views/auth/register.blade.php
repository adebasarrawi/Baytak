@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg">
                <div class="card-header bg-gradient-primary text-white py-4">
                    <h3 class="mb-0 text-center">{{ __('Register') }}</h3>
                </div>

                <div class="card-body px-5 py-4">
                    <!-- Display validation errors if any -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Progress Steps -->
                    <div class="steps mb-5">
                        <div class="step-progress">
                            <div class="step-progress-bar" role="progressbar"></div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('register.post') }}" id="registerForm">
                        @csrf
                        <input type="hidden" id="currentStep" value="1">

                        <!-- Step 1 -->
                        <div id="step1-container" class="step-content">
                            <h4 class="mb-4 text-primary">User Information</h4>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Name') }}">
                                        <label for="name">{{ __('Full Name') }}</label>
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email Address') }}">
                                        <label for="email">{{ __('Email Address') }}</label>
                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="tel" placeholder="{{ __('Phone Number') }}">
                                        <label for="phone">{{ __('Phone Number') }}</label>
                                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}">
                                        <label for="password">{{ __('Password') }}</label>
                                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}">
                                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="button" class="btn btn-primary px-4 py-2" onclick="nextStep()">
                                    {{ __('Continue') }} <i class="fas fa-arrow-right ms-2"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Step 2 -->
                        <div id="step2-container" class="step-content" style="display: none;">
                            <h4 class="mb-4 text-primary">Select Account Type</h4>
                            <p class="text-muted mb-4">Choose the type of account you want to create</p>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="account-type-card" data-type="user">
                                        <div class="account-type-header">
                                            <h5>User Account</h5>
                                            <i class="fas fa-user fa-3x text-primary"></i>
                                        </div>
                                        <ul class="account-type-features">
                                            <li><i class="fas fa-check text-success me-2"></i> Browse and purchase products</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Save favorite items</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Track orders</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Write reviews</li>
                                        </ul>
                                        <div class="account-type-footer">
                                            <button type="button" class="btn btn-outline-primary select-type" onclick="selectUserAccount()">Select</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="account-type-card" data-type="seller">
                                        <div class="account-type-header">
                                            <h5>Seller Account</h5>
                                            <i class="fas fa-store fa-3x text-primary"></i>
                                        </div>
                                        <ul class="account-type-features">
                                            <li><i class="fas fa-check text-success me-2"></i> List unlimited products</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Manage your store</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Access seller dashboard</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Earn money from sales</li>
                                        </ul>
                                        <div class="account-type-footer">
                                            <a data-bs-toggle="collapse" href="#paymentSection" class="btn btn-primary select-type">Become a Seller</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Section -->
                            <div class="collapse mt-5" id="paymentSection">
                                <div class="card card-body">
                                    <h4 class="mb-3 text-primary">Subscription Plans</h4>
                                    
                                    <!-- Subscription Plans -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="card border h-100">
                                                <div class="card-header bg-light">
                                                    <h5 class="mb-0 text-center">Monthly Plan</h5>
                                                </div>
                                                <div class="card-body text-center">
                                                    <h3 class="display-5 text-primary mb-0">$7</h3>
                                                    <p class="text-muted">5 JOD per month</p>
                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input" type="radio" name="subscription" id="monthly" value="monthly" checked>
                                                        <label class="form-check-label" for="monthly">
                                                            Select Monthly Plan
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card border h-100">
                                                <div class="card-header bg-light">
                                                    <h5 class="mb-0 text-center">Yearly Plan</h5>
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                                                        Save 16%
                                                    </span>
                                                </div>
                                                <div class="card-body text-center">
                                                    <h3 class="display-5 text-primary mb-0">$70</h3>
                                                    <p class="text-muted">50 JOD per year</p>
                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input" type="radio" name="subscription" id="yearly" value="yearly">
                                                        <label class="form-check-label" for="yearly">
                                                            Select Yearly Plan
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h4 class="mb-3 text-primary">Payment Information</h4>
                                    <div class="mb-3">
                                        <label for="card-holder" class="form-label">Card Holder Name</label>
                                        <input type="text" class="form-control" id="card-holder" name="card_holder">
                                    </div>
                                    <div class="mb-3">
                                        <label for="card-number" class="form-label">Card Number</label>
                                        <input type="text" class="form-control" id="card-number" name="card_number">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="expiry-date" class="form-label">Expiry Date</label>
                                            <input type="text" class="form-control" id="expiry-date" name="expiry_date" placeholder="MM/YY">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="cvc" class="form-label">CVC</label>
                                            <input type="text" class="form-control" id="cvc" name="cvc">
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-success btn-lg w-100" id="completePaymentBtn">
                                        <i class="fas fa-lock me-2"></i> Complete Payment
                                    </button>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-5">
                                <button type="button" class="btn btn-outline-secondary px-4 py-2" onclick="prevStep()">
                                    <i class="fas fa-arrow-left me-2"></i> {{ __('Back') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="login-link text-center mt-4">
                        <p>Already have an account? <a href="{{ route('login') }}">{{ __('Sign in') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Alert instead of Modal -->
<div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 5; display: none;" id="successAlert">
  <div class="alert alert-success shadow-lg" role="alert">
    <div class="d-flex align-items-center">
      <i class="fas fa-check-circle fa-2x me-3"></i>
      <div>
        <h4 class="alert-heading mb-1">Payment Successful!</h4>
        <p class="mb-0">Your seller account has been activated successfully.</p>
      </div>
    </div>
  </div>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 2;

    document.addEventListener('DOMContentLoaded', function () {
        updateProgressBar();
        console.log('Registration form loaded');
        
        // Add event listener for the complete payment button
        document.getElementById('completePaymentBtn').addEventListener('click', function() {
            confirmPayment();
        });
    });

    function updateProgressBar() {
        const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
        document.querySelector('.step-progress-bar').style.width = progress + '%';
        console.log('Progress bar updated to: ' + progress + '%');
    }

    function nextStep() {
        console.log('Next step clicked');
        if (validateCurrentStep()) {
            document.getElementById(`step${currentStep}-container`).style.display = 'none';
            currentStep++;
            document.getElementById('currentStep').value = currentStep;
            document.getElementById(`step${currentStep}-container`).style.display = 'block';
            updateProgressBar();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            console.log('Moved to step: ' + currentStep);
        } else {
            console.log('Validation failed for step: ' + currentStep);
        }
    }

    function prevStep() {
        console.log('Previous step clicked');
        document.getElementById(`step${currentStep}-container`).style.display = 'none';
        currentStep--;
        document.getElementById('currentStep').value = currentStep;
        document.getElementById(`step${currentStep}-container`).style.display = 'block';
        updateProgressBar();
        window.scrollTo({ top: 0, behavior: 'smooth' });
        console.log('Moved back to step: ' + currentStep);
    }

    function validateCurrentStep() {
        let isValid = true;
        if (currentStep === 1) {
            console.log('Validating step 1');
            const requiredFields = ['name', 'email', 'phone', 'password', 'password-confirm'];
            requiredFields.forEach(id => {
                const field = document.getElementById(id);
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                    console.log('Field is invalid: ' + id);
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password-confirm').value;
            if (password !== confirmPassword) {
                document.getElementById('password-confirm').classList.add('is-invalid');
                isValid = false;
                console.log('Passwords do not match');
            } else {
                document.getElementById('password-confirm').classList.remove('is-invalid');
            }
        }
        return isValid;
    }
    
    function selectUserAccount() {
        console.log('User account selected');
        // Add hidden input for user_type
        addUserTypeInput('user');
        
        // Get the form
        const form = document.getElementById('registerForm');
        
        // Add redirect_to input
        const redirectInput = document.createElement('input');
        redirectInput.type = 'hidden';
        redirectInput.name = 'redirect_to';
        redirectInput.value = 'login';
        form.appendChild(redirectInput);
        
        // Submit the form
        console.log('Submitting form for user account with redirect to login');
        form.submit();
    }
    
    function confirmPayment() {
        console.log('Payment confirmation clicked');
        // Validate payment fields
        const cardHolder = document.getElementById('card-holder').value;
        const cardNumber = document.getElementById('card-number').value;
        const expiryDate = document.getElementById('expiry-date').value;
        const cvc = document.getElementById('cvc').value;
        
        console.log('Payment details:', {
            cardHolder: cardHolder ? 'filled' : 'empty',
            cardNumber: cardNumber ? 'filled' : 'empty',
            expiryDate: expiryDate ? 'filled' : 'empty',
            cvc: cvc ? 'filled' : 'empty'
        });
        
        if (!cardHolder || !cardNumber || !expiryDate || !cvc) {
            alert('Please fill all payment fields');
            return;
        }
        
        // Add hidden input for user_type
        addUserTypeInput('seller');
        
        // Add payment_confirmed flag
        const paymentConfirmedInput = document.createElement('input');
        paymentConfirmedInput.type = 'hidden';
        paymentConfirmedInput.name = 'payment_confirmed';
        paymentConfirmedInput.value = 'true';
        document.getElementById('registerForm').appendChild(paymentConfirmedInput);
        
        // Add redirect_to input
        const redirectInput = document.createElement('input');
        redirectInput.type = 'hidden';
        redirectInput.name = 'redirect_to';
        redirectInput.value = 'login';
        document.getElementById('registerForm').appendChild(redirectInput);
        
        // Show success alert
        const successAlert = document.getElementById('successAlert');
        successAlert.style.display = 'block';
        
        // Submit the form after 2 seconds
        setTimeout(() => {
            console.log('Submitting form for seller account with payment');
            document.getElementById('registerForm').submit();
        }, 2000);
    }
    
    function addUserTypeInput(type) {
        console.log('Adding user_type input with value: ' + type);
        // Remove existing user_type input if it exists
        const existingInput = document.querySelector('input[name="user_type"]');
        if (existingInput) {
            console.log('Removing existing user_type input');
            existingInput.remove();
        }
        
        // Create a new input
        const userTypeInput = document.createElement('input');
        userTypeInput.type = 'hidden';
        userTypeInput.name = 'user_type';
        userTypeInput.value = type;
        document.getElementById('registerForm').appendChild(userTypeInput);
        console.log('user_type input added with value: ' + type);
    }
</script>
@endsection
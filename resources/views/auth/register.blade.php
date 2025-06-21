<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Real Estate Platform</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }

        .register-wrapper {
            width: 100%;
            max-width: 1200px;
            margin: 20px;
        }

        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 80px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            min-height: 700px;
            border: 1px solid rgba(255, 255, 255, 0.8);
        }

        .register-form-section {
            flex: 1.2;
            padding: 30px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-height: 700px;
            overflow-y: auto;
        }

        .register-image-section {
            flex: 0.8;
            background: linear-gradient(135deg, #1a1c20 0%, #2c3e50 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-image-section::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 1;
        }

        .register-image-section::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -15%;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            z-index: 1;
        }

        .image-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            padding: 40px;
        }

        .image-icon {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            animation: float 3s ease-in-out infinite;
        }

        .image-icon i {
            font-size: 2.5rem;
            color: white;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .image-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 15px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .image-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
            font-weight: 300;
            line-height: 1.5;
        }

        .register-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .register-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .register-subtitle {
            color: #6b7280;
            font-size: 0.9rem;
            font-weight: 400;
        }

        /* Progress Bar */
        .steps {
            margin-bottom: 25px;
        }

        .step-progress {
            height: 6px;
            background-color: #e5e7eb;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .step-progress-bar {
            position: absolute;
            height: 100%;
            width: 0%;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            transition: width 0.5s ease;
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            background: #fafafa;
            height: auto;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            background: white;
            outline: none;
        }

        .input-group {
            position: relative;
        }

        .input-group-text {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border: 2px solid #e5e7eb;
            border-right: none;
            color: #3b82f6;
            font-weight: 600;
            border-radius: 12px 0 0 12px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 12px 12px 0;
        }

        .input-group:focus-within .input-group-text {
            border-color: #3b82f6;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6b7280;
            cursor: pointer;
            font-size: 1.1rem;
            transition: color 0.2s ease;
            z-index: 10;
        }

        .password-toggle:hover {
            color: #3b82f6;
        }

        .password-criteria {
            padding-left: 0;
            margin: 10px 0 0 0;
            list-style-type: none;
            font-size: 0.85rem;
        }

        .password-criteria li {
            margin-bottom: 5px;
            transition: color 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border: none;
            border-radius: 12px;
            color: white;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
            cursor: pointer;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(59, 130, 246, 0.4);
        }

        .btn-outline-secondary {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            color: #6b7280;
            padding: 12px 24px;
            font-weight: 600;
            background: white;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            border-color: #3b82f6;
            color: #3b82f6;
            background: #f8fafc;
            transform: translateY(-1px);
        }

        /* Account Type Cards */
        .account-type-card {
            border: 2px solid #e5e7eb;
            border-radius: 15px;
            padding: 25px;
            height: 100%;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            cursor: pointer;
            background: white;
        }

        .account-type-card:hover {
            border-color: #3b82f6;
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .account-type-card.selected {
            border-color: #3b82f6;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        }

        .account-type-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .account-type-header h5 {
            font-weight: 700;
            color: #1f2937;
            margin: 0;
        }

        .account-type-features {
            list-style-type: none;
            padding-left: 0;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .account-type-features li {
            margin-bottom: 10px;
            font-size: 0.9rem;
            color: #4b5563;
        }

        .account-type-footer {
            margin-top: auto;
        }

        .select-type {
            width: 100%;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        /* Payment Section */
        .payment-section {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-radius: 15px;
            padding: 30px;
            margin-top: 30px;
            border: 1px solid #e5e7eb;
        }

        .plan-card {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            background: white;
            cursor: pointer;
        }

        .plan-card:hover {
            border-color: #3b82f6;
            transform: translateY(-2px);
        }

        .plan-card.selected {
            border-color: #3b82f6;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        }

        .plan-price {
            font-size: 2.5rem;
            font-weight: 700;
            color: #3b82f6;
            margin: 10px 0;
        }

        .alert {
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 20px;
            border: none;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fef2f2, #fee2e2);
            color: #dc2626;
            border-left: 4px solid #ef4444;
        }

        .alert-success {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            color: #16a34a;
            border-left: 4px solid #22c55e;
        }

        .validation-feedback {
            margin-top: 8px;
            font-size: 0.85rem;
        }

        .login-link {
            text-align: center;
            color: #6b7280;
            font-size: 0.95rem;
            margin-top: 20px;
        }

        .login-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .login-link a:hover {
            color: #2563eb;
            text-decoration: underline;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInUp 0.6s ease forwards;
        }

        .fade-in.delay-1 {
            animation-delay: 0.1s;
        }

        .fade-in.delay-2 {
            animation-delay: 0.2s;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.15em;
        }

        .validation-pending {
            position: relative;
        }

        .validation-pending::after {
            content: '';
            position: absolute;
            top: 12px;
            right: 12px;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-top-color: #3b82f6;
            border-radius: 50%;
            animation: spinner 0.6s linear infinite;
        }

        @keyframes spinner {
            to {
                transform: rotate(360deg);
            }
        }

        /* Success Alert */
        #successAlert {
            animation: fadeInDown 0.5s ease-out;
            z-index: 9999;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translate(-50%, -30px);
            }
            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
                margin: 10px;
                min-height: auto;
            }

            .register-image-section {
                order: -1;
                min-height: 250px;
            }

            .register-form-section {
                padding: 30px 25px;
                max-height: none;
            }

            .register-title {
                font-size: 1.8rem;
            }

            .image-title {
                font-size: 1.6rem;
            }

            .image-icon {
                width: 80px;
                height: 80px;
            }

            .image-icon i {
                font-size: 2rem;
            }

            .account-type-card {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 576px) {
            .register-form-section {
                padding: 20px 15px;
            }

            .register-title {
                font-size: 1.6rem;
            }

            .payment-section {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="register-wrapper">
        <div class="register-container">
            <!-- Form Section -->
            <div class="register-form-section">
                <div class="register-header fade-in">
                    <h1 class="register-title">Create Account</h1>
                    <p class="register-subtitle">Join our real estate platform today</p>
                </div>

                <!-- Progress Bar -->
                <div class="steps fade-in delay-1">
                    <div class="step-progress">
                        <div class="step-progress-bar" role="progressbar"></div>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger fade-in delay-1">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.post') }}" id="registerForm" class="fade-in delay-1" novalidate>
                    @csrf
                    <input type="hidden" id="currentStep" value="1">

                    <!-- Step 1: User Information -->
                    <div id="step1-container" class="step-content">
                        <h4 class="mb-4 text-primary">Personal Information</h4>
                        
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="form-label">Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <input id="name" type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               name="name" value="{{ old('name') }}" 
                                               required autocomplete="name" autofocus
                                               placeholder="Enter your full name">
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input id="email" type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               name="email" value="{{ old('email') }}" 
                                               required autocomplete="email"
                                               placeholder="Enter your email address">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input id="phone" type="tel" 
                                               class="form-control @error('phone') is-invalid @enderror" 
                                               name="phone" value="{{ old('phone') }}" 
                                               required autocomplete="tel"
                                               placeholder="Enter your phone number">
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group position-relative">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input id="password" type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               name="password" required autocomplete="new-password"
                                               placeholder="Create a password">
                                        <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                            <i class="fas fa-eye" id="passwordIcon"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password-confirm" class="form-label">Confirm Password</label>
                                    <div class="input-group position-relative">
                                        <span class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input id="password-confirm" type="password" 
                                               class="form-control" name="password_confirmation" 
                                               required autocomplete="new-password"
                                               placeholder="Confirm your password">
                                        <button type="button" class="password-toggle" onclick="togglePassword('password-confirm')">
                                            <i class="fas fa-eye" id="passwordConfirmIcon"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-primary px-4 py-2" id="nextStepBtn" onclick="nextStep()">
                                Continue <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Step 2: Account Type -->
                    <div id="step2-container" class="step-content" style="display: none;">
                        <h4 class="mb-4 text-primary">Select Account Type</h4>
                        <p class="text-muted mb-4">Choose the type of account you want to create</p>
                        
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="account-type-card" data-type="user" onclick="selectAccountType('user')">
                                    <div class="account-type-header">
                                        <h5>Property Seeker</h5>
                                        <i class="fas fa-search fa-3x text-primary"></i>
                                    </div>
                                    <ul class="account-type-features">
                                        <li><i class="fas fa-check text-success me-2"></i> Browse unlimited properties</li>
                                        <li><i class="fas fa-check text-success me-2"></i> Save favorite properties</li>
                                        <li><i class="fas fa-check text-success me-2"></i> Contact property owners</li>
                                        <li><i class="fas fa-check text-success me-2"></i> Schedule property visits</li>
                                    </ul>
                                    <div class="account-type-footer">
                                        <button type="button" class="btn btn-outline-primary select-type">
                                            Select Free Account
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="account-type-card" data-type="seller" onclick="selectAccountType('seller')">
                                    <div class="account-type-header">
                                        <h5>Property Owner</h5>
                                        <i class="fas fa-home fa-3x text-primary"></i>
                                    </div>
                                    <ul class="account-type-features">
                                        <li><i class="fas fa-check text-success me-2"></i> List unlimited properties</li>
                                        <li><i class="fas fa-check text-success me-2"></i> Professional dashboard</li>
                                        <li><i class="fas fa-check text-success me-2"></i> Lead management tools</li>
                                        <li><i class="fas fa-check text-success me-2"></i> Analytics and insights</li>
                                    </ul>
                                    <div class="account-type-footer">
                                        <button type="button" class="btn btn-primary select-type">
                                            Become a Seller
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Section -->
                        <div class="payment-section" id="paymentSection" style="display: none;">
                            <h4 class="mb-3 text-primary">Subscription Plans</h4>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="plan-card" onclick="selectPlan('monthly')">
                                        <h5 class="mb-3">Monthly Plan</h5>
                                        <div class="plan-price">$7</div>
                                        <p class="text-muted">5 JOD per month</p>
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="radio" name="subscription" id="monthly" value="monthly" checked>
                                            <label class="form-check-label" for="monthly">
                                                Select Monthly Plan
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="plan-card" onclick="selectPlan('yearly')">
                                        <h5 class="mb-3">Yearly Plan <span class="badge bg-success ms-2">Save 16%</span></h5>
                                        <div class="plan-price">$70</div>
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

                            <h4 class="mb-3 text-primary">Payment Information</h4>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="card-holder" class="form-label">Card Holder Name</label>
                                        <input type="text" class="form-control" id="card-holder" name="card_holder" placeholder="Enter cardholder name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="card-number" class="form-label">Card Number</label>
                                        <input type="text" class="form-control" id="card-number" name="card_number" placeholder="1234 5678 9012 3456">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expiry-date" class="form-label">Expiry Date</label>
                                        <input type="text" class="form-control" id="expiry-date" name="expiry_date" placeholder="MM/YY">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cvc" class="form-label">CVC</label>
                                        <input type="text" class="form-control" id="cvc" name="cvc" placeholder="123">
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn btn-primary btn-lg w-100 mt-4" id="completePaymentBtn">
                                <i class="fas fa-lock me-2"></i> Complete Payment & Register
                            </button>
                        </div>

                        <div class="d-flex justify-content-between mt-4" id="stepNavigation">
                            <button type="button" class="btn btn-outline-secondary px-4 py-2" onclick="prevStep()">
                                <i class="fas fa-arrow-left me-2"></i> Back
                            </button>
                        </div>
                    </div>
                </form>

                <div class="login-link fade-in delay-2">
                    Already have an account? 
                    <a href="{{ route('login') }}">Sign in here</a>
                </div>
            </div>

            <!-- Image Section -->
            <div class="register-image-section">
                <div class="image-content">
                    <div class="image-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h2 class="image-title">Join Our Community</h2>
                    <p class="image-subtitle">
                        Connect with thousands of property seekers and owners. Whether you're looking for your dream home or ready to list your property, we're here to help you succeed.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    <div class="position-fixed top-0 start-50 translate-middle-x p-3" style="z-index: 9999; display: none;" id="successAlert">
        <div class="alert alert-success shadow-lg" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle fa-2x me-3"></i>
                <div>
                    <h4 class="alert-heading mb-1">Registration Successful!</h4>
                    <p class="mb-0">Your account has been created successfully.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Global variables
        let currentStep = 1;
        const totalSteps = 2;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize progress bar
            updateProgressBar();
            
            // Setup form validation
            setupFormValidation();
            
            // Setup payment validation
            setupPaymentValidation();
            
            console.log('Register form initialized');
        });

        function updateProgressBar() {
            const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
            document.querySelector('.step-progress-bar').style.width = progress + '%';
        }

        function setupFormValidation() {
            // Password validation
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password-confirm');
            
            // Create password feedback
            const passwordFeedback = document.createElement('div');
            passwordFeedback.className = 'validation-feedback mt-2';
            passwordInput.parentNode.parentNode.appendChild(passwordFeedback);
            
            const createPasswordValidationList = () => {
                const criteria = [
                    { id: 'length', text: 'At least 8 characters long', regex: /.{8,}/ },
                    { id: 'uppercase', text: 'At least one uppercase letter', regex: /[A-Z]/ },
                    { id: 'lowercase', text: 'At least one lowercase letter', regex: /[a-z]/ },
                    { id: 'number', text: 'At least one number', regex: /[0-9]/ },
                    { id: 'special', text: 'At least one special character (@$!%*?&)', regex: /[@$!%*?&]/ },
                    { id: 'match', text: 'Passwords match', compare: true }
                ];
                
                let html = '<ul class="password-criteria small">';
                criteria.forEach(item => {
                    html += `<li id="${item.id}" class="text-muted"><i class="fas fa-times-circle text-danger me-2"></i>${item.text}</li>`;
                });
                html += '</ul>';
                
                passwordFeedback.innerHTML = html;
                return criteria;
            };
            
            const passwordCriteria = createPasswordValidationList();
            
            // Email validation
            const emailInput = document.getElementById('email');
            const emailFeedback = document.createElement('div');
            emailFeedback.className = 'validation-feedback mt-2';
            emailInput.parentNode.parentNode.appendChild(emailFeedback);
            
            // Phone validation
            const phoneInput = document.getElementById('phone');
            const phoneFeedback = document.createElement('div');
            phoneFeedback.className = 'validation-feedback mt-2';
            phoneInput.parentNode.parentNode.appendChild(phoneFeedback);
            
            // Attach event listeners with debouncing
            emailInput.addEventListener('input', debounce(function() {
                validateEmail(this.value);
            }, 500));
            
            emailInput.addEventListener('blur', function() {
                validateEmail(this.value);
            });
            
            phoneInput.addEventListener('input', debounce(function() {
                validatePhone(this.value);
            }, 500));
            
            phoneInput.addEventListener('blur', function() {
                validatePhone(this.value);
            });
            
            passwordInput.addEventListener('input', validatePassword);
            passwordConfirmInput.addEventListener('input', validatePassword);
        }

        // Debounce function to prevent excessive API calls
        function debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func.apply(this, args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        }

        function setupPaymentValidation() {
            // Format card number
            const cardNumberInput = document.getElementById('card-number');
            if (cardNumberInput) {
                const cardFeedback = document.createElement('div');
                cardFeedback.className = 'validation-feedback mt-2';
                cardNumberInput.parentNode.appendChild(cardFeedback);
                
                cardNumberInput.addEventListener('input', function(e) {
                    let value = this.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                    let formattedValue = '';
                    for (let i = 0; i < value.length; i++) {
                        if (i > 0 && i % 4 === 0) {
                            formattedValue += ' ';
                        }
                        formattedValue += value[i];
                    }
                    this.value = formattedValue;
                });
                
                // Validate card number on blur with uniqueness check
                cardNumberInput.addEventListener('blur', function() {
                    if (this.value.trim() !== '') {
                        validateCardNumber(this.value);
                    }
                });
            }
            
            // Format expiry date
            const expiryDateInput = document.getElementById('expiry-date');
            if (expiryDateInput) {
                expiryDateInput.addEventListener('input', function(e) {
                    let value = this.value.replace(/\D/g, '');
                    if (value.length > 0) {
                        if (value.length <= 2) {
                            this.value = value;
                        } else {
                            this.value = value.substring(0, 2) + '/' + value.substring(2, 4);
                        }
                    }
                });
            }
            
            // Payment button
            const completePaymentBtn = document.getElementById('completePaymentBtn');
            if (completePaymentBtn) {
                completePaymentBtn.addEventListener('click', function() {
                    completePayment();
                });
            }
        }

        // Card validation function
        async function validateCardNumber(cardNumber) {
            const cardNumberInput = document.getElementById('card-number');
            const feedbackDiv = cardNumberInput.parentNode.querySelector('.validation-feedback');
            const cardNumberRegex = /^[0-9\s]{13,19}$/;
            
            if (!cardNumber) {
                feedbackDiv.innerHTML = '<div class="text-danger"><i class="fas fa-times-circle me-2"></i>Card number is required</div>';
                cardNumberInput.classList.add('is-invalid');
                cardNumberInput.classList.remove('is-valid');
                return false;
            }
            
            if (!cardNumberRegex.test(cardNumber)) {
                feedbackDiv.innerHTML = '<div class="text-danger"><i class="fas fa-times-circle me-2"></i>Please enter a valid card number (13-19 digits)</div>';
                cardNumberInput.classList.add('is-invalid');
                cardNumberInput.classList.remove('is-valid');
                return false;
            }
            
            // Check card uniqueness
            try {
                cardNumberInput.classList.add('validation-pending');
                
                const response = await fetch('/check-card-unique', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ card_number: cardNumber })
                });
                
                cardNumberInput.classList.remove('validation-pending');
                
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                
                const data = await response.json();
                
                if (data.exists) {
                    feedbackDiv.innerHTML = '<div class="text-danger"><i class="fas fa-times-circle me-2"></i>This card number is already in use. Please use a different card.</div>';
                    cardNumberInput.classList.add('is-invalid');
                    cardNumberInput.classList.remove('is-valid');
                    return false;
                } else {
                    feedbackDiv.innerHTML = '<div class="text-success"><i class="fas fa-check-circle me-2"></i>Card number is valid and available</div>';
                    cardNumberInput.classList.remove('is-invalid');
                    cardNumberInput.classList.add('is-valid');
                    return true;
                }
            } catch (error) {
                cardNumberInput.classList.remove('validation-pending');
                console.error('Error checking card number:', error);
                feedbackDiv.innerHTML = '<div class="text-warning"><i class="fas fa-exclamation-circle me-2"></i>Card number format is valid, but uniqueness could not be verified</div>';
                cardNumberInput.classList.remove('is-invalid');
                cardNumberInput.classList.remove('is-valid');
                return true;
            }
        }

        async function nextStep() {
            const nextStepBtn = document.getElementById('nextStepBtn');
            nextStepBtn.disabled = true;
            nextStepBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Validating...';
            
            const isValid = await validateCurrentStep();
            
            if (isValid) {
                document.getElementById(`step${currentStep}-container`).style.display = 'none';
                currentStep++;
                document.getElementById('currentStep').value = currentStep;
                document.getElementById(`step${currentStep}-container`).style.display = 'block';
                updateProgressBar();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
            
            nextStepBtn.disabled = false;
            nextStepBtn.innerHTML = 'Continue <i class="fas fa-arrow-right ms-2"></i>';
        }

        function prevStep() {
            document.getElementById(`step${currentStep}-container`).style.display = 'none';
            currentStep--;
            document.getElementById('currentStep').value = currentStep;
            document.getElementById(`step${currentStep}-container`).style.display = 'block';
            updateProgressBar();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        async function validateCurrentStep() {
            if (currentStep === 1) {
                let isValid = true;
                
                // Validate name
                const nameField = document.getElementById('name');
                if (!nameField.value.trim()) {
                    nameField.classList.add('is-invalid');
                    isValid = false;
                } else {
                    nameField.classList.remove('is-invalid');
                }
                
                // Validate email
                const emailValid = await validateEmail(document.getElementById('email').value);
                isValid = emailValid && isValid;
                
                // Validate phone
                const phoneValid = await validatePhone(document.getElementById('phone').value);
                isValid = phoneValid && isValid;
                
                // Validate password
                const passwordValid = validatePassword();
                isValid = passwordValid && isValid;
                
                return isValid;
            }
            return true;
        }

        async function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const emailInput = document.getElementById('email');
            const emailFeedback = emailInput.parentNode.parentNode.querySelector('.validation-feedback');
            
            if (!email) {
                emailFeedback.innerHTML = '<div class="text-danger"><i class="fas fa-times-circle me-2"></i>Email is required</div>';
                emailInput.classList.add('is-invalid');
                emailInput.classList.remove('is-valid');
                return false;
            }
            
            if (!emailRegex.test(email)) {
                let message = '<div class="text-danger"><i class="fas fa-times-circle me-2"></i>Invalid email format. Issues:</div><ul class="small ps-3 mb-0">';
                
                if (!email.includes('@')) {
                    message += '<li class="text-danger">Missing @ symbol</li>';
                }
                
                if (!email.includes('.')) {
                    message += '<li class="text-danger">Missing domain extension (.com, .net, etc.)</li>';
                } else {
                    const parts = email.split('@');
                    if (parts.length > 1 && !parts[1].includes('.')) {
                        message += '<li class="text-danger">Invalid domain format (should include .com, .net, etc.)</li>';
                    }
                }
                
                message += '</ul>';
                emailFeedback.innerHTML = message;
                emailInput.classList.add('is-invalid');
                emailInput.classList.remove('is-valid');
                return false;
            }
            
            // Check email uniqueness
            try {
                emailInput.classList.add('validation-pending');
                
                const response = await fetch('/check-email-unique', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ email })
                });
                
                emailInput.classList.remove('validation-pending');
                
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                
                const data = await response.json();
                
                if (data.exists) {
                    emailFeedback.innerHTML = '<div class="text-danger"><i class="fas fa-times-circle me-2"></i>This email is already registered. Please use a different email.</div>';
                    emailInput.classList.add('is-invalid');
                    emailInput.classList.remove('is-valid');
                    return false;
                } else {
                    emailFeedback.innerHTML = '<div class="text-success"><i class="fas fa-check-circle me-2"></i>Email is valid and available</div>';
                    emailInput.classList.remove('is-invalid');
                    emailInput.classList.add('is-valid');
                    return true;
                }
            } catch (error) {
                emailInput.classList.remove('validation-pending');
                console.error('Error checking email:', error);
                emailFeedback.innerHTML = '<div class="text-warning"><i class="fas fa-exclamation-circle me-2"></i>Email format is valid, but uniqueness could not be verified</div>';
                emailInput.classList.remove('is-invalid');
                emailInput.classList.remove('is-valid');
                return true;
            }
        }

        async function validatePhone(phone) {
            const phoneRegex = /^[0-9+\-\s()]{7,15}$/;
            const phoneInput = document.getElementById('phone');
            const phoneFeedback = phoneInput.parentNode.parentNode.querySelector('.validation-feedback');
            
            if (!phone) {
                phoneFeedback.innerHTML = '<div class="text-danger"><i class="fas fa-times-circle me-2"></i>Phone number is required</div>';
                phoneInput.classList.add('is-invalid');
                phoneInput.classList.remove('is-valid');
                return false;
            }
            
            if (!phoneRegex.test(phone)) {
                phoneFeedback.innerHTML = '<div class="text-danger"><i class="fas fa-times-circle me-2"></i>Invalid phone format (should be 7-15 digits, may include +, -, spaces, or parentheses)</div>';
                phoneInput.classList.add('is-invalid');
                phoneInput.classList.remove('is-valid');
                return false;
            }
            
            // Check phone uniqueness
            try {
                phoneInput.classList.add('validation-pending');
                
                const response = await fetch('/check-phone-unique', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ phone })
                });
                
                phoneInput.classList.remove('validation-pending');
                
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                
                const data = await response.json();
                
                if (data.exists) {
                    phoneFeedback.innerHTML = '<div class="text-danger"><i class="fas fa-times-circle me-2"></i>This phone number is already registered. Please use a different number.</div>';
                    phoneInput.classList.add('is-invalid');
                    phoneInput.classList.remove('is-valid');
                    return false;
                } else {
                    phoneFeedback.innerHTML = '<div class="text-success"><i class="fas fa-check-circle me-2"></i>Phone number is valid and available</div>';
                    phoneInput.classList.remove('is-invalid');
                    phoneInput.classList.add('is-valid');
                    return true;
                }
            } catch (error) {
                phoneInput.classList.remove('validation-pending');
                console.error('Error checking phone:', error);
                phoneFeedback.innerHTML = '<div class="text-warning"><i class="fas fa-exclamation-circle me-2"></i>Phone format is valid, but uniqueness could not be verified</div>';
                phoneInput.classList.remove('is-invalid');
                phoneInput.classList.remove('is-valid');
                return true;
            }
        }

        function validatePassword() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password-confirm').value;
            const passwordInput = document.getElementById('password');
            const passwordConfirmInput = document.getElementById('password-confirm');
            
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecial = /[@$!%*?&]/.test(password);
            const isLongEnough = password.length >= 8;
            const passwordsMatch = password === confirmPassword && password.length > 0;
            
            const isValid = hasUpperCase && hasLowerCase && hasNumber && hasSpecial && isLongEnough && passwordsMatch;
            
            // Update criteria display
            const passwordCriteria = [
                { id: 'length', passed: isLongEnough },
                { id: 'uppercase', passed: hasUpperCase },
                { id: 'lowercase', passed: hasLowerCase },
                { id: 'number', passed: hasNumber },
                { id: 'special', passed: hasSpecial },
                { id: 'match', passed: passwordsMatch }
            ];
            
            passwordCriteria.forEach(criterion => {
                const element = document.getElementById(criterion.id);
                if (element) {
                    if (criterion.passed) {
                        element.innerHTML = element.innerHTML.replace('fa-times-circle text-danger', 'fa-check-circle text-success');
                        element.className = 'text-success';
                    } else {
                        element.innerHTML = element.innerHTML.replace('fa-check-circle text-success', 'fa-times-circle text-danger');
                        element.className = 'text-muted';
                    }
                }
            });
            
            if (isValid) {
                passwordInput.classList.remove('is-invalid');
                passwordInput.classList.add('is-valid');
                passwordConfirmInput.classList.remove('is-invalid');
                passwordConfirmInput.classList.add('is-valid');
            } else {
                if (confirmPassword && !passwordsMatch) {
                    passwordConfirmInput.classList.add('is-invalid');
                }
            }
            
            return isValid;
        }

        function selectAccountType(type) {
            // Remove selection from all cards
            document.querySelectorAll('.account-type-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Select current card
            document.querySelector(`[data-type="${type}"]`).classList.add('selected');
            
            if (type === 'seller') {
                document.getElementById('paymentSection').style.display = 'block';
                document.getElementById('stepNavigation').style.display = 'none';
            } else {
                // For user account, submit form immediately
                addUserTypeInput('user');
                document.getElementById('registerForm').submit();
            }
        }

        function selectPlan(plan) {
            // Remove selection from all plan cards
            document.querySelectorAll('.plan-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Select current plan card
            event.target.closest('.plan-card').classList.add('selected');
            
            // Update radio button
            document.getElementById(plan).checked = true;
        }

        function completePayment() {
            const completePaymentBtn = document.getElementById('completePaymentBtn');
            const originalHtml = completePaymentBtn.innerHTML;
            
            completePaymentBtn.disabled = true;
            completePaymentBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';
            
            // Validate payment fields
            const cardHolder = document.getElementById('card-holder').value;
            const cardNumber = document.getElementById('card-number').value;
            const expiryDate = document.getElementById('expiry-date').value;
            const cvc = document.getElementById('cvc').value;
            
            // Validate card fields
            const cardHolderRegex = /^[a-zA-Z\s'-]{3,}$/;
            const cardNumberRegex = /^[0-9\s]{13,19}$/;
            const expiryDateRegex = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
            const cvcRegex = /^[0-9]{3,4}$/;
            
            let isValid = true;
            let errorMessage = 'Please fix the following issues:\n';
            
            if (!cardHolder || !cardHolderRegex.test(cardHolder)) {
                isValid = false;
                errorMessage += '- Enter a valid cardholder name\n';
                document.getElementById('card-holder').classList.add('is-invalid');
                document.getElementById('card-holder').classList.remove('is-valid');
            } else {
                document.getElementById('card-holder').classList.remove('is-invalid');
                document.getElementById('card-holder').classList.add('is-valid');
            }
            
            if (!cardNumber || !cardNumberRegex.test(cardNumber)) {
                isValid = false;
                errorMessage += '- Enter a valid card number\n';
                document.getElementById('card-number').classList.add('is-invalid');
                document.getElementById('card-number').classList.remove('is-valid');
            } else {
                // Check if card number has validation feedback indicating it's invalid
                const cardFeedback = document.getElementById('card-number').parentNode.querySelector('.validation-feedback');
                if (cardFeedback && cardFeedback.innerHTML.includes('text-danger')) {
                    isValid = false;
                    errorMessage += '- Card number is already in use or invalid\n';
                }
            }
            
            if (!expiryDate || !expiryDateRegex.test(expiryDate)) {
                isValid = false;
                errorMessage += '- Enter a valid expiry date (MM/YY)\n';
                document.getElementById('expiry-date').classList.add('is-invalid');
                document.getElementById('expiry-date').classList.remove('is-valid');
            } else {
                document.getElementById('expiry-date').classList.remove('is-invalid');
                document.getElementById('expiry-date').classList.add('is-valid');
            }
            
            if (!cvc || !cvcRegex.test(cvc)) {
                isValid = false;
                errorMessage += '- Enter a valid CVC (3-4 digits)\n';
                document.getElementById('cvc').classList.add('is-invalid');
                document.getElementById('cvc').classList.remove('is-valid');
            } else {
                document.getElementById('cvc').classList.remove('is-invalid');
                document.getElementById('cvc').classList.add('is-valid');
            }
            
            // Restore button state
            completePaymentBtn.disabled = false;
            completePaymentBtn.innerHTML = originalHtml;
            
            if (!isValid) {
                alert(errorMessage);
                return;
            }
            
            // Add seller type and payment info to form
            addUserTypeInput('seller');
            
            const subscriptionType = document.getElementById('yearly').checked ? 'yearly' : 'monthly';
            addHiddenInput('subscription', subscriptionType);
            addHiddenInput('payment_confirmed', 'true');
            
            // Show success alert
            const successAlert = document.getElementById('successAlert');
            successAlert.style.display = 'block';
            
            // Submit form after delay
            setTimeout(() => {
                document.getElementById('registerForm').submit();
            }, 2000);
        }

        function addUserTypeInput(type) {
            const existingInput = document.querySelector('input[name="user_type"]');
            if (existingInput) {
                existingInput.remove();
            }
            
            addHiddenInput('user_type', type);
        }

        function addHiddenInput(name, value) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = name;
            input.value = value;
            document.getElementById('registerForm').appendChild(input);
        }

        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + 'Icon') || document.getElementById('passwordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Add smooth focus transitions
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.form-control').forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-1px)';
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>
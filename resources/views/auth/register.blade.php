@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* احتفظ بنفس التنسيقات التي لديك */
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        .main-container {
            width: 900px; 
            margin: auto;
        }
        .signup-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 600px;
        }
        .signup-form {
            padding: 40px; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }
        .signup-header {
            text-align: center;
            margin-bottom: 30px;
            color: #2c3e50;
        }
        .signup-header h2 {
            font-size: 2rem; 
        }
        .form-control {
            height: 50px; 
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px 15px;
            font-size: 1rem;
        }
        .form-control:focus {
            border-color: #3498db;
            box-shadow: none;
        }
        .btn-signup {
            background-color: #3498db;
            border: none;
            color: white;
            padding: 12px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }
        .btn-signup:hover {
            background-color: #2980b9;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #7f8c8d;
            font-size: 1rem;
        }
        .login-link a {
            color: #3498db;
            text-decoration: none;
        }
        .terms-check {
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .image-section {
            background-image: url('images/signup.jpg');
            background-size: cover;
            background-position: center;
            height: 100%; 
        }
        @media (max-width: 992px) {
            .image-section {
                min-height: 300px;
                display: block;
                border-radius: 10px 10px 0 0;
            }
            .signup-form {
                padding: 30px;
            }
        }
        @media (max-width: 768px) {
            .image-section {
                display: none;
            }
            body {
                padding: 15px;
            }
            .signup-container {
                height: auto;
            }
        }
        .invalid-feedback {
            font-size: 0.85rem;
            margin-top: -5px;
            margin-bottom: 15px;
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container-fluid main-container">
        <div class="row g-0">
            <!-- Image Section -->
            <div class="col-lg-6 d-none d-lg-block">
                <div class="image-section"></div>
            </div>
            
            <!-- Form Section -->
            <div class="col-lg-6">
                <div class="signup-container">
                    <div class="signup-form">
                        <div class="signup-header">
                            <h2>{{ __('Register') }}</h2>
                        </div>
                        
                        <form method="POST" action="{{ route('register.post') }}" id="registerForm">
                            @csrf

                            <div class="mb-3">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                       placeholder="{{ __('Name') }}">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email"
                                       placeholder="{{ __('Email Address') }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
    <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" 
           name="phone" value="{{ old('phone') }}" required autocomplete="tel"
           placeholder="{{ __('Phone Number') }}">

    @error('phone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
                            
                            
                            <div class="mb-3">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password"
                                       placeholder="{{ __('Password') }}">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <input id="password-confirm" type="password" class="form-control" 
                                       name="password_confirmation" required autocomplete="new-password"
                                       placeholder="{{ __('Confirm Password') }}">
                            </div>
                            
                            <div class="form-check terms-check">
                                <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                <label class="form-check-label" for="termsCheck">
                                    I agree all statements in <a href="#">Terms of service</a>
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-signup">
                                {{ __('Register') }}
                            </button>
                        </form>
                        
                        <div class="login-link">
                            <p>I am already member <a href="{{ route('login') }}">{{ __('Sign in') }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery for AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $('#email').blur(function() {
                var email = $(this).val();
                if(email) {
                    $.ajax({
                        url: '/check-email',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            email: email
                        },
                        success: function(response) {
                            if(response.exists) {
                                $('#email').addClass('is-invalid');
                                $('#email').after('<span class="invalid-feedback" role="alert"><strong>This email is already registered</strong></span>');
                            } else {
                                $('#email').removeClass('is-invalid');
                                $('.invalid-feedback').remove();
                            }
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
@endsection
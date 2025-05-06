@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        
        .container-wrapper {
            display: flex;
            width: 900px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .login-container {
            background: white;
            width: 50%;
            padding: 40px;
        }
        
        .image-container {
            width: 50%;
            background-image: url('images/signin.jpg');
            background-size: cover;
            background-position: center;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .login-header h2 {
            color: #333;
            font-weight: 600;
        }
        
        .form-control {
            height: 45px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px 15px;
        }
        
        .form-control:focus {
            border-color: #4e73df;
            box-shadow: none;
        }
        
        .btn-login {
            background-color: #4e73df;
            border: none;
            color: white;
            padding: 12px;
            width: 100%;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
        }
        
        .btn-login:hover {
            background-color: #3a5bd9;
        }
        
        .signup-option {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        
        .signup-option a {
            color: #4e73df;
            text-decoration: none;
            font-weight: 500;
        }
        
        .forgot-password {
            text-align: right;
            margin-bottom: 15px;
        }
        
        .forgot-password a {
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }
        
        .forgot-password a:hover {
            color: #4e73df;
        }
        
        .social-login {
            margin-top: 25px;
            text-align: center;
        }
        
        .social-login p {
            color: #666;
            margin-bottom: 15px;
            position: relative;
        }
        
        .social-login p::before,
        .social-login p::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #ddd;
            margin: auto 10px;
        }
        
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .social-icon:hover {
            transform: translateY(-3px);
        }
        
        .facebook {
            background-color: #3b5998;
        }
        
        .twitter {
            background-color: #1da1f2;
        }
        
        .google {
            background-color: #db4437;
        }

        .remember-me {
            margin-bottom: 15px;
        }

        .remember-me label {
            margin-left: 5px;
            color: #666;
        }

        @media (max-width: 768px) {
            .container-wrapper {
                flex-direction: column;
                width: 100%;
                max-width: 400px;
            }
            
            .login-container, 
            .image-container {
                width: 100%;
            }
            
            .image-container {
                height: 200px;
                order: -1;
            }
        }
    </style>
</head>
<body>
    <div class="container-wrapper">
        <div class="login-container">
            <div class="login-header">
                <h2>{{ __('Login') }}</h2>
            </div>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                           placeholder="{{ __('Email Address') }}">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                           name="password" required autocomplete="current-password" placeholder="{{ __('Password') }}">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                <div class="remember-me d-flex align-items-center">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
                
                <div class="forgot-password">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
                
                <button type="submit" class="btn btn-login" href="{{ route('home') }}">
                    {{ __('Login') }}
                </button>
            </form>
            
            <div class="signup-option">
                <p>Don't have an account? <a href="{{ route('register') }}">{{ __('Sign Up') }}</a></p>
            </div>
            
            <div class="social-login">
                <p>Or login with</p>
                <div class="social-icons">
                    <a href="#" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon google"><i class="fab fa-google"></i></a>
                </div>
            </div>
        </div>
        
        <div class="image-container"></div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
@endsection
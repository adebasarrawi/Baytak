<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="author" content="Untree.co" />
  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap5" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="auth-check" content="{{ auth()->check() ? 'true' : 'false' }}">

  <title>@yield('title')</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('favicon.png') }}" />

  <!-- Fonts and CSS Files -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('fonts/icomoon/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('fonts/flaticon/font/flaticon.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/tiny-slider.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/aos.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

  <!-- Navbar -->
  @include('layouts.public._navbar')

  <!-- Page Content -->
  <main>
    @yield('content')
  </main>

  <!-- Footer -->
  @include('layouts.public._footer')

  <!-- Loader -->
  <div id="overlayer"></div>
  <div class="loader">
    <div class="spinner-border" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <!-- Login Popup -->
  <div class="login-popup" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); justify-content: center; align-items: center; z-index: 9999;">
    <div class="popup-content" style="background: white; padding: 20px; border-radius: 8px; text-align: center;">
      <h3 style="margin-bottom: 15px;">Please Login</h3>
      <p style="margin-bottom: 20px;">You need to be logged in to add properties to your wishlist.</p>
      <div style="display: flex; gap: 10px; justify-content: center;">
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
        <button onclick="closeLoginPopup()" class="btn btn-outline-secondary">Cancel</button>
      </div>
    </div>
  </div>

  <!-- JS Files -->
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/tiny-slider.js') }}"></script>
  <script src="{{ asset('js/aos.js') }}"></script>
  <script src="{{ asset('js/navbar.js') }}"></script>
  <script src="{{ asset('js/counter.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
@stack('scripts')
</body>
</html>

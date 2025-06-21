<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="author" content="Untree.co" />
  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap5" />
  <meta name="auth-check" content="{{ auth()->check() ? 'true' : 'false' }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  
  <!-- Toastr CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  
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
      <p style="margin-bottom: 20px;">You need to be logged in to access this feature.</p>
      <div style="display: flex; gap: 10px; justify-content: center;">
        <a href="{{ route('login') }}?redirect={{ urlencode(url()->current()) }}" class="btn btn-primary">Login</a>
        <a href="{{ route('register') }}" class="btn btn-secondary">Register</a>
        <button onclick="closeLoginPopup()" class="btn btn-outline-secondary">Cancel</button>
      </div>
    </div>
  </div>

  <!-- Messaging Modal -->
  <div class="modal fade" id="messagingModal" tabindex="-1" aria-labelledby="messagingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="messagingModalLabel"><i class="fas fa-envelope me-2"></i> Send Message</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="quickMessageForm" action="{{ route('messages.store') }}" method="POST">
          @csrf
          <input type="hidden" name="receiver_id" id="quickMessageReceiverId">
          <input type="hidden" name="property_id" id="quickMessagePropertyId">
          <div class="modal-body">
            <div class="mb-3">
              <label for="quickMessageText" class="form-label">Your Message</label>
              <textarea class="form-control" id="quickMessageText" name="message" rows="4" placeholder="Type your message here..." required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i> Send Message</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- JS Files -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/tiny-slider.js') }}"></script>
  <script src="{{ asset('js/aos.js') }}"></script>
  <script src="{{ asset('js/navbar.js') }}"></script>
  <script src="{{ asset('js/counter.js') }}"></script>
  <script src="{{ asset('js/custom.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  
  <script>
    // Show/Hide login popup
    function showLoginPopup() {
      document.querySelector('.login-popup').style.display = 'flex';
    }
    
    function closeLoginPopup() {
      document.querySelector('.login-popup').style.display = 'none';
    }
    
    // Set CSRF token for AJAX requests
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    
    // Quick messaging functions
    function openMessageModal(receiverId, propertyId) {
      const isLoggedIn = $('meta[name="auth-check"]').attr('content') === 'true';
      
      if (!isLoggedIn) {
        showLoginPopup();
        return;
      }
      
      $('#quickMessageReceiverId').val(receiverId);
      $('#quickMessagePropertyId').val(propertyId);
      $('#messagingModal').modal('show');
    }
    
    // Handle quick message form submission
    $(document).ready(function() {
      $('#quickMessageForm').on('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = $(this).find('button[type="submit"]');
        const originalBtnText = submitBtn.html();
        
        // Show loading state
        submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i> Sending...').prop('disabled', true);
        
        $.ajax({
          url: $(this).attr('action'),
          method: 'POST',
          data: $(this).serialize(),
          success: function(response) {
            $('#messagingModal').modal('hide');
            $('#quickMessageText').val('');
            
            toastr.success('Message sent successfully!');
          },
          error: function(xhr) {
            toastr.error('Error sending message. Please try again.');
          },
          complete: function() {
            // Reset button state
            submitBtn.html(originalBtnText).prop('disabled', false);
          }
        });
      });
      
      // Initialize toastr options
      toastr.options = {
        "closeButton": true,
        "positionClass": "toast-top-right",
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000"
      };
    });
  </script>
  
  @stack('scripts')
</body>
</html>
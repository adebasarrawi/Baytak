<!-- navigation.blade.php -->
<nav class="site-nav">
  <div class="container">
    <div class="menu-bg-wrap">
      <div class="site-navigation">
        <a href="{{ url('/') }}" class="logo m-0 float-start position-relative d-inline-block text-decoration-none" style="width: 60px; height: 50px;">
          <img src="{{ asset('images/logo.png') }}" alt="Logo" class="img-fluid w-100 h-100 mt-2">
          <span class="position-absolute top-0 m start-50 translate-middle-x text-white fw-bold" style="font-size: 25px; margin-left: 60px; margin-top: 12px; color:rgb(208, 221, 235) !important ;">Baytak</span>
        </a>

        <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu float-end pt-2">
          <li><a href="{{ url('/') }}">Home</a></li>
          <li><a href="{{ url('/properties') }}">Properties</a></li>
          <li><a href="{{ url('/services') }}">Services</a></li>
          <li><a href="{{ url('/about') }}">About</a></li>
          <li><a href="{{ url('/contact') }}">Contact Us</a></li>
          <li><a href="{{ url('/seller-register') }}">Register</a></li>

          
          @guest
            <!-- Show these items only for guests (not logged in) -->
            <li><a href="{{ url('/login') }}">Login</a></li>
          @else
            <!-- Show these items only for authenticated users -->
            <li><a href="{{ url('/profile') }}">Profile</a></li>
            <li>
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </li>
          @endguest
        </ul>

        <a href="#" class="burger light me-auto float-end mt-1 site-menu-toggle js-menu-toggle d-inline-block d-lg-none">
          <span></span>
        </a>
      </div>
    </div>
  </div>
</nav>

<!-- Add this script to make the mobile menu work with the authentication-aware links -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Clone the navigation for mobile view
    const mobileNav = document.querySelector('.site-menu-toggle');
    
    if (mobileNav) {
      mobileNav.addEventListener('click', function(e) {
        e.preventDefault();
        document.body.classList.toggle('offcanvas-menu');
      });
    }
  });
</script>
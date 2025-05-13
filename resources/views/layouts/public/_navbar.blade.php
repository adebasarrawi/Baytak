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
          <li><a href="{{ url('/property-estimation') }}">Estimate Your Property</a></li>
          <li><a href="{{ url('/about') }}">About</a></li>
          <li><a href="{{ url('/contact') }}">Contact Us</a></li>
          
          <!-- Profile dropdown for all users (guests and authenticated) -->
          <li class="has-children">
            <a href="#" class="user-profile-link">
              <i class="fas fa-user-circle fa-lg"></i>
            </a>
            <ul class="dropdown">
              @guest
                <!-- Show these items only for guests (not logged in) -->
                <li><a href="{{ url('/login') }}">Login</a></li>
                <li><a href="{{ url('/register') }}">Register</a></li>
              @else
                <!-- Show these items only for authenticated users -->
                <li><a href="{{ url('/profile') }}">My Profile</a></li>
                @if(Auth::user()->user_type === 'seller')
                  <li><a href="{{ url('/properties/my') }}">My Properties</a></li>
                @endif
                <li><a href="{{ url('/favorites') }}">Favorites</a></li>
                <li><a href="{{ url('/my-appraisals') }}">My Appraisals</a></li>
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
          </li>
        </ul>

        <a href="#" class="burger light me-auto float-end mt-1 site-menu-toggle js-menu-toggle d-inline-block d-lg-none">
          <span></span>
        </a>
      </div>
    </div>
  </div>
</nav>

<!-- Add this script to make the mobile menu and dropdown work -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Handle desktop dropdown toggle
    const dropdownLinks = document.querySelectorAll('.has-children > a');
    dropdownLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        this.parentNode.classList.toggle('active');
      });
    });
    
    // Handle mobile menu toggle
    const mobileNav = document.querySelector('.site-menu-toggle');
    if (mobileNav) {
      mobileNav.addEventListener('click', function(e) {
        e.preventDefault();
        document.body.classList.toggle('offcanvas-menu');
      });
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
      const isClickInsideDropdown = event.target.closest('.has-children');
      if (!isClickInsideDropdown) {
        document.querySelectorAll('.has-children').forEach(item => {
          item.classList.remove('active');
        });
      }
    });
  });
</script>

<style>
/* Dropdown styling */
.site-menu .has-children {
  position: relative;
}

.site-menu .has-children > a {
  padding-right: 20px;
}

/* Remove the down arrow for the user profile link */
.site-menu .has-children.user-profile > a:after {
  display: none;
}

.site-menu .has-children .dropdown {
  position: absolute;
  right: 0;
  top: 100%;
  min-width: 200px;
  background-color: #fff;
  border-radius: 4px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
  opacity: 0;
  visibility: hidden;
  transition: 0.2s;
  z-index: 99;
  padding: 10px 0;
}

.site-menu .has-children.active > .dropdown {
  opacity: 1;
  visibility: visible;
}

.site-menu .has-children .dropdown li {
  display: block;
  margin: 0;
  padding: 0;
  border-bottom: 1px solid #eee;
}

.site-menu .has-children .dropdown li:last-child {
  border-bottom: none;
}

.site-menu .has-children .dropdown a {
  display: block;
  padding: 10px 15px;
  color: #333;
  transition: 0.2s;
}

.site-menu .has-children .dropdown a:hover {
  background-color: #f8f9fa;
  color: var(--bs-primary);
}

/* Style for user icon */
.user-profile-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  transition: 0.3s;
}

.user-profile-link:hover {
  color: rgba(255, 255, 255, 0.8);
}

/* Mobile menu adjustments */
@media (max-width: 991.98px) {
  .site-menu .has-children .dropdown {
    position: static;
    opacity: 1;
    visibility: visible;
    box-shadow: none;
    background-color: transparent;
    padding-left: 20px;
    display: none;
    padding: 0;
  }
  
  .site-menu .has-children.active > .dropdown {
    display: block;
  }
  
  .site-menu .has-children .dropdown a {
    color: #fff;
    padding: 8px 15px;
  }
  
  .site-menu .has-children .dropdown a:hover {
    background-color: transparent;
    color: rgba(255, 255, 255, 0.8);
  }
  
  .site-menu .has-children .dropdown li {
    border-bottom: none;
  }
}
</style>
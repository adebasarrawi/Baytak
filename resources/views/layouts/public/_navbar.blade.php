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
          
          @auth
            <!-- Messages Icon -->
            <li>
              <a href="{{ route('messages.index') }}" class="nav-icon-link" title="Messages">
                <i class="fas fa-envelope"></i>
                @php
                  $unreadCount = Auth::user()->receivedMessages()->where('is_read', false)->count();
                @endphp
                @if($unreadCount > 0)
                  <span class="nav-badge bg-danger">{{ $unreadCount }}</span>
                @endif
              </a>
            </li>
            
            <!-- Favorites Icon -->
            <li>
              <a href="{{ url('/favorites') }}" class="nav-icon-link" title="Favorites">
                <i class="fas fa-heart"></i>
                @php
                  $favoriteCount = Auth::user()->favorites()->count();
                @endphp
                @if($favoriteCount > 0)
                  <span class="nav-badge bg-primary">{{ $favoriteCount }}</span>
                @endif
              </a>
            </li>
          @endauth
          
          <!-- Profile dropdown -->
          <li class="has-children">
            <a href="#" class="user-profile-link">
              <i class="fas fa-user-circle fa-lg"></i>
            </a>
            <ul class="dropdown">
              @guest
                <li><a href="{{ url('/login') }}">Login</a></li>
                <li><a href="{{ url('/register') }}">Register</a></li>
              @else
                <li><a href="{{ url('/profile') }}">My Profile</a></li>
                @if(Auth::user()->user_type === 'seller')
                  <li><a href="{{ route('properties.my') }}">My Properties</a></li>
                @endif
                <li class="d-lg-none">
                  <a href="{{ route('messages.index') }}">
                    Messages
                    @php
                      $unreadCount = Auth::user()->receivedMessages()->where('is_read', false)->count();
                    @endphp
                    @if($unreadCount > 0)
                      <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                    @endif
                  </a>
                </li>
                <li class="d-lg-none"><a href="{{ url('/favorites') }}">Favorites</a></li>
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
/* Navigation Icon Links */
.nav-icon-link {
  display: inline-flex !important;
  align-items: center;
  justify-content: center;
  color: #fff !important;
  transition: all 0.3s ease;
  padding: 10px 12px !important;
  border-radius: 50%;
  position: relative;
  text-decoration: none !important;
  margin: 0 2px;
}

.nav-icon-link:hover {
  color: #3b82f6 !important;
  background: rgba(255, 255, 255, 0.15);
  transform: translateY(-2px);
  text-decoration: none !important;
}

.nav-icon-link i {
  font-size: 1.25rem;
  transition: all 0.3s ease;
}

.nav-icon-link:hover i {
  transform: scale(1.15);
}

/* Special styling for heart icon */
.nav-icon-link i.fa-heart {
  color: #ff6b6b !important;
}

.nav-icon-link:hover i.fa-heart {
  color: #ff5252 !important;
}

/* Message icon styling */
.nav-icon-link i.fa-envelope {
  color: #ffffff !important;
}

.nav-icon-link:hover i.fa-envelope {
  color: #3b82f6 !important;
}

/* Badge styling */
.nav-badge {
  position: absolute;
  top: -2px;
  right: -2px;
  font-size: 0.65rem !important;
  min-width: 18px;
  height: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0 4px;
  border-radius: 50%;
  font-weight: 600;
  box-shadow: 0 2px 6px rgba(0,0,0,0.25);
  border: 2px solid rgba(255,255,255,0.8);
  animation: pulse 2s infinite;
}

/* Pulse animation for badges */
@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.1); }
  100% { transform: scale(1); }
}

/* User profile icon */
.user-profile-link {
  display: inline-flex !important;
  align-items: center;
  justify-content: center;
  color: #fff !important;
  transition: all 0.3s ease;
  padding: 8px 12px !important;
  border-radius: 50%;
  text-decoration: none !important;
  margin-left: 8px;
}

.user-profile-link:hover {
  color: #3b82f6 !important;
  background: rgba(255, 255, 255, 0.15);
  transform: translateY(-2px);
  text-decoration: none !important;
}

.user-profile-link i {
  font-size: 1.4rem;
  transition: all 0.3s ease;
}

.user-profile-link:hover i {
  transform: scale(1.1);
}

/* User profile icon */
.user-profile-link {
  display: inline-flex !important;
  align-items: center;
  justify-content: center;
  color: #fff !important;
  transition: all 0.3s ease;
  padding: 8px 12px !important;
  border-radius: 50%;
  text-decoration: none !important;
  margin-left: 8px;
}

.user-profile-link:hover {
  color: #3b82f6 !important;
  background: rgba(255, 255, 255, 0.15);
  transform: translateY(-2px);
  text-decoration: none !important;
}

.user-profile-link i {
  font-size: 1.4rem;
  transition: all 0.3s ease;
}

.user-profile-link:hover i {
  transform: scale(1.1);
}

/* Dropdown styling */
.site-menu .has-children {
  position: relative;
}

.site-menu .has-children > a {
  padding-right: 0 !important;
}

.site-menu .has-children .dropdown {
  position: absolute;
  right: 0;
  top: 100%;
  min-width: 220px;
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: 999;
  padding: 8px 0;
  border: 1px solid rgba(0,0,0,0.08);
  margin-top: 8px;
}

.site-menu .has-children.active > .dropdown {
  opacity: 1;
  visibility: visible;
  transform: translateY(3px);
}

.site-menu .has-children .dropdown li {
  display: block;
  margin: 0;
  padding: 0;
}

.site-menu .has-children .dropdown a {
  display: block;
  padding: 12px 20px;
  color: #333;
  transition: all 0.3s ease;
  font-weight: 500;
  font-size: 0.95rem;
  text-decoration: none;
  border-left: 3px solid transparent;
}

.site-menu .has-children .dropdown a:hover {
  background-color: #f8f9fc;
  color: #3b82f6;
  border-left-color: #3b82f6;
  padding-left: 25px;
}

/* Mobile menu adjustments */
@media (max-width: 991.98px) {
  .site-menu .has-children .dropdown {
    position: static;
    opacity: 1;
    visibility: visible;
    box-shadow: none;
    background-color: transparent;
    padding: 0;
    display: none;
    transform: none;
    border: none;
    margin-top: 0;
  }
  
  .site-menu .has-children.active > .dropdown {
    display: block;
    padding-left: 20px;
  }
  
  .site-menu .has-children .dropdown a {
    color: #fff;
    padding: 10px 15px;
    border-left: none;
  }
  
  .site-menu .has-children .dropdown a:hover {
    background-color: transparent;
    color: rgba(255, 255, 255, 0.8);
    padding-left: 15px;
  }
  
  /* Show mobile-only menu items */
  .d-lg-none {
    display: block !important;
  }
  
  /* Hide icon links on mobile */
  .nav-icon-link {
    display: none !important;
  }
}

@media (min-width: 992px) {
  /* Hide mobile-only menu items on desktop */
  .d-lg-none {
    display: none !important;
  }
}

/* Tooltip effect */
.nav-icon-link {
  position: relative;
}

.nav-icon-link::after {
  content: attr(title);
  position: absolute;
  bottom: -35px;
  left: 50%;
  transform: translateX(-50%);
  background: rgba(0,0,0,0.8);
  color: white;
  padding: 6px 10px;
  border-radius: 6px;
  font-size: 0.75rem;
  white-space: nowrap;
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: 1000;
}

.nav-icon-link::before {
  content: '';
  position: absolute;
  bottom: -15px;
  left: 50%;
  transform: translateX(-50%);
  border: 5px solid transparent;
  border-bottom-color: rgba(0,0,0,0.8);
  opacity: 0;
  visibility: hidden;
  transition: all 0.3s ease;
  z-index: 1000;
}

.nav-icon-link:hover::after,
.nav-icon-link:hover::before {
  opacity: 1;
  visibility: visible;
}
</style>
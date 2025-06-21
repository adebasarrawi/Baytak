<!-- Sidebar -->
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                   
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ auth()->user()->name }}
                            <span class="user-level">{{ ucfirst(auth()->user()->user_type) }}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="{{ route('profile') }}">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.dashboard') }}">
                                    <span class="link-collapse">Settings</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <span class="link-collapse">Logout</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <ul class="nav nav-primary">
                <!-- Dashboard Menu Item -->
                         
<li class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
    <a href="{{ route('admin.reports.index') }}">
        <i class="fas fa-chart-bar"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
              


                <!-- User Management Menu Item -->
                <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i>
                        <p>User Management</p>
                    </a>
                </li>

                <!-- Properties Menu Item -->
                <li class="nav-item {{ request()->is('admin/properties*') ? 'active' : '' }}">
                    <a href="{{ route('admin.properties.index') }}">
                        <i class="fas fa-home text-success"></i>
                        <p>Properties</p>
                    </a>
                </li>

              

                <!-- Appraisals Main Menu Item -->
                <li class="nav-item {{ request()->is('admin/appraisals*') ? 'active' : '' }}">
                    <a href="{{ route('admin.appraisals.index') }}">
                        <i class="fas fa-clipboard-check text-blue"></i>
                        <p>Appraisals</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('admin.areas.*') ? 'active' : '' }}">
    <a href="{{ route('admin.areas.index') }}">
        <i class="fas fa-map-marker-alt"></i>
        <p>Areas Management</p>
    </a>
</li>

  <!-- Testimonials Menu Item -->
  <li class="nav-item {{ request()->is('admin/testimonials*') ? 'active' : '' }}">
                    <a href="{{ route('admin.testimonials.index') }}">
                        <i class="fas fa-comments fa-fw"></i>
                        <p>Testimonials</p>
                    </a>
                </li>

              


             


             
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
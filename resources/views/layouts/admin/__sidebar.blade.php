<!-- Sidebar -->
<div class="sidebar sidebar-style-2">
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <div class="user">
                <div class="avatar-sm float-left mr-2">
                    <img src="{{ asset('assets/img/profile.jpg') }}" alt="Profile Image" class="avatar-img rounded-circle">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            Admin User
                            <span class="user-level">Administrator</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="{{ route('admin.dashboard') }}">
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
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
<!-- لعقارات -->
<li class="nav-item {{ request()->is('admin/properties*') ? 'active' : '' }}">
    <a href="{{ route('admin.properties.index') }}">
        <i class="fas fa-home text-success"></i>
        <p>Properties</p>
    </a>
</li>

<!-- للحجوزات -->
<li class="nav-item {{ request()->is('admin/appraisals*') ? 'active' : '' }}">
    <a href="{{ route('admin.appraisals.index') }}">
        <i class="fas fa-clipboard-check text-blue"></i>
        <p>Appraisals</p>
    </a>
</li>

                <!-- Appraisals Sub-Menu Items - تمت إضافتها كعناصر منفصلة -->
                <li class="nav-item pl-3 
                    {{ request()->routeIs('admin.appraisals.index') && !request()->has('status') ? 'active' : '' }}">
                    <a href="{{ route('admin.appraisals.index') }}">
                        <i class="fas fa-list-alt"></i>
                        <p>All Appraisals</p>
                    </a>
                </li>

                <li class="nav-item pl-3 
                    {{ request()->routeIs('admin.appraisals.calendar') ? 'active' : '' }}">
                    <a href="{{ route('admin.appraisals.calendar') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <p>Calendar</p>
                    </a>
                </li>

                <li class="nav-item pl-3 
                    {{ request()->routeIs('admin.appraisals.create') ? 'active' : '' }}">
                    <a href="{{ route('admin.appraisals.create') }}">
                        <i class="fas fa-plus-circle"></i>
                        <p>Create New</p>
                    </a>
                </li>

                <li class="nav-item pl-3 
                    {{ request()->routeIs('admin.appraisals.index') && request()->get('status') == 'pending' ? 'active' : '' }}">
                    <a href="{{ route('admin.appraisals.index', ['status' => 'pending']) }}">
                        <i class="fas fa-clock text-warning"></i>
                        <p>Pending</p>
                    </a>
                </li>

                <li class="nav-item pl-3 
                    {{ request()->routeIs('admin.appraisals.index') && request()->get('status') == 'completed' ? 'active' : '' }}">
                    <a href="{{ route('admin.appraisals.index', ['status' => 'completed']) }}">
                        <i class="fas fa-check-circle text-success"></i>
                        <p>Completed</p>
                    </a>
                </li>

                

        
                <!-- Users Menu Item -->
                <li class="nav-item {{ request()->is('*users*') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-users text-warning"></i>
                        <p>Users</p>
                    </a>
                </li>

                <!-- Settings Menu Item -->
                <li class="nav-item {{ request()->is('*settings*') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-cog"></i>
                        <p>Settings</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
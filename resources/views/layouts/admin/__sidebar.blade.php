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
                                <a href="#profile">
                                    <span class="link-collapse">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="#settings">
                                    <span class="link-collapse">Settings</span>
                                </a>
                            </li>
                            <li>
                                <a href="#logout">
                                    <span class="link-collapse">Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav nav-primary">
                <li class="nav-item {{ request()->is('dashboard*') ? 'active' : '' }}">
                    <a href="/dashboard">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Appraisals Menu Item -->
                <li class="nav-item {{ request()->is('*appraisals*') ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#appraisals" class="{{ !request()->is('*appraisals*') ? 'collapsed' : '' }}" aria-expanded="{{ request()->is('*appraisals*') ? 'true' : 'false' }}">
                        <i class="fas fa-clipboard-check text-blue"></i>
                        <p>Appraisals</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->is('*appraisals*') ? 'show' : '' }}" id="appraisals">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->is('*appraisals') && !request()->query() ? 'active' : '' }}">
                                <a href="{{ route('admin.appraisals.index') }}">
                                    <span class="sub-item">Appraisals List</span>
                                    <span class="badge badge-info">20</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('*appraisals/calendar') ? 'active' : '' }}">
                                <a href="{{ route('admin.appraisals.calendar') }}">
                                    <span class="sub-item">Calendar</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('*appraisals/create') ? 'active' : '' }}">
                                <a href="{{ route('admin.appraisals.create') }}">
                                    <span class="sub-item">Create New</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('*appraisals') && request()->query('status') == 'pending' ? 'active' : '' }}">
                                <a href="{{ route('admin.appraisals.index', ['status' => 'pending']) }}">
                                    <span class="sub-item">Pending</span>
                                    <span class="badge badge-warning">10</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('*appraisals') && request()->query('status') == 'completed' ? 'active' : '' }}">
                                <a href="{{ route('admin.appraisals.index', ['status' => 'completed']) }}">
                                    <span class="sub-item">Completed</span>
                                    <span class="badge badge-success">8</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Properties Menu Item -->
                <li class="nav-item {{ request()->is('*properties*') ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#properties" class="{{ !request()->is('*properties*') ? 'collapsed' : '' }}">
                        <i class="fas fa-home text-success"></i>
                        <p>Properties</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->is('*properties*') ? 'show' : '' }}" id="properties">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->is('*properties') ? 'active' : '' }}">
                                <a href="#properties-list">
                                    <span class="sub-item">All Properties</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('*properties/create') ? 'active' : '' }}">
                                <a href="#properties-create">
                                    <span class="sub-item">Add Property</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <!-- Users Menu Item -->
                <li class="nav-item {{ request()->is('*users*') ? 'active' : '' }}">
                    <a data-toggle="collapse" href="#users" class="{{ !request()->is('*users*') ? 'collapsed' : '' }}">
                        <i class="fas fa-users text-warning"></i>
                        <p>Users</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->is('*users*') ? 'show' : '' }}" id="users">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->is('*users') ? 'active' : '' }}">
                                <a href="#users-list">
                                    <span class="sub-item">User List</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('*users/create') ? 'active' : '' }}">
                                <a href="#users-create">
                                    <span class="sub-item">Add User</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
                <!-- Settings Menu Item -->
                <li class="nav-item {{ request()->is('*settings*') ? 'active' : '' }}">
                    <a href="#settings">
                        <i class="fas fa-cog"></i>
                        <p>Settings</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
@extends('layouts.public.app')

@section('title', 'My Profile')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
    line-height: 1.6;
    color: #2c3e50;
    background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
}

.custom-hero {
    background:linear-gradient(to right, #1a1c20, #2c3e50);

    padding: 120px 0 80px;
    position: relative;
    overflow: hidden;
}

.custom-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -20%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    z-index: 1;
}

.custom-hero::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -10%;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50%;
    z-index: 1;
}

.hero-content {
    position: relative;
    z-index: 2;
    color: white;
}

.hero-title {
    font-size: 40px;
    font-weight: 700;
    margin-bottom: 20px;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    letter-spacing: -0.02em;
}

.hero-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 30px;
    font-weight: 300;
}

.custom-breadcrumb {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 50px;
    padding: 12px 30px;
    display: inline-flex;
    align-items: center;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.custom-breadcrumb .breadcrumb {
    margin: 0;
    padding: 0;
    background: none;
}

.custom-breadcrumb .breadcrumb-item {
    font-size: 0.9rem;
    font-weight: 500;
}

.custom-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: rgba(255, 255, 255, 0.6);
    font-weight: 600;
}

.custom-breadcrumb .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.2s ease;
}

.custom-breadcrumb .breadcrumb-item a:hover {
    color: white;
    text-decoration: underline;
}

.custom-breadcrumb .breadcrumb-item.active {
    color: rgba(255, 255, 255, 0.7);
}

.hero-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 25px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    animation: float 3s ease-in-out infinite;
}

.hero-icon i {
    font-size: 2rem;
    color: white;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.fade-up {
    animation: fadeInUp 0.8s ease-out;
}

.fade-up.delay-1 {
    animation-delay: 0.2s;
    animation-fill-mode: both;
}

.fade-up.delay-2 {
    animation-delay: 0.4s;
    animation-fill-mode: both;
}

.profile-section {
    padding: 50px 0;
    background: linear-gradient(135deg, #f1f5f9 0%, #ffffff 100%);
}

.profile-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.sidebar-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    margin-bottom: 30px;
    transition: all 0.3s ease;
}

.sidebar-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.profile-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 4px solid #3b82f6;
    object-fit: cover;
    margin-bottom: 20px;
    transition: all 0.3s ease;
}

.profile-avatar:hover {
    transform: scale(1.05);
    border-color: #2563eb;
}

.profile-name {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 5px;
}

.profile-email {
    color: #6b7280;
    font-size: 0.9rem;
    margin-bottom: 15px;
}

.badge-seller {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 20px;
    display: inline-block;
}

.nav-menu {
    list-style: none;
    padding: 0;
    margin: 0;
}

.nav-item {
    margin-bottom: 8px;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 12px 16px;
    color: #374151;
    text-decoration: none;
    border-radius: 12px;
    transition: all 0.2s ease;
    font-size: 0.95rem;
    font-weight: 500;
}

.nav-link:hover {
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    color: #1f2937;
    text-decoration: none;
    transform: translateX(5px);
}

.nav-link.active {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.nav-link.text-danger:hover {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
    color: #dc2626;
}

.nav-link i {
    width: 20px;
    margin-right: 10px;
}

.info-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    margin-bottom: 30px;
}

.info-card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    margin: -30px -30px 25px -30px;
    padding: 20px 30px;
    border-bottom: 1px solid #e5e7eb;
    border-radius: 20px 20px 0 0;
}

.info-card-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.info-row {
    display: flex;
    padding: 15px 0;
    border-bottom: 1px solid #f3f4f6;
}

.info-row:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-label {
    flex: 0 0 30%;
    color: #6b7280;
    font-weight: 600;
    font-size: 0.9rem;
}

.info-value {
    flex: 1;
    color: #1f2937;
    font-size: 0.95rem;
}

.badge-status {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
}

.badge-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.badge-secondary {
    background: linear-gradient(135deg, #6b7280, #4b5563);
    color: white;
}

.btn-edit {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
    border-radius: 12px;
    color: white;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-edit:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    transform: translateY(-2px);
    color: white;
    text-decoration: none;
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
}

.stats-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    text-align: center;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    transition: all 0.3s ease;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.stats-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
}

.stats-icon.primary {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
}

.stats-icon.danger {
    background: linear-gradient(135deg, #fef2f2, #fee2e2);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 10px;
}

.stats-label {
    color: #6b7280;
    font-size: 0.95rem;
    font-weight: 500;
    margin-bottom: 15px;
}

.btn-stats {
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    border: 1px solid #d1d5db;
    color: #374151;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 0.85rem;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-stats:hover {
    background: linear-gradient(135deg, #e5e7eb, #d1d5db);
    color: #1f2937;
    text-decoration: none;
}

.success-alert {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    border: none;
    border-radius: 15px;
    padding: 15px 20px;
    margin-bottom: 25px;
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    animation: slideInDown 0.5s ease-out;
}

@keyframes slideInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.success-alert .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

/* Responsive Design */
@media (max-width: 991.98px) {
    .profile-section {
        padding: 30px 0;
    }
    
    .custom-hero {
        padding: 100px 0 60px;
    }
    
    .hero-title {
        font-size: 2.5rem;
    }
    
    .sidebar-card {
        margin-bottom: 20px;
    }
    
    .info-card {
        padding: 25px;
    }
    
    .info-card-header {
        margin: -25px -25px 20px -25px;
        padding: 15px 25px;
    }
}

@media (max-width: 767.98px) {
    .custom-hero {
        padding: 80px 0 50px;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-icon {
        width: 60px;
        height: 60px;
        margin-bottom: 15px;
    }
    
    .hero-icon i {
        font-size: 1.5rem;
    }
    
    .custom-breadcrumb {
        padding: 10px 20px;
        font-size: 0.85rem;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
    }
    
    .sidebar-card {
        padding: 20px;
    }
    
    .info-card {
        padding: 20px;
    }
    
    .info-card-header {
        margin: -20px -20px 15px -20px;
        padding: 15px 20px;
    }
    
    .info-row {
        flex-direction: column;
        gap: 5px;
    }
    
    .info-label {
        flex: none;
        font-size: 0.85rem;
    }
    
    .stats-card {
        padding: 20px;
    }
    
    .stats-icon {
        width: 60px;
        height: 60px;
        margin-bottom: 15px;
    }
    
    .stats-number {
        font-size: 2rem;
    }
}

@media (max-width: 576px) {
    .custom-hero {
        padding: 60px 0 40px;
    }
    
    .hero-title {
        font-size: 1.8rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .custom-breadcrumb {
        padding: 8px 16px;
        font-size: 0.8rem;
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
    }
    
    .profile-name {
        font-size: 1.3rem;
    }
    
    .sidebar-card {
        padding: 15px;
    }
    
    .info-card {
        padding: 15px;
    }
    
    .info-card-header {
        margin: -15px -15px 15px -15px;
        padding: 12px 15px;
    }
    
    .stats-card {
        padding: 15px;
    }
}

.fade-in {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease;
}

.fade-in.visible {
    opacity: 1;
    transform: translateY(0);
}
</style>

<!-- Hero Section -->
<div class="custom-hero">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <div class="hero-content">
                    
                    <h1 class="hero-title fade-up delay-1" style="margin-top: 50px">My Profile</h1>
                    <p class="hero-subtitle fade-up delay-2">Manage your account settings and preferences</p>
                    <nav aria-label="breadcrumb" class="fade-up delay-2">
                     
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Profile Section -->
<div class="profile-section">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-4 mb-4">
                <div class="sidebar-card fade-in">
                    <div class="text-center">
                        @if(Auth::user()->profile_image)
                            <img src="{{ asset('storage/'.Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}" class="profile-avatar">
                        @else
                            <img src="{{ asset('images/default-avatar.jpg') }}" alt="{{ Auth::user()->name }}" class="profile-avatar">
                        @endif
                        <h4 class="profile-name">{{ Auth::user()->name }}</h4>
                        <p class="profile-email">{{ Auth::user()->email }}</p>
                        @if(Auth::user()->user_type === 'seller')
                            <div class="badge-seller">Seller Account</div>
                        @endif
                    </div>
                    
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="{{ route('profile') }}" class="nav-link active">
                                <i class="fas fa-user"></i> Account Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('profile.edit') }}" class="nav-link">
                                <i class="fas fa-edit"></i> Edit Profile
                            </a>
                        </li>
                        @if(Auth::user()->user_type === 'seller')
                            <li class="nav-item">
                                <a href="{{ route('properties.my') }}" class="nav-link">
                                    <i class="fas fa-home"></i> My Properties
                                </a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('favorites.index') }}" class="nav-link">
                                <i class="fas fa-heart"></i> Favorites
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/my-appraisals') }}" class="nav-link">
                                <i class="fas fa-calendar-check"></i> My Appointments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </li>
                    </ul>
                    
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-lg-8">
                @if(session('success'))
                    <div class="alert success-alert alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                
                <!-- Account Information -->
                <div class="info-card fade-in">
                    <div class="info-card-header">
                        <h5 class="info-card-title">Account Information</h5>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Phone</div>
                        <div class="info-value">{{ $user->phone ?? 'Not specified' }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Address</div>
                        <div class="info-value">{{ $user->address ?? 'Not specified' }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Account Type</div>
                        <div class="info-value">
                            @if($user->user_type === 'seller')
                                <span class="badge-status badge-primary">Seller</span>
                            @else
                                <span class="badge-status badge-secondary">Regular User</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="info-row">
                        <div class="info-label">Bio</div>
                        <div class="info-value">{{ $user->bio ?? 'No bio available' }}</div>
                    </div>
                    
                    <div style="margin-top: 25px; padding-top: 25px; border-top: 1px solid #f3f4f6;">
                        <a href="{{ route('profile.edit') }}" class="btn-edit">
                            <i class="fas fa-edit me-2"></i>Edit Information
                        </a>
                    </div>
                </div>
                
                <!-- Account Stats -->
                <div class="row fade-in">
                    @if($user->user_type === 'seller')
                        <div class="col-md-6 mb-4">
                            <div class="stats-card">
                                <div class="stats-icon primary">
                                    <i class="fas fa-home fa-2x text-primary"></i>
                                </div>
                                <div class="stats-number">{{ $user->properties()->count() }}</div>
                                <div class="stats-label">Properties Listed</div>
                                <a href="{{ route('properties.my') }}" class="btn-stats">
                                    <i class="fas fa-eye me-1"></i>View All
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    <div class="col-md-6 mb-4">
                        <div class="stats-card">
                            <div class="stats-icon danger">
                                <i class="fas fa-heart fa-2x text-danger"></i>
                            </div>
                            <div class="stats-number">{{ $user->favorites()->count() }}</div>
                            <div class="stats-label">Favorite Properties</div>
                            <a href="{{ route('favorites.index') }}" class="btn-stats">
                                <i class="fas fa-eye me-1"></i>View All
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fade in animations
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, { threshold: 0.1 });
    
    document.querySelectorAll('.fade-in').forEach(function(el) {
        observer.observe(el);
    });
    
    // Auto-hide alerts
    document.querySelectorAll('.success-alert').forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>

@endsection
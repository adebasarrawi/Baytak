@extends('layouts.public.app')

@section('title', 'My Appraisal Appointments')

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
    background: linear-gradient(to right, #1a1c20, #2c3e50);
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

.sidebar-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    margin-bottom: 30px;
    transition: all 0.3s ease;
    position: sticky;
    top: 20px;
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

.main-content-card {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
    margin-bottom: 30px;
}

.page-header {
    display: flex;
    justify-content: between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 15px;
}

.page-title {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.btn-primary-custom {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-primary-custom:hover {
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
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

.error-alert {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    border: none;
    border-radius: 15px;
    padding: 15px 20px;
    margin-bottom: 25px;
    box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
    animation: slideInDown 0.5s ease-out;
}

@keyframes slideInDown {
    from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); }
}

.alert .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.empty-state {
    text-align: center;
    padding: 80px 40px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
}

.empty-state i {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 12px;
}

.empty-state p {
    color: #6b7280;
    margin-bottom: 30px;
    font-size: 1rem;
}

.appointments-table {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.8);
}

.table {
    margin-bottom: 0;
}

.table thead th {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border: none;
    padding: 20px 15px;
    font-weight: 600;
    color: #374151;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table tbody td {
    padding: 20px 15px;
    border: none;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
}

.table tbody tr {
    transition: all 0.2s ease;
}

.table tbody tr:hover {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.appointment-id {
    font-weight: 600;
    color: #3b82f6;
}

.appointment-address {
    max-width: 200px;
    font-size: 0.9rem;
    line-height: 1.4;
}

.appointment-datetime {
    font-size: 0.9rem;
}

.appointment-date {
    font-weight: 600;
    color: #1f2937;
}

.appointment-time {
    color: #6b7280;
    font-size: 0.8rem;
}

.status-badge {
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-pending {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.status-confirmed {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}

.status-completed {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
}

.status-cancelled {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.btn-sm-custom {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    transition: all 0.2s ease;
    border: none;
    margin-right: 5px;
    margin-bottom: 5px;
}

.btn-view {
    background: transparent;
    color: #3b82f6;
    border: 2px solid #3b82f6;
}

.btn-view:hover {
    background: #3b82f6;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-cancel {
    background: transparent;
    color: #ef4444;
    border: 2px solid #ef4444;
}

.btn-cancel:hover {
    background: #ef4444;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.modal-content {
    border-radius: 20px;
    border: none;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
}

.modal-header {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-bottom: 1px solid #e5e7eb;
    border-radius: 20px 20px 0 0;
    padding: 25px 30px;
}

.modal-title {
    font-weight: 700;
    color: #1f2937;
}

.modal-body {
    padding: 30px;
}

.modal-section-title {
    color: #3b82f6;
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.modal-field {
    margin-bottom: 15px;
}

.modal-field label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 5px;
    display: block;
}

.modal-field span, .modal-field p {
    color: #6b7280;
    margin: 0;
}

.modal-alert {
    border-radius: 12px;
    border: none;
    padding: 15px 20px;
    margin-top: 20px;
}

.modal-alert.alert-info {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
}

.modal-alert.alert-success {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #166534;
}

.modal-alert.alert-danger {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #dc2626;
}

.modal-footer {
    border-top: 1px solid #e5e7eb;
    padding: 20px 30px;
    border-radius: 0 0 20px 20px;
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

.custom-pagination {
    display: flex;
    justify-content: center;
    margin-top: 30px;
}

/* Appointment Details Card */
.appointment-details-card {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border: 2px solid #e5e7eb;
    border-radius: 15px;
    margin: 15px;
    padding: 25px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.details-header {
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 15px;
    margin-bottom: 20px;
}

.details-header h5 {
    color: #1f2937;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
}

.details-section-title {
    color: #3b82f6;
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
    border-bottom: 1px solid #e5e7eb;
    padding-bottom: 8px;
}

.details-field {
    margin-bottom: 12px;
}

.details-field label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 4px;
    display: block;
    font-size: 0.9rem;
}

.details-field span, 
.details-field p {
    color: #6b7280;
    margin: 0;
    font-size: 0.9rem;
}

.details-alert {
    border-radius: 12px;
    border: none;
    padding: 15px 20px;
    margin-top: 20px;
    font-size: 0.9rem;
}

.details-alert.alert-info {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    color: #1e40af;
}

.details-alert.alert-success {
    background: linear-gradient(135deg, #dcfce7, #bbf7d0);
    color: #166534;
}

.details-alert.alert-danger {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    color: #dc2626;
}

/* Modal Fix */
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.5) !important;
    z-index: 1040 !important;
}

.modal {
    z-index: 1050 !important;
}

.modal-dialog {
    z-index: 1051 !important;
}

.modal-content {
    background: white !important;
    color: #333 !important;
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
        position: relative;
        top: auto;
    }
    
    .page-header {
        flex-direction: column;
        align-items: stretch;
        text-align: center;
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
    
    .appointments-table {
        font-size: 0.8rem;
    }
    
    .table thead th,
    .table tbody td {
        padding: 12px 8px;
    }
    
    .appointment-address {
        max-width: 150px;
    }
}

@media (max-width: 575.98px) {
    .custom-hero {
        padding: 60px 0 40px;
    }
    
    .hero-title {
        font-size: 1.8rem;
    }
    
    .hero-subtitle {
        font-size: 1rem;
    }
    
    .main-content-card {
        padding: 20px;
    }
    
    .table-responsive {
        font-size: 0.75rem;
    }
}
</style>

<!-- Hero Section -->
<div class="custom-hero">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-8 text-center">
                <div class="hero-content">
                  
                    <h1 class="hero-title fade-up delay-1" style="margin-top: 50px;">My Appointments</h1>
                    <p class="hero-subtitle fade-up delay-2">Manage your property appraisal appointments</p>
                 
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Appointments Section -->
<div class="profile-section">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-4 col-md-4 mb-4">
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
                            <a href="{{ route('profile') }}" class="nav-link">
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
                            <a href="{{ url('/my-appraisals') }}" class="nav-link active">
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
            <div class="col-lg-8 col-md-8">
                <div class="main-content-card fade-in">
                    <div class="page-header">
                        <h2 class="page-title">My Appraisal Appointments</h2>
                        <a href="{{ route('property.estimation') }}" class="btn-primary-custom">
                            <i class="fas fa-plus-circle"></i> Book New Appointment
                        </a>
                    </div>
                    
                    @if(session('success'))
                        <div class="alert success-alert alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert error-alert alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if($appraisals->isEmpty())
                        <div class="empty-state">
                            <i class="fas fa-calendar-alt"></i>
                            <h3>No Appointments Yet</h3>
                            <p>You haven't booked any property appraisal appointments yet.</p>
                            <a href="{{ route('property.estimation') }}" class="btn-primary-custom">
                                <i class="fas fa-plus-circle"></i> Book an Appointment
                            </a>
                        </div>
                    @else
                        <div class="appointments-table">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Property Address</th>
                                            <th>Date & Time</th>
                                            <th>Appraiser</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($appraisals as $appraisal)
                                            <tr class="{{ $appraisal->trashed() ? 'table-light' : '' }}">
                                                <td class="appointment-id">#{{ $appraisal->id }}</td>
                                                <td>
                                                    <div class="appointment-address">{{ $appraisal->property_address }}</div>
                                                </td>
                                                <td class="appointment-datetime">
                                                    <div class="appointment-date">{{ \Carbon\Carbon::parse($appraisal->appointment_date)->format('M d, Y') }}</div>
                                                    <div class="appointment-time">{{ \Carbon\Carbon::parse($appraisal->appointment_time)->format('h:i A') }}</div>
                                                </td>
                                                <td>
                                                    @if($appraisal->appraiser)
                                                        {{ $appraisal->appraiser->name }}
                                                    @else
                                                        <span class="text-muted">Not Assigned</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $statusClasses = [
                                                            'pending' => 'status-pending',
                                                            'confirmed' => 'status-confirmed',
                                                            'completed' => 'status-completed',
                                                            'cancelled' => 'status-cancelled'
                                                        ];
                                                        $statusClass = $statusClasses[$appraisal->status] ?? 'status-pending';
                                                    @endphp
                                                    <div>
                                                        <span class="status-badge {{ $statusClass }}">
                                                            {{ ucfirst($appraisal->status) }}
                                                        </span>
                                                        @if($appraisal->status === 'cancelled' && $appraisal->cancelled_by)
                                                            <div class="small text-muted mt-1">
                                                                {{ $appraisal->cancelled_by === 'user' ? 'Cancelled by You' : 'Cancelled by Admin' }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm-custom btn-view" data-bs-toggle="collapse" data-bs-target="#details-{{ $appraisal->id }}" aria-expanded="false">
                                                        <i class="fas fa-eye me-1"></i> View Details
                                                    </button>
                                                    
                                                    @if($appraisal->canBeCancelled())
                                                        <form action="{{ route('property.appraisal.cancel', $appraisal->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-sm-custom btn-cancel" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                                                <i class="fas fa-times-circle me-1"></i> Cancel
                                                            </button>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                            
                                            <!-- Appointment Details Row -->
                                            <tr>
                                                <td colspan="6" class="p-0">
                                                    <div class="collapse" id="details-{{ $appraisal->id }}">
                                                        <div class="appointment-details-card">
                                                            <div class="details-header">
                                                                <h5><i class="fas fa-calendar-check me-2"></i>Appointment Details #{{ $appraisal->id }}</h5>
                                                            </div>
                                                            <div class="row g-4">
                                                                <div class="col-md-6">
                                                                    <h6 class="details-section-title">
                                                                        <i class="fas fa-info-circle"></i>
                                                                        Appointment Information
                                                                    </h6>
                                                                    <div class="details-field">
                                                                        <label>Status:</label>
                                                                        <span class="status-badge {{ $statusClass }}">
                                                                            {{ ucfirst($appraisal->status) }}
                                                                        </span>
                                                                        @if($appraisal->status === 'cancelled' && $appraisal->cancelled_by)
                                                                            <div class="small text-muted mt-1">
                                                                                {{ $appraisal->cancelled_by === 'user' ? 'Cancelled by You' : 'Cancelled by Admin' }}
                                                                                @if($appraisal->cancelled_at)
                                                                                    on {{ $appraisal->cancelled_at->format('M d, Y h:i A') }}
                                                                                @endif
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="details-field">
                                                                        <label>Date:</label>
                                                                        <span>{{ \Carbon\Carbon::parse($appraisal->appointment_date)->format('F d, Y') }}</span>
                                                                    </div>
                                                                    <div class="details-field">
                                                                        <label>Time:</label>
                                                                        <span>{{ \Carbon\Carbon::parse($appraisal->appointment_time)->format('h:i A') }}</span>
                                                                    </div>
                                                                    <div class="details-field">
                                                                        <label>Created On:</label>
                                                                        <span>{{ $appraisal->created_at->format('F d, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <h6 class="details-section-title">
                                                                        <i class="fas fa-home"></i>
                                                                        Property Information
                                                                    </h6>
                                                                    <div class="details-field">
                                                                        <label>Address:</label>
                                                                        <p>{{ $appraisal->property_address }}</p>
                                                                    </div>
                                                                    
                                                                    @if($appraisal->property_type)
                                                                        <div class="details-field">
                                                                            <label>Property Type:</label>
                                                                            <span>{{ ucfirst($appraisal->property_type) }}</span>
                                                                        </div>
                                                                    @endif
                                                                    
                                                                    @if($appraisal->property_area)
                                                                        <div class="details-field">
                                                                            <label>Property Area:</label>
                                                                            <span>{{ $appraisal->property_area }} sq.m</span>
                                                                        </div>
                                                                    @endif
                                                                    
                                                                    @if($appraisal->bedrooms || $appraisal->bathrooms)
                                                                        <div class="details-field">
                                                                            <label>Features:</label>
                                                                            <span>
                                                                                @if($appraisal->bedrooms)
                                                                                    {{ $appraisal->bedrooms }} Bedrooms
                                                                                @endif
                                                                                @if($appraisal->bedrooms && $appraisal->bathrooms), @endif
                                                                                @if($appraisal->bathrooms)
                                                                                    {{ $appraisal->bathrooms }} Bathrooms
                                                                                @endif
                                                                            </span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <h6 class="details-section-title">
                                                                        <i class="fas fa-user-tie"></i>
                                                                        Appraiser Information
                                                                    </h6>
                                                                    @if($appraisal->appraiser)
                                                                        <div class="details-field">
                                                                            <label>Name:</label>
                                                                            <span>{{ $appraisal->appraiser->name }}</span>
                                                                        </div>
                                                                        <div class="details-field">
                                                                            <label>Email:</label>
                                                                            <span>{{ $appraisal->appraiser->email }}</span>
                                                                        </div>
                                                                     
                                                                    @else
                                                                        <p class="text-muted">Appraiser not yet assigned</p>
                                                                    @endif
                                                                </div>
                                                                
                                                                <div class="col-md-6">
                                                                    <h6 class="details-section-title">
                                                                        <i class="fas fa-sticky-note"></i>
                                                                        Additional Information
                                                                    </h6>
                                                                    <div class="details-field">
                                                                        <label>Notes:</label>
                                                                        <p>{{ $appraisal->additional_notes ?: 'No additional notes provided.' }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            @if($appraisal->status === 'confirmed')
                                                                <div class="details-alert alert-info">
                                                                    <i class="fas fa-info-circle me-2"></i>
                                                                    <span>Your appointment has been confirmed. Please make sure to be available at the property location at the scheduled time.</span>
                                                                </div>
                                                            @elseif($appraisal->status === 'completed')
                                                                <div class="details-alert alert-success">
                                                                    <i class="fas fa-check-circle me-2"></i>
                                                                    <span>Your appointment has been completed. You will receive the appraisal report via email soon.</span>
                                                                </div>
                                                            @elseif($appraisal->status === 'cancelled')
                                                                <div class="details-alert alert-danger">
                                                                    <i class="fas fa-times-circle me-2"></i>
                                                                    <span>
                                                                        This appointment has been cancelled
                                                                        {{ $appraisal->cancelled_by === 'user' ? ' by you' : ' by the admin' }}.
                                                                        @if($appraisal->cancelled_at)
                                                                            Cancelled on {{ $appraisal->cancelled_at->format('F d, Y \a\t h:i A') }}.
                                                                        @endif
                                                                        If you still need an appraisal, please book a new appointment.
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="custom-pagination fade-in">
                            {{ $appraisals->links() }}
                        </div>
                    @endif
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
    document.querySelectorAll('.success-alert, .error-alert').forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Table row hover effects
    const tableRows = document.querySelectorAll('.table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.style.transform = 'translateY(-2px)';
            row.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.08)';
        });
        row.addEventListener('mouseleave', () => {
            row.style.transform = 'translateY(0)';
            row.style.boxShadow = 'none';
        });
    });

    // Button hover effects
    document.querySelectorAll('.btn-sm-custom').forEach(btn => {
        btn.addEventListener('mouseenter', () => {
            btn.style.transform = 'translateY(-1px)';
        });
        btn.addEventListener('mouseleave', () => {
            btn.style.transform = 'translateY(0)';
        });
    });
});
</script>

@endsection
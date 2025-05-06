@extends('layouts.public.app')

@section('title', 'My Profile')

@section('content')
<div class="hero page-inner overlay" >
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-9 text-center mt-5">
        <h1 class="heading" data-aos="fade-up">My Profile</h1>
        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
          <ol class="breadcrumb text-center justify-content-center">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">My Profile</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>

<div class="section">
  <div class="container">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-lg-3 mb-5 mb-lg-0">
        <div class="profile-sidebar shadow rounded bg-white p-4">
          <div class="text-center mb-4">
            @if($user->profile_image)
              <img src="{{ asset('storage/'.$user->profile_image) }}" alt="{{ $user->name }}" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
            @else
              <img src="{{ asset('images/default-avatar.jpg') }}" alt="{{ $user->name }}" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
            @endif
            <h4>{{ $user->name }}</h4>
            <p class="text-muted small">{{ $user->email }}</p>
          </div>
          
          <div class="list-group">
            <a href="{{ route('profile.show') }}" class="list-group-item list-group-item-action active">
              <i class="fas fa-user me-2"></i> Account Information
            </a>
            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action">
              <i class="fas fa-edit me-2"></i> Edit Profile
            </a>
            <!-- Add more links here like property listings, favorites, etc. -->
            <a href="#" class="list-group-item list-group-item-action">
              <i class="fas fa-home me-2"></i> My Properties
            </a>
            <a href="#" class="list-group-item list-group-item-action">
              <i class="fas fa-heart me-2"></i> Favorites
            </a>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="list-group-item list-group-item-action text-danger">
              <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </div>
        </div>
      </div>
      
      <!-- Main Content -->
      <div class="col-lg-9">
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-white">
            <h5 class="mb-0">Account Information</h5>
          </div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-sm-3">
                <p class="mb-0 text-muted">Full Name</p>
              </div>
              <div class="col-sm-9">
                <p class="mb-0">{{ $user->name }}</p>
              </div>
            </div>
            <hr>
            <div class="row mb-3">
              <div class="col-sm-3">
                <p class="mb-0 text-muted">Email</p>
              </div>
              <div class="col-sm-9">
                <p class="mb-0">{{ $user->email }}</p>
              </div>
            </div>
            <hr>
            <div class="row mb-3">
              <div class="col-sm-3">
                <p class="mb-0 text-muted">Phone</p>
              </div>
              <div class="col-sm-9">
                <p class="mb-0">{{ $user->phone }}</p>
              </div>
            </div>
            <hr>
            <div class="row mb-3">
              <div class="col-sm-3">
                <p class="mb-0 text-muted">Address</p>
              </div>
              <div class="col-sm-9">
                <p class="mb-0">{{ $user->address ?? 'Not specified' }}</p>
              </div>
            </div>
            <hr>
            <div class="row">
              <div class="col-sm-3">
                <p class="mb-0 text-muted">Bio</p>
              </div>
              <div class="col-sm-9">
                <p class="mb-0">{{ $user->bio ?? 'No bio available' }}</p>
              </div>
            </div>
          </div>
          <div class="card-footer bg-white">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Information</a>
          </div>
        </div>
        
        <!-- Account Stats -->
        <div class="row">
          <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
              <div class="card-body text-center p-4">
                <div class="icon-box mb-3 mx-auto">
                  <i class="fas fa-home fa-3x text-primary"></i>
                </div>
                <h5>{{ $user->properties()->count() }}</h5>
                <p class="text-muted">Properties Listed</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
              <div class="card-body text-center p-4">
                <div class="icon-box mb-3 mx-auto">
                  <i class="fas fa-heart fa-3x text-danger"></i>
                </div>
                <h5>{{ $user->favorites()->count() }}</h5>
                <p class="text-muted">Favorite Properties</p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
              <div class="card-body text-center p-4">
                <div class="icon-box mb-3 mx-auto">
                  <i class="fas fa-bell fa-3x text-warning"></i>
                </div>
                <h5>{{ $user->notifications()->count() }}</h5>
                <p class="text-muted">New Notifications</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@extends('layouts.public.app')

@section('title', 'Edit Profile')

@section('content')
<div class="hero page-inner overlay" >
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-9 text-center mt-5">
        <h1 class="heading" data-aos="fade-up">Edit Profile</h1>
        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
          <ol class="breadcrumb text-center justify-content-center">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('profile.show') }}">My Profile</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">Edit Profile</li>
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
            <a href="{{ route('profile.show') }}" class="list-group-item list-group-item-action">
              <i class="fas fa-user me-2"></i> Account Information
            </a>
            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action active">
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
        
        <!-- Profile Information -->
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-white">
            <h5 class="mb-0">Edit Personal Information</h5>
          </div>
          <div class="card-body">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
              @csrf
              
              <div class="mb-3 text-center">
                <div class="profile-image-container mx-auto position-relative" style="width: 150px;">
                  @if($user->profile_image)
                    <img src="{{ asset('storage/'.$user->profile_image) }}" alt="{{ $user->name }}" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                  @else
                    <img src="{{ asset('images/default-avatar.jpg') }}" alt="{{ $user->name }}" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                  @endif
                  <label for="profile_image" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2" style="cursor: pointer;">
                    <i class="fas fa-camera"></i>
                  </label>
                  <input type="file" id="profile_image" name="profile_image" class="d-none">
                </div>
                <p class="small text-muted">Click the camera icon to change your profile picture</p>
              </div>
              
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="name" class="form-label">Full Name</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                  @error('name')
                    <span class="text-danger small">{{ $message }}</span>
                  @enderror
                </div>
                <div class="col-md-6 mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                  @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                  @enderror
                </div>
              </div>
              
              <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" required>
                @error('phone')
                  <span class="text-danger small">{{ $message }}</span>
                @enderror
              </div>
              
              <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}">
                @error('address')
                  <span class="text-danger small">{{ $message }}</span>
                @enderror
              </div>
              
              <div class="mb-3">
                <label for="bio" class="form-label">Bio</label>
                <textarea class="form-control" id="bio" name="bio" rows="4">{{ $user->bio }}</textarea>
                @error('bio')
                  <span class="text-danger small">{{ $message }}</span>
                @enderror
              </div>
              
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
        
        <!-- Change Password -->
        <div class="card shadow-sm">
          <div class="card-header bg-white">
            <h5 class="mb-0">Change Password</h5>
          </div>
          <div class="card-body">
            <form action="{{ route('profile.update-password') }}" method="POST">
              @csrf
              
              <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="current_password" name="current_password" required>
                @error('current_password')
                  <span class="text-danger small">{{ $message }}</span>
                @enderror
              </div>
              
              <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                @error('password')
                  <span class="text-danger small">{{ $message }}</span>
                @enderror
              </div>
              
              <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
              </div>
              
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-warning">Update Password</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
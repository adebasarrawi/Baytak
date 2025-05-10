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
            <li class="breadcrumb-item"><a href="{{ route('profile') }}">My Profile</a></li>
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
            @if(Auth::user()->profile_image)
              <img src="{{ asset('storage/'.Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
            @else
              <img src="{{ asset('images/default-avatar.jpg') }}" alt="{{ Auth::user()->name }}" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
            @endif
            <h4>{{ Auth::user()->name }}</h4>
            <p class="text-muted small">{{ Auth::user()->email }}</p>
            @if(Auth::user()->user_type === 'seller')
              <div class="badge bg-primary py-2 px-3 mb-2">Seller Account</div>
            @endif
          </div>
          
          <div class="list-group">
          <a href="{{ route('profile') }}" class="list-group-item list-group-item-action">
              <i class="fas fa-user me-2"></i> Account Information
            </a>
            <a href="{{ route('profile.edit') }}" class="list-group-item list-group-item-action active">
              <i class="fas fa-edit me-2"></i> Edit Profile
            </a>
            @if(Auth::user()->user_type === 'seller')
              <a href="{{ route('properties.my') }}" class="list-group-item list-group-item-action">
                <i class="fas fa-home me-2"></i> My Properties
              </a>
            @endif
            <a href="{{ route('favorites.index') }}" class="list-group-item list-group-item-action">
              <i class="fas fa-heart me-2"></i> Favorites
            </a>
            <a href="{{ route('notifications.index') }}" class="list-group-item list-group-item-action">
              <i class="fas fa-bell me-2"></i> Notifications
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
          <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif
        
        @if ($errors->any())
          <div class="alert alert-danger mb-4">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        
        <div class="row">
          <!-- Profile Information -->
          <div class="col-12 mb-4">
            <div class="card shadow-sm">
              <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-user-edit me-2 text-primary"></i> Profile Information</h5>
              </div>
              <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  
                  <div class="row mb-4">
                    <div class="col-md-3">
                      <div class="text-center mb-3">
                        @if(Auth::user()->profile_image)
                          <img src="{{ asset('storage/'.Auth::user()->profile_image) }}" alt="{{ Auth::user()->name }}" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;" id="profile-image-preview">
                        @else
                          <img src="{{ asset('images/default-avatar.jpg') }}" alt="{{ Auth::user()->name }}" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;" id="profile-image-preview">
                        @endif
                        <div class="mt-2">
                          <label for="profile_image" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-camera me-1"></i> Change Photo
                          </label>
                          <input type="file" name="profile_image" id="profile_image" class="d-none" accept="image/*">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-9">
                      <div class="row g-3">
                        <div class="col-md-6 mb-3">
                          <label for="name" class="form-label">Full Name</label>
                          <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="email" class="form-label">Email Address</label>
                          <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="phone" class="form-label">Phone Number</label>
                          <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', Auth::user()->phone) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label for="address" class="form-label">Address</label>
                          <input type="text" class="form-control" id="address" name="address" value="{{ old('address', Auth::user()->address) }}">
                        </div>
                        <div class="col-md-12">
                          <label for="bio" class="form-label">Bio</label>
                          <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Tell us something about yourself...">{{ old('bio', Auth::user()->bio) }}</textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-save me-2"></i> Update Profile
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          
          <!-- Change Password -->
          <div class="col-12">
            <div class="card shadow-sm">
              <div class="card-header bg-white py-3">
                <h5 class="mb-0"><i class="fas fa-lock me-2 text-primary"></i> Change Password</h5>
              </div>
              <div class="card-body">
                <form action="{{ route('profile.updatePassword') }}" method="POST">
                  @csrf
                  
                  <div class="row g-3">
                    <div class="col-md-12 mb-3">
                      <label for="current_password" class="form-label">Current Password</label>
                      <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="password" class="form-label">New Password</label>
                      <input type="password" class="form-control" id="password" name="password" required>
                      <div class="form-text">Password must be at least 8 characters long.</div>
                    </div>
                    <div class="col-md-6 mb-3">
                      <label for="password_confirmation" class="form-label">Confirm New Password</label>
                      <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                  </div>
                  
                  <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                      <i class="fas fa-key me-2"></i> Change Password
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Profile image preview
    const profileImageInput = document.getElementById('profile_image');
    const profileImagePreview = document.getElementById('profile-image-preview');
    
    if (profileImageInput && profileImagePreview) {
      profileImageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file && file.type.match('image.*')) {
          const reader = new FileReader();
          reader.onload = function(e) {
            profileImagePreview.src = e.target.result;
          }
          reader.readAsDataURL(file);
        }
      });
    }
  });
</script>
@endpush
@endsection
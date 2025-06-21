@extends('layouts.admin.app')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Edit {{ $user->name }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info me-2">
                <i class="fas fa-eye me-2"></i>View Profile
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- User Information Card -->
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" id="userTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" 
                                    data-bs-target="#basic" type="button" role="tab">
                                <i class="fas fa-user me-2"></i>Basic Info
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="password-tab" data-bs-toggle="tab" 
                                    data-bs-target="#password" type="button" role="tab">
                                <i class="fas fa-lock me-2"></i>Password
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="userTabsContent">
                        <!-- Basic Information Tab -->
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    <!-- Basic Information -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- User Type -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="user_type" class="form-label">User Type <span class="text-danger">*</span></label>
                                            <select class="form-select @error('user_type') is-invalid @enderror" id="user_type" name="user_type" required>
                                                <option value="user" {{ old('user_type', $user->user_type) == 'user' ? 'selected' : '' }}>User</option>
                                                <option value="seller" {{ old('user_type', $user->user_type) == 'seller' ? 'selected' : '' }}>Seller</option>
                                                <option value="appraiser" {{ old('user_type', $user->user_type) == 'appraiser' ? 'selected' : '' }}>Appraiser</option>
                                                <option value="admin" {{ old('user_type', $user->user_type) == 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            @error('user_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Profile Image -->
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="profile_image" class="form-label">Profile Image</label>
                                            <input type="file" class="form-control @error('profile_image') is-invalid @enderror" 
                                                   id="profile_image" name="profile_image" accept="image/*">
                                            <div class="form-text">Max size: 2MB. Allowed formats: JPG, PNG, GIF</div>
                                            @error('profile_image')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            
                                            @if($user->profile_image)
                                            <div class="mt-2">
                                                <small class="text-muted">Current image:</small><br>
                                                <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                                     class="rounded" width="100" height="100" alt="Current Profile">
                                            </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Address -->
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address</label>
                                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                                      id="address" name="address" rows="2">{{ old('address', $user->address) }}</textarea>
                                            @error('address')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Bio -->
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="bio" class="form-label">Bio</label>
                                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                                      id="bio" name="bio" rows="3">{{ old('bio', $user->bio) }}</textarea>
                                            @error('bio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Email Verification -->
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="email_verified" 
                                                       name="email_verified" value="1" 
                                                       {{ old('email_verified', $user->hasVerifiedEmail()) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="email_verified">
                                                    Email is verified
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update User
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Password Tab -->
                        <div class="tab-pane fade" id="password" role="tabpanel">
                            <form action="{{ route('admin.users.update-password', $user) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Warning:</strong> Changing the password will require the user to log in again with the new password.
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">New Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="new_password" name="password" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-secondary" onclick="$('#new_password, #password_confirmation').val('')">Clear</button>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-key me-2"></i>Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- User Stats Card -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>User Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary">{{ $user->properties_count ?? 0 }}</h4>
                                <small class="text-muted">Properties</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success">{{ $user->favorites_count ?? 0 }}</h4>
                            <small class="text-muted">Favorites</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-info">{{ $user->appraisals_count ?? 0 }}</h4>
                                <small class="text-muted">Appraisals</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning">{{ $user->payments->count() ?? 0 }}</h4>
                            <small class="text-muted">Payments</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Info Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>User Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">Member Since:</small><br>
                        <strong>{{ $user->created_at->format('M d, Y') }}</strong>
                        <small class="text-muted">({{ $user->created_at->diffForHumans() }})</small>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">Last Updated:</small><br>
                        <strong>{{ $user->updated_at->format('M d, Y') }}</strong>
                        <small class="text-muted">({{ $user->updated_at->diffForHumans() }})</small>
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">Email Status:</small><br>
                        @if($user->hasVerifiedEmail())
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Verified
                            </span>
                            <small class="text-muted d-block">{{ $user->email_verified_at->format('M d, Y') }}</small>
                        @else
                            <span class="badge bg-warning">
                                <i class="fas fa-exclamation-circle me-1"></i>Not Verified
                            </span>
                        @endif
                    </div>

                    <div class="mb-2">
                        <small class="text-muted">Account Status:</small><br>
                        <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'warning' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if(!$user->hasVerifiedEmail())
                        <a href="{{ route('admin.users.verify-email', $user) }}" 
                           class="btn btn-sm btn-outline-success"
                           onclick="return confirm('Are you sure you want to verify this user\'s email?')">
                            <i class="fas fa-check me-1"></i>Verify Email
                        </a>
                        @endif
                        
                        

                        @php
    $action = $user->status === 'active' ? 'deactivate' : 'activate';
@endphp
<a href="{{ route('admin.users.toggle-status', $user) }}" 
   class="btn btn-sm btn-outline-{{ $user->status === 'active' ? 'warning' : 'success' }}" 
   title="{{ ucfirst($action) }}"
   onclick="return confirm('Are you sure you want to {{ $action }} this user?')">
    <i class="fas fa-{{ $user->status === 'active' ? 'pause' : 'play' }}"></i>
</a>
                        
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                <i class="fas fa-trash me-1"></i>Delete User
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Image preview
    $('#profile_image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Create or update preview
                if ($('#imagePreview').length === 0) {
                    $('#profile_image').after('<div id="imagePreview" class="mt-2"><img src="" class="rounded" width="100" height="100" alt="New Preview"></div>');
                }
                $('#imagePreview img').attr('src', e.target.result);
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').remove();
        }
    });

    // Password strength indicator
    $('#new_password').on('input', function() {
        const password = $(this).val();
        let strength = 0;
        
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/)) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;

        let strengthText = '';
        let strengthClass = '';
        
        switch(strength) {
            case 0:
            case 1:
                strengthText = 'Very Weak';
                strengthClass = 'text-danger';
                break;
            case 2:
                strengthText = 'Weak';
                strengthClass = 'text-warning';
                break;
            case 3:
                strengthText = 'Medium';
                strengthClass = 'text-info';
                break;
            case 4:
                strengthText = 'Strong';
                strengthClass = 'text-success';
                break;
            case 5:
                strengthText = 'Very Strong';
                strengthClass = 'text-success';
                break;
        }

        // Remove existing strength indicator
        $('#new_password').siblings('.password-strength').remove();
        
        if (password.length > 0) {
            $('#new_password').after(`<div class="password-strength small ${strengthClass}">Password Strength: ${strengthText}</div>`);
        }
    });

    // Confirm password match
    $('#password_confirmation').on('input', function() {
        const password = $('#new_password').val();
        const confirmPassword = $(this).val();
        
        // Remove existing match indicator
        $(this).siblings('.password-match').remove();
        
        if (confirmPassword.length > 0) {
            if (password === confirmPassword) {
                $(this).after('<div class="password-match small text-success"><i class="fas fa-check me-1"></i>Passwords match</div>');
            } else {
                $(this).after('<div class="password-match small text-danger"><i class="fas fa-times me-1"></i>Passwords do not match</div>');
            }
        }
    });
});
</script>
@endpush
@endsection
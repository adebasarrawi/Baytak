@extends('layouts.admin.app')

@section('title', 'Add New User')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Add New User</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">Add New</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Users
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-plus me-2"></i>User Information
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <!-- Basic Information Section -->
                            <div class="col-12 mb-4">
                                <h6 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-info-circle me-2"></i>Basic Information
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name') }}" required 
                                               placeholder="Enter full name">
                                    </div>
                                    @error('name')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold">Email Address <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                               id="email" name="email" value="{{ old('email') }}" required
                                               placeholder="Enter email address">
                                    </div>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label fw-bold">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" name="phone" value="{{ old('phone') }}"
                                               placeholder="Enter phone number">
                                    </div>
                                    @error('phone')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_type" class="form-label fw-bold">User Type <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-users-cog"></i></span>
                                        <select class="form-select @error('user_type') is-invalid @enderror" id="user_type" name="user_type" required>
                                            <option value="">Select Type</option>
                                            <option value="user" {{ old('user_type') == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="seller" {{ old('user_type') == 'seller' ? 'selected' : '' }}>Seller</option>
                                            <option value="appraiser" {{ old('user_type') == 'appraiser' ? 'selected' : '' }}>Appraiser</option>
                                            <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </div>
                                    @error('user_type')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Security Section -->
                            <div class="col-12 mb-4 mt-4">
                                <h6 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-lock me-2"></i>Security Settings
                                </h6>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" required
                                               placeholder="Enter password">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-bold">Confirm Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation" required
                                               placeholder="Confirm password">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label fw-bold">Account Status <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    @error('status')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch mt-4 pt-2">
                                        <input class="form-check-input" type="checkbox" id="email_verified" 
                                               name="email_verified" value="1" {{ old('email_verified') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="email_verified">
                                            <i class="fas fa-check-circle text-success me-1"></i>
                                            Mark email as verified
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information Section -->
                            <div class="col-12 mb-4 mt-4">
                                <h6 class="text-primary border-bottom pb-2">
                                    <i class="fas fa-address-card me-2"></i>Additional Information
                                </h6>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="profile_image" class="form-label fw-bold">Profile Image</label>
                                    <input type="file" class="form-control @error('profile_image') is-invalid @enderror" 
                                           id="profile_image" name="profile_image" accept="image/*">
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Max size: 2MB. Allowed formats: JPG, PNG, GIF
                                    </div>
                                    @error('profile_image')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="address" class="form-label fw-bold">Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                                  id="address" name="address" rows="2" 
                                                  placeholder="Enter full address">{{ old('address') }}</textarea>
                                    </div>
                                    @error('address')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="bio" class="form-label fw-bold">Bio</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-quote-left"></i></span>
                                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                                                  id="bio" name="bio" rows="3" 
                                                  placeholder="Brief description about the user...">{{ old('bio') }}</textarea>
                                    </div>
                                    @error('bio')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex justify-content-end gap-3">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Preview Card -->
            <div class="card shadow mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-eye me-2"></i>Profile Preview
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div id="imagePreview" class="mb-3" style="display: none;">
                        <img id="previewImg" src="" class="rounded-circle border border-3 border-primary" 
                             width="100" height="100" alt="Preview">
                    </div>
                    <div id="placeholderPreview" class="mb-3">
                        <div class="bg-gradient-primary rounded-circle mx-auto d-flex align-items-center justify-content-center text-white shadow" 
                             style="width: 100px; height: 100px; font-size: 32px;">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <h5 id="namePreview" class="text-muted">Enter name to preview</h5>
                    <p id="emailPreview" class="text-muted small">Enter email to preview</p>
                    <div id="typePreview" class="mb-2">
                        <span class="badge bg-secondary">Select Type</span>
                    </div>
                    <div id="statusPreview">
                        <span class="badge bg-success">Active</span>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>User Creation Guide
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <h6 class="text-success">
                            <i class="fas fa-users me-1"></i>User Types:
                        </h6>
                        <ul class="list-unstyled ms-3">
                            <li class="mb-2">
                                <span class="badge bg-secondary me-2">User</span>
                                General platform user
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-info me-2">Seller</span>
                                Property seller with listing privileges
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-warning me-2">Appraiser</span>
                                Property appraiser and evaluator
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-danger me-2">Admin</span>
                                Full system administration access
                            </li>
                        </ul>

                        <h6 class="text-success mt-4">
                            <i class="fas fa-toggle-on me-1"></i>Account Status:
                        </h6>
                        <ul class="list-unstyled ms-3">
                            <li class="mb-2">
                                <span class="badge bg-success me-2">Active</span>
                                User can access the system
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-secondary me-2">Inactive</span>
                                User access is suspended
                            </li>
                        </ul>

                        <div class="alert alert-info mt-4">
                            <i class="fas fa-lightbulb me-2"></i>
                            <strong>Pro Tip:</strong> Mark email as verified to skip the email verification process for new users.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    border: none;
    border-radius: 15px;
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #dee2e6;
    color: #6c757d;
}

.form-control:focus, .form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
}

.password-strength {
    margin-top: 0.25rem;
    font-size: 0.875rem;
}

.password-match {
    margin-top: 0.25rem;
    font-size: 0.875rem;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Password toggle functionality
    $('#togglePassword').click(function() {
        const passwordField = $('#password');
        const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    $('#togglePasswordConfirm').click(function() {
        const passwordField = $('#password_confirmation');
        const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
        passwordField.attr('type', type);
        $(this).find('i').toggleClass('fa-eye fa-eye-slash');
    });

    // Image preview
    $('#profile_image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result);
                $('#imagePreview').show();
                $('#placeholderPreview').hide();
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').hide();
            $('#placeholderPreview').show();
        }
    });

    // Live preview updates
    $('#name').on('input', function() {
        const name = $(this).val();
        $('#namePreview').text(name || 'Enter name to preview');
    });

    $('#email').on('input', function() {
        const email = $(this).val();
        $('#emailPreview').text(email || 'Enter email to preview');
    });

    $('#user_type').on('change', function() {
        const type = $(this).val();
        const typeText = $(this).find('option:selected').text();
        
        let badgeClass = 'bg-secondary';
        switch(type) {
            case 'admin': badgeClass = 'bg-danger'; break;
            case 'seller': badgeClass = 'bg-info'; break;
            case 'appraiser': badgeClass = 'bg-warning'; break;
            case 'user': badgeClass = 'bg-secondary'; break;
        }
        
        $('#typePreview').html(`<span class="badge ${badgeClass}">${typeText}</span>`);
    });

    $('#status').on('change', function() {
        const status = $(this).val();
        const badgeClass = status === 'active' ? 'bg-success' : 'bg-secondary';
        $('#statusPreview').html(`<span class="badge ${badgeClass}">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`);
    });

    // Password strength indicator
    $('#password').on('input', function() {
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
        $('#password').closest('.input-group').siblings('.password-strength').remove();
        
        if (password.length > 0) {
            $('#password').closest('.input-group').after(`<div class="password-strength ${strengthClass}"><i class="fas fa-shield-alt me-1"></i>Password Strength: ${strengthText}</div>`);
        }
    });

    // Confirm password match
    $('#password_confirmation').on('input', function() {
        const password = $('#password').val();
        const confirmPassword = $(this).val();
        
        // Remove existing match indicator
        $(this).closest('.input-group').siblings('.password-match').remove();
        
        if (confirmPassword.length > 0) {
            if (password === confirmPassword) {
                $(this).closest('.input-group').after('<div class="password-match text-success"><i class="fas fa-check me-1"></i>Passwords match</div>');
            } else {
                $(this).closest('.input-group').after('<div class="password-match text-danger"><i class="fas fa-times me-1"></i>Passwords do not match</div>');
            }
        }
    });
});
</script>
@endpush
@endsection
@extends('layouts.admin.app')

@section('title', 'Add New Area')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title text-dark">Add New Area</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="fas fa-angle-right"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.areas.index') }}" class="text-decoration-none">Areas</a>
                </li>
                <li class="separator">
                    <i class="fas fa-angle-right"></i>
                </li>
                <li class="nav-item">
                    <span class="text-muted">Add New</span>
                </li>
            </ul>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-plus text-success me-2"></i>
                            Create New Area
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.areas.store') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="name" class="form-label">Area Name <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name') }}" 
                                               placeholder="Enter area name"
                                               required>
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Enter the name of the area (e.g., Downtown, West Amman, etc.)
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="governorate_id" class="form-label">Governorate <span class="text-danger">*</span></label>
                                        <select class="form-select @error('governorate_id') is-invalid @enderror" 
                                                id="governorate_id" 
                                                name="governorate_id" 
                                                required>
                                            <option value="">Select Governorate</option>
                                            @foreach($governorates as $governorate)
                                            <option value="{{ $governorate->id }}" {{ old('governorate_id') == $governorate->id ? 'selected' : '' }}>
                                                {{ $governorate->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('governorate_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Select the governorate this area belongs to
                                        </small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Info Box -->
                            <div class="alert alert-info border-0 bg-info bg-opacity-10">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-info-circle text-info me-3 mt-1"></i>
                                    <div>
                                        <h6 class="text-info mb-1">Important Notes:</h6>
                                        <ul class="mb-0 text-info">
                                            <li>Area names must be unique</li>
                                            <li>Choose the correct governorate for this area</li>
                                            <li>This area will be available for property listings</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('admin.areas.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Areas
                                </a>
                                
                                <div class="d-flex gap-2">
                                    <button type="reset" class="btn btn-outline-warning">
                                        <i class="fas fa-undo me-2"></i>Reset Form
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-plus me-2"></i>Create Area
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Help Card -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-light border-0">
                        <h6 class="mb-0">
                            <i class="fas fa-question-circle text-primary me-2"></i>
                            Need Help?
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-dark">Examples of Areas:</h6>
                                <ul class="text-muted small">
                                    <li>Downtown Amman</li>
                                    <li>Abdoun</li>
                                    <li>Sweifieh</li>
                                    <li>Jabal Al Hussein</li>
                                    <li>Sports City</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-dark">Tips:</h6>
                                <ul class="text-muted small">
                                    <li>Use clear, recognizable area names</li>
                                    <li>Avoid duplicate names within the same governorate</li>
                                    <li>Consider popular neighborhoods and districts</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.form-control:focus,
.form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.alert {
    border-radius: 0.5rem;
}

.btn {
    border-radius: 0.375rem;
}

@media (max-width: 768px) {
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.justify-content-between .d-flex {
        justify-content: center;
    }
}
</style>
@endsection
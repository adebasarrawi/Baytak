@extends('layouts.admin.app')

@section('title', 'Edit Area - ' . $area->name)

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title text-dark">Edit Area</h4>
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
                    <span class="text-muted">Edit {{ $area->name }}</span>
                </li>
            </ul>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-edit text-warning me-2"></i>
                            Edit Area: {{ $area->name }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.areas.update', $area) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label for="name" class="form-label">Area Name <span class="text-danger">*</span></label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', $area->name) }}" 
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
                                            <option value="{{ $governorate->id }}" 
                                                    {{ old('governorate_id', $area->governorate_id) == $governorate->id ? 'selected' : '' }}>
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
                            
                            <!-- Current Info Box -->
                            <div class="alert alert-light border">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-dark mb-2">Current Information:</h6>
                                        <ul class="mb-0 text-muted">
                                            <li><strong>Area:</strong> {{ $area->name }}</li>
                                            <li><strong>Governorate:</strong> {{ $area->governorate->name }}</li>
                                            <li><strong>Properties:</strong> {{ $area->properties->count() }} properties associated</li>
                                            <li><strong>Created:</strong> {{ $area->created_at->format('M d, Y') }}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-dark mb-2">Update Guidelines:</h6>
                                        <ul class="mb-0 text-muted">
                                            <li>Area names must be unique</li>
                                            <li>Changing governorate may affect existing properties</li>
                                            <li>All associated properties will remain linked</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Warning if area has properties -->
                            @if($area->properties->count() > 0)
                            <div class="alert alert-warning border-0">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-exclamation-triangle text-warning me-3 mt-1"></i>
                                    <div>
                                        <h6 class="text-warning mb-1">Important Notice:</h6>
                                        <p class="mb-0 text-warning">
                                            This area has <strong>{{ $area->properties->count() }} properties</strong> associated with it. 
                                            Any changes you make will affect these properties.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('admin.areas.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Areas
                                </a>
                                
                                <div class="d-flex gap-2">
                                    <button type="reset" class="btn btn-outline-warning">
                                        <i class="fas fa-undo me-2"></i>Reset Changes
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i>Update Area
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Associated Properties Card -->
                @if($area->properties->count() > 0)
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-light border-0">
                        <h6 class="mb-0">
                            <i class="fas fa-home text-primary me-2"></i>
                            Properties in {{ $area->name }} ({{ $area->properties->count() }})
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Property</th>
                                        <th>Owner</th>
                                        <th>Status</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($area->properties->take(5) as $property)
                                    <tr>
                                        <td>
                                            <strong>{{ Str::limit($property->title, 30) }}</strong>
                                        </td>
                                        <td>{{ $property->user->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-{{ $property->status === 'approved' ? 'success' : ($property->status === 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($property->status) }}
                                            </span>
                                        </td>
                                        <td>{{ number_format($property->price) }} JD</td>
                                    </tr>
                                    @endforeach
                                    @if($area->properties->count() > 5)
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            ... and {{ $area->properties->count() - 5 }} more properties
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
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
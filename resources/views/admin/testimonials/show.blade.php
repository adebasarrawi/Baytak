@extends('layouts.admin.app')

@section('title', 'View Testimonial')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">View Testimonial</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.testimonials.index') }}">Testimonials</a></li>
        <li class="breadcrumb-item active">View</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-comment me-1"></i> Testimonial Details (Read-Only)
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="testimonial-preview p-4 border rounded bg-light">
                        <div class="d-flex align-items-center mb-3">
                            @if($testimonial->image_path && file_exists(public_path('storage/' . $testimonial->image_path)))
                                <img src="{{ asset('storage/' . $testimonial->image_path) }}" 
                                     alt="{{ $testimonial->name }}" 
                                     class="rounded-circle me-3" 
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-3"
                                     style="width: 60px; height: 60px; color: white;">
                                    <span class="h3 mb-0">{{ strtoupper(substr($testimonial->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <div>
                                <h5 class="mb-0">{{ $testimonial->name }}</h5>
                                @if($testimonial->position)
                                    <p class="text-muted mb-0">{{ $testimonial->position }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="ratings mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                            <span class="ms-2">({{ $testimonial->rating }} / 5)</span>
                        </div>
                        
                        @if($testimonial->area)
                            <div class="area mb-3">
                                <span class="badge bg-light text-primary border">
                                    <i class="fas fa-map-marker-alt me-1"></i> {{ $testimonial->area->name }}
                                </span>
                            </div>
                        @endif
                        
                        <blockquote class="p-3 border-start border-primary border-3">
                            {{ $testimonial->content }}
                        </blockquote>
                        
                        <div class="text-muted mt-4">
                            <small>Submitted on {{ $testimonial->created_at->format('F d, Y \a\t h:i A') }}</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">Testimonial Status</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Current Status:</label>
                                <div>
                                    <span class="badge {{ $testimonial->is_active ? 'bg-success' : 'bg-secondary' }} p-2">
                                        {{ $testimonial->is_active ? 'Approved' : 'Pending' }}
                                    </span>
                                </div>
                            </div>
                            
                            <form action="{{ route('admin.testimonials.toggle-status', $testimonial) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn {{ $testimonial->is_active ? 'btn-outline-secondary' : 'btn-outline-success' }} w-100">
                                    {{ $testimonial->is_active ? 'Set to Pending' : 'Approve Testimonial' }}
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">Actions</div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-1"></i> Back to List
                                </a>
                                
                                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100" 
                                            onclick="return confirm('Are you sure you want to delete this testimonial? This action cannot be undone.');">
                                        <i class="fas fa-trash me-1"></i> Delete Testimonial
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
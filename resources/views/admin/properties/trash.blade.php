@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title text-dark">Properties Trash</h4>
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
                    <a href="{{ route('admin.properties.index') }}" class="text-decoration-none">Properties</a>
                </li>
                <li class="separator">
                    <i class="fas fa-angle-right"></i>
                </li>
                <li class="nav-item">
                    <span class="text-muted">Trash</span>
                </li>
            </ul>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        <!-- Trash Info Card -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-gradient-warning text-white border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ $trashCount ?? 0 }}</h3>
                                <p class="mb-0 opacity-75">Properties in Trash</p>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-trash fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start">
                            <h4 class="card-title text-dark mb-3 mb-md-0">
                                <i class="fas fa-trash me-2 text-warning"></i>
                                Deleted Properties
                            </h4>
                            
                            <!-- Filter Section -->
                            <div class="d-flex gap-2">
                                <form class="d-flex gap-2" action="{{ route('admin.properties.trash') }}" method="GET">
                                    <!-- Search Input -->
                                    <div class="input-group" style="min-width: 250px;">
                                        <input type="text" class="form-control" name="search" 
                                               placeholder="Search deleted properties..." 
                                               value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Clear Search -->
                                    @if(request('search'))
                                    <a href="{{ route('admin.properties.trash') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Clear
                                    </a>
                                    @endif
                                </form>
                                
                                <!-- Back to Properties -->
                                <a href="{{ route('admin.properties.index') }}" class="btn btn-success">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Properties
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Info Alert -->
                        <div class="alert alert-info border-0 bg-light-info">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-info-circle text-info me-2"></i>
                                <div>
                                    <strong>Deleted Properties Archive:</strong> 
                                    This page shows all deleted properties for reference. You can view their details but cannot restore them.
                                </div>
                            </div>
                        </div>
                        
                        <!-- Properties Table -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">ID</th>
                                        <th class="border-0">Property</th>
                                        <th class="border-0">Owner</th>
                                        <th class="border-0">Type</th>
                                        <th class="border-0">Price</th>
                                        <th class="border-0">Deleted Date</th>
                                        <th class="border-0 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($properties as $property)
                                    <tr class="table-warning bg-light">
                                        <td><strong class="text-primary">#{{ $property->id }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($property->images && $property->images->where('is_primary', 1)->first())
                                                    <img src="{{ asset('storage/' . $property->images->where('is_primary', 1)->first()->image_path) }}" 
                                                         class="rounded shadow-sm me-3 opacity-75" width="50" height="50" alt="Property">
                                                @elseif($property->images && $property->images->first())
                                                    <img src="{{ asset('storage/' . $property->images->first()->image_path) }}" 
                                                         class="rounded shadow-sm me-3 opacity-75" width="50" height="50" alt="Property">
                                                @else
                                                    <div class="bg-light rounded shadow-sm me-3 d-flex align-items-center justify-content-center opacity-75" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-home text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-1 text-muted">
                                                        <del>{{ \Illuminate\Support\Str::limit($property->title, 30) }}</del>
                                                    </h6>
                                                    <small class="text-muted">
                                                        {{ $property->location ?? 'No location' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong class="text-muted">
                                                    {{ $property->user ? $property->user->name : 'User Deleted' }}
                                                </strong>
                                                @if($property->user)
                                                <small class="text-muted d-block">{{ $property->user->email }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary rounded-pill">
                                                {{ $property->type ? $property->type->name : 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="text-muted">{{ number_format($property->price) }} JD</strong>
                                        </td>
                                        <td>
                                            <div>
                                                <strong class="text-muted">
                                                    {{ $property->deleted_at ? $property->deleted_at->format('M d, Y') : 'N/A' }}
                                                </strong>
                                                @if($property->deleted_at)
                                                <small class="text-muted d-block">
                                                    {{ $property->deleted_at->diffForHumans() }}
                                                </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <!-- View Property Details -->
                                            <button class="btn btn-sm btn-outline-info" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#viewModal{{ $property->id }}">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </button>
                                        </td>
                                    </tr>
                                    
                                    <!-- View Details Modal -->
                                    <div class="modal fade" id="viewModal{{ $property->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-home text-primary me-2"></i>
                                                        Property Details (Deleted)
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Property Title</label>
                                                                <p class="fw-bold">{{ $property->title }}</p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Location</label>
                                                                <p>{{ $property->location ?? $property->address ?? 'No location' }}</p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Property Type</label>
                                                                <p>
                                                                    <span class="badge bg-info">
                                                                        {{ $property->type ? $property->type->name : 'N/A' }}
                                                                    </span>
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Price</label>
                                                                <p class="fw-bold text-success">{{ number_format($property->price) }} JD</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Owner</label>
                                                                <p>{{ $property->user ? $property->user->name : 'User Deleted' }}</p>
                                                                @if($property->user)
                                                                <small class="text-muted">{{ $property->user->email }}</small>
                                                                @endif
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Status Before Deletion</label>
                                                                <p>
                                                                    @php
                                                                        $statusClass = [
                                                                            'pending' => 'warning',
                                                                            'approved' => 'success',
                                                                            'rejected' => 'danger'
                                                                        ][$property->status] ?? 'secondary';
                                                                    @endphp
                                                                    <span class="badge bg-{{ $statusClass }}">
                                                                        {{ ucfirst($property->status) }}
                                                                    </span>
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Created Date</label>
                                                                <p>{{ $property->created_at->format('M d, Y H:i') }}</p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Deleted Date</label>
                                                                <p class="text-danger fw-bold">
                                                                    {{ $property->deleted_at ? $property->deleted_at->format('M d, Y H:i') : 'N/A' }}
                                                                    @if($property->deleted_at)
                                                                    <br><small>({{ $property->deleted_at->diffForHumans() }})</small>
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    @if($property->description)
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Description</label>
                                                        <p class="border p-3 bg-light rounded">{{ $property->description }}</p>
                                                    </div>
                                                    @endif
                                                    
                                                    @if($property->images && $property->images->count() > 0)
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Property Images ({{ $property->images->count() }})</label>
                                                        <div class="row">
                                                            @foreach($property->images->take(4) as $image)
                                                            <div class="col-3 mb-2">
                                                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                                     class="img-fluid rounded border opacity-75" 
                                                                     alt="Property Image">
                                                            </div>
                                                            @endforeach
                                                            @if($property->images->count() > 4)
                                                            <div class="col-12">
                                                                <small class="text-muted">+ {{ $property->images->count() - 4 }} more images</small>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="empty-state">
                                                <div class="mb-3">
                                                    <i class="fas fa-trash fa-4x text-muted opacity-50"></i>
                                                </div>
                                                <h5 class="text-muted">Trash is Empty</h5>
                                                <p class="text-muted mb-0">
                                                    @if(request('search'))
                                                        No deleted properties match your search.
                                                        <br>
                                                        <a href="{{ route('admin.properties.trash') }}" class="btn btn-sm btn-primary mt-2">
                                                            <i class="fas fa-times me-1"></i>Clear Search
                                                        </a>
                                                    @else
                                                        No properties have been moved to trash yet.
                                                    @endif
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($properties && $properties->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Showing {{ $properties->firstItem() }} to {{ $properties->lastItem() }} 
                                of {{ $properties->total() }} deleted properties
                            </div>
                            <nav aria-label="Trash pagination">
                                <ul class="pagination pagination-sm mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($properties->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $properties->appends(request()->query())->previousPageUrl() }}">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($properties->appends(request()->query())->getUrlRange(1, $properties->lastPage()) as $page => $url)
                                        @if ($page == $properties->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next Page Link --}}
                                    @if ($properties->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $properties->appends(request()->query())->nextPageUrl() }}">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%);
}

.bg-light-info {
    background-color: #e7f3ff !important;
}

.table-warning {
    --bs-table-bg: #fff8e1;
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.table th {
    font-weight: 600;
    color: #495057;
}

.pagination .page-link {
    border-radius: 0.375rem;
    margin: 0 2px;
    border: 1px solid #dee2e6;
}

.pagination .page-item.active .page-link {
    background-color: #007bff;
    border-color: #007bff;
}

.empty-state {
    padding: 2rem 0;
}

@media (max-width: 768px) {
    .d-flex.flex-column.flex-md-row {
        align-items: stretch;
    }
    
    .d-flex.flex-column.flex-md-row .btn {
        margin-bottom: 2px;
        width: 100%;
    }
}
</style>
@endsection
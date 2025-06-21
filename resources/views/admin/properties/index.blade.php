@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title text-dark">Property Management</h4>
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
                    <span class="text-muted">Properties</span>
                </li>
            </ul>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        <!-- Status Dashboard -->
        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card bg-gradient-warning text-white border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ $statusCounts['pending'] ?? 0 }}</h3>
                                <p class="mb-0 opacity-75">Pending Properties</p>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card bg-gradient-success text-white border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ $statusCounts['approved'] ?? 0 }}</h3>
                                <p class="mb-0 opacity-75">Approved Properties</p>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card bg-gradient-danger text-white border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ $statusCounts['rejected'] ?? 0 }}</h3>
                                <p class="mb-0 opacity-75">Rejected Properties</p>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-times-circle fa-2x"></i>
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
                            <h4 class="card-title text-dark mb-3 mb-md-0">Manage Properties</h4>
                            
                            <!-- Enhanced Filter Section -->
                            <div class="d-flex flex-column flex-md-row gap-2 w-100 w-md-auto">
                                <form class="d-flex gap-2 flex-wrap" action="{{ route('admin.properties.index') }}" method="GET">
                                    <!-- Search Input -->
                                    <div class="input-group" style="min-width: 250px;">
                                        <input type="text" class="form-control" name="search" 
                                               placeholder="Search properties..." 
                                               value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Status Filter -->
                                    <select name="status" class="form-select" onchange="this.form.submit()">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    
                                    <!-- Clear Filters -->
                                    @if(request('search') || request('status'))
                                    <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Clear
                                    </a>
                                    @endif
                                </form>
                                
                                <!-- Trash Button -->
                                <a href="{{ route('admin.properties.trash') }}" class="btn btn-outline-warning">
                                    <i class="fas fa-trash me-2"></i>View Trash
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
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
                                        <th class="border-0">Status</th>
                                        <th class="border-0 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($properties as $property)
                                    <tr>
                                        <td><strong class="text-primary">#{{ $property->id }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($property->images && $property->images->where('is_primary', 1)->first())
                                                    <img src="{{ asset('storage/' . $property->images->where('is_primary', 1)->first()->image_path) }}" 
                                                         class="rounded shadow-sm me-3" width="50" height="50" alt="Property">
                                                @elseif($property->images && $property->images->first())
                                                    <img src="{{ asset('storage/' . $property->images->first()->image_path) }}" 
                                                         class="rounded shadow-sm me-3" width="50" height="50" alt="Property">
                                                @else
                                                    <div class="bg-light rounded shadow-sm me-3 d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px;">
                                                        <i class="fas fa-home text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-1">
                                                        <a href="{{ route('properties.show', $property->id) }}" 
                                                           target="_blank" class="text-decoration-none text-dark">
                                                            {{ \Illuminate\Support\Str::limit($property->title, 30) }}
                                                        </a>
                                                    </h6>
                                                    <small class="text-muted">
                                                        {{ $property->location ?? 'No location' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong class="text-dark">
                                                    {{ $property->user ? $property->user->name : 'User Deleted' }}
                                                </strong>
                                                @if($property->user)
                                                <small class="text-muted d-block">{{ $property->user->email }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info rounded-pill">
                                                {{ $property->type ? $property->type->name : 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="text-success">{{ number_format($property->price) }} JD</strong>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'pending' => 'warning',
                                                    'approved' => 'success',
                                                    'rejected' => 'danger'
                                                ][$property->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }} rounded-pill">
                                                {{ ucfirst($property->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column flex-md-row gap-1 justify-content-center">
                                                <!-- View Property -->
                                                <a href="{{ route('properties.show', $property->id) }}" 
                                                   target="_blank"
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </a>
                                                
                                                <!-- Edit/Review Property -->
                                                <a href="{{ route('admin.properties.edit', $property->id) }}" 
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-edit me-1"></i>Review
                                                </a>
                                                
                                                <!-- Move to Trash -->
                                                <button class="btn btn-sm btn-outline-warning" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal{{ $property->id }}">
                                                    <i class="fas fa-archive me-1"></i>Trash
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $property->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                                        Move to Trash
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center mb-3">
                                                        <i class="fas fa-archive fa-3x text-warning mb-3"></i>
                                                        <h6>Are you sure you want to move this property to trash?</h6>
                                                        <p class="text-muted mb-0">
                                                            <strong>{{ $property->title }}</strong><br>
                                                            This property will be moved to trash and can be restored later.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i>Cancel
                                                    </button>
                                                    <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-warning">
                                                            <i class="fas fa-archive me-1"></i>Move to Trash
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="empty-state">
                                                <div class="mb-3">
                                                    <i class="fas fa-home fa-4x text-muted opacity-50"></i>
                                                </div>
                                                <h5 class="text-muted">No Properties Found</h5>
                                                <p class="text-muted mb-0">
                                                    @if(request('search') || request('status'))
                                                        No properties match your current filters.
                                                        <br>
                                                        <a href="{{ route('admin.properties.index') }}" class="btn btn-sm btn-primary mt-2">
                                                            <i class="fas fa-times me-1"></i>Clear Filters
                                                        </a>
                                                    @else
                                                        No properties have been created yet.
                                                    @endif
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Enhanced Pagination -->
                        @if($properties->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Showing {{ $properties->firstItem() }} to {{ $properties->lastItem() }} 
                                of {{ $properties->total() }} properties
                            </div>
                            <nav aria-label="Properties pagination">
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
.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
}
.bg-gradient-danger {
    background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%);
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.btn-group .btn {
    border-radius: 0.375rem !important;
    margin-right: 2px;
}

.btn-group .btn:last-child {
    margin-right: 0;
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
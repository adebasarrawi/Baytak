@extends('layouts.admin.app')

@section('title', 'Areas Management')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title text-dark">Areas Management</h4>
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
                    <span class="text-muted">Areas</span>
                </li>
            </ul>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-gradient-primary text-white border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ $totalAreas }}</h3>
                                <p class="mb-0 opacity-75">Total Areas</p>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-map-marker-alt fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-gradient-success text-white border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ $areasWithProperties }}</h3>
                                <p class="mb-0 opacity-75">Areas with Properties</p>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-home fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-gradient-warning text-white border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ $areasWithoutProperties }}</h3>
                                <p class="mb-0 opacity-75">Empty Areas</p>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-map fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-gradient-info text-white border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ $totalProperties }}</h3>
                                <p class="mb-0 opacity-75">Total Properties</p>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-building fa-2x"></i>
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
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                All Areas
                            </h4>
                            
                            <!-- Filter Section -->
                            <div class="d-flex flex-column flex-md-row gap-2">
                                <form class="d-flex gap-2 flex-wrap" action="{{ route('admin.areas.index') }}" method="GET">
                                    <!-- Search Input -->
                                    <div class="input-group" style="min-width: 250px;">
                                        <input type="text" class="form-control" name="search" 
                                               placeholder="Search areas..." 
                                               value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Governorate Filter -->
                                    <select name="governorate" class="form-select" onchange="this.form.submit()">
                                        <option value="">All Governorates</option>
                                        @foreach($governorates as $gov)
                                        <option value="{{ $gov->id }}" {{ request('governorate') == $gov->id ? 'selected' : '' }}>
                                            {{ $gov->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    
                                    <!-- Clear Filters -->
                                    @if(request('search') || request('governorate'))
                                    <a href="{{ route('admin.areas.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Clear
                                    </a>
                                    @endif
                                </form>
                                
                                <!-- Add New Area -->
                                <a href="{{ route('admin.areas.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus me-2"></i>Add New Area
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">ID</th>
                                        <th class="border-0">Area Name</th>
                                        <th class="border-0">Governorate</th>
                                        <th class="border-0">Properties Count</th>
                                        <th class="border-0">Created Date</th>
                                        <th class="border-0 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($areas as $area)
                                    <tr>
                                        <td><strong class="text-primary">#{{ $area->id }}</strong></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded-circle me-3 d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-map-marker-alt text-primary"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 text-dark">{{ $area->name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info rounded-pill">
                                                {{ $area->governorate->name }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($area->properties_count > 0)
                                                <span class="badge bg-success rounded-pill">
                                                    {{ $area->properties_count }} Properties
                                                </span>
                                            @else
                                                <span class="badge bg-secondary rounded-pill">
                                                    No Properties
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div>
                                                <strong class="text-dark">{{ $area->created_at->format('M d, Y') }}</strong>
                                                <small class="text-muted d-block">{{ $area->created_at->diffForHumans() }}</small>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column flex-md-row gap-1 justify-content-center">
                                                <!-- Edit Area -->
                                                <a href="{{ route('admin.areas.edit', $area) }}" 
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </a>
                                                
                                                <!-- Delete Area -->
                                                @if($area->properties_count == 0)
                                                <button class="btn btn-sm btn-outline-danger delete-btn" 
                                                        data-area-id="{{ $area->id }}"
                                                        data-area-name="{{ $area->name }}"
                                                        data-governorate-name="{{ $area->governorate->name }}">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                                @else
                                                <button class="btn btn-sm btn-outline-secondary" disabled title="Cannot delete - has properties">
                                                    <i class="fas fa-lock me-1"></i>Locked
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="empty-state">
                                                <div class="mb-3">
                                                    <i class="fas fa-map-marker-alt fa-4x text-muted opacity-50"></i>
                                                </div>
                                                <h5 class="text-muted">No Areas Found</h5>
                                                <p class="text-muted mb-0">
                                                    @if(request('search') || request('governorate'))
                                                        No areas match your current filters.
                                                        <br>
                                                        <a href="{{ route('admin.areas.index') }}" class="btn btn-sm btn-primary mt-2">
                                                            <i class="fas fa-times me-1"></i>Clear Filters
                                                        </a>
                                                    @else
                                                        <a href="{{ route('admin.areas.create') }}" class="btn btn-sm btn-success mt-2">
                                                            <i class="fas fa-plus me-1"></i>Add First Area
                                                        </a>
                                                    @endif
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Fixed Pagination -->
                        @if($areas->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap">
                            <div class="text-muted mb-2 mb-md-0">
                                Showing {{ $areas->firstItem() }} to {{ $areas->lastItem() }} 
                                of {{ $areas->total() }} areas
                            </div>
                            <nav aria-label="Areas pagination">
                                <ul class="pagination pagination-sm mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($areas->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $areas->appends(request()->query())->previousPageUrl() }}" rel="prev">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($areas->appends(request()->query())->getUrlRange(1, $areas->lastPage()) as $page => $url)
                                        @if ($page == $areas->currentPage())
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
                                    @if ($areas->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $areas->appends(request()->query())->nextPageUrl() }}" rel="next">
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

        <!-- Statistics Row -->
        <div class="row mt-4">
            <!-- Areas by Governorate -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-pie text-info me-2"></i>
                            Areas by Governorate
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Governorate</th>
                                        <th>Areas Count</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($areasByGovernorate as $govArea)
                                    <tr>
                                        <td><strong>{{ $govArea->governorate_name }}</strong></td>
                                        <td>{{ $govArea->count }}</td>
                                        <td>
                                            <span class="badge bg-info">
                                                {{ $totalAreas > 0 ? round(($govArea->count / $totalAreas) * 100, 1) : 0 }}%
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No data available</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Areas with Most Properties -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-trophy text-warning me-2"></i>
                            Top Areas (Most Properties)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Area</th>
                                        <th>Governorate</th>
                                        <th>Properties</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($topAreas as $topArea)
                                    <tr>
                                        <td><strong>{{ $topArea->name }}</strong></td>
                                        <td>
                                            <span class="badge bg-info">{{ $topArea->governorate->name }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-success">{{ $topArea->properties_count }}</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">No data available</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Single Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Confirm Deletion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="fas fa-map-marker-alt fa-3x text-danger mb-3"></i>
                    <h6>Are you sure you want to delete this area?</h6>
                    <p class="text-muted mb-2">
                        <strong id="modal-area-name"></strong><br>
                        <small id="modal-governorate-name"></small>
                    </p>
                    <p class="text-muted">This action cannot be undone.</p>
                </div>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <form id="delete-form" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Delete Area
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
}

.table th {
    font-weight: 600;
    color: #495057;
}

.empty-state {
    padding: 2rem 0;
}

.pagination {
    --bs-pagination-padding-x: 0.75rem;
    --bs-pagination-padding-y: 0.375rem;
    --bs-pagination-color: #6c757d;
    --bs-pagination-bg: #fff;
    --bs-pagination-border-color: #dee2e6;
    --bs-pagination-hover-color: #0056b3;
    --bs-pagination-hover-bg: #e9ecef;
    --bs-pagination-active-color: #fff;
    --bs-pagination-active-bg: #007bff;
}

@media (max-width: 768px) {
    .d-flex.flex-column.flex-md-row {
        align-items: stretch;
    }
    
    .d-flex.flex-column.flex-md-row .btn {
        margin-bottom: 2px;
        width: 100%;
    }
    
    .pagination {
        justify-content: center;
    }
}

/* Fix modal backdrop issues */
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.5);
}

.modal {
    z-index: 1050;
}

.modal-backdrop {
    z-index: 1040;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle delete button clicks
    const deleteButtons = document.querySelectorAll('.delete-btn');
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('delete-form');
    const modalAreaName = document.getElementById('modal-area-name');
    const modalGovernorateName = document.getElementById('modal-governorate-name');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const areaId = this.dataset.areaId;
            const areaName = this.dataset.areaName;
            const governorateName = this.dataset.governorateName;
            
            // Update modal content
            modalAreaName.textContent = areaName;
            modalGovernorateName.textContent = governorateName;
            deleteForm.action = `/admin/areas/${areaId}`;
            
            // Show modal using Bootstrap 5 method
            const modal = new bootstrap.Modal(deleteModal);
            modal.show();
        });
    });
});
</script>
@endsection
@extends('layouts.admin.app')

@section('title', 'Testimonials Management')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title text-dark">Testimonials Management</h4>
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
                    <span class="text-muted">Testimonials</span>
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
            <div class="col-lg-6 col-md-6 mb-3">
                <div class="card bg-gradient-success text-white border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ $testimonials->where('is_active', 1)->count() }}</h3>
                                <p class="mb-0 opacity-75">Approved Testimonials</p>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 mb-3">
                <div class="card bg-gradient-warning text-white border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ $testimonials->where('is_active', 0)->count() }}</h3>
                                <p class="mb-0 opacity-75">Pending Testimonials</p>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-clock fa-2x"></i>
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
                                <i class="fas fa-comments me-2 text-primary"></i>
                                All Testimonials
                            </h4>
                            
                            <!-- Filter Section -->
                            <div class="d-flex gap-2">
                                <form class="d-flex gap-2" action="{{ route('admin.testimonials.index') }}" method="GET">
                                    <!-- Search Input -->
                                    <div class="input-group" style="min-width: 250px;">
                                        <input type="text" class="form-control" name="search" 
                                               placeholder="Search testimonials..." 
                                               value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Status Filter -->
                                    <select name="status" class="form-select" onchange="this.form.submit()">
                                        <option value="">All Status</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Approved</option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                    
                                    <!-- Clear Filters -->
                                    @if(request('search') || request('status') !== null)
                                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Clear
                                    </a>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">ID</th>
                                        <th class="border-0">Customer Info</th>
                                        <th class="border-0">Rating</th>
                                        <th class="border-0">Area</th>
                                        <th class="border-0">Date</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($testimonials as $testimonial)
                                    <tr>
                                        <td><strong class="text-primary">#{{ $testimonial->id }}</strong></td>
                                        <td>
                                            <div>
                                                <h6 class="mb-1 text-dark">{{ $testimonial->name }}</h6>
                                                <small class="text-muted">{{ $testimonial->position ?? 'Customer' }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                    @endfor
                                                </div>
                                                <span class="badge bg-primary rounded-pill">{{ $testimonial->rating }}/5</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info rounded-pill">
                                                {{ $testimonial->area ? $testimonial->area->name : 'N/A' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong class="text-dark">{{ $testimonial->created_at->format('M d, Y') }}</strong>
                                                <small class="text-muted d-block">{{ $testimonial->created_at->diffForHumans() }}</small>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.testimonials.toggle-status', $testimonial) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="btn btn-sm {{ $testimonial->is_active ? 'btn-success' : 'btn-warning' }} rounded-pill"
                                                        data-confirm="Are you sure you want to {{ $testimonial->is_active ? 'hide' : 'approve' }} this testimonial?"
                                                        onclick="return confirm(this.dataset.confirm)">
                                                    @if($testimonial->is_active)
                                                        <i class="fas fa-check me-1"></i>Approved
                                                    @else
                                                        <i class="fas fa-clock me-1"></i>Pending
                                                    @endif
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column flex-md-row gap-1 justify-content-center">
                                                <!-- View Details -->
                                                <button class="btn btn-sm btn-outline-info" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#viewModal{{ $testimonial->id }}">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </button>
                                                
                                                <!-- Delete -->
                                                <button class="btn btn-sm btn-outline-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal{{ $testimonial->id }}">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <!-- View Details Modal -->
                                    <div class="modal fade" id="viewModal{{ $testimonial->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-comment-dots text-primary me-2"></i>
                                                        Testimonial Details
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Customer Name</label>
                                                                <p class="fw-bold">{{ $testimonial->name }}</p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Position/Title</label>
                                                                <p>{{ $testimonial->position ?? 'Not specified' }}</p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Rating</label>
                                                                <div class="d-flex align-items-center">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }} me-1"></i>
                                                                    @endfor
                                                                    <span class="ms-2 fw-bold">{{ $testimonial->rating }}/5</span>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Area</label>
                                                                <p>
                                                                    <span class="badge bg-info">
                                                                        {{ $testimonial->area ? $testimonial->area->name : 'N/A' }}
                                                                    </span>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Status</label>
                                                                <p>
                                                                    <span class="badge bg-{{ $testimonial->is_active ? 'success' : 'warning' }} rounded-pill">
                                                                        {{ $testimonial->is_active ? 'Approved' : 'Pending' }}
                                                                    </span>
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Submitted Date</label>
                                                                <p>{{ $testimonial->created_at->format('l, F j, Y \a\t g:i A') }}</p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Time Ago</label>
                                                                <p class="text-muted">{{ $testimonial->created_at->diffForHumans() }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label text-muted">Testimonial Message</label>
                                                        <div class="border rounded p-3 bg-light">
                                                            <blockquote class="blockquote mb-0">
                                                                <p>"{{ $testimonial->message }}"</p>
                                                                <footer class="blockquote-footer mt-2">
                                                                    <cite title="Source Title">{{ $testimonial->name }}</cite>
                                                                </footer>
                                                            </blockquote>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <form action="{{ route('admin.testimonials.toggle-status', $testimonial) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-{{ $testimonial->is_active ? 'warning' : 'success' }}">
                                                            @if($testimonial->is_active)
                                                                <i class="fas fa-eye-slash me-1"></i>Hide
                                                            @else
                                                                <i class="fas fa-check me-1"></i>Approve
                                                            @endif
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $testimonial->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                                        Confirm Deletion
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center mb-3">
                                                        <i class="fas fa-trash fa-3x text-danger mb-3"></i>
                                                        <h6>Are you sure you want to delete this testimonial?</h6>
                                                        <p class="text-muted mb-0">
                                                            <strong>From: {{ $testimonial->name }}</strong><br>
                                                            This action cannot be undone.
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-1"></i>Cancel
                                                    </button>
                                                    <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash me-1"></i>Delete Testimonial
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
                                                    <i class="fas fa-comments fa-4x text-muted opacity-50"></i>
                                                </div>
                                                <h5 class="text-muted">No Testimonials Found</h5>
                                                <p class="text-muted mb-0">
                                                    @if(request('search') || request('status') !== null)
                                                        No testimonials match your current filters.
                                                        <br>
                                                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-sm btn-primary mt-2">
                                                            <i class="fas fa-times me-1"></i>Clear Filters
                                                        </a>
                                                    @else
                                                        No testimonials have been submitted yet.
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
                        @if($testimonials->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Showing {{ $testimonials->firstItem() }} to {{ $testimonials->lastItem() }} 
                                of {{ $testimonials->total() }} testimonials
                            </div>
                            <nav aria-label="Testimonials pagination">
                                <ul class="pagination pagination-sm mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($testimonials->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $testimonials->appends(request()->query())->previousPageUrl() }}">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($testimonials->appends(request()->query())->getUrlRange(1, $testimonials->lastPage()) as $page => $url)
                                        @if ($page == $testimonials->currentPage())
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
                                    @if ($testimonials->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $testimonials->appends(request()->query())->nextPageUrl() }}">
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
.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%);
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

.blockquote {
    font-style: italic;
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
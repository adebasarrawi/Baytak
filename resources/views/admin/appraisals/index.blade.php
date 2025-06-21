@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title text-dark">Property Appraisal Appointments</h4>
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
                    <span class="text-muted">Appointments</span>
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
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-gradient-warning text-white border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ $statusCounts['pending'] ?? 0 }}</h3>
                                <p class="mb-0 opacity-75">Pending Appointments</p>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-clock fa-2x"></i>
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
                                <h3 class="mb-0">{{ $statusCounts['confirmed'] ?? 0 }}</h3>
                                <p class="mb-0 opacity-75">Confirmed Appointments</p>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-check-circle fa-2x"></i>
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
                                <h3 class="mb-0">{{ $statusCounts['completed'] ?? 0 }}</h3>
                                <p class="mb-0 opacity-75">Completed Appointments</p>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-flag-checkered fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-gradient-danger text-white border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ $statusCounts['cancelled'] ?? 0 }}</h3>
                                <p class="mb-0 opacity-75">Cancelled Appointments</p>
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
                        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start">
                            <h4 class="card-title text-dark mb-3 mb-lg-0">Manage Appointments</h4>
                            
                            <!-- Enhanced Filter Section -->
                            <div class="d-flex flex-column flex-lg-row gap-2 w-100 w-lg-auto">
                                <form class="d-flex gap-2 flex-wrap" action="{{ route('admin.appraisals.index') }}" method="GET">
                                    <!-- Search Input -->
                                    <div class="input-group" style="min-width: 250px;">
                                        <input type="text" class="form-control" name="search" 
                                               placeholder="Search client, phone, address..." 
                                               value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Status Filter -->
                                    <select name="status" class="form-select" onchange="this.form.submit()">
                                        <option value="">All Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    
                                    <!-- Date Filter -->
                                    <input type="date" name="date" class="form-control" 
                                           value="{{ request('date') }}" 
                                           onchange="this.form.submit()"
                                           title="Filter by appointment date">
                                    
                                    <!-- Clear Filters -->
                                    @if(request('search') || request('status') || request('date'))
                                    <a href="{{ route('admin.appraisals.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times me-1"></i>Clear
                                    </a>
                                    @endif
                                </form>
                                
                                <!-- Calendar View Button -->
                                <a href="{{ route('admin.appraisals.calendar') }}" class="btn btn-success">
                                    <i class="fas fa-calendar-alt me-2"></i>Calendar View
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Appointments Table -->
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="border-0">ID</th>
                                        <th class="border-0">Client Information</th>
                                        <th class="border-0">Property Details</th>
                                        <th class="border-0">Appointment</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appraisals ?? [] as $appraisal)
                                    <tr>
                                        <td><strong class="text-primary">#{{ $appraisal->id }}</strong></td>
                                        <td>
                                            <div>
                                                <h6 class="mb-1 text-dark">{{ $appraisal->client_name }}</h6>
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-envelope me-1"></i>{{ $appraisal->client_email }}
                                                </small>
                                                <small class="text-muted d-block">
                                                    <i class="fas fa-phone me-1"></i>{{ $appraisal->client_phone }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <h6 class="mb-1 text-dark">{{ \Illuminate\Support\Str::limit($appraisal->property_address, 40) }}</h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-home me-1"></i>{{ $appraisal->property_type ?? 'Property Type' }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong class="text-dark d-block">
                                                    {{ \Carbon\Carbon::parse($appraisal->appointment_date)->format('M d, Y') }}
                                                </strong>
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($appraisal->appointment_time)->format('g:i A') }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $statusConfig = [
                                                    'pending' => ['class' => 'warning', 'icon' => 'clock'],
                                                    'confirmed' => ['class' => 'success', 'icon' => 'check-circle'],
                                                    'completed' => ['class' => 'info', 'icon' => 'flag-checkered'],
                                                    'cancelled' => ['class' => 'danger', 'icon' => 'times-circle']
                                                ];
                                                $config = $statusConfig[$appraisal->status] ?? ['class' => 'secondary', 'icon' => 'question'];
                                            @endphp
                                            <span class="badge bg-{{ $config['class'] }} rounded-pill">
                                                <i class="fas fa-{{ $config['icon'] }} me-1"></i>
                                                {{ ucfirst($appraisal->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column flex-md-row gap-1 justify-content-center">
                                                <!-- View Details -->
                                                <button class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#detailsModal{{ $appraisal->id }}">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </button>
                                                
                                                <!-- Edit Appointment -->
                                                <a href="{{ route('admin.appraisals.edit', $appraisal->id) }}" 
                                                   class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </a>
                                                
                                                <!-- Quick Status Update -->
                                                @if($appraisal->status === 'pending')
                                                <form method="POST" action="{{ route('admin.appraisals.update-status', $appraisal->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="btn btn-sm btn-outline-warning"
                                                            onclick="return confirm('Confirm this appointment?')">
                                                        <i class="fas fa-check me-1"></i>Confirm
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    <!-- Details Modal -->
                                    <div class="modal fade" id="detailsModal{{ $appraisal->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        <i class="fas fa-calendar-check text-primary me-2"></i>
                                                        Appointment Details #{{ $appraisal->id }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Client Name</label>
                                                                <p class="fw-bold">{{ $appraisal->client_name }}</p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Contact Information</label>
                                                                <p class="mb-1">
                                                                    <i class="fas fa-envelope me-2 text-primary"></i>
                                                                    {{ $appraisal->client_email }}
                                                                </p>
                                                                <p class="mb-0">
                                                                    <i class="fas fa-phone me-2 text-success"></i>
                                                                    {{ $appraisal->client_phone }}
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Property Address</label>
                                                                <p class="fw-bold">{{ $appraisal->property_address }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Appointment Date</label>
                                                                <p class="fw-bold">
                                                                    {{ \Carbon\Carbon::parse($appraisal->appointment_date)->format('l, F j, Y') }}
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Appointment Time</label>
                                                                <p class="fw-bold">
                                                                    {{ \Carbon\Carbon::parse($appraisal->appointment_time)->format('g:i A') }}
                                                                </p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Current Status</label>
                                                                <p>
                                                                    <span class="badge bg-{{ $config['class'] }} rounded-pill">
                                                                        <i class="fas fa-{{ $config['icon'] }} me-1"></i>
                                                                        {{ ucfirst($appraisal->status) }}
                                                                    </span>
                                                                </p>
                                                            </div>
                                                            @if($appraisal->notes)
                                                            <div class="mb-3">
                                                                <label class="form-label text-muted">Additional Notes</label>
                                                                <p>{{ $appraisal->notes }}</p>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <a href="{{ route('admin.appraisals.edit', $appraisal->id) }}" 
                                                       class="btn btn-primary">
                                                        <i class="fas fa-edit me-1"></i>Edit Appointment
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="empty-state">
                                                <div class="mb-3">
                                                    <i class="fas fa-calendar-times fa-4x text-muted opacity-50"></i>
                                                </div>
                                                <h5 class="text-muted">No Appointments Found</h5>
                                                <p class="text-muted mb-0">
                                                    @if(request('search') || request('status') || request('date'))
                                                        No appointments match your current filters.
                                                        <br>
                                                        <a href="{{ route('admin.appraisals.index') }}" class="btn btn-sm btn-primary mt-2">
                                                            <i class="fas fa-times me-1"></i>Clear Filters
                                                        </a>
                                                    @else
                                                        No appointments have been scheduled yet.
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
                        @if($appraisals && $appraisals->hasPages())
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="text-muted">
                                Showing {{ $appraisals->firstItem() }} to {{ $appraisals->lastItem() }} 
                                of {{ $appraisals->total() }} appointments
                            </div>
                            <nav aria-label="Appointments pagination">
                                <ul class="pagination pagination-sm mb-0">
                                    {{-- Previous Page Link --}}
                                    @if ($appraisals->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i>
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $appraisals->appends(request()->query())->previousPageUrl() }}">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @foreach ($appraisals->appends(request()->query())->getUrlRange(1, $appraisals->lastPage()) as $page => $url)
                                        @if ($page == $appraisals->currentPage())
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
                                    @if ($appraisals->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $appraisals->appends(request()->query())->nextPageUrl() }}">
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
.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
}
.bg-gradient-danger {
    background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%);
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
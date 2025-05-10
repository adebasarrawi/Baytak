@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Property Appraisal Appointments</h4>
            <ul class="breadcrumbs">
                <li class="nav-home">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                    </a>
                </li>
                <li class="separator">
                    <i class="fas fa-angle-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Appointments</a>
                </li>
            </ul>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Status Dashboard -->
        <div class="row mb-4">
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Pending</p>
                                    <h4 class="card-title">{{ $statusCounts['pending'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Confirmed</p>
                                    <h4 class="card-title">{{ $statusCounts['confirmed'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-flag-checkered"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Completed</p>
                                    <h4 class="card-title">{{ $statusCounts['completed'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-danger bubble-shadow-small">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                            </div>
                            <div class="col col-stats ml-3 ml-sm-0">
                                <div class="numbers">
                                    <p class="card-category">Cancelled</p>
                                    <h4 class="card-title">{{ $statusCounts['cancelled'] }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Manage Appointments</h4>
                            <div class="ml-auto">
                                <a href="{{ route('admin.appraisals.calendar') }}" class="btn btn-primary btn-round">
                                    <i class="fas fa-calendar-alt mr-2"></i>Calendar View
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filters -->
                        <form action="{{ route('admin.appraisals.index') }}" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" onchange="this.form.submit()">
                                        <option value="">All Statuses</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="date">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="search">Search</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="search" name="search" placeholder="Search by name, email, phone..." value="{{ request('search') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3 d-flex align-items-end">
                                    <a href="{{ route('admin.appraisals.index') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-times"></i> Clear
                                    </a>
                                </div>
                            </div>
                        </form>
                        
                        <!-- Appointments Table -->
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Client</th>
                                        <th>Property Address</th>
                                        <th>Date & Time</th>
                                        <th>Appraiser</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appraisals as $appraisal)
                                    <tr>
                                        <td>{{ $appraisal->id }}</td>
                                        <td>
                                            <div>{{ $appraisal->client_name }}</div>
                                            <div class="text-muted small">{{ $appraisal->client_email }}</div>
                                            <div class="text-muted small">{{ $appraisal->client_phone }}</div>
                                        </td>
                                        <td>{{ $appraisal->property_address }}</td>
                                        <td>
                                            <div>{{ \Carbon\Carbon::parse($appraisal->appointment_date)->format('M d, Y') }}</div>
                                            <div class="text-muted small">{{ \Carbon\Carbon::parse($appraisal->appointment_time)->format('g:i A') }}</div>
                                        </td>
                                        <td>{{ $appraisal->appraiser ? $appraisal->appraiser->name : 'N/A' }}</td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'pending' => 'warning',
                                                    'confirmed' => 'success',
                                                    'completed' => 'primary',
                                                    'cancelled' => 'danger'
                                                ][$appraisal->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge badge-{{ $statusClass }}">
                                                {{ ucfirst($appraisal->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton{{ $appraisal->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Actions
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $appraisal->id }}">
                                                    <a class="dropdown-item" href="{{ route('admin.appraisals.edit', $appraisal->id) }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <!-- Quick Status Update -->
                                                    <div class="dropdown-divider"></div>
                                                    <h6 class="dropdown-header">Change Status</h6>
                                                    @foreach(['pending', 'confirmed', 'completed', 'cancelled'] as $status)
                                                        @if($status != $appraisal->status)
                                                        <form action="{{ route('admin.appraisals.update-status', $appraisal->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="{{ $status }}">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-arrow-right"></i> Mark as {{ ucfirst($status) }}
                                                            </button>
                                                        </form>
                                                        @endif
                                                    @endforeach
                                                    <div class="dropdown-divider"></div>
                                                    <!-- Delete -->
                                                    <form action="{{ route('admin.appraisals.destroy', $appraisal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this appointment?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                    </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <div class="empty-state">
                                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                                <h5>No appointments found</h5>
                                                <p class="text-muted">No appointments match your current filters</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $appraisals->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .empty-state {
        padding: 30px;
        text-align: center;
    }
    
    .badge {
        padding: 0.4em 0.6em;
        font-size: 80%;
    }
    
    .card-stats .icon-big {
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
    
    .icon-warning {
        color: #ffad46;
        background: rgba(255, 173, 70, 0.2);
    }
    
    .icon-success {
        color: #31ce36;
        background: rgba(49, 206, 54, 0.2);
    }
    
    .icon-primary {
        color: #1572e8;
        background: rgba(21, 114, 232, 0.2);
    }
    
    .icon-danger {
        color: #f25961;
        background: rgba(242, 89, 97, 0.2);
    }
    
    .numbers {
        line-height: 1;
    }
    
    .card-category {
        margin-bottom: 5px;
        font-size: 12px;
        color: #8d9498;
    }
    
    .card-title {
        margin-bottom: 0;
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();
        
        // Initialize date picker if needed
        if($('#date').length) {
            $('#date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        }
    });
</script>
@endpush
endsection
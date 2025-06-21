@extends('layouts.admin.app')

@section('title', 'Reports & Analytics')

@section('content')
<div class="container-fluid">
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title text-dark">Reports & Analytics</h4>
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
                    <span class="text-muted">Reports</span>
                </li>
            </ul>
        </div>

        <!-- Overview Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card bg-gradient-primary text-white border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <h3 class="mb-0">{{ number_format($totalUsers ?? 0) }}</h3>
                                <p class="mb-0 opacity-75">Total Users</p>
                                <small class="opacity-75">
                                    <i class="fas fa-arrow-up"></i>
                                    {{ $userGrowthRate ?? 0 }}% growth
                                </small>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-users fa-2x"></i>
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
                                <h3 class="mb-0">{{ number_format($totalProperties ?? 0) }}</h3>
                                <p class="mb-0 opacity-75">Total Properties</p>
                                <small class="opacity-75">
                                    <i class="fas fa-arrow-up"></i>
                                    {{ $propertyGrowthRate ?? 0 }}% growth
                                </small>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-home fa-2x"></i>
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
                                <h3 class="mb-0">{{ number_format($totalRevenue ?? 0) }} JD</h3>
                                <p class="mb-0 opacity-75">Total Revenue</p>
                                <small class="opacity-75">{{ $activeSubscriptions ?? 0 }} active subs</small>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-dollar-sign fa-2x"></i>
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
                                <h3 class="mb-0">{{ $approvalRate ?? 0 }}%</h3>
                                <p class="mb-0 opacity-75">Approval Rate</p>
                                <small class="opacity-75">{{ $totalActiveProperties ?? 0 }} approved</small>
                            </div>
                            <div class="ms-3 opacity-75">
                                <i class="fas fa-chart-line fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistics Row -->
        <div class="row mb-4">
            <!-- User Statistics -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-users text-primary me-2"></i>
                            User Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border-end">
                                    <h4 class="text-success mb-0">{{ $activeUsersCount ?? 0 }}</h4>
                                    <small class="text-muted">Active Users</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <h4 class="text-info mb-0">{{ $newUsersCount ?? 0 }}</h4>
                                <small class="text-muted">New Users</small>
                            </div>
                            <div class="col-6">
                                <div class="border-end">
                                    <h4 class="text-warning mb-0">{{ $sellersCount ?? 0 }}</h4>
                                    <small class="text-muted">Sellers</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="text-secondary mb-0">{{ $appraisersCount ?? 0 }}</h4>
                                <small class="text-muted">Appraisers</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Property Statistics -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-home text-success me-2"></i>
                            Property Status Distribution
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-success">Approved</span>
                                    <span class="badge bg-success">0</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 0%"></div>
                                </div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-warning">Pending</span>
                                    <span class="badge bg-warning">0</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: 0%"></div>
                                </div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-danger">Rejected</span>
                                    <span class="badge bg-danger">0</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-danger" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Statistics -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-dollar-sign text-info me-2"></i>
                            Subscription Distribution
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-info">Premium</span>
                                    <span class="badge bg-info">0</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info" style="width: 0%"></div>
                                </div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-warning">Basic</span>
                                    <span class="badge bg-warning">0</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: 0%"></div>
                                </div>
                            </div>
                            
                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-secondary">Free</span>
                                    <span class="badge bg-secondary">0</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-secondary" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables Row -->
        <div class="row mb-4">
            <!-- Most Viewed Properties -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-eye text-warning me-2"></i>
                            Most Viewed Properties
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Property</th>
                                        <th>Owner</th>
                                        <th>Views</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($mostViewedProperties) && $mostViewedProperties->count() > 0)
                                        @foreach($mostViewedProperties as $property)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ Str::limit($property->title ?? 'N/A', 25) }}</strong>
                                                    <br><small class="text-muted">{{ $property->area->name ?? 'N/A' }}</small>
                                                </div>
                                            </td>
                                            <td>{{ $property->user->name ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge bg-warning">{{ $property->views ?? 0 }}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="fas fa-eye fa-2x mb-2 opacity-50"></i>
                                            <br>No viewed properties yet
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Properties by Area -->
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            Properties by Area
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Area</th>
                                        <th>Properties</th>
                                        <th>Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($propertiesByArea) && $propertiesByArea->count() > 0)
                                        @foreach($propertiesByArea as $area)
                                        <tr>
                                            <td><strong>{{ $area->name ?? 'N/A' }}</strong></td>
                                            <td>{{ $area->count ?? 0 }}</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ ($totalProperties ?? 0) > 0 ? round((($area->count ?? 0) / $totalProperties) * 100, 1) : 0 }}%
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            <i class="fas fa-map-marker-alt fa-2x mb-2 opacity-50"></i>
                                            <br>No area data available
                                        </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Key Performance Indicators -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-bar text-primary me-2"></i>
                            Key Performance Indicators
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-lg-2 col-md-4 col-6 mb-3">
                                <div class="border-end">
                                    <h4 class="text-primary mb-1">{{ $avgPropertiesPerUser ?? 0 }}</h4>
                                    <small class="text-muted">Avg Properties/User</small>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6 mb-3">
                                <div class="border-end">
                                    <h4 class="text-warning mb-1">{{ $pendingPropertiesCount ?? 0 }}</h4>
                                    <small class="text-muted">Pending Approval</small>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6 mb-3">
                                <div class="border-end">
                                    <h4 class="text-danger mb-1">{{ $rejectedPropertiesCount ?? 0 }}</h4>
                                    <small class="text-muted">Rejected</small>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6 mb-3">
                                <div class="border-end">
                                    <h4 class="text-info mb-1">{{ $totalAppraisals ?? 0 }}</h4>
                                    <small class="text-muted">Total Appraisals</small>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6 mb-3">
                                <div class="border-end">
                                    <h4 class="text-success mb-1">{{ $approvedTestimonials ?? 0 }}</h4>
                                    <small class="text-muted">Approved Reviews</small>
                                </div>
                            </div>
                            <div class="col-lg-2 col-md-4 col-6 mb-3">
                                <h4 class="text-secondary mb-1">{{ $expiredSubscriptions ?? 0 }}</h4>
                                <small class="text-muted">Expired Subs</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0">
                        <h5 class="mb-0">
                            <i class="fas fa-tools text-primary me-2"></i>
                            Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary w-100">
                                    <i class="fas fa-users me-2"></i>Manage Users
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('admin.properties.index') }}" class="btn btn-outline-success w-100">
                                    <i class="fas fa-home me-2"></i>Manage Properties
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('admin.appraisals.index') }}" class="btn btn-outline-info w-100">
                                    <i class="fas fa-calendar-check me-2"></i>View Appraisals
                                </a>
                            </div>
                            <div class="col-lg-3 col-md-6 mb-3">
                                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-comments me-2"></i>Manage Reviews
                                </a>
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
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
}
.bg-gradient-success {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
}
.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%);
}
.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%);
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

.progress {
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}

.border-end {
    border-right: 1px solid #dee2e6;
}

@media (max-width: 768px) {
    .border-end {
        border-right: none;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }
}
</style>
@endsection
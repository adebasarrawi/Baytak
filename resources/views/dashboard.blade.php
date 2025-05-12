@extends('layouts.admin.app')

@section('content')
<div class="content">
    <div class="panel-header bg-primary-gradient">
        <div class="page-inner py-5">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                <div>
                    <h2 class="text-white pb-2 fw-bold">Dashboard</h2>
                    <h5 class="text-white op-7 mb-2">Property Appraisal Management</h5>
                </div>
                <div class="ml-md-auto py-2 py-md-0">
                    <a href="{{ route('admin.appraisals.create') }}" class="btn btn-white btn-border btn-round mr-2">
                        <i class="fa fa-plus"></i> New Appraisal
                    </a>
                    <a href="{{ route('admin.appraisals.calendar') }}" class="btn btn-secondary btn-round">
                        <i class="fa fa-calendar"></i> View Calendar
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="page-inner mt--5">
        <!-- Stats Cards -->
        <div class="row">
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
                                    <h4 class="card-title">{{ $pendingCount ?? 0 }}</h4>
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
                                    <h4 class="card-title">{{ $confirmedCount ?? 0 }}</h4>
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
                                    <h4 class="card-title">{{ $completedCount ?? 0 }}</h4>
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
                                    <h4 class="card-title">{{ $cancelledCount ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Appraisals & Today's Appointments -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Recent Appraisal Requests</div>
                            <div class="card-tools">
                                <a href="{{ route('admin.appraisals.index') }}" class="btn btn-info btn-border btn-round btn-sm">
                                    <span class="btn-label">
                                        <i class="fa fa-list"></i>
                                    </span>
                                    View All
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Client</th>
                                        <th>Address</th>
                                        <th>Date</th>
                                        <th>Appraiser</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentAppraisals ?? [] as $appraisal)
                                    <tr>
                                        <td>{{ $appraisal->client_name }}</td>
                                        <td>{{ Str::limit($appraisal->property_address, 30) }}</td>
                                        <td>{{ date('M d, Y', strtotime($appraisal->appointment_date)) }}</td>
                                        <td>{{ $appraisal->appraiser->name ?? 'Not Assigned' }}</td>
                                        <td>
                                            @php
                                            $statusClass = [
                                                'pending' => 'warning',
                                                'confirmed' => 'info',
                                                'completed' => 'success',
                                                'cancelled' => 'danger'
                                            ][$appraisal->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge badge-{{ $statusClass }}">{{ ucfirst($appraisal->status) }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.appraisals.edit', $appraisal->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @if($appraisal->status == 'pending')
                                                <form action="{{ route('admin.appraisals.update-status', $appraisal->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button type="submit" class="btn btn-sm btn-success" title="Confirm Appointment">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No recent appraisals found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Today's Appointments</div>
                    </div>
                    <div class="card-body pb-0">
                        @forelse($todayAppointments ?? [] as $appraisal)
                        <div class="d-flex">
                            <div class="flex-1 pt-1 ml-2">
                                <h6 class="fw-bold mb-1">{{ $appraisal->client_name }}</h6>
                                <small class="text-muted">{{ date('h:i A', strtotime($appraisal->appointment_time)) }}</small>
                            </div>
                            <div class="d-flex ml-auto align-items-center">
                                <h3 class="text-info fw-bold">
                                    @php
                                    $statusIcon = [
                                        'pending' => '<i class="fas fa-clock text-warning"></i>',
                                        'confirmed' => '<i class="fas fa-check-circle text-success"></i>',
                                        'completed' => '<i class="fas fa-flag-checkered text-primary"></i>',
                                        'cancelled' => '<i class="fas fa-times-circle text-danger"></i>'
                                    ][$appraisal->status] ?? '<i class="fas fa-question-circle"></i>';
                                    @endphp
                                    {!! $statusIcon !!}
                                </h3>
                            </div>
                        </div>
                        <div class="separator-dashed"></div>
                        @empty
                        <div class="text-center py-3">
                            <i class="fas fa-calendar-day fa-3x text-muted mb-3"></i>
                            <p>No appointments scheduled for today</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Appraisers List -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Appraisers</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Specialty</th>
                                        <th class="text-right">Appraisals</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($appraisers ?? [] as $appraiser)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar avatar-sm mr-2">
                                                    <img src="{{ $appraiser->profile_image ? asset($appraiser->profile_image) : asset('images/default-avatar.jpg') }}" alt="{{ $appraiser->name }}" class="avatar-img rounded-circle">
                                                </div>
                                                {{ $appraiser->name }}
                                            </div>
                                        </td>
                                        <td>{{ $appraiser->specialty ?? 'General' }}</td>
                                        <td class="text-right">{{ $appraiser->appraisals_count ?? 0 }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No appraisers found</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Statistics -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Monthly Appraisals</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="monthlyAppraisalsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Appraisals by Status</div>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="appraisalsByStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
// Circle Charts for Appraisals Status - Using static data
$(document).ready(function() {
    const pendingCount = 10;
    const confirmedCount = 8;
    const completedCount = 15;
    const totalCount = 33; // Total count

    Circles.create({
        id: 'circles-1',
        radius: 45,
        value: Math.round((pendingCount / totalCount) * 100),
        maxValue: 100,
        width: 7,
        text: pendingCount,
        colors: ['#f1f1f1', '#FF9E27'],
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        styleWrapper: true,
        styleText: true
    });

    Circles.create({
        id: 'circles-2',
        radius: 45,
        value: Math.round((confirmedCount / totalCount) * 100),
        maxValue: 100,
        width: 7,
        text: confirmedCount,
        colors: ['#f1f1f1', '#2BB930'],
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        styleWrapper: true,
        styleText: true
    });

    Circles.create({
        id: 'circles-3',
        radius: 45,
        value: Math.round((completedCount / totalCount) * 100),
        maxValue: 100,
        width: 7,
        text: completedCount,
        colors: ['#f1f1f1', '#F25961'],
        duration: 400,
        wrpClass: 'circles-wrp',
        textClass: 'circles-text',
        styleWrapper: true,
        styleText: true
    });

    // Monthly Income Chart - Example static data
    var totalIncomeChart = document.getElementById('totalIncomeChart').getContext('2d');

    var mytotalIncomeChart = new Chart(totalIncomeChart, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Total Appraisals",
                backgroundColor: '#1572E8',
                borderColor: 'rgb(23, 125, 255)',
                data: [5, 8, 12, 7, 10, 15, 13, 9, 11, 6, 8, 10], // Static sample data
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false,
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
        }
    });
});
</script>
@endpush
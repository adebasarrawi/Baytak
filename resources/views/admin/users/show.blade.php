@extends('layouts.admin.app')

@section('title', 'User Profile - ' . $user->name)

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-dark">User Profile</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}" class="text-decoration-none">Users</a></li>
                    <li class="breadcrumb-item active text-muted">{{ $user->name }}</li>
                </ol>
            </nav>
        </div>
        <div>
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary me-2">
                <i class="fas fa-edit me-2"></i>Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back to Users
            </a>
        </div>
    </div>

    <div class="row">
        <!-- User Profile & Account Details Combined -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <!-- Profile Section -->
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            @if($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                     class="rounded-circle shadow-sm" width="100" height="100" alt="Profile Image">
                            @else
                                <div class="bg-gradient-primary rounded-circle mx-auto d-flex align-items-center justify-content-center text-white shadow-sm" 
                                     style="width: 100px; height: 100px; font-size: 32px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        
                        <h4 class="mb-1 text-dark">{{ $user->name }}</h4>
                        <p class="text-muted mb-3">{{ $user->email }}</p>
                        
                        <div class="mb-3">
                            <span class="badge bg-primary me-1">
                                {{ ucfirst($user->user_type) }}
                            </span>
                            <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </div>

                        @if($user->bio)
                        <div class="mb-3">
                            <p class="text-muted small">{{ $user->bio }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Account Details Section -->
                    <div class="border-top pt-4">
                        <h6 class="text-dark mb-3">
                            <i class="fas fa-info-circle me-2 text-primary"></i>Account Details
                        </h6>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="bg-light rounded p-3">
                                    <small class="text-muted d-block">User ID</small>
                                    <strong class="text-dark">#{{ $user->id }}</strong>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="bg-light rounded p-3">
                                    <small class="text-muted d-block">Member Since</small>
                                    <strong class="text-dark">{{ $user->created_at->format('M d, Y') }}</strong>
                                    <small class="text-muted d-block">{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="bg-light rounded p-3">
                                    <small class="text-muted d-block">Last Updated</small>
                                    <strong class="text-dark">{{ $user->updated_at->format('M d, Y H:i') }}</strong>
                                    <small class="text-muted d-block">{{ $user->updated_at->diffForHumans() }}</small>
                                </div>
                            </div>

                            @if($user->hasVerifiedEmail())
                            <div class="col-12">
                                <div class="bg-light rounded p-3">
                                    <small class="text-muted d-block">Email Verified</small>
                                    <strong class="text-success">{{ $user->email_verified_at->format('M d, Y H:i') }}</strong>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="border-top pt-4 mt-4">
                        <h6 class="text-dark mb-3">
                            <i class="fas fa-cogs me-2 text-primary"></i>Quick Actions
                        </h6>
                        
                        <div class="d-grid gap-2">
                            @if(!$user->hasVerifiedEmail())
                            <form method="POST" action="{{ route('admin.users.verify-email', $user) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm w-100"
                                        onclick="return confirm('Are you sure you want to verify this user\'s email?')">
                                    <i class="fas fa-check me-2"></i>Verify Email
                                </button>
                            </form>
                            @endif
                            
                            <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-{{ $user->status === 'active' ? 'warning' : 'success' }} btn-sm w-100"
                                        onclick="return confirm('Are you sure you want to {{ $user->status === 'active' ? 'deactivate' : 'activate' }} this user?')">
                                    <i class="fas fa-{{ $user->status === 'active' ? 'pause' : 'play' }} me-2"></i>
                                    {{ $user->status === 'active' ? 'Deactivate' : 'Activate' }} User
                                </button>
                            </form>
                            
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100"
                                        onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                    <i class="fas fa-trash me-2"></i>Delete User
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Activity and Statistics -->
        <div class="col-lg-8">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-gradient-primary text-white border-0 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h3 class="mb-0">{{ $user->properties->count() }}</h3>
                                    <p class="mb-0 opacity-75">Properties</p>
                                </div>
                                <div class="ms-3 opacity-75">
                                    <i class="fas fa-home fa-2x"></i>
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
                                    <h3 class="mb-0">{{ $user->favorites->count() }}</h3>
                                    <p class="mb-0 opacity-75">Favorites</p>
                                </div>
                                <div class="ms-3 opacity-75">
                                    <i class="fas fa-heart fa-2x"></i>
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
                                    <h3 class="mb-0">{{ $user->appraisals->count() }}</h3>
                                    <p class="mb-0 opacity-75">Appraisals</p>
                                </div>
                                <div class="ms-3 opacity-75">
                                    <i class="fas fa-clipboard-list fa-2x"></i>
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
                                    <h3 class="mb-0">{{ $user->payments->count() }}</h3>
                                    <p class="mb-0 opacity-75">Payments</p>
                                </div>
                                <div class="ms-3 opacity-75">
                                    <i class="fas fa-credit-card fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Tabs -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0">
                    <ul class="nav nav-pills" id="activityTabs" role="tablist">
                        <li class="nav-item me-2" role="presentation">
                            <button class="nav-link active rounded-pill" id="properties-tab" data-bs-toggle="tab" 
                                    data-bs-target="#properties" type="button" role="tab">
                                <i class="fas fa-home me-2"></i>Properties ({{ $user->properties->count() }})
                            </button>
                        </li>
                        <li class="nav-item me-2" role="presentation">
                            <button class="nav-link rounded-pill" id="appraisals-tab" data-bs-toggle="tab" 
                                    data-bs-target="#appraisals" type="button" role="tab">
                                <i class="fas fa-clipboard-list me-2"></i>Appraisals ({{ $user->appraisals->count() }})
                            </button>
                        </li>
                        <li class="nav-item me-2" role="presentation">
                            <button class="nav-link rounded-pill" id="favorites-tab" data-bs-toggle="tab" 
                                    data-bs-target="#favorites" type="button" role="tab">
                                <i class="fas fa-heart me-2"></i>Favorites ({{ $user->favorites->count() }})
                            </button>
                        </li>
                        @if($user->user_type === 'seller')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link rounded-pill" id="payments-tab" data-bs-toggle="tab" 
                                    data-bs-target="#payments" type="button" role="tab">
                                <i class="fas fa-credit-card me-2"></i>Subscription ({{ $user->payments->count() }})
                            </button>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="activityTabsContent">
                        <!-- Properties Tab -->
                        <div class="tab-pane fade show active" id="properties" role="tabpanel">
                            @if($user->properties->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0">Property</th>
                                            <th class="border-0">Price</th>
                                            <th class="border-0">Status</th>
                                            <th class="border-0">Created</th>
                                            <th class="border-0">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->properties->take(10) as $property)
                                        <tr>
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
                                                        <h6 class="mb-1 text-dark">
                                                            @if(isset($property->title) && $property->title)
                                                                {{ Str::limit($property->title, 30) }}
                                                            @elseif(isset($property->name) && $property->name)
                                                                {{ Str::limit($property->name, 30) }}
                                                            @else
                                                                Property #{{ $property->id }}
                                                            @endif
                                                        </h6>
                                                        <small class="text-muted">
                                                            {{ $property->location ?? $property->address ?? 'No location' }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if(isset($property->price) && $property->price)
                                                    <strong class="text-primary">{{ number_format($property->price) }} JD</strong>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ 
                                                    ($property->status ?? 'pending') === 'approved' ? 'success' : 
                                                    (($property->status ?? 'pending') === 'pending' ? 'warning' : 'danger') 
                                                }} rounded-pill">
                                                    {{ ucfirst($property->status ?? 'Pending') }}
                                                </span>
                                            </td>
                                            <td class="text-muted">{{ $property->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <a href="{{ route('properties.show', $property) }}" 
                                                   class="btn btn-sm btn-outline-primary rounded-pill" target="_blank">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($user->properties->count() > 10)
                            <div class="text-center mt-3">
                                <p class="text-muted">Showing 10 of {{ $user->properties->count() }} properties</p>
                            </div>
                            @endif
                            @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-home fa-3x text-muted opacity-50"></i>
                                </div>
                                <h5 class="text-muted">No Properties</h5>
                                <p class="text-muted">This user hasn't created any properties yet.</p>
                            </div>
                            @endif
                        </div>

                        <!-- Appraisals Tab -->
                        <div class="tab-pane fade" id="appraisals" role="tabpanel">
                            @if($user->appraisals->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0">Property</th>
                                            <th class="border-0">Contact</th>
                                            <th class="border-0">Date & Time</th>
                                            <th class="border-0">Status</th>
                                            <th class="border-0">Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->appraisals->take(10) as $appraisal)
                                        <tr>
                                            <td>
                                                <div>
                                                    <h6 class="mb-1 text-dark">{{ $appraisal->property_address }}</h6>
                                                    <small class="text-muted">{{ $appraisal->property_type }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="text-dark">{{ $appraisal->client_name }}</div>
                                                    <small class="text-muted">{{ $appraisal->client_phone }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="text-dark">{{ $appraisal->appointment_date->format('M d, Y') }}</div>
                                                    <small class="text-muted">{{ $appraisal->appointment_time }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ 
                                                    $appraisal->status === 'confirmed' ? 'success' : 
                                                    ($appraisal->status === 'pending' ? 'warning' : 
                                                    ($appraisal->status === 'completed' ? 'info' : 'danger')) 
                                                }} rounded-pill">
                                                    {{ ucfirst($appraisal->status) }}
                                                </span>
                                            </td>
                                            <td class="text-muted">{{ $appraisal->created_at->format('M d, Y') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-clipboard-list fa-3x text-muted opacity-50"></i>
                                </div>
                                <h5 class="text-muted">No Appraisals</h5>
                                <p class="text-muted">This user hasn't booked any appraisals yet.</p>
                            </div>
                            @endif
                        </div>

                        <!-- Favorites Tab -->
                        <div class="tab-pane fade" id="favorites" role="tabpanel">
                            @if($user->favorites->count() > 0)
                            <div class="row">
                                @foreach($user->favorites->take(8) as $favorite)
                                <div class="col-lg-6 mb-3">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                @if($favorite->property->images && $favorite->property->images->where('is_primary', 1)->first())
                                                    <img src="{{ asset('storage/' . $favorite->property->images->where('is_primary', 1)->first()->image_path) }}" 
                                                         class="rounded shadow-sm me-3" width="60" height="60" alt="Property">
                                                @elseif($favorite->property->images && $favorite->property->images->first())
                                                    <img src="{{ asset('storage/' . $favorite->property->images->first()->image_path) }}" 
                                                         class="rounded shadow-sm me-3" width="60" height="60" alt="Property">
                                                @else
                                                    <div class="bg-light rounded shadow-sm me-3 d-flex align-items-center justify-content-center" 
                                                         style="width: 60px; height: 60px;">
                                                        <i class="fas fa-home text-muted"></i>
                                                    </div>
                                                @endif
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 text-dark">
                                                        @if(isset($favorite->property->title) && $favorite->property->title)
                                                            {{ Str::limit($favorite->property->title, 25) }}
                                                        @elseif(isset($favorite->property->name) && $favorite->property->name)  
                                                            {{ Str::limit($favorite->property->name, 25) }}
                                                        @else
                                                            Property #{{ $favorite->property->id }}
                                                        @endif
                                                    </h6>
                                                    <p class="mb-1 text-muted small">
                                                        {{ $favorite->property->location ?? $favorite->property->address ?? 'No location' }}
                                                    </p>
                                                    <strong class="text-primary">
                                                        @if(isset($favorite->property->price) && $favorite->property->price)
                                                            {{ number_format($favorite->property->price) }} JD
                                                        @else
                                                            <span class="text-muted">Price not set</span>
                                                        @endif
                                                    </strong>
                                                </div>
                                                <div>
                                                    <a href="{{ route('properties.show', $favorite->property) }}" 
                                                       class="btn btn-sm btn-outline-primary rounded-pill" target="_blank">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-heart fa-3x text-muted opacity-50"></i>
                                </div>
                                <h5 class="text-muted">No Favorites</h5>
                                <p class="text-muted">This user hasn't favorited any properties yet.</p>
                            </div>
                            @endif
                        </div>

                        <!-- Payments Tab (Only for Sellers) -->
                        @if($user->user_type === 'seller')
                        <div class="tab-pane fade" id="payments" role="tabpanel">
                            @if($user->payments->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="border-0">Card Holder</th>
                                            <th class="border-0">Card Number</th>
                                            <th class="border-0">Subscription</th>
                                            <th class="border-0">Expires At</th>
                                            <th class="border-0">Status</th>
                                            <th class="border-0">Created</th>
                                            <th class="border-0">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->payments->take(10) as $payment)
                                        @php 
                                            try {
                                                $subscriptionExpires = $payment->subscription_expires_at ? 
                                                    (is_string($payment->subscription_expires_at) ? 
                                                        \Carbon\Carbon::parse($payment->subscription_expires_at) : 
                                                        $payment->subscription_expires_at) : null;
                                                
                                                $isExpired = $subscriptionExpires && now()->gt($subscriptionExpires);
                                                $isExpiringSoon = $subscriptionExpires && now()->diffInDays($subscriptionExpires, false) <= 7 && now()->diffInDays($subscriptionExpires, false) >= 0;
                                            } catch (\Exception $e) {
                                                $subscriptionExpires = null;
                                                $isExpired = false;
                                                $isExpiringSoon = false;
                                            }
                                        @endphp
                                        <tr>
                                            <td><strong class="text-dark">{{ $payment->card_holder ?? 'N/A' }}</strong></td>
                                            <td>
                                                @if($payment->card_number)
                                                    <code class="text-muted">****-****-****-{{ substr($payment->card_number, -4) }}</code>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary rounded-pill">
                                                    {{ ucfirst($payment->subscription ?? 'Basic') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($subscriptionExpires)
                                                    <div class="text-dark">{{ $subscriptionExpires->format('M d, Y') }}</div>
                                                    <small class="text-muted">{{ $subscriptionExpires->diffForHumans() }}</small>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($payment->active)
                                                    @if($isExpired)
                                                        <span class="badge bg-danger rounded-pill">Expired</span>
                                                    @elseif($isExpiringSoon)
                                                        <span class="badge bg-warning rounded-pill">Expires Soon</span>
                                                    @else
                                                        <span class="badge bg-success rounded-pill">Active</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary rounded-pill">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="text-muted">{{ $payment->created_at->format('M d, Y') }}</td>
                                            <td>
                                                @if($isExpired && $payment->active)
                                                <form method="POST" action="{{ route('admin.users.deactivate-subscription', $payment->id ?? $payment) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-warning rounded-pill" 
                                                            onclick="return confirm('This will deactivate the user subscription and change user type to regular user. Continue?')">
                                                        <i class="fas fa-pause me-1"></i>Deactivate
                                                    </button>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="fas fa-credit-card fa-3x text-muted opacity-50"></i>
                                </div>
                                <h5 class="text-muted">No Subscription History</h5>
                                <p class="text-muted">This seller hasn't made any payments yet.</p>
                            </div>
                            @endif
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

.nav-pills .nav-link {
    background-color: transparent;
    border: 1px solid #dee2e6;
    color: #6c757d;
    transition: all 0.3s ease;
}

.nav-pills .nav-link:hover {
    background-color: #f8f9fa;
    border-color: #007bff;
    color: #007bff;
}

.nav-pills .nav-link.active {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}

.card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.table th {
    font-weight: 600;
    color: #495057;
}

.badge {
    font-weight: 500;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}
</style>

<!-- JavaScript Functions -->
<script>

</script>
@endsection
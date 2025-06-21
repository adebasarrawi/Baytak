@extends('layouts.admin.app')

@section('title', 'User Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">User Management</h1>
        <div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Add New User
            </a>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0 text-primary">
                <i class="fas fa-filter me-2"></i>Search & Filter Options
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-search me-1 text-primary"></i>Search Users
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-primary text-white">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Name, email, or phone..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">
                        <i class="fas fa-users me-1 text-info"></i>User Type
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-info text-white">
                            <i class="fas fa-user-tag"></i>
                        </span>
                        <select name="user_type" class="form-select">
                            <option value="">All Types</option>
                            <option value="user" {{ request('user_type') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="seller" {{ request('user_type') == 'seller' ? 'selected' : '' }}>Seller</option>
                            <option value="appraiser" {{ request('user_type') == 'appraiser' ? 'selected' : '' }}>Appraiser</option>
                            <option value="admin" {{ request('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">
                        <i class="fas fa-toggle-on me-1 text-success"></i>Status
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-success text-white">
                            <i class="fas fa-check-circle"></i>
                        </span>
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-bold">
                        <i class="fas fa-trash me-1 text-warning"></i>Show Deleted
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-warning text-white">
                            <i class="fas fa-eye"></i>
                        </span>
                        <select name="show_deleted" class="form-select">
                            <option value="">Active Users</option>
                            <option value="1" {{ request('show_deleted') ? 'selected' : '' }}>Deleted Users</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-search me-2"></i>Search
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="fas fa-refresh me-2"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                Users List 
                <span class="badge bg-primary">{{ $users->total() }}</span>
            </h5>
            <div>
                <button type="button" class="btn btn-sm btn-outline-danger" id="bulkDeleteBtn" style="display: none;">
                    <i class="fas fa-trash me-1"></i>Delete Selected
                </button>
                <button type="button" class="btn btn-sm btn-outline-success" id="bulkActivateBtn" style="display: none;">
                    <i class="fas fa-check me-1"></i>Activate Selected
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            @if($users->count() > 0)
            <form id="bulkActionForm" method="POST" action="{{ route('admin.users.bulk-action') }}">
                @csrf
                <input type="hidden" name="action" id="bulkAction">
                
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="50">
                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                </th>
                                <th>User</th>
                                <th>Contact Info</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Stats</th>
                                <th>Joined</th>
                                <th width="250">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <input type="checkbox" name="user_ids[]" value="{{ $user->id }}" 
                                           class="form-check-input user-checkbox">
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3">
                                            @if($user->profile_image)
                                                <img src="{{ asset('storage/' . $user->profile_image) }}" 
                                                     class="rounded-circle" width="40" height="40" alt="Avatar">
                                            @else
                                                <div class="avatar-placeholder bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted">ID: {{ $user->id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <div class="mb-1">
                                            <i class="fas fa-envelope text-muted me-1"></i>
                                            {{ $user->email }}
                                            @if($user->hasVerifiedEmail())
                                                <i class="fas fa-check-circle text-success ms-1" title="Verified"></i>
                                            @else
                                                <i class="fas fa-exclamation-circle text-warning ms-1" title="Not Verified"></i>
                                            @endif
                                        </div>
                                        @if($user->phone)
                                        <div>
                                            <i class="fas fa-phone text-muted me-1"></i>
                                            {{ $user->phone }}
                                        </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $user->user_type === 'admin' ? 'danger' : 
                                        ($user->user_type === 'seller' ? 'info' : 
                                        ($user->user_type === 'appraiser' ? 'warning' : 'secondary')) 
                                    }}">
                                        {{ ucfirst($user->user_type) }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->trashed())
                                        <span class="badge bg-dark">Deleted</span>
                                    @else
                                        <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="small">
                                        <div><i class="fas fa-home me-1"></i>{{ $user->properties_count ?? 0 }} Properties</div>
                                        <div><i class="fas fa-heart me-1"></i>{{ $user->favorites_count ?? 0 }} Favorites</div>
                                        <div><i class="fas fa-clipboard-list me-1"></i>{{ $user->appraisals_count ?? 0 }} Appraisals</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="small">
                                        {{ $user->created_at->format('M d, Y') }}
                                        <br>
                                        <span class="text-muted">{{ $user->created_at->diffForHumans() }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        @if($user->trashed())
                                            <div class="d-flex flex-wrap gap-1">
                                                <a href="{{ route('admin.users.restore', $user->id) }}" 
                                                   class="btn btn-sm btn-success" title="Restore User"
                                                   onclick="return confirm('Are you sure you want to restore this user?')">
                                                    <i class="fas fa-undo me-1"></i>Restore
                                                </a>
                                                <a href="{{ route('admin.users.force-delete', $user->id) }}" 
                                                   class="btn btn-sm btn-danger" title="Delete Permanently"
                                                   onclick="return confirm('Are you sure you want to permanently delete this user? This action cannot be undone!')">
                                                    <i class="fas fa-times me-1"></i>Delete Forever
                                                </a>
                                            </div>
                                        @else
                                            <div class="d-flex flex-wrap gap-1">
                                                <a href="{{ route('admin.users.show', $user) }}" 
                                                   class="btn btn-sm btn-outline-info" title="View Profile">
                                                    <i class="fas fa-eye me-1"></i>View
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user) }}" 
                                                   class="btn btn-sm btn-outline-primary" title="Edit User">
                                                    <i class="fas fa-edit me-1"></i>Edit
                                                </a>
                                                @if($user->id !== auth()->id())
                                                @php
                                                    $action = $user->status === 'active' ? 'deactivate' : 'activate';
                                                @endphp
                                                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-outline-{{ $user->status === 'active' ? 'warning' : 'success' }}"
                                                            title="{{ ucfirst($action) }} User"
                                                            onclick="return confirm('Are you sure you want to {{ $action }} this user?')">
                                                        <i class="fas fa-{{ $user->status === 'active' ? 'pause' : 'play' }} me-1"></i>{{ ucfirst($action) }}
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Delete User"
                                                            onclick="return confirm('Are you sure you want to delete this user?')">
                                                        <i class="fas fa-trash me-1"></i>Delete
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
            @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5>No users found</h5>
                <p class="text-muted">Try adjusting your search criteria or add a new user.</p>
            </div>
            @endif
        </div>
        
        @if($users->hasPages())
        <div class="card-footer">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">
                        Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} results
                    </p>
                </div>
                <div class="col-md-6">
                    <nav aria-label="User pagination">
                        <ul class="pagination justify-content-end mb-0">
                            {{-- Previous Page Link --}}
                            @if ($users->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->appends(request()->query())->previousPageUrl() }}">
                                        <i class="fas fa-chevron-left"></i> Previous
                                    </a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($users->appends(request()->query())->getUrlRange(1, $users->lastPage()) as $page => $url)
                                @if ($page == $users->currentPage())
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
                            @if ($users->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $users->appends(request()->query())->nextPageUrl() }}">
                                        Next <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">
                                        Next <i class="fas fa-chevron-right"></i>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Select all functionality
    $('#selectAll').change(function() {
        $('.user-checkbox').prop('checked', this.checked);
        toggleBulkButtons();
    });

    // Individual checkbox change
    $('.user-checkbox').change(function() {
        toggleBulkButtons();
        
        // Update select all checkbox
        if ($('.user-checkbox:checked').length === $('.user-checkbox').length) {
            $('#selectAll').prop('checked', true);
        } else {
            $('#selectAll').prop('checked', false);
        }
    });

    // Toggle bulk action buttons
    function toggleBulkButtons() {
        if ($('.user-checkbox:checked').length > 0) {
            $('#bulkDeleteBtn, #bulkActivateBtn').show();
        } else {
            $('#bulkDeleteBtn, #bulkActivateBtn').hide();
        }
    }

    // Bulk delete
    $('#bulkDeleteBtn').click(function() {
        if (confirm('Are you sure you want to delete selected users?')) {
            $('#bulkAction').val('delete');
            $('#bulkActionForm').submit();
        }
    });

    // Bulk activate
    $('#bulkActivateBtn').click(function() {
        if (confirm('Are you sure you want to activate selected users?')) {
            $('#bulkAction').val('activate');
            $('#bulkActionForm').submit();
        }
    });
});
</script>

<style>
.pagination {
    --bs-pagination-padding-x: 0.75rem;
    --bs-pagination-padding-y: 0.375rem;
    --bs-pagination-font-size: 0.875rem;
    --bs-pagination-color: #6c757d;
    --bs-pagination-bg: #fff;
    --bs-pagination-border-width: 1px;
    --bs-pagination-border-color: #dee2e6;
    --bs-pagination-border-radius: 0.375rem;
    --bs-pagination-hover-color: #0d6efd;
    --bs-pagination-hover-bg: #e9ecef;
    --bs-pagination-hover-border-color: #dee2e6;
    --bs-pagination-focus-color: #0d6efd;
    --bs-pagination-focus-bg: #e9ecef;
    --bs-pagination-focus-box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    --bs-pagination-active-color: #fff;
    --bs-pagination-active-bg: #0d6efd;
    --bs-pagination-active-border-color: #0d6efd;
    --bs-pagination-disabled-color: #6c757d;
    --bs-pagination-disabled-bg: #fff;
    --bs-pagination-disabled-border-color: #dee2e6;
}

.pagination .page-link {
    padding: var(--bs-pagination-padding-y) var(--bs-pagination-padding-x);
    font-size: var(--bs-pagination-font-size);
    color: var(--bs-pagination-color);
    background-color: var(--bs-pagination-bg);
    border: var(--bs-pagination-border-width) solid var(--bs-pagination-border-color);
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.pagination .page-link:hover {
    color: var(--bs-pagination-hover-color);
    background-color: var(--bs-pagination-hover-bg);
    border-color: var(--bs-pagination-hover-border-color);
}

.pagination .page-item.active .page-link {
    color: var(--bs-pagination-active-color);
    background-color: var(--bs-pagination-active-bg);
    border-color: var(--bs-pagination-active-border-color);
}

.pagination .page-item.disabled .page-link {
    color: var(--bs-pagination-disabled-color);
    background-color: var(--bs-pagination-disabled-bg);
    border-color: var(--bs-pagination-disabled-border-color);
}

.card-footer {
    background-color: #f8f9fa;
    border-top: 1px solid rgba(0,0,0,.125);
}

.input-group-text {
    font-weight: 600;
}

.btn-group .btn {
    white-space: nowrap;
}

.d-flex.flex-wrap.gap-1 .btn {
    margin-bottom: 0.25rem;
}

.card.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
}

.form-label.fw-bold {
    color: #495057;
    font-size: 0.875rem;
}
</style>
@endpush
@endsection
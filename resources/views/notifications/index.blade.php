@extends('layouts.public.app')

@section('title', 'My Notifications')

@section('content')
<div class="hero page-inner overlay">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-lg-9 text-center mt-5">
        <h1 class="heading" data-aos="fade-up">My Notifications</h1>
        <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="200">
          <ol class="breadcrumb text-center justify-content-center">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active text-white-50" aria-current="page">My Notifications</li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>

<div class="section">
  <div class="container">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-lg-3 mb-5 mb-lg-0">
        <div class="profile-sidebar shadow rounded bg-white p-4">
          <div class="text-center mb-4">
            <img src="https://via.placeholder.com/150" alt="User" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
            <h4>John Doe</h4>
            <p class="text-muted small">john@example.com</p>
            <div class="badge bg-primary py-2 px-3 mb-2">Seller Account</div>
          </div>
          
          <div class="list-group">
            <a href="#" class="list-group-item list-group-item-action">
              <i class="fas fa-user me-2"></i> Account Information
            </a>
            <a href="#" class="list-group-item list-group-item-action">
              <i class="fas fa-edit me-2"></i> Edit Profile
            </a>
            <a href="#" class="list-group-item list-group-item-action">
              <i class="fas fa-home me-2"></i> My Properties
            </a>
            <a href="#" class="list-group-item list-group-item-action">
              <i class="fas fa-heart me-2"></i> Favorites
            </a>
            <a href="#" class="list-group-item list-group-item-action active">
              <i class="fas fa-bell me-2"></i> Notifications
            </a>
            <a href="#" class="list-group-item list-group-item-action text-danger">
              <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
          </div>
        </div>
      </div>
      
      <!-- Main Content -->
      <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="mb-0">Notifications</h2>
          <div>
            <a href="#" class="btn btn-sm btn-outline-primary">
              <i class="fas fa-check-double me-1"></i> Mark All as Read
            </a>
          </div>
        </div>
        
        <!-- Static Notifications List -->
        <div class="card shadow-sm">
          <div class="card-body p-0">
            <div class="list-group list-group-flush">
              <!-- Unread Notification -->
              <div class="list-group-item list-group-item-light p-3">
                <div class="d-flex align-items-center">
                  <div class="notification-icon me-3">
                    <i class="fas fa-check-circle fa-2x text-success"></i>
                  </div>
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                      <h5 class="mb-1">Property Approved</h5>
                      <small class="text-muted">2 hours ago</small>
                    </div>
                    <p class="mb-1">Your property "Modern Villa with Pool" has been approved and is now live.</p>
                    <a href="#" class="btn btn-sm btn-outline-primary mt-2">
                      View Property
                    </a>
                  </div>
                  <div class="ms-3">
                    <button class="btn btn-sm btn-outline-secondary">
                      <i class="fas fa-check"></i>
                    </button>
                  </div>
                </div>
              </div>
              
              <!-- Read Notification -->
              <div class="list-group-item p-3">
                <div class="d-flex align-items-center">
                  <div class="notification-icon me-3">
                    <i class="fas fa-envelope fa-2x text-primary"></i>
                  </div>
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                      <h5 class="mb-1">New Message</h5>
                      <small class="text-muted">1 day ago</small>
                    </div>
                    <p class="mb-1">You have received a new message from Sarah regarding your property.</p>
                    <a href="#" class="btn btn-sm btn-outline-primary mt-2">
                      View Message
                    </a>
                  </div>
                </div>
              </div>
              
              <!-- Another Notification -->
              <div class="list-group-item p-3">
                <div class="d-flex align-items-center">
                  <div class="notification-icon me-3">
                    <i class="fas fa-bell fa-2x text-warning"></i>
                  </div>
                  <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                      <h5 class="mb-1">System Update</h5>
                      <small class="text-muted">3 days ago</small>
                    </div>
                    <p class="mb-1">Our platform will undergo maintenance tomorrow from 2:00 AM to 4:00 AM.</p>
                  </div>
                </div>
              </div>
              
              <!-- Empty State -->
              <!-- <div class="list-group-item p-5 text-center">
                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                <h4>No Notifications</h4>
                <p class="text-muted mb-0">You don't have any notifications at the moment.</p>
              </div> -->
            </div>
          </div>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
          <nav aria-label="Page navigation">
            <ul class="pagination">
              <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1">Previous</a>
              </li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item">
                <a class="page-link" href="#">Next</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
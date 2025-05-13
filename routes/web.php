<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyImageController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\PropertyAppraisalController;
use App\Http\Controllers\Admin\AppraisalController;
use Illuminate\Auth\Events\Logout;

// Public routes
Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/services', function () {
    return view('public.services');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

// Properties routes - using resource controller for standard CRUD operations
Route::resource('properties', PropertyController::class);

Route::get('/property-single', function () {
    return view('public.property-single');
});

Route::get('/about', function () {
    return view('public.about');
});

Route::get('/contact', function () {
    return view('public.contact');
});


Route::get('/property-estimation', [PropertyAppraisalController::class, 'index'])
     ->name('property.estimation');
Route::post('/property-appraisal/book', [PropertyAppraisalController::class, 'bookAppointment'])->name('property.appraisal.book');

// Protected appraisal routes
Route::middleware(['auth'])->group(function () {
    Route::get('/my-appraisals', [PropertyAppraisalController::class, 'myAppointments'])->name('public.property.appraisals.my');
    Route::put('/property-appraisal/{appraisal}/cancel', [PropertyAppraisalController::class, 'cancelAppointment'])->name('property.appraisal.cancel');
});


// Property Image Routes
Route::get('/properties/{property}/images', [PropertyImageController::class, 'manage'])->name('properties.images.manage');
Route::post('/properties/{property}/images', [PropertyImageController::class, 'upload'])->name('properties.images.upload');
Route::delete('/properties/images/{image}', [PropertyImageController::class, 'destroy'])->name('properties.images.destroy');
Route::patch('/properties/images/{image}/primary', [PropertyImageController::class, 'setPrimary'])->name('properties.images.setPrimary');
Route::post('/properties/{property}/images/order', [PropertyImageController::class, 'updateOrder'])->name('properties.images.updateOrder');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');


// Admin routes for property appraisal management
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard route
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Appraisal Routes
    Route::get('/appraisals', [AppraisalController::class, 'index'])->name('appraisals.index');
    Route::get('/appraisals/calendar', [AppraisalController::class, 'calendar'])->name('appraisals.calendar');
    Route::get('/appraisals/create', [AppraisalController::class, 'create'])->name('appraisals.create');
    Route::get('/appraisals/{appraisal}/edit', [AppraisalController::class, 'edit'])->name('appraisals.edit');
    Route::put('/appraisals/{appraisal}', [AppraisalController::class, 'update'])->name('appraisals.update');
    Route::put('/appraisals/{appraisal}/status', [AppraisalController::class, 'updateStatus'])->name('appraisals.update-status');
    Route::delete('/appraisals/{appraisal}', [AppraisalController::class, 'destroy'])->name('appraisals.destroy');
    
    // Add a route for fetching calendar events via AJAX
    Route::get('/appraisals/events', [AppraisalController::class, 'getEvents'])->name('appraisals.events');
    
    // User routes if needed
    Route::get('/users/{user}', function() {
        // Placeholder for user profile view - replace with actual controller method
        return redirect()->route('admin.dashboard');
    })->name('users.show');
});

// Protected Routes for Authenticated Users
Route::middleware(['auth'])->group(function () {
    // Home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    
    // My Properties route
    Route::get('/my-properties', [PropertyController::class, 'myProperties'])->name('properties.my');
    
    // Favorites routes
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
    
    // Notifications routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-as-read/{notification}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    
    // Payment Routes for Sellers
    Route::get('/seller/payment', [PaymentController::class, 'showPaymentForm'])->name('seller.payment');
    Route::post('/seller/payment', [PaymentController::class, 'processPayment'])->name('seller.payment.process');
    Route::get('/seller/payment/success', function () {
        return view('seller.payment_success');
    })->name('seller.payment.success');
    
    // Seller dashboard route
    Route::get('/seller/dashboard', function() {
        return view('seller.dashboard');
    })->name('seller.dashboard');
});

// Add this inside your admin routes group
Route::get('/dashboard-test', function () {
    return view('admin.dashboard');
})->name('dashboard-test');

Route::get('/a', function () {
    return redirect()->route('admin.appraisals.index');
});
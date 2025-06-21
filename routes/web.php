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
use App\Http\Controllers\PublicPropertyAppraisalController;
use App\Http\Controllers\Admin\AdminAppraisalController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminPropertyController;
use App\Http\Controllers\Admin\AdminUserController;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


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

Route::get('/about', function () {
    return view('public.about');
});

Route::get('/contact', function () {
    return view('public.contact');
});

Route::get('/contact-thank-you', function () {
    return view('public.contact-thank-you');
});

// Property estimation routes
Route::get('/property-estimation', [PublicPropertyAppraisalController::class, 'index'])
     ->name('property.estimation');
Route::post('/property-appraisal/book', [PublicPropertyAppraisalController::class, 'bookAppointment'])->name('property.appraisal.book');
Route::post('/property-appraisal/check-availability', [PublicPropertyAppraisalController::class, 'checkAvailability'])
    ->name('property.appraisal.check-availability');

// Properties routes - IMPORTANT: Define custom routes BEFORE resource routes
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');

// Alternative property single page route
Route::get('/property-single/{id}', [PropertyController::class, 'show'])->name('property-single');

// Protected property routes
Route::middleware(['auth'])->group(function () {
    Route::get('/my-properties', [PropertyController::class, 'myProperties'])->name('properties.my');
    Route::get('/my-archived-properties', [PropertyController::class, 'archivedProperties'])->name('properties.archived');
    Route::put('/properties/{property}/archive', [PropertyController::class, 'archive'])->name('properties.archive');
    Route::put('/properties/{property}/unarchive', [PropertyController::class, 'unarchive'])->name('properties.unarchive');
    
    // My appraisals
    Route::get('/my-appraisals', [PublicPropertyAppraisalController::class, 'myAppointments'])->name('public.property.appraisals.my');
    Route::put('/property-appraisal/{appraisal}/cancel', [PublicPropertyAppraisalController::class, 'cancelAppointment'])->name('property.appraisal.cancel');
});

// Property Image Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/properties/{property}/images', [PropertyImageController::class, 'manage'])->name('properties.images.manage');
    Route::post('/properties/{property}/images', [PropertyImageController::class, 'upload'])->name('properties.images.upload');
    Route::delete('/properties/images/{image}', [PropertyImageController::class, 'destroy'])->name('properties.images.destroy');
    Route::patch('/properties/images/{image}/primary', [PropertyImageController::class, 'setPrimary'])->name('properties.images.setPrimary');
    Route::post('/properties/{property}/images/order', [PropertyImageController::class, 'updateOrder'])->name('properties.images.updateOrder');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::post('/check-email-unique', [App\Http\Controllers\Auth\RegisterController::class, 'checkEmailUnique']);
Route::post('/check-phone-unique', [App\Http\Controllers\Auth\RegisterController::class, 'checkPhoneUnique']);
Route::post('/check-card-unique', [App\Http\Controllers\Auth\RegisterController::class, 'checkCardUnique']);
// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/reports', [App\Http\Controllers\Admin\ReportsController::class, 'index'])->name('reports.index');

     // User Management Routes
     Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\AdminUserController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\AdminUserController::class, 'store'])->name('store');
        Route::get('/{user}', [App\Http\Controllers\Admin\AdminUserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [App\Http\Controllers\Admin\AdminUserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [App\Http\Controllers\Admin\AdminUserController::class, 'update'])->name('update');
        Route::put('/{user}/password', [App\Http\Controllers\Admin\AdminUserController::class, 'updatePassword'])->name('update-password');
        Route::delete('/{user}', [App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/restore', [App\Http\Controllers\Admin\AdminUserController::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [App\Http\Controllers\Admin\AdminUserController::class, 'forceDelete'])->name('force-delete');
        Route::post('/{user}/toggle-status', [App\Http\Controllers\Admin\AdminUserController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/{user}/verify-email', [App\Http\Controllers\Admin\AdminUserController::class, 'verifyEmail'])->name('verify-email');
        Route::post('/bulk-action', [App\Http\Controllers\Admin\AdminUserController::class, 'bulkAction'])->name('bulk-action');
        Route::post('/deactivate-subscription/{paymentId}', [App\Http\Controllers\Admin\AdminUserController::class, 'deactivateSubscription'])->name('deactivate-subscription');
    });
Route::prefix('areas')->name('areas.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AdminAreaController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Admin\AdminAreaController::class, 'create'])->name('create');
    Route::post('/', [App\Http\Controllers\Admin\AdminAreaController::class, 'store'])->name('store');
    Route::get('/{area}/edit', [App\Http\Controllers\Admin\AdminAreaController::class, 'edit'])->name('edit');
    Route::put('/{area}', [App\Http\Controllers\Admin\AdminAreaController::class, 'update'])->name('update');
    Route::delete('/{area}', [App\Http\Controllers\Admin\AdminAreaController::class, 'destroy'])->name('destroy');
});

    // Appraisal Management
    Route::prefix('appraisals')->name('appraisals.')->group(function () {
        Route::get('/', [AdminAppraisalController::class, 'index'])->name('index');
        Route::get('/create', [AdminAppraisalController::class, 'create'])->name('create');
        Route::post('/', [AdminAppraisalController::class, 'store'])->name('store');
        Route::get('/{appraisal}/edit', [AdminAppraisalController::class, 'edit'])->name('edit');
        Route::put('/{appraisal}', [AdminAppraisalController::class, 'update'])->name('update');
        Route::put('/{appraisal}/status', [AdminAppraisalController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{appraisal}', [AdminAppraisalController::class, 'destroy'])->name('destroy');
        Route::get('/calendar', [AdminAppraisalController::class, 'calendar'])->name('calendar');
        Route::get('/events', [AdminAppraisalController::class, 'getEvents'])->name('events');
    });

    // Property Management

    
    Route::prefix('properties')->name('properties.')->group(function () {
        Route::get('/', [AdminPropertyController::class, 'index'])->name('index');
        Route::get('/{property}/edit', [AdminPropertyController::class, 'edit'])->name('edit');
        Route::put('/{property}/status', [AdminPropertyController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{property}', [AdminPropertyController::class, 'destroy'])->name('destroy');
        Route::get('/trash', [AdminPropertyController::class, 'trash'])->name('trash');

    });

    Route::prefix('testimonials')->name('testimonials.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\TestimonialController::class, 'index'])->name('index');
        Route::get('/{testimonial}', [App\Http\Controllers\Admin\TestimonialController::class, 'show'])->name('show');
        Route::patch('/{testimonial}/toggle-status', [App\Http\Controllers\Admin\TestimonialController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/{testimonial}', [App\Http\Controllers\Admin\TestimonialController::class, 'destroy'])->name('destroy');
    });
});

Route::get('/testimonials/submit', [App\Http\Controllers\TestimonialController::class, 'showForm'])->name('testimonials.form');
Route::post('/testimonials', [App\Http\Controllers\TestimonialController::class, 'store'])->name('testimonials.store');

// Protected Routes for Authenticated Users
Route::middleware(['auth'])->group(function () {
    // Home
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');

    Route::delete('/profile/image/delete', [ProfileController::class, 'deleteProfileImage'])->name('profile.image.delete');
    Route::post('/profile/image/set-main', [ProfileController::class, 'setMainProfileImage'])->name('profile.image.setMain');
    
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

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/user/{user}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/send', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/property/{property}', [MessageController::class, 'create'])->name('messages.create');
});

// Debug and testing routes
Route::get('/a', function () {
    return redirect('/dev/appraisals');
});

Route::get('/direct-status-update/{id}/{status}', function($id, $status) {
    try {
        if (!in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'])) {
            return redirect()->back()->with('error', 'Invalid status');
        }
        
        $updateData = ['status' => $status];
        
        if ($status === 'cancelled') {
            $updateData['cancelled_by'] = 'admin';
            $updateData['cancelled_at'] = now();
        }
        
        $updated = DB::table('property_appraisals')
            ->where('id', $id)
            ->update($updateData);
            
        if ($updated) {
            return redirect()->route('admin.appraisals.index')
                ->with('success', 'Appointment status updated to ' . ucfirst($status));
        } else {
            return redirect()->back()
                ->with('error', 'Failed to update appointment status');
        }
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error updating status: ' . $e->getMessage());
    }
});

Route::get('/check-admin', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return 'You are authenticated as admin. User ID: ' . Auth::id() . ', Role: ' . Auth::user()->role;
    } elseif (Auth::check()) {
        return 'You are authenticated but not as admin. User ID: ' . Auth::id() . ', Role: ' . Auth::user()->role;
    } else {
        return 'You are not authenticated';
    }
});

Route::get('/debug-user', function() {
    if (Auth::check()) {
        return [
            'authenticated' => true,
            'id' => Auth::id(),
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'user_type' => Auth::user()->user_type
        ];
    } else {
        return [
            'authenticated' => false
        ];
    }
});

Route::get('/test-image', function() {
    $user = Auth::user();
    if ($user && $user->profile_image) {
        $imagePath = storage_path('app/public/' . $user->profile_image);
        if (file_exists($imagePath)) {
            return response()->file($imagePath);
        }
    }
    return 'No image found';
});

// أضيفي هذا الـ route في web.php للتحقق من حالة العقار
Route::get('/debug-property/{id}', function($id) {
    
    $property = \App\Models\Property::with(['images', 'features'])->find($id);
    
    if (!$property) {
        return 'Property not found';
    }
    
    // التحقق من التحقق من الهوية بطريقة آمنة
    $isAuthenticated = Auth::check();
    $currentUserId = $isAuthenticated ? Auth::id() : null;
    $currentUserRole = $isAuthenticated ? Auth::user()->role : null;
    $canEdit = $isAuthenticated && ($currentUserId === $property->user_id || $currentUserRole === 'admin');
    
    return [
        'property_id' => $property->id,
        'title' => $property->title,
        'status' => $property->status,
        'user_id' => $property->user_id,
        'current_user_id' => $currentUserId,
        'current_user_role' => $currentUserRole,
        'is_authenticated' => $isAuthenticated,
        'images_count' => $property->images->count(),
        'images' => $property->images->map(function($img) {
            return [
                'id' => $img->id,
                'path' => $img->image_path,
                'is_primary' => $img->is_primary,
                'sort_order' => $img->sort_order,
                'file_exists' => \Illuminate\Support\Facades\Storage::disk('public')->exists($img->image_path)
            ];
        }),
        'features_count' => $property->features->count(),
        'features' => $property->features->pluck('name'),
        'can_edit' => $canEdit
    ];
});
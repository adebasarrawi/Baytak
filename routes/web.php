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

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminPropertyController;
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


Route::get('/property-estimation', [PublicPropertyAppraisalController::class, 'index'])
     ->name('property.estimation');
Route::post('/property-appraisal/book', [PublicPropertyAppraisalController::class, 'bookAppointment'])->name('property.appraisal.book');
Route::post('/property-appraisal/check-availability', [PublicPropertyAppraisalController::class, 'checkAvailability'])
    ->name('property.appraisal.check-availability');
// Route::post('/property-appraisal/available-slots', [PublicPropertyAppraisalController::class, 'getAvailableTimeSlots'])->name('property.appraisal.available-slots');

// Protected appraisal routes
Route::middleware(['auth'])->group(function () {
    Route::get('/my-appraisals', [PublicPropertyAppraisalController::class, 'myAppointments'])->name('public.property.appraisals.my');
    Route::put('/property-appraisal/{appraisal}/cancel', [PublicPropertyAppraisalController::class, 'cancelAppointment'])->name('property.appraisal.cancel');
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

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
    });
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


Route::get('/a', function () {
    return redirect('/dev/appraisals');
});

Route::get('/direct-status-update/{id}/{status}', function($id, $status) {
    try {
        if (!in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'])) {
            return redirect()->back()->with('error', 'Invalid status');
        }
        
        $updated = DB::table('property_appraisals')
            ->where('id', $id)
            ->update(['status' => $status]);
            
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
Route::get('/direct-delete-appraisal/{id}', function($id) {
    try {
        $deleted = DB::table('property_appraisals')
            ->where('id', $id)
            ->delete();
            
        if ($deleted) {
            return redirect()->route('admin.appraisals.index')
                ->with('success', 'Appointment deleted successfully');
        } else {
            return redirect()->back()
                ->with('error', 'Failed to delete appointment');
        }
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Error deleting appointment: ' . $e->getMessage());
    }
    

    Route::get('/dashboard', function () {
        if (Auth::check() && Auth::user()->user_type === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard'); // Regular dashboard for non-admin users
    });
});
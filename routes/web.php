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


// Admin routes for property appraisal management
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Appraisal Routes - بترتيب صحيح
    Route::get('/appraisals/events', [AdminAppraisalController::class, 'getEvents'])->name('appraisals.events');
    Route::get('/appraisals/calendar', [AdminAppraisalController::class, 'calendar'])->name('appraisals.calendar');
    Route::get('/appraisals/create', [AdminAppraisalController::class, 'create'])->name('appraisals.create');
    Route::get('/appraisals', [AdminAppraisalController::class, 'index'])->name('appraisals.index');
    Route::post('/appraisals', [AdminAppraisalController::class, 'store'])->name('appraisals.store');
    Route::get('/appraisals/{appraisal}/edit', [AdminAppraisalController::class, 'edit'])->name('appraisals.edit');
    Route::put('/appraisals/{appraisal}', [AdminAppraisalController::class, 'update'])->name('appraisals.update');
    Route::put('/appraisals/{appraisal}/status', [AdminAppraisalController::class, 'updateStatus'])->name('appraisals.update-status');
    Route::delete('/appraisals/{appraisal}', [AdminAppraisalController::class, 'destroy'])->name('appraisals.destroy');
    
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


// اختصار للوصول السريع إلى صفحة appraisals
Route::get('/a', function () {
    return redirect('/dev/appraisals');
});
// مسار مباشر لتحديث حالة الموعد
Route::get('/direct-status-update/{id}/{status}', function($id, $status) {
    try {
        // التحقق من صحة الحالة
        if (!in_array($status, ['pending', 'confirmed', 'completed', 'cancelled'])) {
            return redirect()->back()->with('error', 'Invalid status');
        }
        
        // تحديث الحالة مباشرة في قاعدة البيانات
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
});
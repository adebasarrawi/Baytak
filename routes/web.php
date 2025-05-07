<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertyImageController;



Route::get('/dashboard', function () {
    return view('dashboard');
});
// Route::get('/users', function () {
//     return view('admin.users.index');
// });
// Route::get('/admins', function () {
//     return view('admin.admins.index');
// });

// Route::get('/b', function () {
//     return view('admin.b.index');
// });
// Route::get('/c', function () {
//     return view('admin.c.index');
// });

// Route::get('/admin/a', [App\Http\Controllers\admin\AController::class, 'index'])->name('admin.a.index');
// Route::get('/admin/b', [App\Http\Controllers\admin\BController::class, 'index'])->name('admin.b.index');
// Route::get('/admin/c', [App\Http\Controllers\admin\CController::class, 'index'])->name('admin.c.index');


// use App\Http\Controllers\Auth\LoginController;

// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/services', function () {
    return view('public.services');
});

Route::get('/properties', [PropertyController::class, 'index'])->name('public.properties');

Route::resource('properties', PropertyController::class);

Route::get('/properties/{property}', [PropertyController::class, 'show'])
     ->name('properties.show');

Route::get('/property-single', function () {
    return view('public.property-single');
});

Route::get('/about', function () {
    return view('public.about');
});

Route::get('/contact', function () {
    return view('public.contact');
});

Route::get('/properties.create', function () {
    return view('properties.create');
});

Route::get('/seller-register', function () {
    return view('public.seller-register');
});


Route::get('/estimate', function () {
    return view('public.estimate');
});


// // Authentication routes
// Route::get('/register', function () {
//     return view('public.register');
// })->name('register');

Route::get('/login', function () {
    return view('public.login');
})->name('login');

// use App\Http\Controllers\PropertyController;

// Route::get('/properties/search', [PropertyController::class, 'search'])->name('properties.search');

Route::get('/properties/{property}/images', [PropertyImageController::class, 'manage'])->name('properties.images.manage');
Route::post('/properties/{property}/images', [PropertyImageController::class, 'upload'])->name('properties.images.upload');
Route::delete('/properties/images/{image}', [PropertyImageController::class, 'destroy'])->name('properties.images.destroy');
Route::patch('/properties/images/{image}/primary', [PropertyImageController::class, 'setPrimary'])->name('properties.images.setPrimary');
Route::post('/properties/{property}/images/order', [PropertyImageController::class, 'updateOrder'])->name('properties.images.updateOrder');


// Favorites Routes
// Route::post('/favorites/toggle', [App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');
// Route::get('/favorites', [App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');
// Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Authentication Routes
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.post');
// Profile Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});


// routes/web.php - Add these routes

// Seller Registration and Payment
Route::get('/register/seller', [App\Http\Controllers\Auth\RegisterController::class, 'showSellerRegistrationForm'])->name('register.seller');
Route::post('/register/seller', [App\Http\Controllers\Auth\RegisterController::class, 'registerSeller'])->name('register.seller.post');
Route::get('/seller/payment', [App\Http\Controllers\PaymentController::class, 'showPaymentForm'])->name('seller.payment');
Route::post('/seller/payment/process', [App\Http\Controllers\PaymentController::class, 'processPayment'])->name('seller.payment.process');
Route::get('/seller/payment/success', [App\Http\Controllers\PaymentController::class, 'paymentSuccess'])->name('seller.payment.success');

// // Admin Property Approval
// Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/properties/pending', [App\Http\Controllers\Admin\PropertyController::class, 'pendingProperties'])->name('properties.pending');
//     Route::post('/properties/{property}/approve', [App\Http\Controllers\Admin\PropertyController::class, 'approveProperty'])->name('properties.approve');
//     Route::post('/properties/{property}/reject', [App\Http\Controllers\Admin\PropertyController::class, 'rejectProperty'])->name('properties.reject');
// });
// // Admin Property Approval
// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/properties/pending', [App\Http\Controllers\Admin\PropertyController::class, 'pendingProperties'])->name('admin.properties.pending');
//     Route::post('/admin/properties/{property}/approve', [App\Http\Controllers\Admin\PropertyController::class, 'approveProperty'])->name('admin.properties.approve');
//     Route::post('/admin/properties/{property}/reject', [App\Http\Controllers\Admin\PropertyController::class, 'rejectProperty'])->name('admin.properties.reject');
// });

Route::middleware(['admin'])->group(function () {
    // Routes that require admin access
});

Route::middleware(['seller'])->group(function () {
    // Routes that require seller access
});

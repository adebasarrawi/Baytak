<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    // ... الكود الموجود
    
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        // ... الكود الموجود
        
        // تسجيل الـ middleware هنا
        Route::aliasMiddleware('admin', AdminMiddleware::class);
        
        $this->routes(function () {
            // ... الكود الموجود
        });
    }
}
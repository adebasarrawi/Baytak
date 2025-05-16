<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

class RouteServiceProvider extends ServiceProvider
{
    // ... existing code
    
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */public function boot()
{
    // Other code...
    
    // Only use this ONE method to register the middleware
    $this->app['router']->aliasMiddleware('admin', \App\Http\Middleware\AdminMiddleware::class);
    
    // Remove any other middleware registration like:
    // Route::aliasMiddleware('admin', AdminMiddleware::class);
    // or protected $routeMiddleware = ['admin' => AdminMiddleware::class];
    
    $this->routes(function () {
        // Your existing routes...
    });
}
    
    // Remove this property completely or comment it out
    // protected $routeMiddleware = [
    //     // ...
    //     'admin' => \App\Http\Middleware\AdminMiddleware::class,
    // ];
}
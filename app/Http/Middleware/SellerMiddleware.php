<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in and is a seller
        if (!Auth::check() || Auth::user()->user_type !== 'seller') {
            // If not, redirect to home with error message
            return redirect()->route('home')->with('error', 'You need to be a registered seller to access this page.');
        }

        // Continue processing the request
        return $next($request);
    }
}
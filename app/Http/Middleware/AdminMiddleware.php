<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        // Check if the user is logged in and is an admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // If not, redirect to home with error message
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }

        // Continue processing the request
        return $next($request);
    }
}
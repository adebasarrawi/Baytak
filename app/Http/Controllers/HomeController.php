<?php

namespace App\Http\Controllers;
use App\Models\Testimonial;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function getTestimonials()
{
    return Testimonial::with('area')
        ->where('is_active', true)
        ->latest()
        ->take(6)
        ->get();
}
}

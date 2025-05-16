<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PropertyAppraisal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'You do not have admin access');
        }

        // Counts for each status
        $pendingCount = PropertyAppraisal::where('status', 'pending')->count();
        $confirmedCount = PropertyAppraisal::where('status', 'confirmed')->count();
        $completedCount = PropertyAppraisal::where('status', 'completed')->count();
        $cancelledCount = PropertyAppraisal::where('status', 'cancelled')->count();
        
        // Recent appraisals (last 5)
        $recentAppraisals = PropertyAppraisal::with('appraiser')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Today's appointments
        $todayAppointments = PropertyAppraisal::whereDate('appointment_date', Carbon::today())
            ->orderBy('appointment_time')
            ->get();
        
        // Pending appraisals
        $pendingAppraisals = PropertyAppraisal::where('status', 'pending')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->take(10)
            ->get();
        
        // Get all appraisers with their appraisal counts
        // Change 'role' to 'user_type' to match your database column
        $appraisers = User::where('user_type', 'appraiser')
            ->withCount('appraisals')
            ->orderBy('appraisals_count', 'desc')
            ->take(5)
            ->get();
        
        // Monthly appraisal data for chart
        $monthlyAppraisalData = $this->getMonthlyAppraisalData();
        
        return view('admin.dashboard', compact(
            'pendingCount',
            'confirmedCount',
            'completedCount',
            'cancelledCount',
            'recentAppraisals',
            'todayAppointments',
            'pendingAppraisals',
            'appraisers',
            'monthlyAppraisalData'
        ));
    }
    
    /**
     * Get monthly appraisal data for the current year.
     *
     * @return array
     */
    private function getMonthlyAppraisalData()
    {
        $currentYear = Carbon::now()->year;
        
        // Initialize data array with zeros for all months
        $monthlyData = array_fill(0, 12, 0);
        
        // Get count of appraisals by month
        $results = PropertyAppraisal::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->get();
        
        // Fill data array with actual counts
        foreach ($results as $result) {
            // Months are 1-indexed but array is 0-indexed
            $monthlyData[$result->month - 1] = $result->count;
        }
        
        return $monthlyData;
    }
}
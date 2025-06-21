<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Property;
use App\Models\Payment;
use App\Models\PropertyAppraisal;
use App\Models\Testimonial;
use App\Models\Area;
use App\Models\PropertyType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        // Date filter - default to last 30 days
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        // Convert to Carbon instances
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        // 📊 GENERAL STATISTICS
        $totalUsers = User::count();
        $totalProperties = Property::count();
        $totalActiveProperties = Property::where('status', 'approved')->count();
        $totalRevenue = Payment::where('active', true)->sum('subscription');

        // 📈 USERS ANALYTICS
        $newUsersCount = User::whereBetween('created_at', [$start, $end])->count();
        $activeUsersCount = User::where('status', 'active')->count();
        $sellersCount = User::where('user_type', 'seller')->count();
        $appraisersCount = User::where('user_type', 'appraiser')->count();

        // User registration trend (last 12 months)
        $userRegistrationTrend = User::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Top users by properties
        $topUsersByProperties = User::withCount('properties')
            ->having('properties_count', '>', 0)
            ->orderBy('properties_count', 'desc')
            ->take(10)
            ->get();

        // 🏠 PROPERTIES ANALYTICS
        $newPropertiesCount = Property::whereBetween('created_at', [$start, $end])->count();
        $pendingPropertiesCount = Property::where('status', 'pending')->count();
        $rejectedPropertiesCount = Property::where('status', 'rejected')->count();
        
        // Properties by status
        $propertiesByStatus = Property::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status');

        // Properties trend (last 12 months)
        $propertiesTrend = Property::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Most viewed properties
        $mostViewedProperties = Property::with(['user', 'area'])
            ->where('views', '>', 0)
            ->orderBy('views', 'desc')
            ->take(10)
            ->get();

        // Properties by type
        $propertiesByType = Property::join('property_types', 'properties.property_type_id', '=', 'property_types.id')
            ->select('property_types.name', DB::raw('count(*) as count'))
            ->groupBy('property_types.name')
            ->orderBy('count', 'desc')
            ->get();

        // 📍 GEOGRAPHIC ANALYTICS
        $propertiesByArea = Property::join('areas', 'properties.area_id', '=', 'areas.id')
            ->select('areas.name', DB::raw('count(*) as count'))
            ->groupBy('areas.name')
            ->orderBy('count', 'desc')
            ->take(10)
            ->get();

        // 💰 REVENUE ANALYTICS
        $monthlyRevenue = Payment::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(CASE WHEN subscription = "premium" THEN 50 WHEN subscription = "basic" THEN 25 ELSE 0 END) as revenue')
            )
            ->where('active', true)
            ->where('created_at', '>=', Carbon::now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $subscriptionDistribution = Payment::select('subscription', DB::raw('count(*) as count'))
            ->where('active', true)
            ->groupBy('subscription')
            ->get()
            ->pluck('count', 'subscription');

        // Active vs Expired subscriptions
        $activeSubscriptions = Payment::where('active', true)
            ->where('subscription_expires_at', '>', now())
            ->count();
        
        $expiredSubscriptions = Payment::where('active', true)
            ->where('subscription_expires_at', '<=', now())
            ->count();

        // 📅 APPRAISALS ANALYTICS (if exists)
        $totalAppraisals = 0;
        $pendingAppraisals = 0;
        $completedAppraisals = 0;
        $appraisalsTrend = collect([]);
        
        if (class_exists('App\Models\PropertyAppraisal')) {
            $totalAppraisals = PropertyAppraisal::count();
            $pendingAppraisals = PropertyAppraisal::where('status', 'pending')->count();
            $completedAppraisals = PropertyAppraisal::where('status', 'completed')->count();
            
            $appraisalsTrend = PropertyAppraisal::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                    DB::raw('COUNT(*) as count')
                )
                ->where('created_at', '>=', Carbon::now()->subMonths(12))
                ->groupBy('month')
                ->orderBy('month')
                ->get();
        }

        // 💬 TESTIMONIALS ANALYTICS (if exists)
        $totalTestimonials = 0;
        $approvedTestimonials = 0;
        
        if (class_exists('App\Models\Testimonial')) {
            $totalTestimonials = Testimonial::count();
            $approvedTestimonials = Testimonial::where('is_active', true)->count();
        }

        // 📊 PERFORMANCE METRICS
        $approvalRate = $totalProperties > 0 ? round(($totalActiveProperties / $totalProperties) * 100, 2) : 0;
        $userGrowthRate = $this->calculateGrowthRate('users', $start, $end);
        $propertyGrowthRate = $this->calculateGrowthRate('properties', $start, $end);

        // Average properties per user
        $avgPropertiesPerUser = $totalUsers > 0 ? round($totalProperties / $totalUsers, 2) : 0;

        return view('admin.reports.index', compact(
            // General
            'totalUsers', 'totalProperties', 'totalActiveProperties', 'totalRevenue',
            'startDate', 'endDate',
            
            // Users
            'newUsersCount', 'activeUsersCount', 'sellersCount', 'appraisersCount',
            'userRegistrationTrend', 'topUsersByProperties',
            
            // Properties
            'newPropertiesCount', 'pendingPropertiesCount', 'rejectedPropertiesCount',
            'propertiesByStatus', 'propertiesTrend', 'mostViewedProperties', 'propertiesByType',
            
            // Geographic
            'propertiesByArea',
            
            // Revenue
            'monthlyRevenue', 'subscriptionDistribution', 'activeSubscriptions', 'expiredSubscriptions',
            
            // Appraisals
            'totalAppraisals', 'pendingAppraisals', 'completedAppraisals', 'appraisalsTrend',
            
            // Testimonials
            'totalTestimonials', 'approvedTestimonials',
            
            // Performance
            'approvalRate', 'userGrowthRate', 'propertyGrowthRate', 'avgPropertiesPerUser'
        ));
    }

    private function calculateGrowthRate($table, $start, $end)
    {
        $currentPeriod = DB::table($table)
            ->whereBetween('created_at', [$start, $end])
            ->count();
            
        $previousStart = $start->copy()->subDays($start->diffInDays($end));
        $previousEnd = $start->copy()->subDay();
        
        $previousPeriod = DB::table($table)
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->count();
            
        if ($previousPeriod == 0) {
            return $currentPeriod > 0 ? 100 : 0;
        }
        
        return round((($currentPeriod - $previousPeriod) / $previousPeriod) * 100, 2);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\PropertyAppraisal;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // للتطوير فقط: تجاوز فحص الدور
        if (Auth::check()) {
            // قم بتسجيل محاولة الوصول للتصحيح
            Log::info('Development mode: Bypassing role check for user ID: ' . Auth::id());
            return $next($request);
        }
    
        // التحقق من تسجيل الدخول فقط
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in');
        }
        
        // الكود الأصلي معلق مؤقتًا
        /*
        if (Auth::check() && Auth::user()->role === 'admin') {
            Log::info('User is admin - allowing access');
            return $next($request);
        }
        
        Log::warning('Access denied - User is not admin');
        return redirect('/')->with('error', 'You do not have admin access');
        */
        
        return $next($request);
    }

    public function updateStatus(Request $request, PropertyAppraisal $appraisal)
{
    try {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);
        
        $oldStatus = $appraisal->status;
        $newStatus = $request->status;
        
        $appraisal->status = $newStatus;
        $appraisal->save();
        
        // أضف تسجيل للتصحيح
        Log::info('Appraisal status updated', [
            'appraisal_id' => $appraisal->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus
        ]);
        
        // استخدم redirect لصفحة admin.appraisals.index
        return redirect()->route('admin.appraisals.index')
            ->with('success', 'Appointment status updated successfully');
            
    } catch (\Exception $e) {
        // سجل الخطأ
        Log::error('Error updating appraisal status: ' . $e->getMessage());
        
        // إعادة التوجيه مع رسالة خطأ
        return redirect()->back()->with('error', 'Error updating status: ' . $e->getMessage());
    }
}
}
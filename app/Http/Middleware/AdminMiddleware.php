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
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'You must be logged in');
        }
        
        // Change 'role' to 'user_type' to match your database
        if (Auth::user()->user_type !== 'admin') {
            return redirect('/')->with('error', 'You do not have admin access');
        }
        
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
            
            Log::info('Appraisal status updated', [
                'appraisal_id' => $appraisal->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus
            ]);
            
            return redirect()->route('admin.appraisals.index')
                ->with('success', 'Appointment status updated successfully');
                
        } catch (\Exception $e) {
            Log::error('Error updating appraisal status: ' . $e->getMessage());
            
            return redirect()->back()->with('error', 'Error updating status: ' . $e->getMessage());
        }
    }


}
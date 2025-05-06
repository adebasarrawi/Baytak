<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
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
     * Show the payment form for seller registration.
     *
     * @return \Illuminate\View\View
     */
    public function showPaymentForm()
    {
        if (Auth::user()->user_type !== 'pending_seller') {
            return redirect()->route('home');
        }
        
        return view('seller.payment', [
            'amount' => 3.00, // 3 JOD
            'currency' => 'JOD'
        ]);
    }

    /**
     * Process the payment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processPayment(Request $request)
    {
        // Here you would integrate with your payment gateway
        // This is a simplified example
        
        try {
            // Process payment with payment gateway
            // For now, we'll simulate a successful payment
            
            // If payment successful, update user type
            $userId = Auth::id();
            
            // Use DB facade to update directly
            DB::table('users')
                ->where('id', $userId)
                ->update(['user_type' => 'seller']);
                
            // Record the payment
            PaymentTransaction::create([
                'user_id' => $userId,
                'amount' => 3.00,
                'currency' => 'JOD',
                'payment_method' => $request->payment_method,
                'transaction_id' => 'TR-' . uniqid(), // In real implementation, use gateway's transaction ID
                'status' => 'completed'
            ]);
            
            return redirect()->route('seller.payment.success');
        } catch (\Exception $e) {
            return back()->withErrors(['payment' => 'Payment failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Show payment success page.
     *
     * @return \Illuminate\View\View
     */
    public function paymentSuccess()
    {
        // Get fresh user data from database
        $user = User::find(Auth::id());
        
        if (!$user || $user->user_type !== 'seller') {
            return redirect()->route('home');
        }
        
        return view('seller.payment-success');
    }
}
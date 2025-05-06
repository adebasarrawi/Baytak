<?php
// app/Http/Controllers/PaymentController.php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            $user = Auth::user();
            $user->user_type = 'seller';
            $user->save();
            
            // Create the PaymentTransaction model if you haven't already
            // php artisan make:model PaymentTransaction -m
            
            // Record the payment
            PaymentTransaction::create([
                'user_id' => $user->id,
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
        if (Auth::user()->user_type !== 'seller') {
            return redirect()->route('home');
        }
        
        return view('seller.payment-success');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\PaymentTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    public function showPaymentForm()
    {
        if (Auth::user()->user_type !== 'pending_seller') {
            return redirect()->route('home');
        }
        
        return view('seller.payment', [
            'amount' => 3.00, 
            'currency' => 'JOD'
        ]);
    }

    public function processPayment(Request $request)
    {
        try {
            Log::info('Processing payment', $request->all());
            
            $userId = Auth::id();
            $user = User::findOrFail($userId);
            
            if ($user->user_type === 'seller') {
                return redirect()->route('home')->with('info', 'You are already a seller.');
            }
            
            // Update both user_type and role to 'seller'
            $user->update([
                'user_type' => 'seller',
                'role' => 'seller' // Important - update the role to seller
            ]);
            
            Log::info('User updated to seller: ' . $userId);
                
            // Record the transaction
            PaymentTransaction::create([
                'user_id' => $userId,
                'amount' => 3.00,
                'currency' => 'JOD',
                'payment_method' => $request->payment_method ?? 'credit_card',
                'transaction_id' => 'TR-' . uniqid(),
                'status' => 'completed'
            ]);
            
            Log::info('Payment transaction recorded');
            
            return redirect()->route('seller.payment.success');
        } catch (\Exception $e) {
            Log::error('Payment processing error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return back()->withErrors(['payment' => 'Payment failed: ' . $e->getMessage()]);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth; // قم بإضافة هذا السطر

class SellerRegisterController extends Controller
{
    public function showRegistrationForm()
    {
        // Initialize step in session if not set
        if (!session()->has('step')) {
            session(['step' => 1]);
        }
        
        return view('public.seller-register');
    }

    public function register(Request $request)
    {
        // التحقق من الخطوة الأولى
        if ($request->step == 1) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'shop_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('step', 1);
            }

            $request->session()->put('seller_step1', $request->except('_token', 'step', 'password_confirmation'));
            return redirect()->route('seller.register')->with('step', 2);
        }

        if ($request->step == 2) {
            $validator = Validator::make($request->all(), [
                'card_number' => 'required|string|min:16|max:16',
                'card_expiry' => 'required|string|min:5|max:5',
                'card_cvc' => 'required|string|min:3|max:3',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('step', 2);
            }

            $step1Data = $request->session()->get('seller_step1');

            $user = User::create([
                'name' => $step1Data['name'],
                'email' => $step1Data['email'],
                'password' => Hash::make($step1Data['password']),
                'role' => 'seller',
                'shop_name' => $step1Data['shop_name'],
                'phone' => $step1Data['phone'],
                'payment_status' => 'paid', 
            ]);

            $request->session()->forget('seller_step1');

            Auth::login($user);

            return redirect()->route('seller.dashboard')->with('success', 'SUCCESS');
        }
    }
}
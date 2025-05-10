<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        Log::info('Registration request data:', $request->all());

        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'max:15'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'user_type' => ['required', 'string', 'in:user,seller'],
                'card_holder' => ['required_if:user_type,seller', 'nullable', 'string', 'max:255'],
                'card_number' => ['required_if:user_type,seller', 'nullable', 'string', 'max:19'],
                'expiry_date' => ['required_if:user_type,seller', 'nullable', 'string', 'max:7'],
                'cvc' => ['required_if:user_type,seller', 'nullable', 'string', 'max:4'],
                'subscription' => ['sometimes', 'string', 'in:monthly,yearly'],
                'redirect_to' => ['sometimes', 'string'],
                'payment_confirmed' => ['sometimes', 'string'],
            ]);

            // إنشاء المستخدم
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'role' => $request->user_type === 'seller' ? 'seller' : 'user',
                'user_type' => $request->user_type,
            ]);

            Log::info('User created with ID: ' . $user->id);

            // إذا كان مستخدم من نوع بائع وقدم معلومات الدفع
            if ($request->user_type === 'seller' && 
                $request->filled('card_holder') && 
                $request->filled('card_number') &&
                $request->has('payment_confirmed')) {

                // حفظ معلومات الدفع
                $payment = Payment::create([
                    'user_id' => $user->id,
                    'card_holder' => $request->card_holder,
                    'card_number' => $request->card_number,
                    'expiry_date' => $request->expiry_date,
                    'cvc' => $request->cvc,
                    'subscription' => $request->subscription ?? 'monthly',
                ]);

                Log::info('Payment record created with ID: ' . $payment->id);
            }

            // التحقق مما إذا كان يجب إعادة التوجيه إلى صفحة تسجيل الدخول
            if ($request->has('redirect_to') && $request->redirect_to === 'login') {
                Log::info('Redirecting to login page after registration');
                return redirect()->route('login')->with('success', 'Registration successful! Please login to continue.');
            }

            // تسجيل الدخول تلقائيًا
            Auth::login($user);
            return redirect()->route('home')->with('success', 'Registration successful!');

        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return back()->withInput()->withErrors(['registration' => 'Registration failed: ' . $e->getMessage()]);
        }
    }
}
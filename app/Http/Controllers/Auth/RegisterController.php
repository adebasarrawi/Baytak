<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // دالة للتحقق من تفرد البريد الإلكتروني
    public function checkEmailUnique(Request $request)
    {
        $email = $request->email;
        $exists = User::where('email', $email)->exists();
        
        return response()->json([
            'exists' => $exists
        ]);
    }
    public function checkCardUnique(Request $request)
{
    $cardNumber = $request->card_number;
    
    // Remove spaces for consistent comparison
    $cleanCardNumber = str_replace(' ', '', $cardNumber);
    
    // Check if this card number exists in the database
    $exists = Payment::whereRaw("REPLACE(card_number, ' ', '') = ?", [$cleanCardNumber])->exists();
    
    return response()->json([
        'exists' => $exists
    ]);
}
    
    // دالة للتحقق من تفرد رقم الهاتف
    public function checkPhoneUnique(Request $request)
    {
        $phone = $request->phone;
        $exists = User::where('phone', $phone)->exists();
        
        return response()->json([
            'exists' => $exists
        ]);
    }

    public function register(Request $request)
    {
        Log::info('Registration request data:', $request->all());

        try {
            // رسائل التحقق المخصصة
            $messages = [
                'name.required' => 'Please enter your full name.',
                'email.required' => 'Please enter an email address.',
                'email.email' => 'Please enter a valid email address format (example@domain.com).',
                'email.unique' => 'This email is already registered in our system.',
                'phone.required' => 'Please enter your phone number.',
                'phone.unique' => 'This phone number is already registered in our system.',
                'phone.regex' => 'Please enter a valid phone number format.',
                'password.required' => 'Please enter a password.',
                'password.min' => 'Password must be at least 8 characters long.',
                'password.confirmed' => 'Password confirmation does not match.',
                'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.',
                'card_holder.required_if' => 'Card holder name is required for seller accounts.',
                'card_number.required_if' => 'Card number is required for seller accounts.',
                'card_number.regex' => 'Please enter a valid card number.',
                'card_number.unique' => 'This card number is already in use.',
                'expiry_date.required_if' => 'Card expiry date is required for seller accounts.',
                'expiry_date.regex' => 'Please enter a valid expiry date format (MM/YY).',
                'cvc.required_if' => 'CVC is required for seller accounts.',
                'cvc.regex' => 'Please enter a valid CVC (3-4 digits).',
            ];

            // قواعد التحقق المحسنة
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
                'phone' => ['required', 'string', 'regex:/^[0-9+\-\s()]{7,15}$/', 'unique:users'],
                'password' => [
                    'required', 
                    'string', 
                    'min:8', 
                    'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/'
                ],
                'user_type' => ['required', 'string', 'in:user,seller'],
                'card_holder' => ['required_if:user_type,seller', 'nullable', 'string', 'max:255'],
                'card_number' => [
                    'required_if:user_type,seller', 
                    'nullable', 
                    'string', 
                    'regex:/^[0-9\s]{13,19}$/',
                    function ($attribute, $value, $fail) {
                        if (!empty($value)) {
                            // إزالة المسافات للمقارنة
                            $cleanCardNumber = str_replace(' ', '', $value);
                            $exists = Payment::whereRaw("REPLACE(card_number, ' ', '') = ?", [$cleanCardNumber])->exists();
                            if ($exists) {
                                $fail('This card number is already in use.');
                            }
                        }
                    }
                ],
                'expiry_date' => [
                    'required_if:user_type,seller', 
                    'nullable', 
                    'string', 
                    'regex:/^(0[1-9]|1[0-2])\/([0-9]{2})$/'
                ],
                'cvc' => [
                    'required_if:user_type,seller', 
                    'nullable', 
                    'string', 
                    'regex:/^[0-9]{3,4}$/'
                ],
                'subscription' => ['sometimes', 'string', 'in:monthly,yearly'],
                'redirect_to' => ['sometimes', 'string'],
                'payment_confirmed' => ['sometimes', 'string'],
            ], $messages);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $validated = $validator->validated();

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['user_type'] === 'seller' ? 'seller' : ($validated['email'] === 'admin@example.com' ? 'admin' : 'user'),
                'user_type' => $validated['user_type'],
            ]);

            Log::info('User created with ID: ' . $user->id);

            // إذا كان المستخدم بائع وقدم معلومات الدفع
            if ($validated['user_type'] === 'seller' && 
                isset($validated['card_holder']) && 
                isset($validated['card_number']) && 
                isset($request->payment_confirmed)) {

                // حساب تاريخ انتهاء الاشتراك
                $now = Carbon::now();
                $subscription_type = $validated['subscription'] ?? 'monthly';
                $expires_at = ($subscription_type === 'yearly') 
                    ? $now->copy()->addYear() 
                    : $now->copy()->addMonth();

                // حفظ معلومات الدفع
                $payment = Payment::create([
                    'user_id' => $user->id,
                    'card_holder' => $validated['card_holder'],
                    'card_number' => $validated['card_number'],
                    'expiry_date' => $validated['expiry_date'],
                    'cvc' => $validated['cvc'],
                    'subscription' => $subscription_type,
                    'subscription_expires_at' => $expires_at,
                    'active' => true,
                ]);

                Log::info('Payment record created with ID: ' . $payment->id . ', Expires at: ' . $expires_at);
            }

            // التحقق مما إذا كان يجب إعادة التوجيه إلى صفحة تسجيل الدخول
            if (isset($validated['redirect_to']) && $validated['redirect_to'] === 'login') {
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
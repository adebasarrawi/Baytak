<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    protected function authenticated(Request $request, $user)
{
    if ($user->user_type === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect('/profile'); // or any other default redirect for non-admin users
}

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
    
            return redirect()->route('profile'); // تغيير هنا ليرجع لصفحة البروفايل مباشرة
        }
    
        return back()->withErrors([
            'email' => 'بيانات الاعتماد المقدمة غير متطابقة مع سجلاتنا.',
        ])->withInput($request->except('password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
    
}
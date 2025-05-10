<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'user_type',
        'profile_image',
        'bio',
        'address',
        // إضافة الحقول الجديدة للتحقق من البريد
        'email_verification_code',
        'email_verification_expires_at',
        'email_verified_at'
    ];

   

    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_code' // إخفاء كود التحقق
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_verification_expires_at' => 'datetime'
    ];

    // الميثود الموجودة
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSeller()
    {
        return $this->user_type === 'seller';
    }

    // ميثود للتحقق من البريد
    public function hasVerifiedEmail()
    {
        return $this->email_verified_at !== null;
    }

    // توليد كود التحقق
    public function generateVerificationCode()
    {
        $this->email_verification_code = sprintf("%06d", mt_rand(1, 999999));
        $this->email_verification_expires_at = Carbon::now()->addMinutes(30);
        $this->save();

        return $this->email_verification_code;
    }

    // التحقق من صحة كود التفعيل
    public function verifyEmailCode($code)
    {
        // التحقق من الكود وعدم انتهاء صلاحيته
        return $this->email_verification_code === $code && 
               $this->email_verification_expires_at > now();
    }

    // تفعيل البريد الإلكتروني
    public function markEmailAsVerified()
    {
        $this->email_verified_at = now();
        $this->email_verification_code = null;
        $this->email_verification_expires_at = null;
        $this->save();
    }

    // العلاقات الموجودة
    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
  
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    
    public function favoriteProperties()
    {
        return $this->belongsToMany(Property::class, 'favorites', 'user_id', 'property_id')->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function paymentTransactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }
}
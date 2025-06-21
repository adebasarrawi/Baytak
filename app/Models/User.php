<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'user_type',
        'profile_image',
        'bio',
        'address',
        'email_verification_code',
        'email_verification_expires_at',
        'email_verified_at',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verification_code'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_verification_expires_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    protected $dates = ['deleted_at'];

    // Existing methods
    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isSeller()
    {
        return $this->user_type === 'seller';
    }

    public function hasVerifiedEmail()
    {
        return $this->email_verified_at !== null;
    }

    public function generateVerificationCode()
    {
        $this->email_verification_code = sprintf("%06d", mt_rand(1, 999999));
        $this->email_verification_expires_at = Carbon::now()->addMinutes(30);
        $this->save();

        return $this->email_verification_code;
    }

    public function verifyEmailCode($code)
    {
        return $this->email_verification_code === $code &&
                $this->email_verification_expires_at > now();
    }

    public function markEmailAsVerified()
    {
        $this->email_verified_at = now();
        $this->email_verification_code = null;
        $this->email_verification_expires_at = null;
        $this->save();
    }

    // Status methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function activate()
    {
        $this->update(['status' => 'active']);
    }

    public function deactivate()
    {
        $this->update(['status' => 'inactive']);
    }

    // Relationships
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

    public function appraisals()
    {
        return $this->hasMany(PropertyAppraisal::class);
    }

    public function appraisalsAsAppraiser()
    {
        return $this->hasMany(PropertyAppraisal::class, 'appraiser_id');
    }

    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    // Password mutator
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

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
    
    // Add this method to easily get favorite properties
    public function favoriteProperties()
    {
        return $this->belongsToMany(Property::class, 'favorites', 'user_id', 'property_id')->withTimestamps();
    }
    
    public function isSeller()
    {
        return $this->user_type === 'seller';
    }
}
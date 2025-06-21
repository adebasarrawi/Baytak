<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appraiser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'experience_years',
        'license_number',
        'specialty',
        'availability',
        'hourly_rate',
        'rating',
        'profile_image',
        'bio',
        'certification'
    ];

    /**
     * Get the user associated with the appraiser.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the appraiser's profile image URL
     */
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return asset('storage/' . $this->profile_image);
        }
        return asset('images/default-avatar.jpg');
    }

    /**
     * Get the appraiser's name from the user relationship
     */
    public function getNameAttribute()
    {
        return $this->user ? $this->user->name : 'Unknown';
    }

    /**
     * Get the appraiser's email from the user relationship
     */
    public function getEmailAttribute()
    {
        return $this->user ? $this->user->email : '';
    }
}
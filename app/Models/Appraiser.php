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
        'rating'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
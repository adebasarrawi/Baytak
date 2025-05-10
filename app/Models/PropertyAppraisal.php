<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAppraisal extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'appraiser_id',
        'client_name',
        'client_email',
        'client_phone',
        'property_address',
        'appointment_date',
        'appointment_time',
        'additional_notes',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
    ];

    /**
     * Get the user that owns the appraisal request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the appraiser assigned to this appraisal.
     */
    public function appraiser()
    {
        return $this->belongsTo(User::class, 'appraiser_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyAppraisal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'appraiser_id',
        'client_name',
        'client_email',
        'client_phone',
        'property_address',
        'property_type',
        'property_area',
        'appointment_date',
        'appointment_time',
        'status',
        'cancelled_by',
        'cancelled_at',
        'additional_notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    /**
     * Get the user that owns the appraisal.
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
        return $this->belongsTo(Appraiser::class);
    }

    /**
     * Check if the appraisal can be cancelled.
     */
    public function canBeCancelled()
    {
        return $this->status === 'pending';
    }

    /**
     * Get the cancellation text for display.
     */
    public function getCancellationDisplayAttribute()
    {
        if ($this->status !== 'cancelled') {
            return null;
        }

        return $this->cancelled_by === 'user' ? 'Cancelled by User' : 'Cancelled by Admin';
    }
}
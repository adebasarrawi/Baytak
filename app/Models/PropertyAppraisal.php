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
        'property_type',
        // Removed 'property_area',
        'bedrooms',
        'bathrooms',
        'additional_notes',
        'status',
    ];

    /**
     * Get the user who booked the appraisal.
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

    /**
     * Scope a query to only include pending appraisals.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include confirmed appraisals.
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope a query to only include completed appraisals.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include cancelled appraisals.
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Get the formatted appointment date.
     */
    public function getFormattedDateAttribute()
    {
        return date('F d, Y', strtotime($this->appointment_date));
    }

    /**
     * Get the formatted appointment time.
     */
    public function getFormattedTimeAttribute()
    {
        return date('h:i A', strtotime($this->appointment_time));
    }
}
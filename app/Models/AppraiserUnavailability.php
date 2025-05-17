<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppraiserUnavailability extends Model
{
    use HasFactory;

    protected $table = 'appraiser_unavailability';

    protected $fillable = [
        'appraiser_id',
        'date',
        'time',
    ];

    /**
     * Get the appraiser associated with the unavailability.
     */
    public function appraiser()
    {
        return $this->belongsTo(Appraiser::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes; // المسار الصحيح

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Testimonial extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'name',
        'position',
        'content',
        'rating',
        'area_id',
        'is_active',
        'image_path',
    ];

    // Relationship with Area
    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
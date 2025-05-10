<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'price',
        'size',
        'bedrooms',
        'bathrooms',
        'property_type_id',
        'area_id',
        'address',
        'purpose',
        'slug',
        'is_approved',
        'is_featured',
        'latitude',
        'longitude',
        'parking_spaces',
        'status',
        'year_built',
        'floors',
        'views',
        'rejection_reason'
    ];

    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'property_feature');
    }

    public function images() {
        return $this->hasMany(PropertyImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(PropertyImage::class)->where('is_primary', true);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'property_id', 'user_id')->withTimestamps();
    }
}
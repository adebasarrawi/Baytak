<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 


class Property extends Model
{
    public function getRouteKeyName()
    {
        return 'id';
    }
    use SoftDeletes;
    protected $dates = ['deleted_at', 'archived_at'];

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
        'rejection_reason',
        'year_built',
        'floors',
        'views',
        'rejection_reason',
        'archived_at',
        'deleted_at',

    ];
    public function delete()
    {
        $this->update(['status' => 'removed']);
        
        return parent::delete();
    }

    protected $casts = [
        'archived_at' => 'datetime',
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
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'User Deleted',
            'email' => 'N/A'
        ]);
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

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeArea($query, $areaId)
    {
        if ($areaId) {
            return $query->where('area_id', $areaId);
        }
        return $query;
    }

    public function scopeWithFeatures($query, $featureIds)
    {
        if (!empty($featureIds)) {
            return $query->whereHas('features', function($q) use ($featureIds) {
                $q->whereIn('features.id', $featureIds);
            });
        }
        return $query;
    }

    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        if ($minPrice >= 0) {
            $query->where('price', '>=', $minPrice);
        }
        
        if ($maxPrice >= 0) {
            $query->where('price', '<=', $maxPrice);
        }
        
        return $query;
    }
    

    public function scopeSizeRange($query, $minSize, $maxSize)
    {
        if ($minSize >= 0) {
            $query->where('size', '>=', $minSize);
        }
        
        if ($maxSize >= 0) {
            $query->where('size', '<=', $maxSize);
        }
        
        return $query;
    }
}
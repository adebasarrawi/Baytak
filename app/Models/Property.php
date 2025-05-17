<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
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
        'rejection_reason'
    ];

    // علاقة العقار بنوع العقار
    public function type()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    // علاقة العقار بالمنطقة
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    // علاقة العقار بالمستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // علاقة العقار بالميزات (Many-to-Many)
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

    // نطاقات البحث
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

    // نطاق البحث حسب المنطقة
    public function scopeArea($query, $areaId)
    {
        if ($areaId) {
            return $query->where('area_id', $areaId);
        }
        return $query;
    }

    // نطاق البحث حسب الميزات
    public function scopeWithFeatures($query, $featureIds)
    {
        if (!empty($featureIds)) {
            return $query->whereHas('features', function($q) use ($featureIds) {
                $q->whereIn('features.id', $featureIds);
            });
        }
        return $query;
    }

    // نطاق البحث حسب السعر
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

    // نطاق البحث حسب المساحة
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
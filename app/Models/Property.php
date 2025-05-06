<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\District;


class Property extends Model
{
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

// في App\Models\Property
public function features()
{
    return $this->belongsToMany(Feature::class, 'property_feature'); // تحديد اسم الجدول الوسيط
}

public function images()
{
    return $this->hasMany(PropertyImage::class);
}

// إذا كنت تريدين الصورة الأساسية فقط
public function primaryImage()
{
    return $this->hasOne(PropertyImage::class)->where('is_primary', true);
}

// In app/Models/Property.php

// Add this method
public function favoritedBy()
{
    return $this->belongsToMany(User::class, 'favorites', 'property_id', 'user_id')->withTimestamps();
}


}

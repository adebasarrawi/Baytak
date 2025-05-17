<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['name', 'icon'];

    // علاقة الميزة بالعقارات (Many-to-Many)
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_feature');
    }
}
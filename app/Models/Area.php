<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }
    
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
    
}

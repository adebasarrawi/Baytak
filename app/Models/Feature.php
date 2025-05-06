<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    public function properties()
{
    return $this->belongsToMany(Property::class, 'property_features');
}

}

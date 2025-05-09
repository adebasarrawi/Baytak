<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Governorate extends Model
{
    protected $fillable = ['name', 'name_en'];
    
    public function areas()
    {
        return $this->hasMany(Area::class);
    }
}
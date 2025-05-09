<?php
// app/Models/PropertyImage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $fillable = [
        'property_id',
        'image_path',
        'is_primary',
        'sort_order'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
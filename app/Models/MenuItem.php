<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $fillable = [
        'restaurant_id',
        'category_id',
        'name',
        'base_price',
        'is_available',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ItemVariant::class);
    }

    public function addons()
    {
        return $this->belongsToMany(
            Addon::class,
            'item_addons'
        );
    }
}

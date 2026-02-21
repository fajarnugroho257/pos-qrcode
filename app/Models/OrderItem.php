<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'menu_item_id',
        'qty',
        'price',
    ];

    public function addons()
    {
        return $this->belongsToMany(
            Addon::class,
            'order_item_addons',
        );
    }
}

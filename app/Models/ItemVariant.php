<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemVariant extends Model
{
    protected $fillable = [
        'menu_item_id',
        'name',
        'price_modifier',
    ];

    public function menuItem()
    {
        return $this->belongsTo(MenuItem::class);
    }
}

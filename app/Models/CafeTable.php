<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CafeTable extends Model
{
    protected $fillable = [
        'restaurant_id',
        'table_number',
        'capacity',
        'status',
        'location',
        'qr_image',
        'is_active',
    ];
}

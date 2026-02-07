<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CafeTable extends Model
{
    protected $fillable = [
        'restaurant_id',
        'name',
        'capacity',
    ];
}

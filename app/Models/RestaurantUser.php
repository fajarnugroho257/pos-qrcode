<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RestaurantUser extends Model
{
    protected $table = 'restaurant_user';

    protected $fillable = [
        'restaurant_id',
        'user_id',
    ];
}

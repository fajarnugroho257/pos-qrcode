<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = [
        'admin_user_id',
        'name',
        'address',
        'phone',
        'is_active',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'restaurant_user',
            'restaurant_id',
            'user_id',
        );
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}

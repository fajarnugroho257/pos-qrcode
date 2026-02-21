<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // public $incrementing = false;
    protected $fillable = [
        'name',
        'username',
        'password',
        'role_id',
    ];

    protected $primaryKey = 'id';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function app_role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'role_id');
    }

    public function restaurants()
    {
        return $this->belongsToMany(
            Restaurant::class,
            'restaurant_user',
            'user_id',
            'restaurant_id',
        );
    }

    public function activeRestaurant()
    {
        $ownedRestaurant = Restaurant::where('admin_user_id', $this->id)->first();
        if ($ownedRestaurant) {
            return $ownedRestaurant;
        }

        return $this->restaurants()->first();
    }
}

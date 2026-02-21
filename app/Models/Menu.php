<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'app_menu';

    protected $primaryKey = 'menu_id';

    protected $fillable = ['menu_id', 'menu_name', 'menu_icon', 'menu_st', 'menu_level', 'menu_url', 'menu_parent'];

    public function children()
    {
        return $this->hasMany(Menu::class, 'menu_parent', 'menu_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'app_role_menu', 'menu_id', 'role_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppMenu extends Model
{
    protected $table = 'app_menu';

    protected $primaryKey = 'menu_id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['menu_id', 'menu_name', 'menu_icon', 'menu_level', 'menu_url', 'menu_parent'];

    public function children()
    {
        return $this->hasMany(self::class, 'menu_parent', 'menu_id')
            ->orderBy('menu_level')
            ->orderBy('menu_name');
    }
}

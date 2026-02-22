<?php

use Illuminate\Support\Facades\Cache;

if (! function_exists('clear_menu_cache')) {
    function clear_menu_cache(int $restaurantId): void
    {
        Cache::increment("menu_version:{$restaurantId}");
    }
}

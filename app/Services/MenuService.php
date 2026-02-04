<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;

class MenuService {
    public function getSidebarMenu() {
        if (!Auth::check()) return collect();

        $roleId = Auth::user()->role_id;
        $cacheKey = "sidebar_menu_" . $roleId;

        return Cache::remember($cacheKey, now()->addDay(), function () use ($roleId) {
            $allMenus = Menu::whereHas('roles', function($q) use ($roleId) {
                $q->where('app_role_menu.role_id', $roleId);
            })->orderBy('menu_id', 'asc')->get();

            return $this->buildTree($allMenus);
        });
    }

    public function buildTree($elements, $parentId = '0') {
        $branch = collect();
        foreach ($elements as $element) {
            if ($element->menu_parent == $parentId) {
                $children = $this->buildTree($elements, $element->menu_id);
                $element->setRelation('children', $children);
                
                // Logika sederhana untuk cek apakah menu aktif
                $element->is_active = request()->is($element->menu_url . '*');
                $branch->push($element);
            }
        }
        return $branch;
    }
}

?>
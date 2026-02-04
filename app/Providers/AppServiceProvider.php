<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use App\Services\MenuService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(MenuService $menuService): void
    {
        Paginator::useTailwind();

        view()->composer('*', function ($view) {
            if (auth()->check()) {
                $roleId = auth()->user()->role_id;
                $cacheKey = "sidebar_menu_" . $roleId;
                
                $menus = Cache::remember($cacheKey, now()->addDay(), function () use ($roleId) {
                    // Ambil data berdasarkan tabel app_role_menu anda
                    $allMenus = \App\Models\Menu::whereHas('roles', function($q) use ($roleId) {
                        $q->where('app_role_menu.role_id', $roleId);
                    })->orderBy('menu_id', 'asc')->get();

                    return app(\App\Services\MenuService::class)->buildTree($allMenus);
                });

                $view->with('menus', $menus);
                // nama pengguna
                $cacheName = "pengguna";
                $pengguna = Cache::remember($cacheName, now()->addDay(), function () {
                    return auth()->user()->name;
                });
                $view->with('pengguna', $pengguna);
            }
        });

        // DB::listen(function ($query) {
        //     // Query SQL
        //     $sql = $query->sql;
            
        //     // Bindings (parameter)
        //     $bindings = $query->bindings;
            
        //     // Waktu eksekusi (ms)
        //     $time = $query->time;

        //     // Log ke laravel.log
        //     Log::info('SQL: '.$sql.' | Bindings: '.json_encode($bindings).' | Time: '.$time.'ms');

        //     // Atau tampilkan di debug
        //     dump($sql, $bindings, $time);
        // });
    }
}

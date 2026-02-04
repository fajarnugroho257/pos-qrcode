<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

class CheckMenuAccess
{
    public function handle(Request $request, Closure $next, $menuUrl = null)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $roleId = Auth::user()->role_id;

        // Cek apakah role user memiliki akses ke menu_url ini
        $hasAccess = Menu::where('menu_url', $menuUrl)
            ->whereHas('roles', function ($q) use ($roleId) {
                $q->where('app_role_menu.role_id', $roleId);
            })->exists();

        if (!$hasAccess) {
            // Jika tidak punya akses, lempar ke 403 atau dashboard
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
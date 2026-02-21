<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\base\DataUserController;
use App\Http\Controllers\base\MenuAddonsController;
use App\Http\Controllers\base\MenuCategoriesController;
use App\Http\Controllers\base\MenuController;
use App\Http\Controllers\base\MenuListController;
use App\Http\Controllers\base\MenuTagsController;
use App\Http\Controllers\base\RoleController;
use App\Http\Controllers\base\RolemenuController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\CafeTableController;
use App\Http\Controllers\OrderPesananController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// login
Route::middleware(['guest'])->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/login-process', [LoginController::class, 'loginProcess'])->name('loginProcess');
    Route::get('/order', [OrderPesananController::class, 'index']);
});

Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::middleware(['checkMenu:dashboard'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });
    // // Menu Aplikasi
    Route::middleware(['checkMenu:menuApp'])->group(function () {
        Route::get('/menu-aplikasi', [MenuController::class, 'index'])->name('menuApp');
        Route::get('/add-menu-aplikasi', [MenuController::class, 'create'])->name('menuAppAdd');
        Route::post('/add-process-menu-aplikasi', [MenuController::class, 'store'])->name('menuAppAddProcess');
        Route::get('/edit-menu-aplikasi/{menu_id}', [MenuController::class, 'edit'])->name('menuAppEdit');
        Route::post('/edit-process-menu-aplikasi/{menu_id}', [MenuController::class, 'update'])->name('menuAppEditProcess');
        Route::get('/delete-process-menu-aplikasi/{menu_id}', [MenuController::class, 'destroy'])->name('menuAppDeleteProcess');
    });
    // Role Pengguna
    Route::middleware(['checkMenu:rolePengguna'])->group(function () {
        Route::get('/role-pengguna', [RoleController::class, 'index'])->name('rolePengguna');
        Route::get('/add-role-pengguna', [RoleController::class, 'create'])->name('rolePenggunaAdd');
        Route::post('/add-process-role-pengguna', [RoleController::class, 'store'])->name('rolePenggunaAddProcess');
        Route::get('/edit-role-pengguna/{role_id}', [RoleController::class, 'edit'])->name('rolePenggunaEdit');
        Route::post('/edit-process-role-pengguna/{role_id}', [RoleController::class, 'update'])->name('rolePenggunaEditProcess');
        Route::get('/delete-process-role-pengguna/{role_id}', [RoleController::class, 'destroy'])->name('rolePenggunaDeleteProcess');
    });
    // Role Menu
    Route::middleware(['checkMenu:roleMenu'])->group(function () {
        Route::get('/role-menu', [RolemenuController::class, 'index'])->name('roleMenu');
        Route::get('/list-data-role-menu/{role_id}', [roleMenuController::class, 'listDataRoleMenu'])->name('listDataRoleMenu');
        Route::post('/add-role-menu', [roleMenuController::class, 'tambahRoleMenu'])->name('tambahRoleMenu');
    });
    // Data User
    Route::middleware(['checkMenu:dataUser'])->group(function () {
        Route::get('/data-user', [DataUserController::class, 'index'])->name('dataUser');
        Route::get('/add-data-user', [DataUserController::class, 'create'])->name('dataUserAdd');
        Route::post('/process-add-data-user', [DataUserController::class, 'store'])->name('dataUserAddProcess');
        Route::get('/update-data-user/{id}', [DataUserController::class, 'edit'])->name('dataUserEdit');
        Route::post('/process-update-data-user/{id}', [DataUserController::class, 'update'])->name('dataUserEditProcess');
        Route::get('/process-delete-data-user/{id}', [DataUserController::class, 'destroy'])->name('dataUserDelete');
    });

    Route::middleware(['checkMenu:menuItems'])->group(function () {

        // Categories
        Route::get('/menu/categories', [MenuCategoriesController::class, 'index'])
            ->name('menuCategories');

        Route::get('/menu/categories/create', [MenuCategoriesController::class, 'create'])
            ->name('menuCategoriesCreate');

        Route::post('/menu/categories', [MenuCategoriesController::class, 'store'])
            ->name('menuCategoriesStore');

        Route::delete('/menu/categories/{id}', [MenuCategoriesController::class, 'destroy'])
            ->name('menuCategoriesDelete');

        Route::get('/menu/categories/{id}', [MenuCategoriesController::class, 'edit'])
            ->name('menuCategoriesEdit');

        Route::put('/menu/categories/{id}', [MenuCategoriesController::class, 'update'])
            ->name('menuCategoriesUpdate');

        // Addons
        Route::get('/menu/addons', [MenuAddonsController::class, 'index'])
            ->name('menuAddons');

        Route::get('/menu/addons/create', [MenuAddonsController::class, 'create'])
            ->name('menuAddonsCreate');

        Route::post('/menu/addons', [MenuAddonsController::class, 'store'])
            ->name('menuAddonsStore');

        Route::get('/menu/addons/{id}', [MenuAddonsController::class, 'edit'])
            ->name('menuAddonsEdit');

        Route::put('/menu/addons/{id}', [MenuAddonsController::class, 'update'])
            ->name('menuAddonsUpdate');

        Route::delete('/menu/addons/{id}', [MenuAddonsController::class, 'destroy'])
            ->name('menuAddonsDelete');

        // Tags
        Route::get('/menu/tags', [MenuTagsController::class, 'index'])
            ->name('menuTags');

        Route::get('/menu/tags/create', [MenuTagsController::class, 'create'])
            ->name('menuTagsCreate');

        Route::post('/menu/tags', [MenuTagsController::class, 'store'])
            ->name('menuTagsStore');

        Route::get('/menu/tags/{id}', [MenuTagsController::class, 'edit'])
            ->name('menuTagsEdit');

        Route::put('/menu/tags/{id}', [MenuTagsController::class, 'update'])
            ->name('menuTagsUpdate');

        Route::delete('/menu/tags/{id}', [MenuTagsController::class, 'destroy'])
            ->name('menuTagsDelete');

        // Menu Items
        Route::get('/menu/items', [MenuListController::class, 'index'])
            ->name('menuItems');

        Route::get('/menu/items/create', [MenuListController::class, 'create'])
            ->name('menuItemsCreate');

        Route::post('/menu/items', [MenuListController::class, 'store'])
            ->name('menuItemsStore');

        Route::get('/menu/items/{id}', [MenuListController::class, 'edit'])
            ->name('menuItemsEdit');

        Route::put('/menu/items/{id}', [MenuListController::class, 'update'])
            ->name('menuItemsUpdate');

        Route::delete('/menu/items/{id}', [MenuListController::class, 'destroy'])
            ->name('menuItemsDelete');

    });

    // data meja
    Route::middleware(['checkMenu:cafeTables'])->group(function () {
        Route::get('/cafe-tables', [CafeTableController::class, 'index'])->name('cafeTables');
        Route::get('/cafe-tables/create', [CafeTableController::class, 'create'])->name('cafeTablesCreate');
        Route::post('/cafe-tables', [CafeTableController::class, 'store'])->name('cafeTablesStore');
        Route::get('/cafe-tables/show/{id}', [CafeTableController::class, 'show'])->name('cafeTablesShow');
        Route::get('/cafe-tables/edit/{id}', [CafeTableController::class, 'edit'])->name('cafeTablesEdit');
        Route::put('/cafe-tables/update/{id}', [CafeTableController::class, 'update'])->name('cafeTablesUpdate');
        Route::delete('/cafe-tables/delete/{id}', [CafeTableController::class, 'destroy'])->name('cafeTablesDelete');
        Route::get('/cafe-tables/download/{id}', [CafeTableController::class, 'download'])->name('cafeTablesDownload');

    });

    Route::post('/keluar', [LoginController::class, 'logOut'])->name('logOut');
    Route::get('/log-out', [LoginController::class, 'logOut'])->name('log-out');

    /* YOUR ROUTE APLICATION */

    /* END YOUR ROUTE APLICATION */
});

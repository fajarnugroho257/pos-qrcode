<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\base\DataUserController;
use App\Http\Controllers\base\MenuController;
use App\Http\Controllers\base\RoleController;
use App\Http\Controllers\base\RolemenuController;
use App\Http\Controllers\DashboardController;
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
        Route::get('/update-data-user/{user_id}', [DataUserController::class, 'edit'])->name('dataUserEdit');
        Route::post('/process-update-data-user/{user_id}', [DataUserController::class, 'update'])->name('dataUserEditProcess');
        Route::get('/process-delete-data-user/{user_id}', [DataUserController::class, 'destroy'])->name('dataUserDelete');
    });
    
    Route::post('/keluar', [LoginController::class, 'logOut'])->name('logOut');
    Route::get('/log-out', [LoginController::class, 'logOut'])->name('log-out');
    
    /* YOUR ROUTE APLICATION */

    /* END YOUR ROUTE APLICATION */
});



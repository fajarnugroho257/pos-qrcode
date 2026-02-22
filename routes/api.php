<?php

use App\Http\Controllers\api\MenuController;
use App\Http\Controllers\api\MenuVariantController;
use App\Http\Controllers\api\TagsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/restaurants/{restaurant}/menus', [MenuController::class, 'index']);
Route::get('/restaurants/{restaurant}/tags', [TagsController::class, 'index']);
Route::get('/restaurants/{restaurant}/menus/{menu}/variants', [MenuVariantController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

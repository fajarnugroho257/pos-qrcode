<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/api/restaurants/{restaurant}/menus/{menu}/addons",
 *     operationId="getMenuAddons",
 *     tags={"Menus"},
 *     summary="Get menu item addons",
 *     description="Public endpoint to fetch paginated addons of a menu item",
 *
 *     @OA\Parameter(
 *         name="restaurant",
 *         in="path",
 *         required=true,
 *         description="Restaurant ID",
 *
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *
 *     @OA\Parameter(
 *         name="menu",
 *         in="path",
 *         required=true,
 *         description="Menu Item ID",
 *
 *         @OA\Schema(type="integer", example=12)
 *     ),
 *
 *     @OA\Parameter(
 *         name="page",
 *         in="query",
 *         description="Page number",
 *
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *         description="Items per page",
 *
 *         @OA\Schema(type="integer", example=10)
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Success",
 *
 *         @OA\JsonContent(
 *             type="object",
 *
 *             @OA\Property(property="success", type="boolean", example=true),
 *             @OA\Property(
 *                 property="data",
 *                 type="array",
 *
 *                 @OA\Items(
 *
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="name", type="string", example="Extra Cheese"),
 *                     @OA\Property(property="price", type="number", example=3000)
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="meta",
 *                 type="object",
 *                 @OA\Property(property="current_page", type="integer", example=1),
 *                 @OA\Property(property="last_page", type="integer", example=2),
 *                 @OA\Property(property="per_page", type="integer", example=10),
 *                 @OA\Property(property="total", type="integer", example=15)
 *             )
 *         )
 *     )
 * )
 */
class MenuAddonController extends Controller
{
    public function index(Request $request, $restaurantId, $menuId)
    {
        $perPage = $request->integer('per_page', 10);

        $menu = MenuItem::where('id', $menuId)
            ->where('restaurant_id', $restaurantId)
            ->firstOrFail();

        $addons = $menu->addons()
            ->orderBy('name')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $addons->items(),
            'meta' => [
                'current_page' => $addons->currentPage(),
                'last_page' => $addons->lastPage(),
                'per_page' => $addons->perPage(),
                'total' => $addons->total(),
            ],
        ]);
    }
}

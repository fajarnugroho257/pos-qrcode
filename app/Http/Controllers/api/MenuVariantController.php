<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\ItemVariant;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/api/restaurants/{restaurant}/menus/{menu}/variants",
 *     operationId="getMenuVariants",
 *     tags={"Menus"},
 *     summary="Get menu item variants",
 *     description="Public endpoint to fetch paginated variants of a menu item",
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
 *                     type="object",
 *
 *                     @OA\Property(property="id", type="integer", example=1),
 *                     @OA\Property(property="menu_item_id", type="integer", example=12),
 *                     @OA\Property(property="name", type="string", example="Large"),
 *                     @OA\Property(property="price_modifier", type="number", example=5000)
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
class MenuVariantController extends Controller
{
    public function index(Request $request, $restaurantId, $menuId)
    {
        $perPage = $request->integer('per_page', 10);

        $variants = ItemVariant::where('menu_item_id', $menuId)
            ->whereHas('menuItem', function ($q) use ($restaurantId) {
                $q->where('restaurant_id', $restaurantId);
            })
            ->orderBy('name')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $variants->items(),
            'meta' => [
                'current_page' => $variants->currentPage(),
                'last_page' => $variants->lastPage(),
                'per_page' => $variants->perPage(),
                'total' => $variants->total(),
            ],
        ]);
    }
}

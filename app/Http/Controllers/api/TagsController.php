<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

/**
 * @OA\Get(
 *     path="/api/restaurants/{restaurant}/tags",
 *     operationId="getRestaurantTags",
 *     tags={"Menus"},
 *     summary="Get tags by restaurant",
 *     description="Public endpoint to fetch paginated tags for a restaurant",
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
 *                     @OA\Property(property="name", type="string", example="pedas")
 *                 )
 *             ),
 *             @OA\Property(
 *                 property="meta",
 *                 type="object",
 *                 @OA\Property(property="current_page", type="integer", example=1),
 *                 @OA\Property(property="last_page", type="integer", example=3),
 *                 @OA\Property(property="per_page", type="integer", example=10),
 *                 @OA\Property(property="total", type="integer", example=25)
 *             )
 *         )
 *     )
 * )
 */
class TagsController extends Controller
{
    public function index(Request $request, $restaurantId)
    {
        $perPage = $request->integer('per_page', 10);

        $tags = Tag::where('restaurant_id', $restaurantId)
            ->orderBy('name')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $tags->items(),

            'meta' => [
                'current_page' => $tags->currentPage(),
                'last_page' => $tags->lastPage(),
                'per_page' => $tags->perPage(),
                'total' => $tags->total(),
            ],
        ]);
    }
}

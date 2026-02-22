<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/**
 * @OA\Get(
 *     path="/api/restaurants/{restaurant}/menus",
 *     operationId="getRestaurantMenus",
 *     tags={"Menus"},
 *     summary="Get restaurant menu list",
 *     description="Public endpoint to fetch menus with pagination, search, category and tags filter",
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
 *
 *         @OA\Schema(type="integer", example=1)
 *     ),
 *
 *     @OA\Parameter(
 *         name="per_page",
 *         in="query",
 *
 *         @OA\Schema(type="integer", example=10)
 *     ),
 *
 *     @OA\Parameter(
 *         name="search",
 *         in="query",
 *         description="Search menu name",
 *
 *         @OA\Schema(type="string")
 *     ),
 *
 *     @OA\Parameter(
 *         name="category_id",
 *         in="query",
 *
 *         @OA\Schema(type="integer")
 *     ),
 *
 *     @OA\Parameter(
 *         name="tags[]",
 *         in="query",
 *         description="Filter by tag names",
 *
 *         @OA\Schema(
 *             type="array",
 *
 *             @OA\Items(type="string", example="pedas")
 *         )
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
 *                 @OA\Items(type="object")
 *             ),
 *
 *             @OA\Property(
 *                 property="meta",
 *                 type="object",
 *                 @OA\Property(property="current_page", type="integer"),
 *                 @OA\Property(property="last_page", type="integer"),
 *                 @OA\Property(property="per_page", type="integer"),
 *                 @OA\Property(property="total", type="integer")
 *             )
 *         )
 *     )
 * )
 */
class MenuController extends Controller
{
    public function index(Request $request, $restaurantId)
    {
        $perPage = $request->integer('per_page', 10);
        $page = $request->integer('page', 1);

        // cache key harus unik per filter & page
        $cacheKey = 'menu_' . md5(json_encode([
            'restaurant_id' => $restaurantId,
            'category_id' => $request->category_id,
            'search' => $request->search,
            'tags' => $request->tags,
            'page' => $page,
            'per_page' => $perPage,
        ]));

        $menus = Cache::remember($cacheKey, 60, function () use ($request, $restaurantId, $perPage) {

            return MenuItem::query()
                ->where('restaurant_id', $restaurantId)
                ->where('is_available', true)
                ->with([
                    'category:id,name',
                    'variants:id,menu_item_id,name,price_modifier',
                    'addons:id,name,price',
                    'tags:id,name',
                ])
                ->when(
                    $request->category_id,
                    fn ($q) => $q->where('category_id', $request->category_id),
                )
                ->when(
                    $request->search,
                    fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'),
                )
                ->when(
                    ! empty($request->tags),
                    fn ($q) => $q->whereHas('tags', function ($tagQuery) use ($request) {
                        $tagQuery->whereIn('name', $request->tags);
                    }),
                )
                ->orderBy('name')
                ->paginate($perPage)
                ->through(function ($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->name,
                        'base_price' => (int) $item->base_price,
                        'image_url' => $item->image_url
                            ? asset('storage/' . $item->image_url)
                            : null,

                        'category' => $item->category,

                        'variants' => $item->variants->map(fn ($v) => [
                            'id' => $v->id,
                            'name' => $v->name,
                            'price_modifier' => (int) $v->price_modifier,
                        ]),

                        'addons' => $item->addons->map(fn ($a) => [
                            'id' => $a->id,
                            'name' => $a->name,
                            'price' => (int) $a->price,
                        ]),

                        'tags' => $item->tags->pluck('name'),
                    ];
                });
        });

        return response()->json([
            'success' => true,
            'data' => $menus->items(),

            'meta' => [
                'current_page' => $menus->currentPage(),
                'last_page' => $menus->lastPage(),
                'per_page' => $menus->perPage(),
                'total' => $menus->total(),
            ],

            // 'links' => [
            //     'next' => $menus->nextPageUrl(),
            //     'prev' => $menus->previousPageUrl(),
            // ],
        ]);
    }
}

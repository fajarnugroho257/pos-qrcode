<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
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
    use ApiResponse;

    public function index(Request $request, $restaurantId)
    {
        $perPage = $request->integer('per_page', 10);
        $page = $request->integer('page', 1);

        $version = Cache::get("menu_version:{$restaurantId}", 1);
        // cache key harus unik per filter & page
        $cacheKey = 'menu_' . md5(json_encode([
            'version' => $version,
            'restaurant_id' => $restaurantId,
            'category_id' => $request->category_id,
            'search' => $request->search,
            'tags' => $request->tags,
            'page' => $page,
            'per_page' => $perPage,
        ]));

        $menus = Cache::remember($cacheKey, 300, function () use ($request, $restaurantId, $perPage) {

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

        return $this->successPaginated($menus);
    }

    /**
     * @OA\Get(
     *     path="/api/restaurants/{restaurant}/menus/{menu}",
     *     operationId="getRestaurantMenuDetail",
     *     tags={"Menus"},
     *     summary="Get single menu detail",
     *     description="Public endpoint to fetch a single menu detail",
     *
     *     @OA\Parameter(
     *         name="restaurant",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *
     *     @OA\Parameter(
     *         name="menu",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Menu not found"
     *     )
     * )
     */
    public function show($restaurantId, $menuId)
    {
        $version = Cache::get("menu_version:{$restaurantId}", 1);

        $cacheKey = 'menu_detail_' . md5(json_encode([
            'version' => $version,
            'restaurant_id' => $restaurantId,
            'menu_id' => $menuId,
        ]));

        $menu = Cache::remember($cacheKey, 300, function () use ($restaurantId, $menuId) {

            $menu = MenuItem::query()
                ->where('restaurant_id', $restaurantId)
                ->where('id', $menuId)
                ->where('is_available', true)
                ->with([
                    'category:id,name',
                    'variants:id,menu_item_id,name,price_modifier',
                    'addons:id,name,price',
                    'tags:id,name',
                ])
                ->firstOrFail();

            return [
                'id' => $menu->id,
                'name' => $menu->name,
                'description' => $menu->description,
                'base_price' => (int) $menu->base_price,
                'image_url' => $menu->image_url
                    ? asset('storage/' . $menu->image_url)
                    : null,

                'category' => $menu->category,

                'variants' => $menu->variants->map(fn ($v) => [
                    'id' => $v->id,
                    'name' => $v->name,
                    'price_modifier' => (int) $v->price_modifier,
                ]),

                'addons' => $menu->addons->map(fn ($a) => [
                    'id' => $a->id,
                    'name' => $a->name,
                    'price' => (int) $a->price,
                ]),

                'tags' => $menu->tags->pluck('name'),
            ];
        });

        return $this->success($menu);
    }
}

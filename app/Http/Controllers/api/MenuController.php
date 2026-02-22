<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    public function index(Request $request, $restaurantId)
    {
        $perPage = $request->integer('per_page', 10);
        $page    = $request->integer('page', 1);

        // cache key harus unik per filter & page
        $cacheKey = 'menu_' . md5(json_encode([
            'restaurant_id' => $restaurantId,
            'category_id'   => $request->category_id,
            'search'        => $request->search,
            'tags'          => $request->tags,
            'page'          => $page,
            'per_page'      => $perPage,
        ]));

        $menus = Cache::remember($cacheKey, 60, function () use ($request, $restaurantId, $perPage) {

            return MenuItem::query()
                ->where('restaurant_id', $restaurantId)
                ->where('is_available', true)
                ->with([
                    'category:id,name',
                    'variants:id,menu_item_id,name,price_modifier',
                    "addons:id,name,price",
                    'tags:id,name',
                ])
                ->when($request->category_id, fn ($q) =>
                    $q->where('category_id', $request->category_id)
                )
                ->when($request->search, fn ($q) =>
                    $q->where('name', 'like', '%' . $request->search . '%')
                )
                ->when(! empty($request->tags), fn ($q) =>
                    $q->whereHas('tags', function ($tagQuery) use ($request) {
                        $tagQuery->whereIn('name', $request->tags);
                    }, '=', count($request->tags))
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
                'last_page'    => $menus->lastPage(),
                'per_page'     => $menus->perPage(),
                'total'        => $menus->total(),
            ],

            // 'links' => [
            //     'next' => $menus->nextPageUrl(),
            //     'prev' => $menus->previousPageUrl(),
            // ],
        ]);
    }
}
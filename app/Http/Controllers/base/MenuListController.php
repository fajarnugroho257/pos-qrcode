<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MenuListController extends Controller
{
    public function index(Request $request)
    {
        $restaurant = auth()->user()->activeRestaurant();

        $items = MenuItem::where('restaurant_id', $restaurant->id)
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->with('category')
            ->paginate(10)
            ->withQueryString();

        return view('base.menu_items.index', [
            'title' => 'Menu',
            'desc' => 'Daftar menu restoran',
            'items' => $items,
        ]);
    }

    public function create()
    {
        $categories = Category::where(
            'restaurant_id',
            auth()->user()->activeRestaurant()->id,
        )->get();

        $addons = Addon::where(
            'restaurant_id',
            auth()->user()->activeRestaurant()->id,
        )->get();

        $tags = Tag::where(
            'restaurant_id',
            auth()->user()->activeRestaurant()->id,
        )->get();

        return view('base.menu_items.add', [
            'categories' => $categories,
            'addons' => $addons,
            'tags' => $tags,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            // variants
            'variants' => 'nullable|array',
            'variants.*.name' => 'required_with:variants|string|max:50',
            'variants.*.price' => 'required_with:variants|numeric|min:0',

            // addon & tag
            'addons' => 'nullable|array',
            'addons.*' => 'exists:addons,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        DB::transaction(function () use ($request) {

            // upload image
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')
                    ->store('menu-items', 'public');
            }

            // create menu
            $menu = MenuItem::create([
                'restaurant_id' => auth()->user()->activeRestaurant()->id,
                'category_id' => $request->category_id,
                'name' => $request->name,
                'base_price' => $request->price,
                'is_available' => $request->is_active,
                'image_url' => $imagePath,
            ]);

            // =========================
            // SAVE VARIANTS
            // =========================
            if ($request->filled('variants')) {
                foreach ($request->variants as $variant) {
                    if (! empty($variant['name'])) {
                        $menu->variants()->create([
                            'name' => $variant['name'],
                            'price_modifier' => $variant['price'] ?? 0,
                        ]);
                    }
                }
            }

            // =========================
            // SYNC ADDONS
            // =========================
            if ($request->filled('addons')) {
                $menu->addons()->sync($request->addons);
            }

            // =========================
            // SYNC TAGS
            // =========================
            if ($request->filled('tags')) {
                $menu->tags()->sync($request->tags);
            }

        });

        return redirect()
            ->route('menuItems')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $restaurantId = auth()->user()->activeRestaurant()->id;

        $menuItem = MenuItem::with(['variants', 'addons', 'tags'])
            ->where('id', $id)
            ->where('restaurant_id', $restaurantId)
            ->firstOrFail();

        $categories = Category::where('restaurant_id', $restaurantId)->get();

        $addons = Addon::where('restaurant_id', $restaurantId)
            ->orderBy('name')
            ->get();

        $tags = Tag::where('restaurant_id', $restaurantId)
            ->orderBy('name')
            ->get();

        return view('base.menu_items.edit', [
            'title' => 'Edit Menu',
            'desc' => 'Ubah data menu restoran',
            'menuItem' => $menuItem,
            'categories' => $categories,
            'addons' => $addons,
            'tags' => $tags,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:100',
            'base_price' => 'required|numeric|min:0',
            'is_available' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            // ⬇️ VALIDASI RELASI
            'addons' => 'nullable|array',
            'addons.*' => 'exists:addons,id',

            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',

            'variants' => 'nullable|array',
            'variants.*.name' => 'required_with:variants|string|max:100',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $id) {

            $menuItem = MenuItem::with('variants')->findOrFail($id);

            /* =====================
            * UPDATE MENU ITEM
            * ===================== */
            $data = [
                'name' => $request->name,
                'category_id' => $request->category_id,
                'base_price' => $request->base_price,
                'is_available' => $request->is_available,
            ];

            /* IMAGE */
            if ($request->hasFile('image')) {
                if ($menuItem->image_url && Storage::disk('public')->exists($menuItem->image_url)) {
                    Storage::disk('public')->delete($menuItem->image_url);
                }

                $data['image_url'] = $request->file('image')
                    ->store('menu-items', 'public');
            }

            $menuItem->update($data);

            /* =====================
            * SYNC VARIANTS (KEY PART)
            * ===================== */

            // 1. hapus semua variant lama
            $menuItem->variants()->delete();

            // 2. simpan ulang variant baru (jika ada)
            if ($request->filled('variants')) {
                foreach ($request->variants as $variant) {
                    // skip baris kosong (safety)
                    if (empty($variant['name'])) {
                        continue;
                    }

                    $menuItem->variants()->create([
                        'name' => $variant['name'],
                        'price_modifier' => $variant['price'],
                    ]);
                }
            }

            /* =====================
            * SYNC ADDON & TAG
            * ===================== */
            $menuItem->addons()->sync($request->addons ?? []);
            $menuItem->tags()->sync($request->tags ?? []);
        });

        return redirect()
            ->route('menuItems')
            ->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy($id)
    {
        $item = MenuItem::where('id', $id)
            ->where('restaurant_id', auth()->user()->activeRestaurant()->id)
            ->firstOrFail();

        if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
            Storage::disk('public')->delete($item->image_url);
        }

        $item->delete();

        return redirect()
            ->route('menuItems')
            ->with('success', 'Menu berhasil dihapus');
    }
}

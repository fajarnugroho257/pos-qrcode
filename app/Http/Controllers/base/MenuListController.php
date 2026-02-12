<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;
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
            auth()->user()->activeRestaurant()->id
        )->get();

        return view('base.menu_items.add', [
            'categories' => $categories,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:100',
            'price'       => 'required|numeric|min:0',
            'is_active'   => 'required|boolean',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('menu-items', 'public');
        }

        MenuItem::create([
            'restaurant_id' => auth()->user()->activeRestaurant()->id,
            'category_id'   => $request->category_id,
            'name'          => $request->name,
            'base_price'         => $request->price,
            'is_available'     => $request->is_active,
            'image_url'     => $imagePath,
        ]);

        return redirect()
            ->route('menuItems')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $restaurantId = auth()->user()->activeRestaurant()->id;

        $item = MenuItem::where('id', $id)
            ->where('restaurant_id', $restaurantId)
            ->firstOrFail();

        $categories = Category::where('restaurant_id', $restaurantId)->get();

        return view('base.menu_items.edit', [
            'title' => 'Edit Menu',
            'desc' => 'Ubah data menu restoran',
            'menuItem' => $item,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:100',
            'base_price'       => 'required|numeric|min:0',
            'is_available'   => 'required|boolean',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $item = MenuItem::where('id', $id)
            ->where('restaurant_id', auth()->user()->activeRestaurant()->id)
            ->firstOrFail();
            if ($request->hasFile('image')) {
            // delete old image
                if ($item->image_url && Storage::disk('public')->exists($item->image_url)) {
                        Storage::disk('public')->delete($item->image_url);
                    }
                $item->image_url = $request->file('image')
                    ->store('menu-items', 'public');
            }

        $item->update($request->only([
            'category_id',
            'name',
            'base_price',
            'is_available',
        ]));

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

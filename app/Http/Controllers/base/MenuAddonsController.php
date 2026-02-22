<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuAddonsController extends Controller
{
    public function index(Request $request)
    {
        $restaurantId = auth()->user()->activeRestaurant()->id;

        $addons = Addon::where('restaurant_id', $restaurantId)
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('base.menu_addons.index', [
            'title' => 'Addon Menu',
            'desc' => 'Daftar addon menu restoran',
            'addons' => $addons,
        ]);
    }

    public function create()
    {
        return view('base.menu_addons.add', [
            'title' => 'Tambah Addon',
            'desc' => 'Addon menu restoran',
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        Addon::create([
            'restaurant_id' => auth()->user()->activeRestaurant()->id,
            'name' => $request->name,
            'price' => $request->price,
        ]);

        return redirect()
            ->route('menuAddons')
            ->with('success', 'Addon berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $restaurantId = auth()->user()->activeRestaurant()->id;

        $addon = Addon::where('id', $id)
            ->where('restaurant_id', $restaurantId)
            ->firstOrFail();

        return view('base.menu_addons.edit', [
            'title' => 'Edit Addon',
            'desc' => 'Ubah data addon menu',
            'addon' => $addon,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
        ]);

        $restaurantId = auth()->user()->activeRestaurant()->id;

        $addon = Addon::where('id', $id)
            ->where('restaurant_id', $restaurantId)
            ->firstOrFail();

        $addon->update([
            'name' => $request->name,
            'price' => $request->price,
        ]);

        clear_menu_cache(auth()->user()->activeRestaurant()->id);

        return redirect()
            ->route('menuAddons')
            ->with('success', 'Addon berhasil diperbarui');
    }

    public function destroy(string $id): RedirectResponse
    {
        $restaurantId = auth()->user()->activeRestaurant()->id;

        $addon = Addon::where('id', $id)
            ->where('restaurant_id', $restaurantId)
            ->firstOrFail();

        $addon->delete();

        return redirect()
            ->route('menuAddons')
            ->with('success', 'Addon berhasil dihapus');
    }
}

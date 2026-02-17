<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Category;



class MenuCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $restaurant = auth()->user()->activeRestaurant();

        $categories = Category::where('restaurant_id', $restaurant->id)
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->with('restaurant')
            ->paginate(10)
            ->withQueryString();

        return view('base.menu_categories.index', [
            'title' => 'Kategori Menu',
            'desc' => 'Daftar kategori menu restoran',
            'categories' => $categories,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('base.menu_categories.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);
        $restaurantId = auth()->user()->activeRestaurant()->id;

        Category::create([
            'restaurant_id' => $restaurantId,
            'name' => $request->name,
        ]);

        return redirect()
            ->route('menuCategories')
            ->with('success', 'Kategori berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $restaurantId = auth()->user()->activeRestaurant()->id;
        $category = Category::query()->where('restaurant_id', $restaurantId)->findOrFail($id);

        return view('base.menu_categories.edit', [
            'title'    => 'Edit Kategori',
            'desc'     => 'Ubah data kategori menu restoran',
            'category' => $category,
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // 1. Validasi
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        // 2. Ambil restaurant aktif user
        $user = auth()->user();

        // Jika user hanya punya 1 restaurant
        $restaurantId = auth()->user()->activeRestaurant()->id;

        // 3. Ambil kategori berdasarkan ID & restaurant
        $category = Category::where('id', $id)
            ->where('restaurant_id', $restaurantId)
            ->firstOrFail();

        // 4. Update data
        $category->update([
            'name' => $request->name,
        ]);

        // 5. Redirect
        return redirect()
            ->route('menuCategories')
            ->with('success', 'Kategori berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $user = auth()->user();

        // Ambil restaurant aktif user (sesuai relasi kamu) test
        $restaurant = auth()->user()->activeRestaurant()->id;

        if (! $restaurant) {
            return redirect()
                ->route('menuCategories')
                ->with('error', 'Restoran tidak ditemukan');
        }

        // Pastikan kategori milik restoran tersebut
        $category = Category::where('id', $id)
            ->where('restaurant_id', $restaurant)
            ->firstOrFail();

        $category->delete();

        return redirect()
            ->route('menuCategories')
            ->with('success', 'Kategori berhasil dihapus');
    }
}

<?php

namespace App\Http\Controllers\base;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MenuTagsController extends Controller
{
    public function index(Request $request)
    {
        $restaurant = auth()->user()->activeRestaurant();

        $tags = Tag::where('restaurant_id', $restaurant->id)
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->paginate(10)
            ->withQueryString();

        return view('base.menu_tags.index', [
            'title' => 'Tag Menu',
            'desc' => 'Daftar tag menu restoran',
            'tags' => $tags,
        ]);
    }

    public function create()
    {
        return view('base.menu_tags.add', [
            'title' => 'Tambah Tag',
            'desc' => 'Tambah tag menu restoran',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        Tag::create([
            'restaurant_id' => auth()->user()->activeRestaurant()->id,
            'name' => $request->name,
        ]);

        return redirect()
            ->route('menuTags')
            ->with('success', 'Tag berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        $tag = Tag::where('restaurant_id', auth()->user()->activeRestaurant()->id)
            ->findOrFail($id);

        return view('base.menu_tags.edit', [
            'title' => 'Edit Tag',
            'desc' => 'Ubah data tag menu',
            'tag' => $tag,
        ]);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $tag = Tag::where('restaurant_id', auth()->user()->activeRestaurant()->id)
            ->findOrFail($id);

        $tag->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('menuTags')
            ->with('success', 'Tag berhasil diperbarui');
    }

    public function destroy(string $id): RedirectResponse
    {
        $tag = Tag::where('restaurant_id', auth()->user()->activeRestaurant()->id)
            ->findOrFail($id);

        $tag->delete();

        return redirect()
            ->route('menuTags')
            ->with('success', 'Tag berhasil dihapus');
    }
}

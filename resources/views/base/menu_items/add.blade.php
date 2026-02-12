@extends('layouts.app')

@section('content')
<div>
    <main class="max-w-7xl mx-auto py-8 px-4">
        <div class="bg-white p-8 md:p-10 rounded-2xl shadow-sm border border-gray-200 min-h-100">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                <div>
                    <h2 class="text-sm md:text-xl font-bold text-gray-800">
                        {{ $title ?? 'Tambah Menu' }}
                    </h2>
                    <p class="text-xs md:text-sm text-gray-500">
                        {{ $desc ?? 'Menu restoran' }}
                    </p>
                </div>
                <div class="flex justify-end gap-3">
                    <a href="{{ route('menuItems') }}"
                       class="cursor-pointer bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2
                              rounded-md md:rounded-lg text-xs md:text-sm font-medium flex items-center gap-2">
                        <i class="fa fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <hr class="my-4 text-gray-300">
            @include('layouts.notification')

            {{-- Form --}}
            <form action="{{ route('menuItemsStore') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="space-y-8 mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Nama Menu --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Nama Menu
                            </label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="Contoh: Nasi Goreng Spesial"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                          focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        </div>

                        {{-- Kategori --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Kategori
                            </label>
                            <select name="category_id"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                           focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Harga --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Harga
                            </label>
                            <input type="number"
                                   name="price"
                                   min="0"
                                   value="{{ old('price') }}"
                                   placeholder="Contoh: 15000"
                                   class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                          focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        </div>

                        {{-- Image --}}
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Gambar Menu
                            </label>
                            <input type="file"
                                name="image"
                                accept="image/*"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                        focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        </div>


                        {{-- Status --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Status
                            </label>
                            <select name="is_active"
                                    class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm
                                           focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                                <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>
                                    Aktif
                                </option>
                                <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>
                                    Nonaktif
                                </option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="bg-gray-50 px-8 py-6 flex justify-end gap-3 border-t border-gray-100">
                    <button type="reset"
                            class="px-6 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800">
                        Reset
                    </button>
                    <button type="submit"
                            class="px-8 py-2.5 bg-indigo-600 text-white text-sm font-bold
                                   rounded-md md:rounded-lg shadow-lg shadow-indigo-200 hover:bg-indigo-700">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </main>
</div>
@endsection

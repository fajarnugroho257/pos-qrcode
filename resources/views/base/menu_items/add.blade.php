@extends('layouts.app')

@push('styles')
<style>
.select2-container--default .select2-selection--multiple {
    border-radius: 0.75rem;
    border-color: #e5e7eb;
    min-height: 46px;
    padding: 6px;
}
</style>
@endpush

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
                        {{-- Addon --}}
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Addon
                            </label>
                            <select name="addons[]"
                                    multiple
                                    class="select2 w-full px-4 py-3 border border-gray-200 rounded-xl text-sm">
                                @foreach ($addons as $addon)
                                    <option value="{{ $addon->id }}"
                                        {{ collect(old('addons'))->contains($addon->id) ? 'selected' : '' }}>
                                        {{ $addon->name }} (Rp {{ number_format($addon->price) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Tag --}}
                        <div class="space-y-2 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Tag
                            </label>
                            <select name="tags[]"
                                    multiple
                                    class="select2 w-full px-4 py-3 border border-gray-200 rounded-xl text-sm">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}"
                                        {{ collect(old('tags'))->contains($tag->id) ? 'selected' : '' }}>
                                        {{ $tag->name }}
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

                        {{-- Variants --}}
                        <div class="space-y-3 md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Variant Menu
                            </label>

                            <div id="variant-wrapper" class="space-y-3">
                                {{-- default one row (for old input) --}}
                                @if (old('variants'))
                                    @foreach (old('variants') as $i => $variant)
                                        <div class="flex gap-3 items-center variant-row">
                                            <input type="text"
                                                name="variants[{{ $i }}][name]"
                                                value="{{ $variant['name'] }}"
                                                placeholder="Nama Variant (misal: Large)"
                                                class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm">

                                            <input type="number"
                                                name="variants[{{ $i }}][price]"
                                                value="{{ $variant['price'] }}"
                                                min="0"
                                                placeholder="Harga"
                                                class="w-40 px-4 py-3 border border-gray-200 rounded-xl text-sm">

                                            <button type="button"
                                                    class="remove-variant text-red-500 hover:text-red-700 text-sm">
                                                ✕
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <button type="button"
                                    id="add-variant"
                                    class="mt-2 inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-800">
                                + Tambah Variant
                            </button>
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

@push('scripts')
<script>
$(document).ready(function () {
    $('.select2').select2({
        placeholder: 'Pilih',
        allowClear: true,
        width: '100%'
    });

    let variantIndex = {{ old('variants') ? count(old('variants')) : 0 }};

    $('#add-variant').on('click', function () {
        let html = `
            <div class="flex gap-3 items-center variant-row">
                <input type="text"
                       name="variants[${variantIndex}][name]"
                       placeholder="Nama Variant (misal: Large)"
                       class="flex-1 px-4 py-3 border border-gray-200 rounded-xl text-sm">

                <input type="number"
                       name="variants[${variantIndex}][price]"
                       min="0"
                       placeholder="Harga"
                       class="w-80 px-4 py-3 border border-gray-200 rounded-xl text-sm">

                <button type="button"
                        class="remove-variant text-red-500 hover:text-red-700 text-sm">
                    ✕
                </button>
            </div>
        `;

        $('#variant-wrapper').append(html);
        variantIndex++;
    });

    $(document).on('click', '.remove-variant', function () {
        $(this).closest('.variant-row').remove();
    });
});
</script>
@endpush



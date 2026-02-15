@extends('layouts.app')

@push('styles')
<style>
.select2-container .select2-selection--single {
    height: 42px !important;
    border: 1px solid #dee2e6 !important;
    border-radius: 10px !important;
    display: flex;
    align-items: center;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 42px !important;
    padding-left: 15px !important;
    color: #495057;
}

.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #80bdff !important;
    outline: 0;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 42px !important;
    top: 0 !important;
    right: 10px !important;
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
                        {{ $title ?? 'Tambah Kategori' }}
                    </h2>
                    <p class="text-xs md:text-sm text-gray-500">
                        {{ $desc ?? 'Kategori menu restoran' }}
                    </p>
                </div>
                <div class="flex justify-end gap-3">
                    <a href="{{ route('cafeTables') }}"
                       class="cursor-pointer bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md md:rounded-lg text-xs md:text-sm font-medium transition-colors flex items-center gap-2">
                        <i class="fa fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <hr class="my-4 text-gray-300">
            @include('layouts.notification')

            {{-- Form --}}
            <form action="{{ route('cafeTablesUpdate', [$detail->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-8 mb-4">
                    <div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    Nomor Meja
                                </label>
                                <input type="number"
                                       name="table_number"
                                       value="{{ old('table_number', $detail->table_number) }}"
                                       placeholder="Contoh: 1"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    Kapasitas
                                </label>
                                <input type="number"
                                       name="capacity"
                                       value="{{ old('capacity', $detail->capacity) }}"
                                       placeholder="Contoh: 2"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    Lokasi
                                </label>
                                <input type="text"
                                       name="location"
                                       value="{{ old('location', $detail->location) }}"
                                       placeholder="Contoh: Depan"
                                       class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    Status
                                </label>
                                <select name="is_active"
                                    class="select2 w-full px-4 py-3 border border-gray-200 rounded-xl text-sm">
                                    <option value=""></option>
                                    <option @selected(old('is_active', $detail->is_active) == '1') value="1">Ya</option>
                                    <option @selected(old('is_active', $detail->is_active) == '0') value="0">Tidak</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">
                                    QR Code
                                </label>
                                <img src="{{ asset('storage/' . $detail->qr_image) }}" width="150" alt="{{ $detail->qr_image }}">
                                <small class="text-red-400"><b>*tidak tergenerate ulang</b></small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="bg-gray-50 px-8 py-6 flex items-center justify-end gap-3 border-t border-gray-100">
                    <button type="reset"
                            class="px-6 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors">
                        Reset
                    </button>
                    <button type="submit"
                            class="px-8 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-md md:rounded-lg shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all active:scale-95">
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
            width: '100%'
        });
    });
</script>
@endpush
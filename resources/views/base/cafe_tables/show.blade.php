@extends('layouts.app')

@section('content')
<div>
    <main class="max-w-7xl mx-auto py-8 px-4">
        <div class="bg-white p-8 md:p-10 rounded-2xl shadow-sm border border-gray-200 min-h-100">
            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                <div>
                    <h2 class="text-sm md:text-xl font-bold text-gray-800">
                        {{ $title ?? '' }}
                    </h2>
                    <p class="text-xs md:text-sm text-gray-500">
                        {{ $desc ?? '' }}
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
            <div class="space-y-8 mb-4">
                <div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- Category Name --}}
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Nomor Meja
                            </label>
                            <b>{{ $detail->table_number }}</b>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Kapasitas
                            </label>
                            <b>{{ $detail->capacity }}</b>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Lokasi
                            </label>
                            <b>{{ $detail->location }}</b>
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                Status
                            </label>
                            @if ($detail->is_active == "1")
                                <span class="bg-green-500 text-white rounded-sm p-1 text-xs"><b>AKTIF</b></span>
                            @else
                                <span class="bg-red-500 text-white rounded-sm p-1 text-xs"><b>NON-AKTIF</b></span>
                            @endif
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                QR Code
                            </label>
                            <img src="{{ asset('storage/' . $detail->qr_image) }}" width="200" alt="{{ $detail->qr_image }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
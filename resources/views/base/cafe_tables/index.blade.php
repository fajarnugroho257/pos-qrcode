@extends('layouts.app')

@section('content')
<div>
    <main class="max-w-7xl mx-auto py-8 px-4">
        <div class="bg-white p-8 md:p-10 rounded-2xl shadow-sm border border-gray-200 min-h-100">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                <div>
                    <h2 class="text-sm md:text-xl font-bold text-gray-800">
                        {{ $title ?? 'Kategori Menu' }}
                    </h2>
                    <p class="text-xs md:text-sm text-gray-500">
                        {{ $desc ?? 'Daftar kategori menu restoran' }}
                    </p>
                </div>

                <div class="flex items-center gap-3 justify-between">
                    {{-- Search --}}
                    <form action="{{ route('cafeTables') }}" method="GET">
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Cari Nomor/lokasi meja..."
                                   class="pl-10 pr-4 py-2 border border-gray-200 rounded-xl text-sm
                                          focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                            <button type="submit"
                                    class="cursor-pointer w-4 h-4 absolute left-3 top-2.5
                                           text-gray-400 fa fa-search">
                            </button>
                        </div>
                    </form>
                    {{-- download --}}
                    <a href="{{ route('cafeTablesCreate') }}"
                       class="cursor-pointer bg-gray-600 hover:bg-gray-700 text-white
                              px-4 py-2 rounded-md md:rounded-lg text-xs md:text-sm
                              font-medium transition-colors flex items-center gap-2">
                        <i class="fa fa-download"></i>
                        Download
                    </a>
                    {{-- Add --}}
                    <a href="{{ route('cafeTablesCreate') }}"
                       class="cursor-pointer bg-indigo-600 hover:bg-indigo-700 text-white
                              px-4 py-2 rounded-md md:rounded-lg text-xs md:text-sm
                              font-medium transition-colors flex items-center gap-2">
                        <i class="fa fa-plus"></i>
                        Tambah
                    </a>
                </div>
            </div>

            <hr class="my-4 text-gray-300">

            {{-- Table --}}
            <div class="overflow-x-auto">
                @include('layouts.notification')

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-600 text-xs uppercase tracking-wider text-center">
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">No</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Meja</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Kapasitas</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Lokasi</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Status</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Qr Code</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 text-sm md:text-base">
                        @forelse ($cafeTables as $key => $cafeTable)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 text-center">
                                    {{ $cafeTables->firstItem() + $key }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <b>{{ $cafeTable->table_number }}</b>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $cafeTable->capacity }} Orang
                                </td>
                                <td class="px-6 py-4 text-center">
                                    {{ $cafeTable->location ?? "-" }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($cafeTable->is_active == "1")
                                        <span class="bg-green-500 text-white rounded-sm p-1 text-xs">AKTIF</span>
                                    @else
                                        <span class="bg-red-500 text-white rounded-sm p-1 text-xs">NON-AKTIF</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex justify-center">
                                    <div class="text-center">
                                        <img src="{{ asset('storage/' . $cafeTable->qr_image) }}" width="100" alt="{{ $cafeTable->qr_image }}">
                                        <a href="{{ route('cafeTablesDownload', $cafeTable->id) }}" class="text-[10px] bg-gray-700 hover:bg-gray-400 text-white px-1 block"><i class="fa fa-download"></i> <span class="hidden md:inline">Download</span></a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('cafeTablesShow', $cafeTable->id) }}"
                                       class="text-gray-400 hover:text-green-600 p-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('cafeTablesEdit', $cafeTable->id) }}"
                                       class="text-gray-400 hover:text-indigo-600 p-1">
                                        <i class="fas fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('cafeTablesDelete', $cafeTable->id) }}"
                                        method="POST"
                                        class="inline delete-form">
                                        @csrf
                                        @method('DELETE')

                                        <button type="button"
                                                class="text-gray-400 hover:text-red-600 p-1 btn-delete">
                                            <i class="fas fa-trash-can"></i>
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-6 text-center text-gray-400">
                                    Data meja belum tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Pagination --}}
            <div class="py-2 border-t border-gray-100 justify-between gap-4">
                {{ $cafeTables->links() }}
            </div>
        </div>
    </main>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: 'Hapus Meja?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush


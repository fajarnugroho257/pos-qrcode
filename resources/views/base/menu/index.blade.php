@extends('layouts.app')
@section('content')
<div>
    <main class="max-w-7xl mx-auto py-8 px-4">
        <div class="bg-white p-8 md:p-10 rounded-2xl shadow-sm border border-gray-200 min-h-100">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                <div>
                    <h2 class="text-sm md:text-xl font-bold text-gray-800">{{ $title }}</h2>
                    <p class="text-xs md:text-sm text-gray-500">{{ $desc }}</p>
                </div>
                <div class="flex items-center gap-3 justify-between">
                    <form action="{{ route('menuApp') }}" method="GET">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari induk menu..." class="pl-10 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            <button type="submit" class="cursor-pointer w-4 h-4 absolute left-3 top-2.5 text-gray-400 fa fa-search"></button>
                        </div>
                    </form>
                    <a href="{{ route('menuAppAdd') }}" class="cursor-pointer bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md md:rounded-lg text-xs md:text-sm font-medium transition-colors flex items-center gap-2">
                        <i class="fa fa-plus"></i>
                        Tambah
                    </a>
                </div>
            </div>
            <hr class="my-4 text-gray-300">
            <div class="overflow-x-auto">
                @include('layouts.notification')
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-600 text-xs uppercase tracking-wider text-center">
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">ID</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Nama Menu</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Icon</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm md:text-base">
                        @foreach ($rs_menu as $menu)
                            @include('partials.menu-row', [
                                'menu' => $menu,
                                'level' => 0
                            ])
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="p-6 border-t border-gray-100 justify-between gap-4">
                {{-- {{ $rs_menu->links() }} --}}
            </div>
        </div>
    </main>
</div>
@endsection

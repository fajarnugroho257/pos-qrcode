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
                    <form action="{{ route('roleMenu') }}" method="get">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari role..." class="pl-10 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all">
                            <button type="submit" class="cursor-pointer w-4 h-4 absolute left-3 top-2.5 text-gray-400 fa fa-search"></button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="my-4 text-gray-300">
            <div class="overflow-x-auto">
                @include('layouts.notification')
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-600 text-xs uppercase tracking-wider text-center">
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">No</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Nama Role</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm md:text-base">
                        @foreach ($rs_role as $key => $role)
                            <tr class="hover:bg-gray-50/65 transition-colors">
                                <td class="px-6 py-4 text-center">{{ $rs_role->firstItem() + $key }}</td>
                                <td class="px-6 py-4 text-center">{{ $role->role_name }}</td>
                                <td class="px-6 py-4 flex justify-center">
                                    <a href="{{ route('listDataRoleMenu', ['role_id' => $role->role_id]) }}" class="text-gray-400 hover:text-indigo-600 p-1"><i class="fa fa-desktop"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="py-2 border-t border-gray-100 justify-between gap-4">
                {{ $rs_role->links() }}
            </div>
        </div>
    </main>
</div>
@endsection

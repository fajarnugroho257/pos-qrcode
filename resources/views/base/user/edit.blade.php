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
                <div class="flex items-center gap-3">
                    <a href="{{ route('dataUser') }}" class="cursor-pointer bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md md:rounded-lg text-xs md:text-sm font-medium transition-colors flex items-center gap-2">
                        <i class="fa fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>
            <hr class="my-4 text-gray-300">
            @include('layouts.notification')
            <form action="{{ route('dataUserEditProcess', $detail->user_id) }}" method="POST" >
                @method('POST')
                @csrf
                <div class="space-y-8 mb-4">
                    <div>
                        <div class="flex items-center gap-2 mb-6 text-indigo-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2"/></svg>
                            <h3 class="font-bold uppercase tracking-wider text-xs">Informasi Dasar</h3>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $detail->name) }}" placeholder="Nama Lengkap" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2 group">
                                    <label class="block text-sm font-semibold text-gray-700 group-focus-within:text-indigo-600 transition-colors">
                                        Role Pengguna
                                    </label>
                                    <div class="relative">
                                        <select id="role" name="role_id"
                                            class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 outline-none ring-offset-1 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer">
                                            <option value="">Pilih Role...</option>
                                            @foreach ($rs_role as $roles)
                                                <option @selected(old('role_id', $detail->role_id) == $roles->role_id) value="{{ $roles->role_id }}">{{ $roles->role_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-2 group">
                                    <label class="block text-sm font-semibold text-gray-700 group-focus-within:text-indigo-600 transition-colors">
                                        Status
                                    </label>
                                    <div class="relative">
                                        <select name="user_st" name="user_st"
                                            class="w-full appearance-none px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 outline-none ring-offset-1 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all cursor-pointer">
                                            <option value="">Pilih Status...</option>
                                            <option @selected(old('user_st', $detail->user_st) == 'yes') value="yes">Aktif</option>
                                            <option @selected(old('user_st', $detail->user_st) == 'no') value="no">Non Aktif</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Username</label>
                                <input type="text" name="username" value="{{ old('username', $detail->username) }}" placeholder="Username" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                            </div>
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Password</label>
                                <input type="password" name="password" placeholder="password" class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 px-8 py-6 flex items-center justify-end gap-3 border-t border-gray-100">
                    <button type="reset" class="px-6 py-2.5 text-sm font-semibold text-gray-600 hover:text-gray-800 transition-colors">
                        Reset
                    </button>
                    <button type="submit" class="px-8 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-md md:rounded-lg shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all active:scale-95">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </main>
</div>
@endsection

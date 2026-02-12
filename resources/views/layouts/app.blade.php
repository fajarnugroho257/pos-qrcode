<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Base App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css">
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
    <style>
        .sidebar-clip {
            clip-path: circle(0% at 100% 0%);
            transition: clip-path 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .sidebar-active {
            clip-path: circle(150% at 100% 0%);
        }
        /* Class pembantu untuk dropdown desktop */
        .show-dropdown {
            opacity: 1 !important;
            vertical-align: visible !important;
            visibility: visible !important;
            transform: scale(100%) !important;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-900">

    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-indigo-600 rounded-lg"></div>
                <span class="font-bold text-xl tracking-tight">Admin<span class="text-indigo-600">Pro</span></span>
            </div>

            @include('layouts.partials.navbar')

            <div class="hidden md:flex items-center gap-4">
                <div class="relative dropdown-root">
                    <button class="dropdown-toggle flex items-center gap-3 p-1 pr-3 hover:bg-gray-100 rounded-full transition-all cursor-pointer">
                        <div class="w-9 h-9 rounded-full bg-indigo-600 border-2 border-white shadow-sm flex items-center justify-center text-white font-bold text-xs">
                            AD
                        </div>
                        <div class="text-left hidden lg:block">
                            <p class="text-xs font-bold text-gray-800 line-clamp-1">{{ $pengguna }}</p>
                            <p class="text-[10px] text-gray-500 line-clamp-1">admin@portal.com</p>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>

                    <div class="dropdown-menu absolute right-0 mt-2 w-64 bg-white border border-gray-200 rounded-2xl shadow-xl opacity-0 invisible scale-95 transition-all duration-200 origin-top-right z-50">
                        <div class="p-4 border-b border-gray-50 bg-gray-50/50 rounded-t-2xl">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Akun Saya</p>
                            <div class="mt-2 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                                    AD
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ $pengguna }}</p>
                                    <p class="text-xs text-gray-500">Super User</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-2">
                            <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"/></svg>
                                Profil Saya
                            </a>
                            <a href="#" class="flex items-center gap-3 px-3 py-2 text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-width="2"/><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="2"/></svg>
                                Pengaturan Keamanan
                            </a>
                        </div>

                        <div class="p-2 border-t border-gray-50">
                            <form action="{{ route('logOut') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-colors font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    Keluar Sistem
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <button id="open-sidebar" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
            </button>
        </div>
    </header>

    <div id="overlay" class="fixed inset-0 bg-black/50 z-40 hidden opacity-0 transition-opacity duration-300"></div>

    <aside id="sidebar" wire:ignore class="fixed top-0 right-0 h-full w-[75%] bg-indigo-950 z-50 sidebar-clip md:hidden shadow-2xl flex flex-col">
        <div class="flex items-center justify-between p-5 border-b border-indigo-800/50">
            <span class="text-indigo-200 text-xs font-bold uppercase tracking-widest">Portal Navigasi</span>
            <button id="close-sidebar" class="p-2 text-indigo-300 hover:text-white transition-transform active:scale-90">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2"/></svg>
            </button>
        </div>

        <div class="p-6 bg-indigo-900/40 border-b border-indigo-800/50">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-600 flex items-center justify-center text-white font-bold text-lg shadow-lg border border-indigo-400/30">
                    {{ substr(Auth::user()->name ?? 'AD', 0, 2) }}
                </div>
                <div class="overflow-hidden">
                    <p class="text-white font-bold text-base truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                    <p class="text-indigo-300 text-xs truncate">{{ Auth::user()->email ?? 'admin@portal.com' }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 mt-5">
                <a href="#" class="flex items-center justify-center gap-2 py-2.5 bg-indigo-800/50 text-indigo-100 text-xs rounded-xl hover:bg-indigo-700 transition-colors border border-indigo-700/50">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"/></svg>
                    Profil
                </a>
                <a href="#" class="flex items-center justify-center gap-2 py-2.5 bg-indigo-800/50 text-indigo-100 text-xs rounded-xl hover:bg-indigo-700 transition-colors border border-indigo-700/50">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-width="2"/></svg>
                    Sandi
                </a>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto p-6 space-y-4 no-scrollbar">
            @isset($menus)
                @foreach($menus as $menu)
                    @include('layouts.partials.mobile_menu_item', ['menu' => $menu])
                @endforeach
            @endisset
        </nav>

        <div class="p-6 border-t border-indigo-800/50 bg-indigo-950/30">
            <form action="{{ route('logOut') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-3.5 bg-red-500/10 text-red-400 border border-red-500/20 rounded-2xl font-bold flex items-center justify-center gap-3 hover:bg-red-500 hover:text-white transition-all group">
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Keluar Aplikasi
                </button>
            </form>
        </div>
    </aside>

    @yield('content')
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    @vite('resources/js/app.js')
    @yield('javascript')
    @stack('scripts')
</body>
</html>

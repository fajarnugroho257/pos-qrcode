<nav class="hidden md:flex items-center space-x-1">
    @isset($menus)
        @foreach($menus as $menu)
            <div class="relative group dropdown-root">
                @if($menu->children->isEmpty())
                    <a href="{{ url($menu->menu_url) }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md flex items-center gap-2">
                        <i class="{{ $menu->menu_icon }}"></i> {{ $menu->menu_name }}
                    </a>
                @else
                    <button class="dropdown-toggle flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md cursor-pointer">
                        <i class="{{ $menu->menu_icon }}"></i> {{ $menu->menu_name }}
                        <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2"/></svg>
                    </button>
                    
                    <div class="dropdown-menu absolute left-0 mt-2 w-52 bg-white border border-gray-200 rounded-xl shadow-xl opacity-0 invisible scale-95 transition-all duration-200 z-50 group-hover:opacity-100 group-hover:visible group-hover:scale-100">
                        <div class="p-1">
                            @foreach($menu->children as $child)
                                @include('layouts.partials.menu_item', ['menu' => $child, 'level' => 2])
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endforeach
    @endisset
</nav>
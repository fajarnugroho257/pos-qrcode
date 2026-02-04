@if($menu->children->isEmpty())
    <a href="{{ route($menu->menu_url) }}" wire:navigate class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg">
        <i class="{{ $menu->menu_icon }} mr-2"></i> {{ $menu->menu_name }}
    </a>
@else
    <div class="relative group/sub dropdown-root">
        <button class="dropdown-toggle w-full flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 rounded-lg cursor-pointer">
            <span><i class="{{ $menu->menu_icon }} mr-2"></i> {{ $menu->menu_name }}</span>
            <svg class="w-4 h-4 -rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2"/></svg>
        </button>
        
        <div class="dropdown-menu absolute left-full top-0 ml-1 w-52 bg-white border border-gray-200 rounded-xl shadow-xl opacity-0 invisible scale-95 transition-all duration-200 group-hover/sub:opacity-100 group-hover/sub:visible group-hover/sub:scale-100">
            <div class="p-1">
                @foreach($menu->children as $child)
                    @include('layouts.partials.menu_item', ['menu' => $child])
                @endforeach
            </div>
        </div>
    </div>
@endif
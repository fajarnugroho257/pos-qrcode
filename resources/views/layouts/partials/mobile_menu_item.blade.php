@if($menu->children->isEmpty())
    <a href="{{ route($menu->menu_url) }}" class="block text-lg text-white opacity-90 hover:opacity-100">
        <i class="{{ $menu->menu_icon }} mr-2"></i> {{ $menu->menu_name }}
    </a>
@else
    <div class="space-y-2">
        <button class="mobile-collapse-trigger flex items-center justify-between w-full text-lg text-white font-medium">
            <span><i class="{{ $menu->menu_icon }} mr-2"></i> {{ $menu->menu_name }}</span>
            <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2"/></svg>
        </button>
        <div class="hidden pl-4 space-y-3 mt-2 border-l border-indigo-500/50">
            @foreach($menu->children as $child)
                @include('layouts.partials.mobile_menu_item', ['menu' => $child])
            @endforeach
        </div>
    </div>
@endif
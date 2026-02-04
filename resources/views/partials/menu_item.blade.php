@if($menu->children->isEmpty())
    <a class="dropdown-item" href="{{ $menu->menu_url ? url($menu->menu_url) : '#' }}">
        <i class="{{ $menu->menu_icon }} mr-2"></i> {{ $menu->menu_name }}
    </a>
@else
    <div class="dropdown-submenu">
        {{-- Tambahkan class dropdown-toggle di sini --}}
        <a class="dropdown-item dropdown-toggle" href="#">
            <i class="{{ $menu->menu_icon }} mr-2"></i> {{ $menu->menu_name }}
        </a>
        <div class="dropdown-menu">
            @foreach($menu->children as $child)
                @include('layouts.partials.menu_item', ['menu' => $child])
            @endforeach
        </div>
    </div>
@endif
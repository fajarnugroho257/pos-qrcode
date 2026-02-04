<tr class="hover:bg-gray-50/65 transition-colors">
    <td class="px-6 py-4 text-center">{{ $menu->menu_id }}</td>
    <td class="px-6 py-4">
        {!! str_repeat('&nbsp;&nbsp;&nbsp;', $level) !!}
        @if ($level > 0) └─ @endif
        {{ $menu->menu_name }}
    </td>
    <td class="px-6 py-4 text-center"><i class="{{ $menu->menu_icon }} text-gray-600"></i></td>
    <td class="px-6 py-4 flex justify-center">
        <a href="{{ route('menuAppEdit', ['menu_id' => $menu->menu_id]) }}" class="text-gray-400 hover:text-indigo-600 p-1"><i class="fas fa-pen-to-square"></i></a>
        <a href="{{ route('menuAppDeleteProcess', ['menu_id' => $menu->menu_id]) }}" onclick="return confirm('Apakah anda yakin akan menghapus data ini ?')" class="text-gray-400 hover:text-red-600 p-1"><i class="fas fa-trash-can"></i></a>
    </td>
</tr>

@if ($menu->children->count())
    @foreach ($menu->children as $child)
        @include('partials.menu-row', [
            'menu' => $child,
            'level' => $level + 1
        ])
    @endforeach
@endif

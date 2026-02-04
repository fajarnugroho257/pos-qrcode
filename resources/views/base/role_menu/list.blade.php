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
                <div class="flex items-center gap-3 justify-end">
                    <a href="{{ route('roleMenu') }}" class="cursor-pointer bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md md:rounded-lg text-xs md:text-sm font-medium transition-colors flex items-center gap-2">
                        <i class="fa fa-arrow-left"></i>
                        Kembali
                    </a>
                </div>
            </div>
            <hr class="my-4 text-gray-300">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 text-gray-600 text-xs uppercase tracking-wider text-center">
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">No</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Nama Menu</th>
                            <th class="px-6 py-4 font-semibold border-b border-gray-100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm md:text-base">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($rs_menu as $menu)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-500 text-center">{{ $no++ }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-600 font-medium">{{ $menu->menu_name }}</span>
                                </td>
                                <td class="px-6 py-4 text-center flex items-center">                                    
                                    <label class="mx-auto cursor-pointer group">
                                        <div class="relative flex items-center">
                                            <input type="checkbox" data-menu_id="{{ $menu->menu_id }}" @checked($menu->role_menu_id !== null) class="peer appearance-none w-5 h-5 border-2 border-gray-300 rounded-md checked:bg-indigo-600 checked:border-indigo-600 transition-all duration-200 cursor-pointer" />
                                            <svg class="absolute w-3.5 h-3.5 text-white opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity duration-200 left-0.5 top-0.5" 
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
@endsection
@section('javascript')
    <script>
        $(document).ready(function() {
            //
            $('input[type="checkbox"]').click(function() {
                var menu_id = $(this).data('menu_id');
                if ($(this).is(":checked")) {
                    var status = 'tambah';
                } else if ($(this).is(":not(:checked)")) {
                    var status = 'hapus';
                }
                let token = '{{ csrf_token() }}';
                $.ajax({
                    url: `{{ route('tambahRoleMenu') }}`,
                    type: "POST",
                    cache: false,
                    data: {
                        "role_id": `{{ $detail->role_id }}`,
                        "menu_id": menu_id,
                        "status": status,
                        "_token": token
                    },
                    success: function(response) {
                        $('#errors').html('');
                        alert(response.message);
                    },
                    error: function(error) {
                        var data_error = error.responseJSON.errors;
                        console.log(data_error);
                        var errorString = '';
                        var errorString = '<div class="alert alert-danger"> <ul>';
                        $.each(data_error, function(key, value) {
                            errorString += '<li>' + value + '</li>';
                        });
                        errorString += '</ul></div>';
                        $('#errors').html(errorString);
                    }

                });
            });
        });
    </script>
@endsection

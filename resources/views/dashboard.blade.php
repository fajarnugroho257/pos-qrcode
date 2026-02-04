@extends('layouts.app')
@section('content')
<div>
    <div id="overlay" class="fixed inset-0 bg-black/50 z-40 hidden opacity-0 transition-opacity duration-300"></div>
    <main class="max-w-7xl mx-auto py-8 px-4">
        <div class="bg-white p-10 rounded-2xl shadow-sm border border-gray-200 min-h-100">
            <h1 class="text-2xl font-bold">Portal Admin Aktif</h1>
            <p class="text-gray-500 mt-2">Dropdown kini mendukung <b>Hover</b> di Desktop dan <b>Klik/Collapse</b> di Mobile.</p>
        </div>
    </main>
</div>
@endsection

@if ($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex gap-3 animate-in fade-in slide-in-from-top-2 duration-300">
            <div class="shrink-0">
                <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-red-800">Terjadi kesalahan:</h3>
                <ul class="mt-1 ml-4 list-disc list-outside text-sm text-red-700 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    @session('success')
        <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-100 flex gap-3 animate-in fade-in slide-in-from-top-2 duration-300">
            <div class="shrink-0">
                <i class="fa-solid fa-check text-green-500 mt-0.5"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-green-800">Sukses:</h3>
                <ul class="mt-1 ml-4 list-disc list-outside text-sm text-green-700 space-y-1">
                    <li>{{ session('success') }}</li>
                </ul>
            </div>
        </div>
    @endsession
    @session('error')
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 flex gap-3 animate-in fade-in slide-in-from-top-2 duration-300">
            <div class="shrink-0">
                <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-red-800">Terjadi kesalahan:</h3>
                <ul class="mt-1 ml-4 list-disc list-outside text-sm text-red-700 space-y-1">
                    <li>{{ session('error') }}</li>
                </ul>
            </div>
        </div>
    @endsession
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-mesh min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-110">
        <div class="bg-white/80 backdrop-blur-xl rounded-3xl shadow-2xl border border-white p-8 md:p-10">
            
            <div class="flex flex-col items-center mb-8">
                <div class="w-14 h-14 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Selamat Datang</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola bisnis Anda dengan lebih mudah</p>
            </div>
            @include('layouts.notification')
            <form action="{{ route('loginProcess') }}" class="space-y-5" method="POST">
                @method('POST')
                @csrf
                <div>
                    <label for="username" class="block text-sm font-semibold text-slate-700 mb-1.5 ml-1">Username</label>
                    <input 
                        type="username" 
                        id="username" 
                        name="username"
                        required
                        placeholder="Username"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white/50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all duration-200 placeholder:text-slate-400"
                    >
                </div>
                <div>
                    <div class="flex justify-between items-center mb-1.5 ml-1">
                        <label for="password" class="text-sm font-semibold text-slate-700">Password</label>
                        <a href="#" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 transition-colors">Lupa Password?</a>
                    </div>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password"
                            required
                            placeholder="••••••••"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-white/50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition-all duration-200"
                        >
                    </div>
                </div>
                <div class="flex items-center space-x-2 ml-1">
                    <input 
                        type="checkbox" 
                        id="remember" 
                        class="w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer"
                    >
                    <label for="remember" class="text-sm text-slate-600 cursor-pointer select-none">Ingat perangkat ini</label>
                </div>
                <button 
                    type="submit" 
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3.5 rounded-xl shadow-lg shadow-indigo-100 transition-all duration-300 transform active:scale-[0.97] hover:shadow-indigo-200"
                >
                    Masuk ke Akun
                </button>
            </form>
            <p class="text-center mt-8 text-sm text-slate-500">
                Belum punya akun? 
                <a href="#" class="font-bold text-indigo-600 hover:text-indigo-700 underline underline-offset-4 decoration-2 decoration-indigo-100 hover:decoration-indigo-200 transition-all">Daftar sekarang</a>
            </p>
        </div>

        <p class="text-center mt-6 text-xs text-slate-400">
            &copy; 2026 Perusahaan Anda. Seluruh hak cipta dilindungi.
        </p>
    </div>
</body>
</html>

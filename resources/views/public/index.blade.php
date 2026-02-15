<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodie App Fixed Nav</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-200">

    <div class="mx-auto min-h-screen max-w-md bg-white shadow-2xl relative flex flex-col">
        
        <header class="sticky top-0 z-30 bg-white/95 backdrop-blur-md flex items-center justify-between px-6 py-4">
            <label for="menu-toggle" class="cursor-pointer">
                <i class="fa-solid fa-bars text-xl"></i>
            </label>
            <h1 class="text-lg font-bold">Home</h1>
            <div class="h-10 w-10 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold">US</div>
        </header>

        <main class="flex-1 px-6 pb-24 pt-4 overflow-y-auto">
            
            <div class="mb-6">
                <p class="text-gray-400 text-xs">Delivery To</p>
                <h2 class="font-bold flex items-center gap-1">Jakarta City <i class="fa-solid fa-chevron-down text-[10px] text-orange-500"></i></h2>
                <div class="mt-4 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search for food..." class="w-full rounded-2xl bg-gray-100 py-3 pl-12 pr-4 outline-none focus:ring-2 focus:ring-orange-200">
                </div>
            </div>

            <div class="mb-8">
                <h3 class="font-bold mb-4">Find By Category</h3>
                <div class="flex gap-4 overflow-x-auto pb-2 scrollbar-hide">
                    <div class="min-w-[80px] bg-orange-500 text-white p-4 rounded-2xl text-center shadow-lg shadow-orange-100">
                        <i class="fa-solid fa-leaf text-xl mb-1"></i>
                        <p class="text-[10px] font-bold">Salad</p>
                    </div>
                    </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-3xl p-2 shadow-sm border border-gray-50">
                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=300" class="w-full h-28 object-cover rounded-2xl mb-2">
                    <h4 class="text-xs font-bold truncate">Seafood Pasta</h4>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-orange-500 text-[10px] font-bold">⭐ 4.8</span>
                        <span class="text-xs font-bold">$12.00</span>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-2 shadow-sm border border-gray-50">
                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=300" class="w-full h-28 object-cover rounded-2xl mb-2">
                    <h4 class="text-xs font-bold truncate">Seafood Pasta</h4>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-orange-500 text-[10px] font-bold">⭐ 4.8</span>
                        <span class="text-xs font-bold">$12.00</span>
                    </div>
                </div>
                <div class="bg-white rounded-3xl p-2 shadow-sm border border-gray-50">
                    <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=300" class="w-full h-28 object-cover rounded-2xl mb-2">
                    <h4 class="text-xs font-bold truncate">Seafood Pasta</h4>
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-orange-500 text-[10px] font-bold">⭐ 4.8</span>
                        <span class="text-xs font-bold">$12.00</span>
                    </div>
                </div>
            </div>
        </main>

        <nav class="fixed bottom-0 z-40 w-full max-w-md bg-white/95 backdrop-blur-md px-10 py-5 flex justify-between border-t border-gray-100 rounded-t-[32px] shadow-[0_-5px_15px_rgba(0,0,0,0.05)]">
            <button class="text-orange-500 transition-transform active:scale-90">
                <i class="fa-solid fa-house text-xl"></i>
            </button>
            <button class="text-gray-300 hover:text-orange-400 transition-transform active:scale-90">
                <i class="fa-solid fa-cart-shopping text-xl"></i>
            </button>
            <button class="text-gray-300 hover:text-orange-400 transition-transform active:scale-90">
                <i class="fa-solid fa-magnifying-glass text-xl"></i>
            </button>
            <button class="text-gray-300 hover:text-orange-400 transition-transform active:scale-90">
                <i class="fa-solid fa-user text-xl"></i>
            </button>
        </nav>

    </div>

    <style>
        /* Menghilangkan scrollbar tapi tetap bisa di-scroll */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</body>
</html>
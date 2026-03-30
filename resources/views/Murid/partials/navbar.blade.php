<div class="sticky top-0 z-20 bg-white/90 backdrop-blur-md border-b border-gray-200/80 px-4 sm:px-6 py-2.5 flex items-center justify-between shadow-sm">
    <!-- Tombol toggle sudah dipindah ke pojok kiri bawah, jadi di sini tidak perlu -->
    
    <div class="flex-1"></div>

    <div class="flex items-center space-x-3 sm:space-x-4">
        <div class="flex items-center space-x-2 sm:space-x-3 bg-gray-50/80 rounded-full pl-3 pr-2 py-1.5 border border-gray-100">
            <span class="text-xs sm:text-sm font-semibold text-gray-700 hidden sm:inline-block">{{ Auth::user()->name }}</span>
            <div class="w-8 h-8 sm:w-9 sm:h-9 bg-gradient-to-r from-green-500 to-teal-600 rounded-full flex items-center justify-center text-white text-sm font-bold shadow-md ring-2 ring-white">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
        </div>
    </div>
</div>
<!-- Navbar baru - Opsi 1: Solid putih clean -->
<div class="sticky top-0 z-20 bg-white border-b border-gray-200 px-4 sm:px-6 py-2 flex items-center justify-between shadow-sm">
    <button id="sidebarToggle" class="md:hidden p-2 rounded-lg hover:bg-gray-100">
        <i class="fas fa-bars text-gray-600 text-xl"></i>
    </button>
    
    <!-- Search bar (desktop only) -->
    <div class="hidden md:block flex-1 max-w-md mx-auto lg:mx-0 lg:ml-4">
        <div class="relative">
            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" placeholder="Cari..." class="w-full border border-gray-200 rounded-lg py-2 pl-10 pr-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
        </div>
    </div>

    <div class="flex items-center space-x-3">
        <button class="p-2 rounded-lg hover:bg-gray-100 relative">
            <i class="fas fa-bell text-gray-600"></i>
            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
        </button>
        <div class="flex items-center space-x-2 pl-2 border-l border-gray-200">
            <span class="text-sm font-medium text-gray-700 hidden sm:block">Admin</span>
            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center text-white text-sm font-semibold">
                A
            </div>
        </div>
    </div>
</div>
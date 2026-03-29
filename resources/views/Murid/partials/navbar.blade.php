<div class="sticky top-0 z-20 bg-white border-b border-gray-200 px-4 sm:px-6 py-2 flex items-center justify-between shadow-sm">
    <button id="sidebarToggle" class="lg:hidden p-2 rounded-lg hover:bg-gray-100">
        <i class="fas fa-bars text-gray-600 text-xl"></i>
    </button>
    
    <div class="flex-1"></div>

    <div class="flex items-center space-x-3">
        <div class="flex items-center space-x-2 pl-2 border-l border-gray-200">
            <span class="text-sm font-medium text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
            <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-teal-600 rounded-lg flex items-center justify-center text-white text-sm font-semibold">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
        </div>
    </div>
</div>
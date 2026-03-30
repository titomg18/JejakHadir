<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 sm:w-72 h-screen bg-white shadow-2xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="flex flex-col h-full">
        <!-- Header -->
        <div class="flex items-center justify-between px-4 sm:px-5 py-5 sm:py-6 border-b border-gray-100">
            <div class="flex items-center space-x-2.5">
                <div class="bg-gradient-to-br from-green-600 to-teal-600 text-white p-2.5 rounded-xl shadow-lg">
                    <i class="fas fa-qrcode text-lg sm:text-xl"></i>
                </div>
                <span class="text-lg sm:text-xl font-black bg-gradient-to-r from-green-700 to-teal-700 bg-clip-text text-transparent">JejakHadir</span>
            </div>
            <button id="closeSidebar" class="lg:hidden text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Profile Info -->
        <div class="px-4 sm:px-5 py-4 sm:py-5 border-b border-gray-100">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg ring-2 ring-green-100">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-bold text-gray-800 text-sm sm:text-base">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                        <i class="fas fa-graduation-cap text-[10px]"></i> Murid
                    </p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-2 sm:px-3 py-4 sm:py-6 space-y-1 overflow-y-auto">
            <a href="{{ route('murid.dashboard') }}" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 text-gray-600 {{ request()->routeIs('murid.dashboard') ? 'bg-green-50 text-green-700 rounded-xl shadow-sm border-l-4 border-green-600' : 'hover:bg-green-50/70 hover:text-green-600 rounded-xl transition-all duration-200 group' }}">
                <i class="fas fa-tachometer-alt w-5 sm:w-6 {{ request()->routeIs('murid.dashboard') ? 'text-green-600' : 'group-hover:text-green-600' }}"></i>
                <span class="ml-3 text-sm sm:text-base font-medium">Dashboard</span>
            </a>
            <a href="{{ route('murid.scan') }}" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 text-gray-600 {{ request()->routeIs('murid.scan') ? 'bg-green-50 text-green-700 rounded-xl shadow-sm border-l-4 border-green-600' : 'hover:bg-green-50/70 hover:text-green-600 rounded-xl transition-all duration-200 group' }}">
                <i class="fas fa-qrcode w-5 sm:w-6 {{ request()->routeIs('murid.scan') ? 'text-green-600' : 'group-hover:text-green-600' }}"></i>
                <span class="ml-3 text-sm sm:text-base font-medium">Scan QR</span>
            </a>
            <a href="{{ route('murid.history') }}" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 text-gray-600 {{ request()->routeIs('murid.history') ? 'bg-green-50 text-green-700 rounded-xl shadow-sm border-l-4 border-green-600' : 'hover:bg-green-50/70 hover:text-green-600 rounded-xl transition-all duration-200 group' }}">
                <i class="fas fa-history w-5 sm:w-6 {{ request()->routeIs('murid.history') ? 'text-green-600' : 'group-hover:text-green-600' }}"></i>
                <span class="ml-3 text-sm sm:text-base font-medium">History Absensi</span>
            </a>
            <a href="{{ route('murid.profile') }}" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 text-gray-600 {{ request()->routeIs('murid.profile') ? 'bg-green-50 text-green-700 rounded-xl shadow-sm border-l-4 border-green-600' : 'hover:bg-green-50/70 hover:text-green-600 rounded-xl transition-all duration-200 group' }}">
                <i class="fas fa-user-circle w-5 sm:w-6 {{ request()->routeIs('murid.profile') ? 'text-green-600' : 'group-hover:text-green-600' }}"></i>
                <span class="ml-3 text-sm sm:text-base font-medium">Profile</span>
            </a>
        </nav>

        <!-- Logout -->
        <div class="px-2 sm:px-3 py-4 sm:py-5 border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-3 sm:px-4 py-2.5 sm:py-3 text-gray-500 hover:bg-red-50 hover:text-red-600 rounded-xl transition-all duration-200 group">
                    <i class="fas fa-sign-out-alt w-5 sm:w-6 group-hover:text-red-600"></i>
                    <span class="ml-3 text-sm sm:text-base font-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
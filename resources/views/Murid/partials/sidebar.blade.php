<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen bg-white shadow-xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="flex flex-col h-full">
        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-5 border-b border-gray-200">
            <div class="flex items-center space-x-2">
                <div class="bg-gradient-to-r from-green-600 to-teal-600 text-white p-2 rounded-xl">
                    <i class="fas fa-qrcode text-xl"></i>
                </div>
                <span class="text-xl font-bold bg-gradient-to-r from-green-700 to-teal-700 bg-clip-text text-transparent">JejakHadir</span>
            </div>
            <button id="closeSidebar" class="lg:hidden text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Profile Info -->
        <div class="px-4 py-4 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">Murid</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
            <a href="{{ route('murid.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 {{ request()->routeIs('murid.dashboard') ? 'bg-green-50 rounded-xl border-l-4 border-green-600' : 'hover:bg-green-50 hover:text-green-600 rounded-xl transition group' }}">
                <i class="fas fa-tachometer-alt w-6 {{ request()->routeIs('murid.dashboard') ? 'text-green-600' : 'group-hover:text-green-600' }}"></i>
                <span class="ml-3 font-medium">Dashboard</span>
            </a>
            <a href="{{ route('murid.scan') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-green-50 hover:text-green-600 rounded-xl transition group {{ request()->routeIs('murid.scan') ? 'bg-green-50 text-green-600 border-l-4 border-green-600' : '' }}">
                <i class="fas fa-qrcode w-6 group-hover:text-green-600"></i>
                <span class="ml-3 font-medium">Scan QR</span>
            </a>
            <a href="{{ route('murid.history') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-green-50 hover:text-green-600 rounded-xl transition group {{ request()->routeIs('murid.history') ? 'bg-green-50 text-green-600 border-l-4 border-green-600' : '' }}">
                <i class="fas fa-history w-6 group-hover:text-green-600"></i>
                <span class="ml-3 font-medium">History Absensi</span>
            </a>
            <a href="{{ route('murid.profile') }}" class="flex items-center px-4 py-3 text-gray-600 hover:bg-green-50 hover:text-green-600 rounded-xl transition group {{ request()->routeIs('murid.profile') ? 'bg-green-50 text-green-600 border-l-4 border-green-600' : '' }}">
                <i class="fas fa-user-circle w-6 group-hover:text-green-600"></i>
                <span class="ml-3 font-medium">Profile</span>
            </a>
        </nav>

        <!-- Logout -->
        <div class="px-2 py-4 border-t border-gray-200">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-xl transition group">
                    <i class="fas fa-sign-out-alt w-6 group-hover:text-red-600"></i>
                    <span class="ml-3 font-medium">Logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>
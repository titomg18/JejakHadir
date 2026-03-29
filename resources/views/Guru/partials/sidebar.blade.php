<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen bg-white shadow-xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <div class="flex flex-col h-full">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-between px-4 py-5 border-b border-gray-200">
            <div class="flex items-center space-x-2">
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white p-2 rounded-xl">
                    <i class="fas fa-qrcode text-xl"></i>
                </div>
                <span class="text-xl font-bold bg-gradient-to-r from-indigo-700 to-purple-700 bg-clip-text text-transparent">JejakHadir</span>
            </div>
            <button id="closeSidebar" class="lg:hidden text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <!-- Profile Info -->
        <div class="px-4 py-4 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold shadow-md">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">Guru</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
            <a href="{{ route('guru.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 {{ request()->routeIs('guru.dashboard') ? 'bg-indigo-50 rounded-xl border-l-4 border-indigo-600' : 'hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition group' }}">
                <i class="fas fa-tachometer-alt w-6 {{ request()->routeIs('guru.dashboard') ? 'text-indigo-600' : 'group-hover:text-indigo-600' }}"></i>
                <span class="ml-3 font-medium">Dashboard</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition group">
                <i class="fas fa-chalkboard-teacher w-6 group-hover:text-indigo-600"></i>
                <span class="ml-3 font-medium">Kelas</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition group">
                <i class="fas fa-clipboard-list w-6 group-hover:text-indigo-600"></i>
                <span class="ml-3 font-medium">Absensi</span>
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-xl transition group">
                <i class="fas fa-qrcode w-6 group-hover:text-indigo-600"></i>
                <span class="ml-3 font-medium">QR-Code</span>
            </a>
        </nav>

        <!-- Logout Button -->
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
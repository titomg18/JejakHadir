<aside class="sidebar fixed md:static inset-y-0 left-0 w-72 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out z-30 md:z-0 flex flex-col shadow-xl md:shadow-none">
    <!-- Logo area -->
    <div class="px-6 py-6">
        <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-gradient-to-tr from-blue-600 to-purple-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                <i class="fas fa-qrcode text-white text-lg"></i>
            </div>
            <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">JejakHadir</span>
        </div>
        <p class="text-xs text-gray-400 mt-1 ml-1">Admin panel v2.0</p>
    </div>

    <!-- Profile card -->
    <div class="mx-4 p-4 bg-white/40 rounded-2xl border border-white/60 mb-4">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-purple-100 rounded-2xl flex items-center justify-center text-blue-600 text-xl">
                <i class="fas fa-user-circle"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800">Admin Utama</p>
                <p class="text-xs text-gray-500">admin@jejakhadir.sch.id</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-4 space-y-1">
        <a href="{{ route('admin.dashboard') }}" class="menu-item flex items-center px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'active text-gray-700' : 'text-gray-600' }}">
            <i class="fas fa-chart-pie"></i>
            <span class="ml-3">Dashboard</span>
        </a>
        <a href="{{ route('admin.users') }}" class="menu-item flex items-center px-4 py-3 {{ request()->routeIs('admin.users*') ? 'active text-gray-700' : 'text-gray-600' }}">
            <i class="fas fa-users-cog"></i>
            <span class="ml-3">Kelola User</span>
        </a>
        <a href="#" class="menu-item flex items-center px-4 py-3 text-gray-600">
            <i class="fas fa-chalkboard"></i>
            <span class="ml-3">Kelola Kelas</span>
        </a>
        <a href="#" class="menu-item flex items-center px-4 py-3 text-gray-600">
            <i class="fas fa-chalkboard-teacher"></i>
            <span class="ml-3">Kelola Guru</span>
        </a>
        <a href="#" class="menu-item flex items-center px-4 py-3 text-gray-600">
            <i class="fas fa-user-graduate"></i>
            <span class="ml-3">Kelola Murid</span>
        </a>
        <div class="pt-6 mt-4 border-t border-white/50">
            <a href="#" class="menu-item flex items-center px-4 py-3 text-gray-600">
                <i class="fas fa-file-alt"></i>
                <span class="ml-3">Laporan</span>
            </a>
            <a href="#" class="menu-item flex items-center px-4 py-3 text-gray-600">
                <i class="fas fa-cog"></i>
                <span class="ml-3">Pengaturan</span>
            </a>
            <form method="POST" action="/logout" class="inline">
                @csrf
                <button type="submit" class="menu-item flex items-center px-4 py-3 text-red-500 hover:bg-red-50/50 w-full text-left">
                    <i class="fas fa-sign-out-alt text-red-400"></i>
                    <span class="ml-3">Keluar</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar footer -->
    <div class="p-5 text-xs text-gray-400 border-t border-white/50">
        <p>© 2025 JejakHadir</p>
        <p>v1.2.0</p>
    </div>
</aside>
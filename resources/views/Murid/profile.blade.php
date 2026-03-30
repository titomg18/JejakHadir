<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Saya | JejakHadir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .bg-gradient-custom {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        }
        .profile-card {
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- TOMBOL TOGGLE DI KIRI BAWAH -->
    <button id="sidebarToggle" class="lg:hidden fixed bottom-4 left-4 z-50 bg-gradient-to-r from-green-600 to-teal-600 text-white p-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 hidden lg:hidden"></div>

    @include('Murid.partials.sidebar')

    <main class="lg:ml-72 min-h-screen bg-gradient-custom p-5 md:p-7 lg:p-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-8 text-center">
                    <div class="w-24 h-24 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 ring-4 ring-white/50 shadow-lg">
                        <span class="text-white text-4xl font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                    <h2 class="text-2xl font-bold text-white">{{ Auth::user()->name }}</h2>
                    <p class="text-green-100 mt-1 flex items-center justify-center gap-1">
                        <i class="fas fa-graduation-cap text-sm"></i> Murid
                    </p>
                </div>

                <div class="p-6 md:p-8">
                    <dl class="divide-y divide-gray-100">
                        <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-sm font-semibold text-gray-500 flex items-center gap-1"><i class="fas fa-envelope w-4 text-green-500"></i> Email</dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2 font-medium">{{ Auth::user()->email }}</dd>
                        </div>
                        <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-sm font-semibold text-gray-500 flex items-center gap-1"><i class="fas fa-id-card w-4 text-green-500"></i> NIS</dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">{{ Auth::user()->murid->nis ?? '-' }}</dd>
                        </div>
                        <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-sm font-semibold text-gray-500 flex items-center gap-1"><i class="fas fa-id-card w-4 text-green-500"></i> NISN</dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">{{ Auth::user()->murid->nisn ?? '-' }}</dd>
                        </div>
                        <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-sm font-semibold text-gray-500 flex items-center gap-1"><i class="fas fa-calendar-alt w-4 text-green-500"></i> Tempat, Tgl Lahir</dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">{{ Auth::user()->murid->tempat_lahir ?? '-' }}, {{ Auth::user()->murid->tanggal_lahir ? \Carbon\Carbon::parse(Auth::user()->murid->tanggal_lahir)->format('d-m-Y') : '-' }}</dd>
                        </div>
                        <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-sm font-semibold text-gray-500 flex items-center gap-1"><i class="fas fa-venus-mars w-4 text-green-500"></i> Jenis Kelamin</dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">{{ Auth::user()->murid->jenis_kelamin == 'L' ? 'Laki-laki' : (Auth::user()->murid->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</dd>
                        </div>
                        <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-sm font-semibold text-gray-500 flex items-center gap-1"><i class="fas fa-map-marker-alt w-4 text-green-500"></i> Alamat</dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">{{ Auth::user()->murid->alamat ?? '-' }}</dd>
                        </div>
                        <div class="py-4 grid grid-cols-1 sm:grid-cols-3 gap-2">
                            <dt class="text-sm font-semibold text-gray-500 flex items-center gap-1"><i class="fas fa-phone-alt w-4 text-green-500"></i> No. Telp Orang Tua</dt>
                            <dd class="text-sm text-gray-900 sm:col-span-2">{{ Auth::user()->murid->no_telp_orang_tua ?? '-' }}</dd>
                        </div>
                    </dl>

                    <div class="mt-8 text-center text-xs text-gray-400 bg-gray-50 rounded-xl py-3 px-4">
                        <i class="fas fa-shield-alt mr-1 text-green-500"></i> Data diri hanya dapat diubah oleh admin.
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('closeSidebar');

        // Fungsi untuk menyembunyikan/menampilkan tombol toggle
        function updateToggleVisibility() {
            if (window.innerWidth >= 1024) {
                if (toggleBtn) toggleBtn.style.display = 'none';
            } else {
                const isSidebarClosed = sidebar.classList.contains('-translate-x-full');
                toggleBtn.style.display = isSidebarClosed ? 'flex' : 'none';
            }
        }

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            updateToggleVisibility();
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
            updateToggleVisibility();
        }

        toggleBtn?.addEventListener('click', openSidebar);
        closeBtn?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);
        
        if (window.innerWidth < 1024) {
            document.querySelectorAll('#sidebar nav a').forEach(link => {
                link.addEventListener('click', () => closeSidebar());
            });
        }
        
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            } else {
                sidebar.classList.add('-translate-x-full');
            }
            updateToggleVisibility();
        });
        
        if (window.innerWidth < 1024) sidebar.classList.add('-translate-x-full');
        updateToggleVisibility();
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Dashboard Murid | JejakHadir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .hover-lift {
            transition: all 0.25s ease;
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -12px rgba(0, 0, 0, 0.15);
        }
        .bg-gradient-custom {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- TOMBOL TOGGLE DI KIRI BAWAH -->
    <button id="sidebarToggle" class="lg:hidden fixed bottom-4 left-4 z-50 bg-gradient-to-r from-green-600 to-teal-600 text-white p-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 hidden lg:hidden transition-all duration-300"></div>

    @include('Murid.partials.sidebar')

    <main class="lg:ml-64 xl:ml-72 min-h-screen bg-gradient-custom p-4 sm:p-6 md:p-8">
        <!-- konten dashboard sama seperti sebelumnya -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-800 tracking-tight">📱 Dashboard</h2>
                    <p class="text-gray-500 mt-1 text-sm sm:text-base flex items-center gap-1 flex-wrap">
                        <i class="fas fa-smile-wink text-green-500"></i> Selamat datang kembali, 
                        <span class="font-semibold text-gray-700">{{ Auth::user()->name }}</span>
                    </p>
                </div>
                <div class="text-xs sm:text-sm text-gray-400 bg-white/60 backdrop-blur-sm px-3 sm:px-4 py-2 rounded-full inline-flex items-center gap-2 w-fit">
                    <i class="fas fa-calendar-alt text-green-500"></i>
                    <span>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6 md:gap-7 mb-8 sm:mb-10">
            <!-- Card Scan -->
            <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl hover-lift overflow-hidden border border-gray-100">
                <a href="{{ route('murid.scan') }}" class="block p-5 sm:p-6 text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-3 sm:mb-4 group-hover:bg-green-200 transition-all duration-200">
                        <i class="fas fa-qrcode text-green-600 text-2xl sm:text-3xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800">Scan QR Code</h3>
                    <p class="text-gray-500 mt-1 sm:mt-2 text-xs sm:text-sm">Lakukan absen dengan scan QR</p>
                </a>
            </div>
            <!-- Card History -->
            <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl hover-lift overflow-hidden border border-gray-100">
                <a href="{{ route('murid.history') }}" class="block p-5 sm:p-6 text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-3 sm:mb-4 group-hover:bg-blue-200 transition-all duration-200">
                        <i class="fas fa-history text-blue-600 text-2xl sm:text-3xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800">History Absensi</h3>
                    <p class="text-gray-500 mt-1 sm:mt-2 text-xs sm:text-sm">Lihat riwayat kehadiran</p>
                </a>
            </div>
            <!-- Card Profile -->
            <div class="group bg-white rounded-2xl shadow-md hover:shadow-xl hover-lift overflow-hidden border border-gray-100">
                <a href="{{ route('murid.profile') }}" class="block p-5 sm:p-6 text-center">
                    <div class="w-16 h-16 sm:w-20 sm:h-20 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-3 sm:mb-4 group-hover:bg-purple-200 transition-all duration-200">
                        <i class="fas fa-user-circle text-purple-600 text-2xl sm:text-3xl"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-bold text-gray-800">Profile Saya</h3>
                    <p class="text-gray-500 mt-1 sm:mt-2 text-xs sm:text-sm">Lihat informasi diri</p>
                </a>
            </div>
        </div>

        <div class="bg-white/90 backdrop-blur-sm rounded-2xl shadow-md p-5 sm:p-6 border border-green-100">
            <h3 class="font-bold text-gray-800 flex items-center text-base sm:text-lg"><i class="fas fa-info-circle text-green-500 mr-2"></i> Informasi Sistem</h3>
            <ul class="mt-3 sm:mt-4 space-y-2 text-xs sm:text-sm text-gray-600">
                <li class="flex items-center gap-2"><span class="w-2 h-2 bg-green-500 rounded-full"></span> Absen hanya bisa dilakukan 1x per hari.</li>
                <li class="flex items-center gap-2"><span class="w-2 h-2 bg-green-500 rounded-full"></span> QR code berubah setiap 5 detik untuk keamanan.</li>
                <li class="flex items-center gap-2"><span class="w-2 h-2 bg-green-500 rounded-full"></span> History absensi bisa dilihat kapan saja.</li>
            </ul>
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('closeSidebar');

        function updateToggleVisibility() {
            if (window.innerWidth >= 1024) {
                // Di desktop, sidebar selalu terbuka, tombol tidak perlu
                if (toggleBtn) toggleBtn.style.display = 'none';
            } else {
                // Di mobile: tampilkan tombol hanya jika sidebar tertutup
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

        if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);
        
        // Saat link di sidebar diklik di mobile, tutup sidebar
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
        
        // Inisialisasi awal
        if (window.innerWidth < 1024) sidebar.classList.add('-translate-x-full');
        updateToggleVisibility();
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Murid | JejakHadir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <button id="sidebarToggle" class="lg:hidden fixed top-4 left-4 z-50 bg-green-600 text-white p-3 rounded-lg shadow-lg">
        <i class="fas fa-bars text-xl"></i>
    </button>
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

    @include('Murid.partials.sidebar')

    <main class="lg:ml-64 min-h-screen bg-gradient-to-br from-green-50 via-white to-teal-50 p-4 md:p-6 lg:p-8">
        <div class="mb-8">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800">📱 Dashboard Murid</h2>
            <p class="text-gray-600 mt-1">Selamat datang, {{ Auth::user()->name }}!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Card Scan -->
            <div class="bg-white rounded-2xl shadow-md hover-lift">
                <a href="{{ route('murid.scan') }}" class="block p-6 text-center">
                    <div class="w-20 h-20 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-qrcode text-green-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Scan QR Code</h3>
                    <p class="text-gray-500 mt-2">Lakukan absen dengan scan QR</p>
                </a>
            </div>
            <!-- Card History -->
            <div class="bg-white rounded-2xl shadow-md hover-lift">
                <a href="{{ route('murid.history') }}" class="block p-6 text-center">
                    <div class="w-20 h-20 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-history text-blue-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">History Absensi</h3>
                    <p class="text-gray-500 mt-2">Lihat riwayat kehadiran</p>
                </a>
            </div>
            <!-- Card Profile -->
            <div class="bg-white rounded-2xl shadow-md hover-lift">
                <a href="{{ route('murid.profile') }}" class="block p-6 text-center">
                    <div class="w-20 h-20 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-user-circle text-purple-600 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800">Profile Saya</h3>
                    <p class="text-gray-500 mt-2">Lihat informasi diri</p>
                </a>
            </div>
        </div>

        <!-- Informasi singkat -->
        <div class="bg-white rounded-2xl shadow-md p-6">
            <h3 class="font-bold text-gray-800 flex items-center"><i class="fas fa-info-circle text-green-500 mr-2"></i> Informasi</h3>
            <ul class="mt-3 space-y-2 text-sm text-gray-600">
                <li>✅ Absen hanya bisa dilakukan 1x per hari.</li>
                <li>🔄 QR code berubah setiap 5 detik untuk keamanan.</li>
                <li>📊 History absensi bisa dilihat kapan saja.</li>
            </ul>
        </div>
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('closeSidebar');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.style.overflow = '';
        }
        toggleBtn?.addEventListener('click', openSidebar);
        closeBtn?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
        if (window.innerWidth < 1024) sidebar.classList.add('-translate-x-full');
    </script>
</body>
</html>
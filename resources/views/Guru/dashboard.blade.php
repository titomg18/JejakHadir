<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Guru Dashboard - JejakHadir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .sidebar-transition {
            transition: transform 0.3s ease-in-out;
        }
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

    <!-- TOMBOL TOGGLE DI KIRI BAWAH -->
    <button id="sidebarToggle" class="lg:hidden fixed bottom-4 left-4 z-50 bg-indigo-600 text-white p-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 hidden lg:hidden transition-opacity"></div>

    @include('Guru.partials.sidebar')

    <main class="lg:ml-64 min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 p-4 md:p-6 lg:p-8">
        <!-- Header Welcome -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800">📋 Dashboard Guru</h2>
                <p class="text-gray-600 mt-1 text-lg">Kelola kelas, murid, dan pantau kehadiran dengan mudah.</p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center space-x-3">
                <span class="bg-white px-4 py-2 rounded-full text-sm shadow-sm border border-gray-100">
                    <i class="far fa-calendar-alt text-indigo-500 mr-2"></i>{{ now()->format('l, d F Y') }}
                </span>
            </div>
        </div>

        <!-- Statistik Cards (konten asli, tidak diubah) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Total Kelas -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 hover-lift overflow-hidden relative">
                <div class="absolute top-0 right-0 w-20 h-20 bg-indigo-50 rounded-bl-full"></div>
                <div class="p-6 relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Kelas</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">6</p>
                        </div>
                        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 text-white p-4 rounded-2xl shadow-lg">
                            <i class="fas fa-chalkboard-teacher text-2xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-green-600 mt-4"><i class="fas fa-arrow-up mr-1"></i>+2 dari bulan lalu</p>
                </div>
            </div>
            <!-- Total Murid -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 hover-lift overflow-hidden relative">
                <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-bl-full"></div>
                <div class="p-6 relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Murid</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">142</p>
                        </div>
                        <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-4 rounded-2xl shadow-lg">
                            <i class="fas fa-user-graduate text-2xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-green-600 mt-4"><i class="fas fa-arrow-up mr-1"></i>+5 dari bulan lalu</p>
                </div>
            </div>
            <!-- Hadir Hari Ini -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 hover-lift overflow-hidden relative">
                <div class="absolute top-0 right-0 w-20 h-20 bg-yellow-50 rounded-bl-full"></div>
                <div class="p-6 relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Hadir Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">98</p>
                        </div>
                        <div class="bg-gradient-to-br from-yellow-500 to-orange-500 text-white p-4 rounded-2xl shadow-lg">
                            <i class="fas fa-calendar-check text-2xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-yellow-600 mt-4"><i class="fas fa-clock mr-1"></i>78% kehadiran</p>
                </div>
            </div>
            <!-- QR Aktif -->
            <div class="bg-white rounded-2xl shadow-md border border-gray-100 hover-lift overflow-hidden relative">
                <div class="absolute top-0 right-0 w-20 h-20 bg-purple-50 rounded-bl-full"></div>
                <div class="p-6 relative">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">QR Code Aktif</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">3</p>
                        </div>
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white p-4 rounded-2xl shadow-lg">
                            <i class="fas fa-qrcode text-2xl"></i>
                        </div>
                    </div>
                    <p class="text-xs text-purple-600 mt-4"><i class="fas fa-sync-alt mr-1"></i>Bisa generate baru</p>
                </div>
            </div>
        </div>

        <!-- Fitur Utama Cards (konten asli) -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold text-gray-800 inline-block border-b-4 border-indigo-500 pb-2 pr-6">✨ Fitur Utama</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <a href="{{ route('guru.kelas') }}" class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
                <div class="p-6 text-center">
                    <div class="w-20 h-20 bg-indigo-100 group-hover:bg-indigo-200 rounded-2xl flex items-center justify-center mx-auto mb-4 transition-colors duration-300">
                        <i class="fas fa-chalkboard-teacher text-indigo-600 group-hover:text-indigo-700 text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">Kelas</h4>
                    <p class="text-sm text-gray-500 mt-2">Atur dan kelola data kelas</p>
                </div>
                <div class="bg-indigo-50 py-2 text-center text-indigo-600 text-sm font-medium group-hover:bg-indigo-100 transition">
                    Kelola sekarang <i class="fas fa-arrow-right ml-1"></i>
                </div>
            </a>
            <a href="#" class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
                <div class="p-6 text-center">
                    <div class="w-20 h-20 bg-green-100 group-hover:bg-green-200 rounded-2xl flex items-center justify-center mx-auto mb-4 transition-colors duration-300">
                        <i class="fas fa-user-graduate text-green-600 group-hover:text-green-700 text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 group-hover:text-green-600 transition-colors">Murid</h4>
                    <p class="text-sm text-gray-500 mt-2">Daftar murid dan detailnya</p>
                </div>
                <div class="bg-green-50 py-2 text-center text-green-600 text-sm font-medium group-hover:bg-green-100 transition">
                    Lihat semua <i class="fas fa-arrow-right ml-1"></i>
                </div>
            </a>
            <a href="{{ route('guru.absensi') }}" class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
                <div class="p-6 text-center">
                    <div class="w-20 h-20 bg-yellow-100 group-hover:bg-yellow-200 rounded-2xl flex items-center justify-center mx-auto mb-4 transition-colors duration-300">
                        <i class="fas fa-clipboard-list text-yellow-600 group-hover:text-yellow-700 text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 group-hover:text-yellow-600 transition-colors">Absensi</h4>
                    <p class="text-sm text-gray-500 mt-2">Rekap kehadiran harian</p>
                </div>
                <div class="bg-yellow-50 py-2 text-center text-yellow-600 text-sm font-medium group-hover:bg-yellow-100 transition">
                    Lihat rekap <i class="fas fa-arrow-right ml-1"></i>
                </div>
            </a>
            <a href="{{ route('guru.qrcode') }}" class="group bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">
                <div class="p-6 text-center">
                    <div class="w-20 h-20 bg-purple-100 group-hover:bg-purple-200 rounded-2xl flex items-center justify-center mx-auto mb-4 transition-colors duration-300">
                        <i class="fas fa-qrcode text-purple-600 group-hover:text-purple-700 text-3xl"></i>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 group-hover:text-purple-600 transition-colors">QR-Code</h4>
                    <p class="text-sm text-gray-500 mt-2">Generate & scan QR presensi</p>
                </div>
                <div class="bg-purple-50 py-2 text-center text-purple-600 text-sm font-medium group-hover:bg-purple-100 transition">
                    Kelola QR <i class="fas fa-arrow-right ml-1"></i>
                </div>
            </a>
        </div>

        <!-- Dua Kolom: Aktivitas & Info (konten asli) -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800 flex items-center"><i class="fas fa-history text-indigo-500 mr-2"></i> Aktivitas Presensi Terkini</h3>
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat semua <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Murid</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kelas</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th><th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th></tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <tr class="hover:bg-gray-50"><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Ahmad Fauzi</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">XII IPA 1</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">07:45</td><td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Hadir</span></td></tr>
                            <tr class="hover:bg-gray-50"><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Siti Nurhaliza</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">XII IPA 2</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">07:50</td><td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Hadir</span></td></tr>
                            <tr class="hover:bg-gray-50"><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Budi Santoso</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">XII IPA 1</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">07:55</td><td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-100 text-green-800">Hadir</span></td></tr>
                            <tr class="hover:bg-gray-50"><td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Dewi Lestari</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">XII IPA 2</td><td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">08:10</td><td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Terlambat</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl border border-green-200 p-6 shadow-md">
                    <div class="flex items-start space-x-4"><div class="bg-green-500 text-white p-3 rounded-xl shadow-lg"><i class="fab fa-whatsapp text-2xl"></i></div><div><h4 class="font-bold text-gray-800">Notifikasi WhatsApp</h4><p class="text-sm text-gray-600 mt-1">Setiap presensi akan langsung dilaporkan kepada orang tua via WhatsApp.</p><span class="inline-block mt-3 text-xs bg-green-200 text-green-800 px-3 py-1 rounded-full">Aktif</span></div></div>
                </div>
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                    <h4 class="font-bold text-gray-800 flex items-center"><i class="fas fa-chart-line text-indigo-500 mr-2"></i> Kehadiran Minggu Ini</h4>
                    <div class="mt-4 h-32 flex items-end space-x-2"><div class="w-1/6 bg-indigo-200 rounded-t-lg h-16 flex flex-col justify-end items-center text-xs">Sen</div><div class="w-1/6 bg-indigo-300 rounded-t-lg h-20 flex flex-col justify-end items-center text-xs">Sel</div><div class="w-1/6 bg-indigo-400 rounded-t-lg h-24 flex flex-col justify-end items-center text-xs">Rab</div><div class="w-1/6 bg-indigo-300 rounded-t-lg h-20 flex flex-col justify-end items-center text-xs">Kam</div><div class="w-1/6 bg-indigo-200 rounded-t-lg h-14 flex flex-col justify-end items-center text-xs">Jum</div><div class="w-1/6 bg-indigo-100 rounded-t-lg h-8 flex flex-col justify-end items-center text-xs">Sab</div></div>
                    <p class="text-xs text-gray-500 mt-2 text-center">Rata-rata 85% kehadiran</p>
                </div>
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                    <h4 class="font-bold text-gray-800 flex items-center"><i class="fas fa-clock text-indigo-500 mr-2"></i> Jadwal Hari Ini</h4>
                    <ul class="mt-3 space-y-2 text-sm"><li class="flex justify-between"><span>📘 Matematika</span><span class="text-gray-500">07:30 - 09:00</span></li><li class="flex justify-between"><span>📗 Fisika</span><span class="text-gray-500">09:15 - 10:45</span></li><li class="flex justify-between"><span>📙 Kimia</span><span class="text-gray-500">11:00 - 12:30</span></li></ul>
                </div>
            </div>
        </div>

        @include('Guru.partials.footer')
    </main>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('closeSidebar');

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

        if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);

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
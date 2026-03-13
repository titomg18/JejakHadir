<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | JejakHadir</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        body {
            background: #f9fafc;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.6);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.05);
        }
        .stat-card {
            transition: all 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 30px -10px rgba(59, 130, 246, 0.15);
        }
        .sidebar {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.7);
        }
        .menu-item {
            transition: all 0.2s;
            border-radius: 12px;
            margin: 4px 0;
        }
        .menu-item:hover {
            background: rgba(59, 130, 246, 0.08);
            color: #1e40af;
        }
        .menu-item.active {
            background: linear-gradient(90deg, rgba(59,130,246,0.12) 0%, rgba(139,92,246,0.12) 100%);
            color: #2563eb;
            font-weight: 500;
            border-left: 4px solid #3b82f6;
        }
        .menu-item i {
            width: 24px;
            color: #6b7280;
        }
        .menu-item.active i {
            color: #3b82f6;
        }
        .progress-bar {
            height: 6px;
            background: #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }
        .progress-fill {
            height: 6px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            border-radius: 10px;
            width: 0%;
        }
        .table-row-hover:hover {
            background: rgba(59, 130, 246, 0.04);
        }
    </style>
</head>
<body class="antialiased">

    <div class="flex h-screen overflow-hidden bg-[#f9fafc]">
        <!-- Sidebar -->
        @include('Admin.partials.sidebar')

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Navbar -->
            @include('Admin.partials.navbar')

            <!-- Dashboard content dengan dummy data -->
            <div class="p-6 md:p-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                    <p class="text-gray-500 mt-1">Kelola presensi pintar dengan mudah.</p>
                </div>

                <!-- Statistik cards dengan progress bar (dummy) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total User</p>
                                <p class="text-3xl font-bold text-gray-800 mt-1">245</p>
                                <span class="inline-flex items-center text-xs text-green-600 bg-green-50 px-2 py-0.5 rounded-full mt-2">
                                    <i class="fas fa-arrow-up mr-1 text-xs"></i> +12
                                </span>
                            </div>
                            <div class="w-12 h-12 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                        </div>
                        <div class="progress-bar mt-4">
                            <div class="progress-fill" style="width: 75%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">75% kapasitas</p>
                    </div>

                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Kelas</p>
                                <p class="text-3xl font-bold text-gray-800 mt-1">12</p>
                                <span class="inline-flex items-center text-xs text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full mt-2">
                                    <i class="fas fa-check-circle mr-1 text-xs"></i> Aktif
                                </span>
                            </div>
                            <div class="w-12 h-12 bg-purple-50 rounded-2xl flex items-center justify-center text-purple-500">
                                <i class="fas fa-chalkboard-teacher text-xl"></i>
                            </div>
                        </div>
                        <div class="progress-bar mt-4">
                            <div class="progress-fill" style="width: 100%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">12 kelas aktif</p>
                    </div>

                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Guru</p>
                                <p class="text-3xl font-bold text-gray-800 mt-1">28</p>
                                <span class="inline-flex items-center text-xs text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full mt-2">
                                    <i class="fas fa-user-plus mr-1 text-xs"></i> +2
                                </span>
                            </div>
                            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500">
                                <i class="fas fa-user-tie text-xl"></i>
                            </div>
                        </div>
                        <div class="progress-bar mt-4">
                            <div class="progress-fill" style="width: 60%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">60% dari target</p>
                    </div>

                    <div class="glass-card rounded-2xl p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total Murid</p>
                                <p class="text-3xl font-bold text-gray-800 mt-1">312</p>
                                <span class="inline-flex items-center text-xs text-green-600 bg-green-50 px-2 py-0.5 rounded-full mt-2">
                                    <i class="fas fa-arrow-up mr-1 text-xs"></i> 90% hadir
                                </span>
                            </div>
                            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500">
                                <i class="fas fa-user-graduate text-xl"></i>
                            </div>
                        </div>
                        <div class="progress-bar mt-4">
                            <div class="progress-fill" style="width: 90%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Hari ini 90% hadir</p>
                    </div>
                </div>

                <!-- Fitur utama dengan desain lebih menarik (dummy) -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <div class="glass-card rounded-2xl p-6 flex items-start space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-cyan-400 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                            <i class="fas fa-qrcode text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Presensi QR Code</h3>
                            <p class="text-sm text-gray-500 mt-1 leading-relaxed">Murid scan QR, data langsung tercatat. Cepat dan anti-rekayasa.</p>
                            <div class="mt-3 flex items-center space-x-2">
                                <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full">Aktif</span>
                                <span class="text-xs text-gray-400">123 scan hari ini</span>
                            </div>
                        </div>
                    </div>

                    <div class="glass-card rounded-2xl p-6 flex items-start space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-400 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-green-200">
                            <i class="fab fa-whatsapp text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Notifikasi WhatsApp</h3>
                            <p class="text-sm text-gray-500 mt-1 leading-relaxed">Orang tua mendapat notifikasi otomatis saat anak hadir.</p>
                            <div class="mt-3 flex items-center space-x-2">
                                <span class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-full">Terintegrasi</span>
                                <span class="text-xs text-gray-400">98% sukses terkirim</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick access cards (dummy) -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Akses Cepat</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="#" class="glass-card p-5 rounded-xl flex flex-col items-center text-center hover:scale-105 transition-transform duration-200">
                            <div class="w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500 mb-3 text-2xl">
                                <i class="fas fa-users-cog"></i>
                            </div>
                            <span class="font-medium text-gray-800 text-sm">User</span>
                        </a>
                        <a href="#" class="glass-card p-5 rounded-xl flex flex-col items-center text-center hover:scale-105 transition">
                            <div class="w-14 h-14 bg-purple-50 rounded-xl flex items-center justify-center text-purple-500 mb-3 text-2xl">
                                <i class="fas fa-chalkboard"></i>
                            </div>
                            <span class="font-medium text-gray-800 text-sm">Kelas</span>
                        </a>
                        <a href="#" class="glass-card p-5 rounded-xl flex flex-col items-center text-center hover:scale-105 transition">
                            <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 mb-3 text-2xl">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <span class="font-medium text-gray-800 text-sm">Guru</span>
                        </a>
                        <a href="#" class="glass-card p-5 rounded-xl flex flex-col items-center text-center hover:scale-105 transition">
                            <div class="w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500 mb-3 text-2xl">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <span class="font-medium text-gray-800 text-sm">Murid</span>
                        </a>
                    </div>
                </div>

                <!-- Tabel absensi dengan desain modern (dummy) -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">Absensi Hari Ini</h2>
                        <a href="#" class="text-sm text-blue-600 hover:underline flex items-center">
                            Lihat semua <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                    <!-- Tambahkan overflow-x-auto untuk tabel agar bisa di-scroll horizontal di layar kecil -->
                    <div class="glass-card rounded-2xl overflow-hidden overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-white/30 bg-white/40">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/30">
                                <tr class="table-row-hover">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Andi Saputra</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">XII IPA 1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">07:15</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">Hadir</span></td>
                                </tr>
                                <tr class="table-row-hover">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Budi Santoso</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">XII IPA 1</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">07:22</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">Hadir</span></td>
                                </tr>
                                <tr class="table-row-hover">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Citra Lestari</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">XI IPS 2</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">07:05</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">Hadir</span></td>
                                </tr>
                                <tr class="table-row-hover">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Dewi Putri</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">XI IPS 2</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">07:30</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-medium">Terlambat</span></td>
                                </tr>
                                <tr class="table-row-hover">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800">Eko Prasetyo</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">X IPA 3</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">06:55</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">Hadir</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 bg-white/30 text-sm text-gray-500 border-t border-white/30 rounded-b-2xl">
                        Menampilkan 5 dari 48 presensi
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Backdrop & sidebar toggle script -->
    <script>
        const sidebar = document.querySelector('aside');
        const toggleBtn = document.getElementById('sidebarToggle');
        const backdrop = document.createElement('div');
        backdrop.className = 'fixed inset-0 bg-black/20 backdrop-blur-sm z-20 hidden md:hidden transition-opacity';
        document.body.appendChild(backdrop);

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
            document.body.style.overflow = '';
        }

        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (sidebar.classList.contains('-translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        });

        backdrop.addEventListener('click', closeSidebar);

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.add('hidden');
                document.body.style.overflow = '';
            }
        });
    </script>
</body>
</html>
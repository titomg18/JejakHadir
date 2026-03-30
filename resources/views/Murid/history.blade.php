<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Absensi | JejakHadir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .bg-gradient-custom {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        }
        .table-row-hover:hover {
            background-color: #f9fafb;
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
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-history text-green-600"></i> History Absensi
                </h2>
                <p class="text-gray-500 text-sm mt-1">Riwayat kehadiran Anda sebagai murid</p>
            </div>

            <div class="overflow-x-auto p-1">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($histories as $history)
                        <tr class="table-row-hover transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <i class="far fa-calendar-alt text-gray-400 mr-2"></i>
                                {{ \Carbon\Carbon::parse($history->tanggal)->format('d-m-Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <i class="far fa-clock text-gray-400 mr-2"></i>
                                {{ $history->waktu_absen ? \Carbon\Carbon::parse($history->waktu_absen)->format('H:i:s') : '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm 
                                    @if($history->status == 'hadir') bg-green-100 text-green-800 ring-1 ring-green-200
                                    @elseif($history->status == 'izin') bg-yellow-100 text-yellow-800 ring-1 ring-yellow-200
                                    @elseif($history->status == 'sakit') bg-blue-100 text-blue-800 ring-1 ring-blue-200
                                    @else bg-red-100 text-red-800 ring-1 ring-red-200 @endif">
                                    <i class="fas 
                                        @if($history->status == 'hadir') fa-check-circle mr-1
                                        @elseif($history->status == 'izin') fa-calendar-check mr-1
                                        @elseif($history->status == 'sakit') fa-thermometer-half mr-1
                                        @else fa-times-circle mr-1 @endif"></i>
                                    {{ ucfirst($history->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-3 block"></i>
                                <span class="text-sm">Belum ada riwayat absensi.</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
                // Di desktop, tombol tidak perlu
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

        toggleBtn?.addEventListener('click', openSidebar);
        closeBtn?.addEventListener('click', closeSidebar);
        overlay?.addEventListener('click', closeSidebar);
        
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
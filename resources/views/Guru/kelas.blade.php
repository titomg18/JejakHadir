<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelas Saya | JejakHadir</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .table-row-hover:hover {
            background-color: #f9fafb;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <!-- Sidebar Toggle Button (Mobile) -->
    <button id="sidebarToggle" class="lg:hidden fixed top-4 left-4 z-50 bg-indigo-600 text-white p-3 rounded-lg shadow-lg focus:outline-none">
        <i class="fas fa-bars text-xl"></i>
    </button>

    <!-- Overlay for mobile sidebar -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden transition-opacity"></div>

    <!-- Sidebar -->
    @include('Guru.partials.sidebar')

    <!-- Main Content -->
    <main class="lg:ml-64 min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 p-4 md:p-6 lg:p-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800">📚 Kelas Saya</h2>
                <p class="text-gray-600 mt-1 text-lg">Daftar kelas yang Anda ajar sebagai wali kelas beserta murid-muridnya.</p>
            </div>
        </div>

        @if($kelas->isEmpty())
            <div class="bg-white rounded-2xl shadow-md p-8 text-center">
                <i class="fas fa-chalkboard-teacher text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Anda belum ditugaskan sebagai wali kelas.</p>
            </div>
        @else
            @foreach($kelas as $k)
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 mb-8 overflow-hidden">
                    <!-- Header Kelas -->
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $k->nama_kelas }}</h3>
                                @if($k->deskripsi)
                                    <p class="text-gray-600 mt-1">{{ $k->deskripsi }}</p>
                                @endif
                            </div>
                            <div class="bg-white rounded-full px-4 py-2 shadow-sm">
                                <span class="text-sm text-gray-600"><i class="fas fa-users mr-1"></i> {{ $k->murids->count() }} Murid</span>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Murid -->
                    <div class="p-6">
                        @if($k->murids->isEmpty())
                            <p class="text-gray-500 text-center py-4">Belum ada murid di kelas ini.</p>
                        @else
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Murid</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS/NISN</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach($k->murids as $index => $murid)
                                            <tr class="table-row-hover">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $murid->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $murid->email }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $murid->nis ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @endif

        <!-- Footer -->
        @include('Guru.partials.footer')
    </main>

    <!-- JavaScript untuk toggle sidebar (sama seperti dashboard) -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggle');
        const closeBtn = document.getElementById('closeSidebar');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        }

        toggleBtn.addEventListener('click', openSidebar);
        closeBtn.addEventListener('click', closeSidebar);
        overlay.addEventListener('click', closeSidebar);

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });

        if (window.innerWidth < 1024) {
            sidebar.classList.add('-translate-x-full');
        }
    </script>
</body>
</html>
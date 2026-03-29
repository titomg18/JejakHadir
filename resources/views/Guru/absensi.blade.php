<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Kelas | JejakHadir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .status-badge {
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-hadir { background: #d1fae5; color: #065f46; }
        .status-izin { background: #fed7aa; color: #92400e; }
        .status-sakit { background: #bfdbfe; color: #1e3a8a; }
        .status-alpha { background: #fee2e2; color: #991b1b; }
        .status-belum { background: #f3f4f6; color: #4b5563; }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <button id="sidebarToggle" class="lg:hidden fixed top-4 left-4 z-50 bg-indigo-600 text-white p-3 rounded-lg shadow-lg">
        <i class="fas fa-bars text-xl"></i>
    </button>
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

    @include('Guru.partials.sidebar')

    <main class="lg:ml-64 min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 p-4 md:p-6 lg:p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">📋 Absensi Kelas</h2>
                <p class="text-gray-600 mt-1">{{ $kelas ? $kelas->nama_kelas : 'Anda belum memiliki kelas' }}</p>
            </div>
            <div class="mt-2 text-sm text-gray-500">
                Tanggal: {{ date('d F Y') }}
            </div>
        </div>

        @if(!$kelas)
            <div class="bg-white rounded-2xl shadow-md p-8 text-center">
                <i class="fas fa-chalkboard-teacher text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Anda belum ditugaskan sebagai wali kelas.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Murid</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIS</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu Absen</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($dataMurid as $index => $murid)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index+1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $murid->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $murid->nis }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="status-badge status-{{ $murid->status }}">
                                        {{ ucfirst($murid->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $murid->waktu }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <select onchange="updateStatus({{ $murid->id }}, this.value)" class="border rounded-md px-2 py-1 text-sm">
                                        <option value="hadir" {{ $murid->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                        <option value="izin" {{ $murid->status == 'izin' ? 'selected' : '' }}>Izin</option>
                                        <option value="sakit" {{ $murid->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                        <option value="alpha" {{ $murid->status == 'alpha' ? 'selected' : '' }}>Alpha</option>
                                    </select>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada murid di kelas ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @include('Guru.partials.footer')
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

        function updateStatus(userId, status) {
            fetch(`/guru/absensi/${userId}/update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status: status })
            }).then(res => res.json()).then(data => {
                if (data.success) location.reload();
                else alert('Gagal update status');
            });
        }
    </script>
</body>
</html>
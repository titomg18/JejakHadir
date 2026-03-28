<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kelas | JejakHadir</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f9fafc; }
        .glass-card {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.6);
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }
        .sidebar {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255,255,255,0.7);
        }
        .menu-item {
            transition: all 0.2s;
            border-radius: 12px;
            margin: 4px 0;
        }
        .menu-item:hover {
            background: rgba(59,130,246,0.08);
            color: #1e40af;
        }
        .menu-item.active {
            background: linear-gradient(90deg, rgba(59,130,246,0.12) 0%, rgba(139,92,246,0.12) 100%);
            color: #2563eb;
            font-weight: 500;
            border-left: 4px solid #3b82f6;
        }
        .menu-item i { width: 24px; color: #6b7280; }
        .menu-item.active i { color: #3b82f6; }
        .table-row-hover:hover { background: rgba(59,130,246,0.04); }
        .modal { transition: opacity 0.25s ease; }
    </style>
</head>
<body>

<div class="flex h-screen overflow-hidden bg-[#f9fafc]">
    @include('Admin.partials.sidebar')

    <main class="flex-1 overflow-y-auto">
        @include('Admin.partials.navbar')

        <div class="p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Detail Kelas: {{ $kelas->nama_kelas }}</h1>
                    <p class="text-gray-500 mt-1">Daftar murid dalam kelas ini.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('admin.kelas') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Informasi Kelas -->
            <div class="glass-card rounded-2xl p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama Kelas</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $kelas->nama_kelas }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Wali Kelas</p>
                        <p class="text-lg font-semibold text-gray-800">{{ $kelas->waliKelas->name ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-gray-500">Deskripsi</p>
                        <p class="text-gray-700">{{ $kelas->deskripsi ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Daftar Murid -->
            <div class="glass-card rounded-2xl overflow-hidden overflow-x-auto">
                <div class="px-6 py-4 border-b border-white/30 bg-white/40 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-700">Daftar Murid</h3>
                    <button onclick="openAddMuridModal()" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:shadow-lg transition flex items-center">
                        <i class="fas fa-plus mr-2"></i> Tambah Murid
                    </button>
                </div>
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-white/30 bg-white/40">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/30">
                        @forelse($kelas->murids as $index => $murid)
                        <tr class="table-row-hover">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $murid->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $murid->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form method="POST" action="{{ route('admin.kelas.removeMurid', [$kelas->id, $murid->id]) }}" class="inline" onsubmit="return confirm('Yakin keluarkan murid ini dari kelas?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-user-minus"></i> Keluarkan
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada murid di kelas ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-white/30 text-sm text-gray-500 border-t border-white/30 rounded-b-2xl">
                <span>Total {{ $kelas->murids->count() }} murid</span>
            </div>
        </div>
    </main>
</div>

<!-- Modal Tambah Murid -->
<div id="addMuridModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden modal items-center justify-center flex">
    <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-semibold text-gray-800">Tambah Murid ke Kelas</h3>
            <button onclick="closeAddMuridModal()" class="text-gray-400 hover:text-gray-600">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.kelas.addMurid', $kelas->id) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Murid</label>
                <select name="murid_id" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <option value="">-- Pilih Murid --</option>
                    @foreach($muridTidakBerKelas as $murid)
                        <option value="{{ $murid->id }}">{{ $murid->name }} ({{ $murid->email }})</option>
                    @endforeach
                </select>
                @if($muridTidakBerKelas->isEmpty())
                    <p class="text-xs text-yellow-600 mt-1">Tidak ada murid yang belum memiliki kelas.</p>
                @endif
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeAddMuridModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50">Batal</button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white hover:shadow-lg">Tambah</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Sidebar toggle
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

    if (toggleBtn) {
        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (sidebar.classList.contains('-translate-x-full')) openSidebar();
            else closeSidebar();
        });
    }

    backdrop.addEventListener('click', closeSidebar);
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.add('hidden');
            document.body.style.overflow = '';
        }
    });

    // Modal controls
    const addMuridModal = document.getElementById('addMuridModal');
    function openAddMuridModal() {
        addMuridModal.classList.remove('hidden');
        addMuridModal.classList.add('flex');
    }
    function closeAddMuridModal() {
        addMuridModal.classList.add('hidden');
        addMuridModal.classList.remove('flex');
    }
    window.addEventListener('click', (e) => {
        if (e.target === addMuridModal) closeAddMuridModal();
    });

    @if(session('success'))
        alert('{{ session('success') }}');
    @endif
    @if(session('error'))
        alert('{{ session('error') }}');
    @endif
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Guru | JejakHadir</title>
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
        .table-row-hover:hover {
            background: rgba(59, 130, 246, 0.04);
        }
        .modal {
            transition: opacity 0.25s ease;
        }
    </style>
</head>
<body class="antialiased">

    <div class="flex h-screen overflow-hidden bg-[#f9fafc]">
        @include('Admin.partials.sidebar')

        <main class="flex-1 overflow-y-auto">
            @include('Admin.partials.navbar')

            <div class="p-6 md:p-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Kelola Guru</h1>
                        <p class="text-gray-500 mt-1">Daftar semua guru yang terdaftar.</p>
                    </div>
                </div>

                <!-- Tabel Guru -->
                <div class="glass-card rounded-2xl overflow-hidden overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-white/30 bg-white/40">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                             </tr>
                        </thead>
                        <tbody class="divide-y divide-white/30">
                            @forelse($gurus ?? [] as $index => $guru)
                            <tr class="table-row-hover">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $guru->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $guru->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                        Guru
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if($guru->guru)
                                        <button 
                                            onclick="openEditModal({{ $guru->guru->id }}, '{{ addslashes($guru->name) }}', '{{ addslashes($guru->guru->nip ?? '') }}', '{{ addslashes($guru->guru->tempat_lahir ?? '') }}', '{{ $guru->guru->tanggal_lahir ? $guru->guru->tanggal_lahir->format('Y-m-d') : '' }}', '{{ $guru->guru->jenis_kelamin ?? '' }}', '{{ addslashes($guru->guru->alamat ?? '') }}', '{{ addslashes($guru->guru->no_telp ?? '') }}')"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit"></i> Edit Data
                                        </button>
                                    @else
                                        <span class="text-gray-400">Data tidak tersedia</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada guru terdaftar.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-white/30 text-sm text-gray-500 border-t border-white/30 rounded-b-2xl flex justify-between items-center">
                    <span>Total <span id="guruCount">{{ $gurus->count() ?? 0 }}</span> guru</span>
                    <span class="text-xs">Halaman 1 dari 1</span>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Edit Data Guru -->
    <div id="editGuruModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden modal items-center justify-center flex">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl max-h-[90vh] overflow-y-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">Edit Data Guru</h3>
                <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="editGuruForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="guru_id" name="guru_id">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="nama" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 bg-gray-100" readonly disabled>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                    <input type="text" name="nip" id="nip" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" id="tempat_lahir" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        <option value="">-- Pilih --</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="alamat" id="alamat" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                    <input type="text" name="no_telp" id="no_telp" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white hover:shadow-lg">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Sidebar toggle script (sama seperti sebelumnya) -->
    <script>
        // Sidebar toggle (salin dari dashboard)
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
                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
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

        // Modal logic
        const modal = document.getElementById('editGuruModal');
        const form = document.getElementById('editGuruForm');
        const updateUrlBase = '{{ route("admin.guru.detail.update", ":id") }}';

        function openEditModal(id, nama, nip, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, no_telp) {
            document.getElementById('guru_id').value = id;
            document.getElementById('nama').value = nama;
            document.getElementById('nip').value = nip;
            document.getElementById('tempat_lahir').value = tempat_lahir;
            document.getElementById('tanggal_lahir').value = tanggal_lahir;
            document.getElementById('jenis_kelamin').value = jenis_kelamin;
            document.getElementById('alamat').value = alamat;
            document.getElementById('no_telp').value = no_telp;

            form.action = updateUrlBase.replace(':id', id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeEditModal();
            }
        });

        @if(session('success'))
            alert('{{ session("success") }}');
        @endif
        @if($errors->any())
            alert('{{ $errors->first() }}');
        @endif
    </script>
</body>
</html>
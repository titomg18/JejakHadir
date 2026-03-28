<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kelas | JejakHadir</title>
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
        body.modal-active {
            overflow-x: hidden;
            overflow-y: visible !important;
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
                        <h1 class="text-3xl font-bold text-gray-800">Kelola Kelas</h1>
                        <p class="text-gray-500 mt-1">Daftar semua kelas.</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <button onclick="openModal()" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:shadow-lg hover:shadow-blue-200 transition flex items-center">
                            <i class="fas fa-plus mr-2"></i> Tambah Kelas
                        </button>
                    </div>
                </div>

                <div class="glass-card rounded-2xl overflow-hidden overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="border-b border-white/30 bg-white/40">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kelas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wali Kelas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                             </tr>
                        </thead>
                        <tbody class="divide-y divide-white/30">
                            @forelse($kelas ?? [] as $index => $kelasItem)
                            <tr class="table-row-hover">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $kelasItem->nama_kelas }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $kelasItem->deskripsi ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $kelasItem->waliKelas->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.kelas.detail', $kelasItem->id) }}" class="text-green-600 hover:text-green-900 mr-3">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <button onclick="editKelas({{ $kelasItem->id }}, '{{ addslashes($kelasItem->nama_kelas) }}', '{{ addslashes($kelasItem->deskripsi) }}', '{{ $kelasItem->wali_kelas_id }}')" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.kelas.destroy', $kelasItem->id) }}" class="inline" onsubmit="return confirm('Yakin hapus kelas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada kelas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-white/30 text-sm text-gray-500 border-t border-white/30 rounded-b-2xl flex justify-between items-center">
                    <span>Total <span id="kelasCount">{{ $kelas->count() ?? 0 }}</span> kelas</span>
                    <span class="text-xs">Halaman 1 dari 1</span>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Form Tambah/Edit Kelas -->
    <div id="kelasModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden modal items-center justify-center flex">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800" id="modalTitle">Tambah Kelas</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="kelasForm" method="POST">
                @csrf
                <input type="hidden" id="kelasId" name="kelas_id">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Kelas</label>
                    <input type="text" id="nama_kelas" name="nama_kelas" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200"></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Wali Kelas (Guru)</label>
                    <select id="wali_kelas_id" name="wali_kelas_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        <option value="">Pilih Wali Kelas</option>
                        @foreach($gurus ?? [] as $guru)
                            <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white hover:shadow-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Sidebar toggle (sama seperti sebelumnya)
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

        // Modal controls
        const modal = document.getElementById('kelasModal');
        const modalTitle = document.getElementById('modalTitle');
        const form = document.getElementById('kelasForm');
        const kelasIdInput = document.getElementById('kelasId');
        const namaKelasInput = document.getElementById('nama_kelas');
        const deskripsiInput = document.getElementById('deskripsi');
        const waliKelasSelect = document.getElementById('wali_kelas_id');

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Reset form
            form.reset();
            form.action = '{{ route("admin.kelas.store") }}';
            form.method = 'POST';
            kelasIdInput.value = '';
            modalTitle.innerText = 'Tambah Kelas';
            // Hapus hidden _method jika ada
            let methodInput = form.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function editKelas(id, nama_kelas, deskripsi, wali_kelas_id) {
            kelasIdInput.value = id;
            namaKelasInput.value = nama_kelas;
            deskripsiInput.value = deskripsi;
            waliKelasSelect.value = wali_kelas_id;
            form.action = '/admin/kelas/' + id;
            form.method = 'POST';
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                form.appendChild(methodInput);
            }
            methodInput.value = 'PUT';
            modalTitle.innerText = 'Edit Kelas';
            openModal();
        }

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Show success/error messages
        @if(session('success'))
            alert('{{ session("success") }}');
        @endif
        @if($errors->any())
            alert('{{ $errors->first() }}');
        @endif
    </script>
</body>
</html>
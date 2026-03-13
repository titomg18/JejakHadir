<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User | JejakHadir</title>
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
        /* Modal */
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
        <!-- Sidebar (gunakan partial) -->
        @include('Admin.partials.sidebar')

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Navbar -->
            @include('Admin.partials.navbar')

            <!-- Content -->
            <div class="p-6 md:p-8">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Kelola User</h1>
                        <p class="text-gray-500 mt-1">Daftar semua pengguna aplikasi.</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <button onclick="openModal()" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:shadow-lg hover:shadow-blue-200 transition flex items-center">
                            <i class="fas fa-plus mr-2"></i> Tambah User
                        </button>
                    </div>
                </div>

                <!-- Tabel User -->
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
                            @forelse($users ?? [] as $index => $user)
                            <tr class="table-row-hover">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($user->role == 'admin') bg-purple-100 text-purple-800 
                                        @elseif($user->role == 'guru') bg-blue-100 text-blue-800 
                                        @else bg-green-100 text-green-800 @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <button onclick="editUser({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}')" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" class="inline" onsubmit="return confirm('Yakin hapus user ini?')">
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
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">Belum ada user.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-white/30 text-sm text-gray-500 border-t border-white/30 rounded-b-2xl flex justify-between items-center">
                    <span>Total <span id="userCount">{{ $users->count() ?? 0 }}</span> user</span>
                    <span class="text-xs">Halaman 1 dari 1</span>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal Form Tambah/Edit User -->
    <div id="userModal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden modal items-center justify-center flex">
        <div class="bg-white rounded-2xl w-full max-w-md p-6 shadow-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800" id="modalTitle">Tambah User</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form id="userForm" method="POST">
                @csrf
                <input type="hidden" id="userId" name="user_id">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select id="role" name="role" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200">
                        <option value="admin">Admin</option>
                        <option value="guru">Guru</option>
                        <option value="murid">Murid</option>
                    </select>
                </div>
                <div class="mb-4" id="passwordField">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200">
                    <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah (pada edit)</p>
                </div>
                <div class="mb-4" id="passwordConfirmationField">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-200">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-purple-600 text-white hover:shadow-lg">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Backdrop & sidebar toggle script (sama seperti di dashboard) -->
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

        // Modal controls
        const modal = document.getElementById('userModal');
        const modalTitle = document.getElementById('modalTitle');
        const form = document.getElementById('userForm');
        const userIdInput = document.getElementById('userId');
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const roleSelect = document.getElementById('role');
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const passwordField = document.getElementById('passwordField');
        const passwordConfirmationField = document.getElementById('passwordConfirmationField');

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Reset form untuk tambah
            form.reset();
            form.action = '{{ route("admin.users.store") }}';
            form.method = 'POST';
            userIdInput.value = '';
            modalTitle.innerText = 'Tambah User';
            passwordInput.required = true;
            passwordConfirmationInput.required = true;
            passwordField.style.display = 'block';
            passwordConfirmationField.style.display = 'block';
        }

        function openModalForEdit() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Tidak reset form untuk edit
            modalTitle.innerText = 'Edit User';
            passwordInput.required = false;
            passwordConfirmationInput.required = false;
            passwordField.style.display = 'block';
            passwordConfirmationField.style.display = 'block';
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Edit user
        function editUser(id, name, email, role) {
            userIdInput.value = id;
            nameInput.value = name;
            emailInput.value = email;
            roleSelect.value = role;
            form.action = '/admin/users/' + id;
            form.method = 'POST';
            // Add _method PUT
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                form.appendChild(methodInput);
            }
            methodInput.value = 'PUT';
            openModalForEdit();
        }

        // Tutup modal jika klik di luar
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeModal();
            }
        });

        // Show success/error messages if any
        @if(session('success'))
            alert('{{ session("success") }}');
        @endif
        @if($errors->any())
            alert('{{ $errors->first() }}');
        @endif
    </script>
</body>
</html>
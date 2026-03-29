<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Saya | JejakHadir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">

    <button id="sidebarToggle" class="lg:hidden fixed top-4 left-4 z-50 bg-green-600 text-white p-3 rounded-lg shadow-lg">
        <i class="fas fa-bars text-xl"></i>
    </button>
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

    @include('Murid.partials.sidebar')

    <main class="lg:ml-64 min-h-screen bg-gradient-to-br from-green-50 via-white to-teal-50 p-4 md:p-6 lg:p-8">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-md p-6">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
                        <p class="text-gray-500">Murid</p>
                    </div>
                </div>

                <div class="border-t border-gray-100 pt-4">
                    <dl class="divide-y divide-gray-100">
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Email</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ Auth::user()->email }}</dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">NIS</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ Auth::user()->murid->nis ?? '-' }}</dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">NISN</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ Auth::user()->murid->nisn ?? '-' }}</dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Tempat, Tanggal Lahir</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ Auth::user()->murid->tempat_lahir ?? '-' }}, {{ Auth::user()->murid->tanggal_lahir ? \Carbon\Carbon::parse(Auth::user()->murid->tanggal_lahir)->format('d-m-Y') : '-' }}</dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Jenis Kelamin</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ Auth::user()->murid->jenis_kelamin == 'L' ? 'Laki-laki' : (Auth::user()->murid->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ Auth::user()->murid->alamat ?? '-' }}</dd>
                        </div>
                        <div class="py-3 grid grid-cols-3 gap-4">
                            <dt class="text-sm font-medium text-gray-500">No. Telp Orang Tua</dt>
                            <dd class="text-sm text-gray-900 col-span-2">{{ Auth::user()->murid->no_telp_orang_tua ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="mt-6 text-center text-sm text-gray-400">
                    <i class="fas fa-lock mr-1"></i> Data diri hanya dapat diubah oleh admin.
                </div>
            </div>
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
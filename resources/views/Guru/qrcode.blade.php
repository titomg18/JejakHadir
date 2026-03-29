<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Absensi | JejakHadir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <button id="sidebarToggle" class="lg:hidden fixed top-4 left-4 z-50 bg-indigo-600 text-white p-3 rounded-lg shadow-lg">
        <i class="fas fa-bars text-xl"></i>
    </button>
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

    @include('Guru.partials.sidebar')

    <main class="lg:ml-64 min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 p-4 md:p-6 lg:p-8">
        <div class="max-w-md mx-auto">
            <div class="bg-white rounded-2xl shadow-md p-6 text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">QR Code Absensi</h2>
                <p class="text-gray-600 mb-4">
                    Kelas: <strong>{{ $kelas ? $kelas->nama_kelas : 'Tidak ada kelas' }}</strong>
                </p>
                <p class="text-sm text-gray-500 mb-4">QR Code ini akan berubah setiap 5 detik untuk keamanan.</p>

                @if($kelas)
                    <div id="qrcode" class="flex justify-center mb-4"></div>
                    <div class="text-sm text-gray-500 mt-2">
                        <i class="fas fa-sync-alt fa-spin mr-1"></i> Memperbarui otomatis...
                    </div>
                @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-yellow-800">
                        Anda belum ditugaskan sebagai wali kelas. Tidak dapat membuat QR code.
                    </div>
                @endif
            </div>
        </div>

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

        @if($kelas)
        let qrcodeContainer = document.getElementById('qrcode');
        let currentQR = null;

        function refreshQR() {
            fetch('{{ route("guru.qrcode.refresh") }}')
                .then(res => res.json())
                .then(data => {
                    if (data.url) {
                        if (currentQR) {
                            qrcodeContainer.innerHTML = '';
                        }
                        currentQR = new QRCode(qrcodeContainer, {
                            text: data.url,
                            width: 256,
                            height: 256,
                            colorDark: "#000000",
                            colorLight: "#ffffff",
                            correctLevel: QRCode.CorrectLevel.H
                        });
                    }
                })
                .catch(err => console.error('Gagal refresh QR:', err));
        }

        refreshQR();
        setInterval(refreshQR, 5000); // refresh setiap 5 detik
        @endif
    </script>
</body>
</html>
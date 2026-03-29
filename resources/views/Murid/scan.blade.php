<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QR Absensi | JejakHadir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Menggunakan html5-qrcode versi stabil -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
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
                <h2 class="text-2xl font-bold text-gray-800 mb-2 text-center">Scan QR Code Absensi</h2>
                <p class="text-gray-500 text-center mb-4">Arahkan kamera ke QR code yang ditampilkan guru.</p>

                <div id="reader" style="width: 100%;"></div>
                <div id="result" class="mt-4 text-center text-sm font-semibold"></div>

                <div class="mt-4 text-center space-x-2">
                    <button id="startScanBtn" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Mulai Scan</button>
                    <button id="stopScanBtn" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Hentikan</button>
                </div>
                <div id="debugInfo" class="mt-4 text-xs text-gray-400 text-center"></div>
            </div>
        </div>
    </main>

    <script>
        // Sidebar toggle
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
        if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);
        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.add('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        });
        if (window.innerWidth < 1024) sidebar.classList.add('-translate-x-full');

        // QR Scanner menggunakan html5-qrcode
        let html5QrCode = null;
        const debugDiv = document.getElementById('debugInfo');
        const resultDiv = document.getElementById('result');

        document.getElementById('startScanBtn').addEventListener('click', startScan);
        document.getElementById('stopScanBtn').addEventListener('click', stopScan);

        function startScan() {
            if (html5QrCode) {
                stopScan().then(() => initScanner());
            } else {
                initScanner();
            }
        }

        function initScanner() {
            if (typeof Html5Qrcode === 'undefined') {
                debugDiv.innerHTML = 'Library QR code tidak terload. Coba refresh halaman.';
                return;
            }
            html5QrCode = new Html5Qrcode("reader");
            const config = { fps: 10, qrbox: { width: 250, height: 250 } };
            html5QrCode.start(
                { facingMode: "environment" },
                config,
                onScanSuccess,
                onScanError
            ).then(() => {
                debugDiv.innerHTML = 'Kamera aktif, arahkan ke QR code.';
            }).catch(err => {
                console.error(err);
                let errorMsg = 'Gagal memulai kamera: ';
                if (err === 'NotAllowedError') errorMsg += 'Izin kamera ditolak. Berikan izin kamera.';
                else if (err === 'NotFoundError') errorMsg += 'Tidak ada kamera terdeteksi.';
                else errorMsg += err;
                debugDiv.innerHTML = errorMsg;
                alert(errorMsg);
            });
        }

        function onScanSuccess(decodedText, decodedResult) {
            stopScan();
            debugDiv.innerHTML = 'QR terdeteksi, memproses...';
            fetch(decodedText, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resultDiv.innerHTML = `<span class="text-green-600 font-bold">✅ ${data.success}</span>`;
                    debugDiv.innerHTML = 'Absensi berhasil!';
                } else if (data.error) {
                    resultDiv.innerHTML = `<span class="text-red-600 font-bold">❌ ${data.error}</span>`;
                    debugDiv.innerHTML = 'Gagal: ' + data.error;
                } else {
                    resultDiv.innerHTML = `<span class="text-red-600 font-bold">❌ Gagal memproses absen</span>`;
                }
            })
            .catch(error => {
                console.error(error);
                resultDiv.innerHTML = `<span class="text-red-600 font-bold">❌ Gagal menghubungi server</span>`;
                debugDiv.innerHTML = 'Error: ' + error;
            });
        }

        function onScanError(errorMessage) {
            // tidak perlu log setiap error
        }

        async function stopScan() {
            if (html5QrCode) {
                try {
                    await html5QrCode.stop();
                    await html5QrCode.clear();
                    debugDiv.innerHTML = 'Scanner dihentikan.';
                } catch (err) {
                    console.error(err);
                } finally {
                    html5QrCode = null;
                }
            }
            return Promise.resolve();
        }
    </script>
</body>
</html>
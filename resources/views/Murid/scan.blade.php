<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Scan QR Absensi | JejakHadir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <style>
        .bg-gradient-custom {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%);
        }
        #reader {
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
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
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="px-6 py-5 bg-gray-50/50 border-b border-gray-100">
                    <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                        <i class="fas fa-qrcode text-green-600"></i> Scan QR Code
                    </h2>
                    <p class="text-gray-500 text-sm mt-1">Arahkan kamera ke QR code yang ditampilkan guru</p>
                </div>

                <div class="p-6">
                    <div id="reader" class="w-full rounded-xl overflow-hidden shadow-inner"></div>
                    
                    <div id="result" class="mt-5 text-center text-sm font-semibold"></div>

                    <div class="mt-6 flex flex-wrap justify-center gap-3">
                        <button id="startScanBtn" class="bg-gradient-to-r from-green-600 to-teal-600 text-white px-6 py-2.5 rounded-xl hover:shadow-lg transition-all duration-200 flex items-center gap-2 font-medium">
                            <i class="fas fa-play"></i> Mulai Scan
                        </button>
                        <button id="stopScanBtn" class="bg-gray-200 text-gray-700 px-6 py-2.5 rounded-xl hover:bg-gray-300 transition-all duration-200 flex items-center gap-2 font-medium">
                            <i class="fas fa-stop"></i> Hentikan
                        </button>
                    </div>
                    
                    <div id="debugInfo" class="mt-5 text-xs text-gray-400 text-center bg-gray-50 rounded-xl py-2 px-3"></div>
                </div>
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
                if (toggleBtn) toggleBtn.style.display = 'none';
            } else {
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

        if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);
        
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
        
        if (window.innerWidth < 1024) sidebar.classList.add('-translate-x-full');
        updateToggleVisibility();

        // QR Scanner (tidak berubah sama sekali)
        let html5QrCode = null;
        const debugDiv = document.getElementById('debugInfo');
        const resultDiv = document.getElementById('result');
        const startBtn = document.getElementById('startScanBtn');
        const stopBtn = document.getElementById('stopScanBtn');

        startBtn.addEventListener('click', startScan);
        stopBtn.addEventListener('click', stopScan);

        function startScan() {
            if (html5QrCode) {
                stopScan().then(() => initScanner());
            } else {
                initScanner();
            }
        }

        function initScanner() {
            if (typeof Html5Qrcode === 'undefined') {
                debugDiv.innerHTML = '⚠️ Library QR code tidak terload. Refresh halaman.';
                return;
            }
            html5QrCode = new Html5Qrcode("reader");
            const config = { fps: 10, qrbox: { width: 280, height: 280 } };
            html5QrCode.start(
                { facingMode: "environment" },
                config,
                onScanSuccess,
                onScanError
            ).then(() => {
                debugDiv.innerHTML = '📷 Kamera aktif, arahkan ke QR code.';
                startBtn.disabled = true;
                stopBtn.disabled = false;
            }).catch(err => {
                console.error(err);
                let errorMsg = '❌ Gagal memulai kamera: ';
                if (err === 'NotAllowedError') errorMsg += 'Izin kamera ditolak. Berikan izin kamera.';
                else if (err === 'NotFoundError') errorMsg += 'Tidak ada kamera terdeteksi.';
                else errorMsg += err;
                debugDiv.innerHTML = errorMsg;
                alert(errorMsg);
                startBtn.disabled = false;
            });
        }

        function onScanSuccess(decodedText, decodedResult) {
            stopScan();
            debugDiv.innerHTML = '🔍 QR terdeteksi, memproses...';
            fetch(decodedText, {
                method: 'GET',
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    resultDiv.innerHTML = `<div class="bg-green-100 text-green-700 p-3 rounded-xl inline-block shadow-sm"><i class="fas fa-check-circle mr-2"></i> ✅ ${data.success}</div>`;
                    debugDiv.innerHTML = '✨ Absensi berhasil!';
                } else if (data.error) {
                    resultDiv.innerHTML = `<div class="bg-red-100 text-red-700 p-3 rounded-xl inline-block shadow-sm"><i class="fas fa-exclamation-triangle mr-2"></i> ❌ ${data.error}</div>`;
                    debugDiv.innerHTML = 'Gagal: ' + data.error;
                } else {
                    resultDiv.innerHTML = `<div class="bg-red-100 text-red-700 p-3 rounded-xl inline-block shadow-sm"><i class="fas fa-times-circle mr-2"></i> Gagal memproses absen</div>`;
                }
                setTimeout(() => {
                    resultDiv.innerHTML = '';
                }, 5000);
            })
            .catch(error => {
                console.error(error);
                resultDiv.innerHTML = `<div class="bg-red-100 text-red-700 p-3 rounded-xl inline-block shadow-sm"><i class="fas fa-wifi mr-2"></i> ❌ Gagal menghubungi server</div>`;
                debugDiv.innerHTML = 'Error: ' + error;
            });
        }

        function onScanError(errorMessage) {}

        async function stopScan() {
            if (html5QrCode) {
                try {
                    await html5QrCode.stop();
                    await html5QrCode.clear();
                    debugDiv.innerHTML = '⏹️ Scanner dihentikan.';
                } catch (err) {
                    console.error(err);
                } finally {
                    html5QrCode = null;
                    startBtn.disabled = false;
                    stopBtn.disabled = true;
                }
            } else {
                startBtn.disabled = false;
                stopBtn.disabled = true;
            }
            return Promise.resolve();
        }
        
        // Initial button state
        stopBtn.disabled = true;
    </script>
</body>
</html>
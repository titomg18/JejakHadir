<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru | JejakHadir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: linear-gradient(135deg, #eff6ff 0%, #f8fafc 50%, #f5f3ff 100%); min-height: 100vh; }
        .card {
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.7);
            box-shadow: 0 8px 32px rgba(0,0,0,0.06);
        }
        .hover-lift { transition: all 0.2s ease; }
        .hover-lift:hover { transform: translateY(-3px); box-shadow: 0 20px 40px rgba(79,70,229,0.12); }
        .progress-bar { height: 6px; background: #e5e7eb; border-radius: 10px; overflow: hidden; }
        .progress-fill { height: 6px; border-radius: 10px; transition: width 1.2s ease; }
    </style>
</head>
<body class="antialiased">

    {{-- SIDEBAR TOGGLE MOBILE --}}
    <button id="sidebarToggle" class="lg:hidden fixed bottom-4 left-4 z-50 bg-indigo-600 text-white p-3 rounded-xl shadow-lg">
        <i class="fas fa-bars text-xl"></i>
    </button>
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 hidden lg:hidden"></div>

    @include('Guru.partials.sidebar')

    <main class="lg:ml-64 p-4 md:p-6 lg:p-8 space-y-6">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    Selamat datang, {{ $guru->name }} 👋
                </h1>
                <p class="text-gray-500 text-sm mt-1">
                    <i class="fas fa-calendar-day text-indigo-400 mr-1"></i>
                    {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                    @if($kelas)
                        &nbsp;·&nbsp; <span class="text-indigo-600 font-medium">Wali Kelas {{ $kelas->nama_kelas }}</span>
                    @endif
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('guru.absensi') }}"
                    class="inline-flex items-center gap-2 bg-white border border-gray-200 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-medium hover:border-indigo-300 hover:text-indigo-600 transition shadow-sm">
                    <i class="fas fa-clipboard-list"></i> Absensi
                </a>
                <a href="{{ route('guru.qrcode') }}"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-2.5 rounded-xl text-sm font-medium shadow hover:shadow-md transition">
                    <i class="fas fa-qrcode"></i> QR Code
                </a>
            </div>
        </div>

        @if(!$kelas)
            {{-- BELUM JADI WALI KELAS --}}
            <div class="card rounded-2xl p-10 text-center">
                <div class="w-20 h-20 bg-indigo-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-chalkboard text-indigo-300 text-3xl"></i>
                </div>
                <p class="text-gray-600 font-medium">Anda belum ditugaskan sebagai wali kelas.</p>
                <p class="text-gray-400 text-sm mt-1">Hubungi admin untuk mendapatkan kelas.</p>
            </div>
        @else

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card hover-lift rounded-2xl p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Murid</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalMurid }}</p>
                        <span class="inline-flex items-center text-xs text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full mt-2">
                            <i class="fas fa-door-open mr-1"></i> {{ $kelas->nama_kelas }}
                        </span>
                    </div>
                    <div class="w-11 h-11 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-500">
                        <i class="fas fa-user-graduate text-lg"></i>
                    </div>
                </div>
                <div class="progress-bar mt-4">
                    <div class="progress-fill bg-indigo-400" style="width:100%"></div>
                </div>
            </div>

            <div class="card hover-lift rounded-2xl p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Hadir</p>
                        <p class="text-3xl font-bold mt-1 {{ $persenHadir >= 80 ? 'text-green-600' : ($persenHadir >= 60 ? 'text-yellow-600' : 'text-red-600') }}">{{ $hadirHariIni }}</p>
                        <span class="inline-flex items-center text-xs px-2 py-0.5 rounded-full mt-2
                            {{ $persenHadir >= 80 ? 'text-green-700 bg-green-50' : ($persenHadir >= 60 ? 'text-yellow-700 bg-yellow-50' : 'text-red-700 bg-red-50') }}">
                            {{ $persenHadir }}% hari ini
                        </span>
                    </div>
                    <div class="w-11 h-11 bg-green-50 rounded-2xl flex items-center justify-center text-green-500">
                        <i class="fas fa-clipboard-check text-lg"></i>
                    </div>
                </div>
                <div class="progress-bar mt-4">
                    <div class="progress-fill" style="width:{{ $persenHadir }}%; background:{{ $persenHadir>=80?'#22c55e':($persenHadir>=60?'#eab308':'#ef4444') }}"></div>
                </div>
            </div>

            <div class="card hover-lift rounded-2xl p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Izin + Sakit</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $izinHariIni + $sakitHariIni }}</p>
                        <span class="inline-flex items-center text-xs text-yellow-700 bg-yellow-50 px-2 py-0.5 rounded-full mt-2">
                            {{ $izinHariIni }} izin &nbsp;·&nbsp; {{ $sakitHariIni }} sakit
                        </span>
                    </div>
                    <div class="w-11 h-11 bg-yellow-50 rounded-2xl flex items-center justify-center text-yellow-500">
                        <i class="fas fa-file-medical text-lg"></i>
                    </div>
                </div>
                <div class="progress-bar mt-4">
                    <div class="progress-fill bg-yellow-400" style="width:{{ $totalMurid>0?round((($izinHariIni+$sakitHariIni)/$totalMurid)*100):0 }}%"></div>
                </div>
            </div>

            <div class="card hover-lift rounded-2xl p-5">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Alpha</p>
                        <p class="text-3xl font-bold text-red-600 mt-1">{{ $alphaHariIni }}</p>
                        <span class="inline-flex items-center text-xs text-red-700 bg-red-50 px-2 py-0.5 rounded-full mt-2">
                            <i class="fas fa-exclamation-circle mr-1"></i> tanpa keterangan
                        </span>
                    </div>
                    <div class="w-11 h-11 bg-red-50 rounded-2xl flex items-center justify-center text-red-500">
                        <i class="fas fa-times-circle text-lg"></i>
                    </div>
                </div>
                <div class="progress-bar mt-4">
                    <div class="progress-fill bg-red-400" style="width:{{ $totalMurid>0?round(($alphaHariIni/$totalMurid)*100):0 }}%"></div>
                </div>
            </div>
        </div>

        {{-- GRAFIK --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Grafik bar 7 hari --}}
            <div class="card rounded-2xl p-6 lg:col-span-2">
                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="font-semibold text-gray-800">Kehadiran 7 Hari Terakhir</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Kelas {{ $kelas->nama_kelas }}</p>
                    </div>
                    <div class="flex gap-3 text-xs text-gray-500">
                        <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-indigo-500 inline-block"></span>Hadir</span>
                        <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-yellow-400 inline-block"></span>Izin/Sakit</span>
                        <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-full bg-red-400 inline-block"></span>Alpha</span>
                    </div>
                </div>
                <canvas id="grafikBar" height="120"></canvas>
            </div>

            {{-- Donut chart bulan ini --}}
            <div class="card rounded-2xl p-6 flex flex-col">
                <div class="mb-4">
                    <h2 class="font-semibold text-gray-800">Bulan {{ $daftarBulan[$bulan] }}</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Rekap total absensi</p>
                </div>
                <div class="flex-1 flex items-center justify-center">
                    <div style="position:relative; width:180px; height:180px;">
                        <canvas id="grafikDonut"></canvas>
                        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                            <p class="text-2xl font-bold text-gray-800">{{ array_sum($grafikDonut) }}</p>
                            <p class="text-xs text-gray-400">total</p>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2 mt-4 text-xs">
                    <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-indigo-500"></span><span class="text-gray-600">Hadir <strong>{{ $grafikDonut['hadir'] }}</strong></span></div>
                    <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-400"></span><span class="text-gray-600">Izin <strong>{{ $grafikDonut['izin'] }}</strong></span></div>
                    <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-yellow-400"></span><span class="text-gray-600">Sakit <strong>{{ $grafikDonut['sakit'] }}</strong></span></div>
                    <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-400"></span><span class="text-gray-600">Alpha <strong>{{ $grafikDonut['alpha'] }}</strong></span></div>
                </div>
            </div>
        </div>

        {{-- TABEL + ALPHA --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Scan terbaru hari ini --}}
            <div class="card rounded-2xl overflow-hidden lg:col-span-2">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold text-gray-800">Scan Terbaru Hari Ini</h2>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $absensiTerbaru->count() }} siswa tercatat</p>
                    </div>
                    <a href="{{ route('guru.absensi') }}" class="text-sm text-indigo-600 hover:underline flex items-center gap-1">
                        Lihat semua <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50/80">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Waktu</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($absensiTerbaru as $abs)
                                <tr class="hover:bg-indigo-50/20 transition-colors">
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center text-indigo-600 font-bold text-xs flex-shrink-0">
                                                {{ strtoupper(substr($abs->user->name ?? '?', 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $abs->user->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 text-gray-500 text-xs">
                                        {{ $abs->waktu_absen ? \Carbon\Carbon::parse($abs->waktu_absen)->format('H:i') : '-' }}
                                    </td>
                                    <td class="px-5 py-3">
                                        @if($abs->status === 'hadir')
                                            <span class="px-2.5 py-1 text-xs rounded-lg bg-green-50 text-green-700 font-semibold">✅ Hadir</span>
                                        @elseif($abs->status === 'izin')
                                            <span class="px-2.5 py-1 text-xs rounded-lg bg-blue-50 text-blue-700 font-semibold">📄 Izin</span>
                                        @elseif($abs->status === 'sakit')
                                            <span class="px-2.5 py-1 text-xs rounded-lg bg-yellow-50 text-yellow-700 font-semibold">🤒 Sakit</span>
                                        @else
                                            <span class="px-2.5 py-1 text-xs rounded-lg bg-red-50 text-red-700 font-semibold">❌ Alpha</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-5 py-12 text-center text-gray-400">
                                        <i class="fas fa-qrcode text-3xl mb-2 block text-gray-200"></i>
                                        Belum ada yang scan hari ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Murid perlu perhatian --}}
            <div class="card rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="font-semibold text-gray-800">⚠️ Perlu Perhatian</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Paling sering alpha bulan ini</p>
                </div>
                <div class="divide-y divide-gray-50">
                    @forelse($muridAlpha as $i => $murid)
                        <div class="px-5 py-3 flex items-center gap-3 hover:bg-red-50/30 transition">
                            <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0
                                {{ $i === 0 ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-500' }}">
                                {{ $i + 1 }}
                            </span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $murid->name }}</p>
                            </div>
                            <span class="flex-shrink-0 px-2 py-1 bg-red-50 text-red-600 text-xs font-bold rounded-lg">
                                {{ $murid->jumlah_alpha }}x
                            </span>
                        </div>
                    @empty
                        <div class="py-10 text-center text-gray-400">
                            <i class="fas fa-smile text-2xl mb-2 block text-green-300"></i>
                            <p class="text-sm">Tidak ada siswa alpha<br>bulan ini!</p>
                        </div>
                    @endforelse
                </div>
                @if($muridAlpha->count() > 0)
                <div class="px-5 py-3 border-t border-gray-50">
                    <a href="{{ route('guru.absensi') }}" class="text-xs text-indigo-600 hover:underline flex items-center gap-1">
                        Kelola absensi <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                @endif
            </div>
        </div>

        @endif {{-- end if $kelas --}}

        @include('Guru.partials.footer')
    </main>

<script>
@if($kelas)
    // ── Grafik Bar 7 hari ──────────────────────────────────────────
    const labels7  = @json(collect($grafikHarian)->pluck('label'));
    const dataHadir  = @json(collect($grafikHarian)->pluck('hadir'));
    const dataIzinSakit = @json(collect($grafikHarian)->map(fn($d) => $d['izin'] + $d['sakit']));
    const dataAlpha  = @json(collect($grafikHarian)->pluck('alpha'));

    new Chart(document.getElementById('grafikBar'), {
        type: 'bar',
        data: {
            labels: labels7,
            datasets: [
                { label: 'Hadir',      data: dataHadir,     backgroundColor: 'rgba(99,102,241,0.75)', borderRadius: 6, borderSkipped: false },
                { label: 'Izin/Sakit', data: dataIzinSakit, backgroundColor: 'rgba(234,179,8,0.6)',   borderRadius: 6, borderSkipped: false },
                { label: 'Alpha',      data: dataAlpha,     backgroundColor: 'rgba(239,68,68,0.55)',  borderRadius: 6, borderSkipped: false },
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, stacked: false, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    // ── Donut chart bulan ini ──────────────────────────────────────
    const donutData = @json($grafikDonut);
    new Chart(document.getElementById('grafikDonut'), {
        type: 'doughnut',
        data: {
            labels: ['Hadir', 'Izin', 'Sakit', 'Alpha'],
            datasets: [{
                data: [donutData.hadir, donutData.izin, donutData.sakit, donutData.alpha],
                backgroundColor: ['#6366f1', '#60a5fa', '#facc15', '#f87171'],
                borderWidth: 0,
                hoverOffset: 6,
            }]
        },
        options: {
            cutout: '72%',
            plugins: { legend: { display: false }, tooltip: { callbacks: {
                label: ctx => ` ${ctx.label}: ${ctx.parsed}`
            }}}
        }
    });
@endif

    // Sidebar toggle mobile
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('sidebarOverlay');
    const toggleBtn = document.getElementById('sidebarToggle');
    const closeBtn  = document.getElementById('closeSidebar');

    toggleBtn?.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    });
    [overlay, closeBtn].forEach(el => el?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }));
    if (window.innerWidth < 1024) sidebar.classList.add('-translate-x-full');
</script>
</body>
</html>
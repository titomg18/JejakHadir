<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | JejakHadir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f9fafc; }
        .glass-card {
            background: rgba(255,255,255,0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.6);
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        }
        .sidebar {
            background: rgba(255,255,255,0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255,255,255,0.7);
        }
        .menu-item { transition: all 0.2s; border-radius: 12px; margin: 4px 0; }
        .menu-item:hover { background: rgba(59,130,246,0.08); color: #1e40af; }
        .menu-item.active {
            background: linear-gradient(90deg, rgba(59,130,246,0.12) 0%, rgba(139,92,246,0.12) 100%);
            color: #2563eb; font-weight: 500; border-left: 4px solid #3b82f6;
        }
        .menu-item i { width: 24px; color: #6b7280; }
        .menu-item.active i { color: #3b82f6; }
        .stat-card { transition: all 0.2s ease; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 20px 30px -10px rgba(59,130,246,0.15); }
        .progress-bar { height: 6px; background: #e5e7eb; border-radius: 10px; overflow: hidden; }
        .progress-fill { height: 6px; background: linear-gradient(90deg, #3b82f6, #8b5cf6); border-radius: 10px; transition: width 1s ease; }
    </style>
</head>
<body class="antialiased">

<div class="flex h-screen overflow-hidden">
    @include('Admin.partials.sidebar')

    <main class="flex-1 overflow-y-auto">
        @include('Admin.partials.navbar')

        <div class="p-6 md:p-8 space-y-6">

            {{-- HEADER --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="fas fa-calendar-day text-blue-400 mr-1"></i>
                        {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                    </p>
                </div>
                <a href="{{ route('admin.laporan') }}"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2.5 rounded-xl text-sm font-medium shadow hover:shadow-md transition">
                    <i class="fas fa-file-alt"></i> Lihat Laporan
                </a>
            </div>

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Murid --}}
                <div class="glass-card stat-card rounded-2xl p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Murid</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalMurid }}</p>
                            <span class="inline-flex items-center text-xs text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full mt-2">
                                <i class="fas fa-check-circle mr-1"></i> Terdaftar
                            </span>
                        </div>
                        <div class="w-11 h-11 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-500">
                            <i class="fas fa-user-graduate text-lg"></i>
                        </div>
                    </div>
                    <div class="progress-bar mt-4">
                        <div class="progress-fill" style="width: {{ $totalMurid > 0 ? 100 : 0 }}%"></div>
                    </div>
                </div>

                {{-- Guru --}}
                <div class="glass-card stat-card rounded-2xl p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Guru</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalGuru }}</p>
                            <span class="inline-flex items-center text-xs text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full mt-2">
                                <i class="fas fa-chalkboard-teacher mr-1"></i> Pengajar
                            </span>
                        </div>
                        <div class="w-11 h-11 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-500">
                            <i class="fas fa-user-tie text-lg"></i>
                        </div>
                    </div>
                    <div class="progress-bar mt-4">
                        <div class="progress-fill" style="width: {{ $totalGuru > 0 ? 100 : 0 }}%"></div>
                    </div>
                </div>

                {{-- Kelas --}}
                <div class="glass-card stat-card rounded-2xl p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Kelas</p>
                            <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalKelas }}</p>
                            <span class="inline-flex items-center text-xs text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full mt-2">
                                <i class="fas fa-door-open mr-1"></i> Aktif
                            </span>
                        </div>
                        <div class="w-11 h-11 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-500">
                            <i class="fas fa-chalkboard text-lg"></i>
                        </div>
                    </div>
                    <div class="progress-bar mt-4">
                        <div class="progress-fill" style="width: 100%"></div>
                    </div>
                </div>

                {{-- Hadir hari ini --}}
                <div class="glass-card stat-card rounded-2xl p-5">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Hadir Hari Ini</p>
                            <p class="text-3xl font-bold mt-1 {{ $persenHadir >= 80 ? 'text-green-600' : ($persenHadir >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ $hadirHariIni }}
                            </p>
                            <span class="inline-flex items-center text-xs {{ $persenHadir >= 80 ? 'text-green-600 bg-green-50' : ($persenHadir >= 60 ? 'text-yellow-600 bg-yellow-50' : 'text-red-600 bg-red-50') }} px-2 py-0.5 rounded-full mt-2">
                                <i class="fas fa-percentage mr-1"></i> {{ $persenHadir }}% hadir
                            </span>
                        </div>
                        <div class="w-11 h-11 bg-green-50 rounded-2xl flex items-center justify-center text-green-500">
                            <i class="fas fa-clipboard-check text-lg"></i>
                        </div>
                    </div>
                    <div class="progress-bar mt-4">
                        <div class="progress-fill" style="width: {{ $persenHadir }}%; background: {{ $persenHadir >= 80 ? 'linear-gradient(90deg, #22c55e, #16a34a)' : ($persenHadir >= 60 ? 'linear-gradient(90deg, #eab308, #ca8a04)' : 'linear-gradient(90deg, #ef4444, #b91c1c)') }};"></div>
                    </div>
                </div>
            </div>

            {{-- GRAFIK + REKAP KELAS --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Grafik 7 hari --}}
                <div class="glass-card rounded-2xl p-6 lg:col-span-2">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="font-semibold text-gray-800">Kehadiran 7 Hari Terakhir</h2>
                            <p class="text-xs text-gray-400 mt-0.5">Grafik rekap harian</p>
                        </div>
                        <div class="flex gap-3 text-xs text-gray-500">
                            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-500 inline-block"></span>Hadir</span>
                            <span class="flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-red-400 inline-block"></span>Alpha</span>
                        </div>
                    </div>
                    <canvas id="grafikHarian" height="110"></canvas>
                </div>

                {{-- Rekap bulan ini --}}
                <div class="glass-card rounded-2xl p-6">
                    <h2 class="font-semibold text-gray-800 mb-4">Rekap Bulan Ini</h2>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2 text-sm text-gray-600">
                                <span class="w-8 h-8 rounded-xl bg-green-50 flex items-center justify-center text-green-500 text-xs"><i class="fas fa-check"></i></span>
                                Hadir
                            </span>
                            <span class="font-bold text-green-600 text-lg">{{ $totalHadirBulan }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2 text-sm text-gray-600">
                                <span class="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500 text-xs"><i class="fas fa-file-alt"></i></span>
                                Izin
                            </span>
                            <span class="font-bold text-blue-600 text-lg">{{ $totalIzinBulan }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2 text-sm text-gray-600">
                                <span class="w-8 h-8 rounded-xl bg-yellow-50 flex items-center justify-center text-yellow-500 text-xs"><i class="fas fa-heartbeat"></i></span>
                                Sakit
                            </span>
                            <span class="font-bold text-yellow-600 text-lg">{{ $totalSakitBulan }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="flex items-center gap-2 text-sm text-gray-600">
                                <span class="w-8 h-8 rounded-xl bg-red-50 flex items-center justify-center text-red-500 text-xs"><i class="fas fa-times"></i></span>
                                Alpha
                            </span>
                            <span class="font-bold text-red-600 text-lg">{{ $totalAlphaBulan }}</span>
                        </div>
                    </div>
                    <div class="mt-5 pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.laporan') }}" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                            Lihat laporan lengkap <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- REKAP PER KELAS + MURID ALPHA --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Rekap per kelas hari ini --}}
                <div class="glass-card rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="font-semibold text-gray-800">Kehadiran Per Kelas — Hari Ini</h2>
                        <p class="text-xs text-gray-400 mt-0.5">{{ now()->locale('id')->translatedFormat('d F Y') }}</p>
                    </div>
                    <div class="p-4 space-y-3">
                        @forelse($rekapKelas as $kelas)
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center text-blue-600 text-xs font-bold flex-shrink-0">
                                    {{ strtoupper(substr($kelas->nama_kelas, 0, 2)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-sm font-medium text-gray-700 truncate">{{ $kelas->nama_kelas }}</span>
                                        <span class="text-xs text-gray-500 ml-2 flex-shrink-0">{{ $kelas->hadir_hari_ini }}/{{ $kelas->total_murid }}</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $kelas->persen }}%;
                                            background: {{ $kelas->persen >= 80 ? 'linear-gradient(90deg, #22c55e, #16a34a)' : ($kelas->persen >= 60 ? 'linear-gradient(90deg, #eab308, #ca8a04)' : 'linear-gradient(90deg, #ef4444, #b91c1c)') }};"></div>
                                    </div>
                                </div>
                                <span class="text-xs font-bold flex-shrink-0 {{ $kelas->persen >= 80 ? 'text-green-600' : ($kelas->persen >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                    {{ $kelas->persen }}%
                                </span>
                            </div>
                        @empty
                            <div class="py-8 text-center text-gray-400 text-sm">
                                <i class="fas fa-inbox text-2xl mb-2 block"></i>
                                Belum ada data kelas
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Murid paling sering alpha --}}
                <div class="glass-card rounded-2xl overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100">
                        <h2 class="font-semibold text-gray-800">⚠️ Perlu Perhatian</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Murid paling sering alpha bulan ini</p>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @forelse($muridAlpha as $i => $murid)
                            <div class="px-6 py-3 flex items-center gap-3 hover:bg-red-50/30 transition">
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0
                                    {{ $i === 0 ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $i + 1 }}
                                </span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-800 truncate">{{ $murid->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $murid->kelas?->nama_kelas ?? '-' }}</p>
                                </div>
                                <span class="flex-shrink-0 px-2.5 py-1 bg-red-50 text-red-600 text-xs font-bold rounded-lg">
                                    {{ $murid->jumlah_alpha }}x alpha
                                </span>
                            </div>
                        @empty
                            <div class="py-8 text-center text-gray-400 text-sm">
                                <i class="fas fa-smile text-2xl mb-2 block text-green-400"></i>
                                Tidak ada siswa yang alpha bulan ini!
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- ABSENSI TERBARU --}}
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h2 class="font-semibold text-gray-800">Scan Terbaru Hari Ini</h2>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $absensiTerbaru->count() }} scan tercatat</p>
                    </div>
                    <a href="{{ route('admin.laporan') }}" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                        Lihat laporan <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50/80">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Kelas</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Waktu</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($absensiTerbaru as $abs)
                                <tr class="hover:bg-blue-50/20 transition-colors">
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center text-blue-600 font-bold text-xs flex-shrink-0">
                                                {{ strtoupper(substr($abs->user->name ?? '?', 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $abs->user->name ?? '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 text-gray-500">{{ $abs->kelas?->nama_kelas ?? '-' }}</td>
                                    <td class="px-5 py-3 text-gray-500">
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
                                    <td colspan="4" class="px-5 py-12 text-center text-gray-400">
                                        <i class="fas fa-qrcode text-3xl mb-2 block text-gray-300"></i>
                                        Belum ada yang scan hari ini
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- AKSES CEPAT --}}
            <div>
                <h2 class="text-base font-semibold text-gray-700 mb-3">Akses Cepat</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('admin.users') }}" class="glass-card p-5 rounded-2xl flex flex-col items-center text-center hover:scale-105 transition-transform duration-200 cursor-pointer">
                        <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-500 mb-3 text-xl">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <span class="font-medium text-gray-700 text-sm">Kelola User</span>
                    </a>
                    <a href="{{ route('admin.kelas') }}" class="glass-card p-5 rounded-2xl flex flex-col items-center text-center hover:scale-105 transition-transform duration-200 cursor-pointer">
                        <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center text-purple-500 mb-3 text-xl">
                            <i class="fas fa-chalkboard"></i>
                        </div>
                        <span class="font-medium text-gray-700 text-sm">Kelola Kelas</span>
                    </a>
                    <a href="{{ route('admin.guru') }}" class="glass-card p-5 rounded-2xl flex flex-col items-center text-center hover:scale-105 transition-transform duration-200 cursor-pointer">
                        <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 mb-3 text-xl">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                        <span class="font-medium text-gray-700 text-sm">Kelola Guru</span>
                    </a>
                    <a href="{{ route('admin.laporan') }}" class="glass-card p-5 rounded-2xl flex flex-col items-center text-center hover:scale-105 transition-transform duration-200 cursor-pointer">
                        <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-500 mb-3 text-xl">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <span class="font-medium text-gray-700 text-sm">Laporan</span>
                    </a>
                </div>
            </div>

        </div>
    </main>
</div>

<script>
    // Grafik 7 hari
    const labels  = @json(collect($grafikHarian)->pluck('label'));
    const hadir   = @json(collect($grafikHarian)->pluck('hadir'));
    const alpha   = @json(collect($grafikHarian)->pluck('alpha'));

    new Chart(document.getElementById('grafikHarian'), {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Hadir',
                    data: hadir,
                    backgroundColor: 'rgba(59,130,246,0.7)',
                    borderRadius: 6,
                    borderSkipped: false,
                },
                {
                    label: 'Alpha',
                    data: alpha,
                    backgroundColor: 'rgba(239,68,68,0.5)',
                    borderRadius: 6,
                    borderSkipped: false,
                },
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });

    // Sidebar toggle
    const sidebar   = document.querySelector('aside');
    const toggleBtn = document.getElementById('sidebarToggle');
    const backdrop  = document.createElement('div');
    backdrop.className = 'fixed inset-0 bg-black/20 backdrop-blur-sm z-20 hidden md:hidden';
    document.body.appendChild(backdrop);
    toggleBtn?.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
        backdrop.classList.toggle('hidden');
    });
    backdrop.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
    });
</script>
</body>
</html>
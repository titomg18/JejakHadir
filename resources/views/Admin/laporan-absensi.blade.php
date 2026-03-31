<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Absensi | JejakHadir</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 20px 30px -10px rgba(59,130,246,0.15); }
        .badge-hadir { background:#dcfce7; color:#15803d; }
        .badge-izin  { background:#dbeafe; color:#1d4ed8; }
        .badge-sakit { background:#fef9c3; color:#854d0e; }
        .badge-alpha { background:#fee2e2; color:#b91c1c; }
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .glass-card { box-shadow: none; border: 1px solid #e5e7eb; background: white; }
            .sidebar { display: none !important; }
        }
    </style>
</head>
<body class="antialiased">
<div class="flex min-h-screen">

    @include('Admin.partials.sidebar')

    <main class="flex-1 overflow-auto">
        @include('Admin.partials.navbar')

        <div class="p-6 space-y-6">

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Laporan Absensi Siswa</h1>
                    <p class="text-sm text-gray-500 mt-1">Rekap kehadiran seluruh siswa per bulan</p>
                </div>
                <button onclick="window.print()"
                    class="no-print inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium shadow hover:shadow-md transition">
                    <i class="fas fa-print"></i> Cetak Laporan
                </button>
            </div>

            {{-- FILTER --}}
            <div class="glass-card rounded-2xl p-5 no-print">
                <form method="GET" action="{{ route('admin.laporan') }}" class="flex flex-wrap gap-4 items-end">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Bulan</label>
                        <select name="bulan" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none bg-white/80">
                            @foreach($daftarBulan as $num => $nama)
                                <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tahun</label>
                        <select name="tahun" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none bg-white/80">
                            @foreach($daftarTahun as $thn)
                                <option value="{{ $thn }}" {{ $tahun == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Kelas</label>
                        <select name="kelas_id" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none bg-white/80">
                            <option value="semua" {{ $kelasId == 'semua' ? 'selected' : '' }}>Semua Kelas</option>
                            @foreach($semuaKelas as $kelas)
                                <option value="{{ $kelas->id }}" {{ $kelasId == $kelas->id ? 'selected' : '' }}>{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition">
                        <i class="fas fa-filter"></i> Tampilkan
                    </button>
                </form>
            </div>

            {{-- STAT CARDS --}}
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="glass-card stat-card rounded-2xl p-4">
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Siswa</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalMurid }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-users text-blue-500 text-xs"></i>
                        <span class="text-xs text-gray-400">siswa terdaftar</span>
                    </div>
                </div>
                <div class="glass-card stat-card rounded-2xl p-4">
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Hari Efektif</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $hariEfektif }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-calendar-check text-purple-500 text-xs"></i>
                        <span class="text-xs text-gray-400">hari masuk</span>
                    </div>
                </div>
                <div class="glass-card stat-card rounded-2xl p-4">
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Hadir</p>
                    <p class="text-3xl font-bold text-green-600 mt-1">{{ $totalHadir }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-check-circle text-green-500 text-xs"></i>
                        <span class="text-xs text-gray-400">kehadiran</span>
                    </div>
                </div>
                <div class="glass-card stat-card rounded-2xl p-4">
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Izin + Sakit</p>
                    <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $totalIzin + $totalSakit }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-file-medical text-yellow-500 text-xs"></i>
                        <span class="text-xs text-gray-400">keterangan</span>
                    </div>
                </div>
                <div class="glass-card stat-card rounded-2xl p-4">
                    <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Alpha</p>
                    <p class="text-3xl font-bold text-red-600 mt-1">{{ $totalAlpha }}</p>
                    <div class="flex items-center gap-1 mt-2">
                        <i class="fas fa-times-circle text-red-500 text-xs"></i>
                        <span class="text-xs text-gray-400">tanpa keterangan</span>
                    </div>
                </div>
            </div>

            {{-- TABEL --}}
            <div class="glass-card rounded-2xl overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h2 class="font-semibold text-gray-800">
                            Rekap Kehadiran — {{ $daftarBulan[$bulan] }} {{ $tahun }}
                        </h2>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $totalMurid }} siswa ditemukan</p>
                    </div>
                    <input type="text" id="searchInput" placeholder="Cari nama siswa..."
                        class="no-print border border-gray-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none bg-white/80 w-52"
                        onkeyup="filterTable()">
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm" id="laporanTable">
                        <thead class="bg-gray-50/80">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">No</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama Siswa</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">NIS</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Kelas</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-green-600 uppercase tracking-wide">Hadir</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-blue-600 uppercase tracking-wide">Izin</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-yellow-600 uppercase tracking-wide">Sakit</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-red-600 uppercase tracking-wide">Alpha</th>
                                <th class="px-5 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">% Hadir</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" id="tableBody">
                            @forelse($muridList as $i => $murid)
                                @php
                                    $persen = $hariEfektif > 0 ? round(($murid->total_hadir / $hariEfektif) * 100) : 0;
                                    $persenColor = $persen >= 80 ? 'text-green-600' : ($persen >= 60 ? 'text-yellow-600' : 'text-red-600');
                                    $barColor    = $persen >= 80 ? 'bg-green-500' : ($persen >= 60 ? 'bg-yellow-500' : 'bg-red-500');
                                @endphp
                                <tr class="hover:bg-blue-50/30 transition-colors table-row">
                                    <td class="px-5 py-4 text-gray-400 text-xs">{{ $i + 1 }}</td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center text-blue-600 font-semibold text-xs flex-shrink-0">
                                                {{ strtoupper(substr($murid->name, 0, 1)) }}
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $murid->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-4 text-gray-500 text-xs">{{ $murid->murid?->nis ?? '-' }}</td>
                                    <td class="px-5 py-4 text-gray-600 text-xs">{{ $murid->kelas?->nama_kelas ?? '-' }}</td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="badge-hadir inline-block px-2.5 py-1 rounded-lg text-xs font-semibold">{{ $murid->total_hadir }}</span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="badge-izin inline-block px-2.5 py-1 rounded-lg text-xs font-semibold">{{ $murid->total_izin }}</span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="badge-sakit inline-block px-2.5 py-1 rounded-lg text-xs font-semibold">{{ $murid->total_sakit }}</span>
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <span class="badge-alpha inline-block px-2.5 py-1 rounded-lg text-xs font-semibold">{{ $murid->total_alpha }}</span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                <div class="{{ $barColor }} h-1.5 rounded-full" style="width: {{ $persen }}%"></div>
                                            </div>
                                            <span class="text-xs font-semibold {{ $persenColor }} w-10 text-right">{{ $persen }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-5 py-16 text-center">
                                        <div class="flex flex-col items-center gap-3">
                                            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                                <i class="fas fa-inbox text-gray-300 text-2xl"></i>
                                            </div>
                                            <p class="text-gray-400 font-medium">Tidak ada data absensi</p>
                                            <p class="text-gray-300 text-sm">Coba ubah filter bulan atau kelas</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($muridList->count() > 0)
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex flex-wrap gap-4 text-sm text-gray-500">
                    <span><i class="fas fa-info-circle text-blue-400 mr-1"></i>
                        Hari efektif bulan ini: <strong class="text-gray-700">{{ $hariEfektif }} hari</strong>
                    </span>
                    <span>Total hadir: <strong class="text-green-600">{{ $totalHadir }}</strong></span>
                    <span>Total izin: <strong class="text-blue-600">{{ $totalIzin }}</strong></span>
                    <span>Total sakit: <strong class="text-yellow-600">{{ $totalSakit }}</strong></span>
                    <span>Total alpha: <strong class="text-red-600">{{ $totalAlpha }}</strong></span>
                </div>
                @endif
            </div>

        </div>
    </main>
</div>

<script>
    function filterTable() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows  = document.querySelectorAll('#tableBody .table-row');
        rows.forEach(row => {
            const nama = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
            const nis  = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';
            row.style.display = (nama.includes(input) || nis.includes(input)) ? '' : 'none';
        });
    }
</script>
</body>
</html>
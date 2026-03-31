<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $bulan = now()->month;
        $tahun = now()->year;

        // ── Stat Cards ──────────────────────────────────────────────
        $totalMurid = User::where('role', 'murid')->count();
        $totalGuru  = User::where('role', 'guru')->count();
        $totalKelas = Kelas::count();
        $totalUser  = User::count();

        // Kehadiran hari ini
        $hadirHariIni = Absensi::where('tanggal', $today)->where('status', 'hadir')->count();
        $persenHadir  = $totalMurid > 0 ? round(($hadirHariIni / $totalMurid) * 100) : 0;

        // ── Grafik kehadiran 7 hari terakhir ────────────────────────
        $grafikHarian = [];
        for ($i = 6; $i >= 0; $i--) {
            $tgl = now()->subDays($i)->toDateString();
            $label = now()->subDays($i)->locale('id')->translatedFormat('D, d M');
            $grafikHarian[] = [
                'label'  => $label,
                'hadir'  => Absensi::where('tanggal', $tgl)->where('status', 'hadir')->count(),
                'alpha'  => Absensi::where('tanggal', $tgl)->where('status', 'alpha')->count(),
                'izin'   => Absensi::where('tanggal', $tgl)->where('status', 'izin')->count(),
                'sakit'  => Absensi::where('tanggal', $tgl)->where('status', 'sakit')->count(),
            ];
        }

        // ── Rekap per kelas hari ini ─────────────────────────────────
        $rekapKelas = Kelas::withCount([
            'murids as total_murid',
            'murids as hadir_hari_ini' => function ($q) use ($today) {
                $q->whereHas('absensi', fn($a) => $a->where('tanggal', $today)->where('status', 'hadir'));
            },
        ])->orderBy('nama_kelas')->get()->map(function ($k) {
            $k->persen = $k->total_murid > 0
                ? round(($k->hadir_hari_ini / $k->total_murid) * 100)
                : 0;
            return $k;
        });

        // ── 10 absensi terbaru hari ini ──────────────────────────────
        $absensiTerbaru = Absensi::with(['user', 'kelas'])
            ->where('tanggal', $today)
            ->orderByDesc('waktu_absen')
            ->limit(10)
            ->get();

        // ── Statistik bulan ini ──────────────────────────────────────
        $totalHadirBulan = Absensi::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'hadir')->count();
        $totalAlphaBulan = Absensi::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'alpha')->count();
        $totalIzinBulan  = Absensi::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'izin')->count();
        $totalSakitBulan = Absensi::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'sakit')->count();

        // ── Murid paling sering alpha bulan ini ─────────────────────
        $muridAlpha = User::where('role', 'murid')
            ->withCount(['absensi as jumlah_alpha' => fn($q) =>
                $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'alpha')
            ])
            ->with('kelas')
            ->having('jumlah_alpha', '>', 0)
            ->orderByDesc('jumlah_alpha')
            ->limit(5)
            ->get();

        return view('Admin.dashboard', compact(
            'totalMurid', 'totalGuru', 'totalKelas', 'totalUser',
            'hadirHariIni', 'persenHadir',
            'grafikHarian', 'rekapKelas',
            'absensiTerbaru',
            'totalHadirBulan', 'totalAlphaBulan', 'totalIzinBulan', 'totalSakitBulan',
            'muridAlpha'
        ));
    }
}
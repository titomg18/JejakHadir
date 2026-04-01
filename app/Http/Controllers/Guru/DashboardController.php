<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $guru  = Auth::user();
        $today = now()->toDateString();
        $bulan = now()->month;
        $tahun = now()->year;

        // Kelas yang diampu guru ini (sebagai wali kelas)
        $kelas = Kelas::with('murids')->where('wali_kelas_id', $guru->id)->first();

        $totalMurid   = 0;
        $hadirHariIni = 0;
        $izinHariIni  = 0;
        $sakitHariIni = 0;
        $alphaHariIni = 0;
        $persenHadir  = 0;
        $grafikHarian = [];
        $grafikDonut  = [];
        $absensiTerbaru = collect();
        $muridAlpha   = collect();

        if ($kelas) {
            $totalMurid = $kelas->murids->count();
            $muridIds   = $kelas->murids->pluck('id');

            // Rekap hari ini
            $absensiToday = Absensi::where('kelas_id', $kelas->id)
                ->where('tanggal', $today)
                ->whereIn('user_id', $muridIds)
                ->get();

            $hadirHariIni = $absensiToday->where('status', 'hadir')->count();
            $izinHariIni  = $absensiToday->where('status', 'izin')->count();
            $sakitHariIni = $absensiToday->where('status', 'sakit')->count();
            $alphaHariIni = $absensiToday->where('status', 'alpha')->count();
            $persenHadir  = $totalMurid > 0 ? round(($hadirHariIni / $totalMurid) * 100) : 0;

            // Grafik 7 hari terakhir
            for ($i = 6; $i >= 0; $i--) {
                $tgl   = now()->subDays($i)->toDateString();
                $label = now()->subDays($i)->locale('id')->translatedFormat('D d/m');
                $data  = Absensi::where('kelas_id', $kelas->id)
                    ->where('tanggal', $tgl)
                    ->whereIn('user_id', $muridIds)
                    ->selectRaw("
                        SUM(CASE WHEN status='hadir' THEN 1 ELSE 0 END) as hadir,
                        SUM(CASE WHEN status='izin'  THEN 1 ELSE 0 END) as izin,
                        SUM(CASE WHEN status='sakit' THEN 1 ELSE 0 END) as sakit,
                        SUM(CASE WHEN status='alpha' THEN 1 ELSE 0 END) as alpha
                    ")->first();

                $grafikHarian[] = [
                    'label' => $label,
                    'hadir' => (int)($data->hadir ?? 0),
                    'izin'  => (int)($data->izin  ?? 0),
                    'sakit' => (int)($data->sakit  ?? 0),
                    'alpha' => (int)($data->alpha  ?? 0),
                ];
            }

            // Donut chart rekap bulan ini
            $rekapBulan = Absensi::where('kelas_id', $kelas->id)
                ->whereMonth('tanggal', $bulan)
                ->whereYear('tanggal', $tahun)
                ->whereIn('user_id', $muridIds)
                ->selectRaw("
                    SUM(CASE WHEN status='hadir' THEN 1 ELSE 0 END) as hadir,
                    SUM(CASE WHEN status='izin'  THEN 1 ELSE 0 END) as izin,
                    SUM(CASE WHEN status='sakit' THEN 1 ELSE 0 END) as sakit,
                    SUM(CASE WHEN status='alpha' THEN 1 ELSE 0 END) as alpha
                ")->first();

            $grafikDonut = [
                'hadir' => (int)($rekapBulan->hadir ?? 0),
                'izin'  => (int)($rekapBulan->izin  ?? 0),
                'sakit' => (int)($rekapBulan->sakit  ?? 0),
                'alpha' => (int)($rekapBulan->alpha  ?? 0),
            ];

            // 8 absensi terbaru hari ini
            $absensiTerbaru = Absensi::with('user')
                ->where('kelas_id', $kelas->id)
                ->where('tanggal', $today)
                ->orderByDesc('waktu_absen')
                ->limit(8)
                ->get();

            // Murid paling sering alpha bulan ini
            $muridAlpha = $kelas->murids()
                ->withCount(['absensi as jumlah_alpha' => fn($q) =>
                    $q->where('kelas_id', $kelas->id)
                      ->whereMonth('tanggal', $bulan)
                      ->whereYear('tanggal', $tahun)
                      ->where('status', 'alpha')
                ])
                ->having('jumlah_alpha', '>', 0)
                ->orderByDesc('jumlah_alpha')
                ->limit(5)
                ->get();
        }

        $daftarBulan = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
        ];

        return view('Guru.dashboard', compact(
            'guru', 'kelas', 'totalMurid',
            'hadirHariIni', 'izinHariIni', 'sakitHariIni', 'alphaHariIni', 'persenHadir',
            'grafikHarian', 'grafikDonut',
            'absensiTerbaru', 'muridAlpha',
            'bulan', 'daftarBulan'
        ));
    }
}
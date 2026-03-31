<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $bulan   = (int) $request->get('bulan', now()->month);
        $tahun   = (int) $request->get('tahun', now()->year);
        $kelasId = $request->get('kelas_id', 'semua');

        $semuaKelas = Kelas::orderBy('nama_kelas')->get();

        $query = User::where('role', 'murid')
            ->with(['murid', 'kelas'])
            ->withCount([
                'absensi as total_hadir' => fn($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'hadir'),
                'absensi as total_izin'  => fn($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'izin'),
                'absensi as total_sakit' => fn($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'sakit'),
                'absensi as total_alpha' => fn($q) => $q->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->where('status', 'alpha'),
            ]);

        if ($kelasId !== 'semua') {
            $query->where('kelas_id', $kelasId);
        }

        $muridList = $query->orderBy('name')->get();

        // Hari efektif = jumlah hari berbeda yang ada data absensi di bulan itu
        $hariEfektifQuery = Absensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun);
        if ($kelasId !== 'semua') {
            $hariEfektifQuery->where('kelas_id', $kelasId);
        }
        $hariEfektif = $hariEfektifQuery
            ->selectRaw('COUNT(DISTINCT DATE(tanggal)) as jumlah')
            ->value('jumlah') ?? 0;

        $totalMurid = $muridList->count();
        $totalHadir = $muridList->sum('total_hadir');
        $totalIzin  = $muridList->sum('total_izin');
        $totalSakit = $muridList->sum('total_sakit');
        $totalAlpha = $muridList->sum('total_alpha');

        $daftarBulan = [
            1=>'Januari', 2=>'Februari', 3=>'Maret',    4=>'April',
            5=>'Mei',     6=>'Juni',     7=>'Juli',      8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember',
        ];
        $daftarTahun = range(now()->year, now()->year - 3);

        return view('Admin.laporan-absensi', compact(
            'muridList', 'semuaKelas', 'bulan', 'tahun', 'kelasId',
            'hariEfektif', 'totalMurid', 'totalHadir', 'totalIzin',
            'totalSakit', 'totalAlpha', 'daftarBulan', 'daftarTahun'
        ));
    }
}
<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index()
    {
        $guru = Auth::user();
        // Ambil kelas yang wali kelasnya adalah guru ini
        $kelas = Kelas::with('murids')->where('wali_kelas_id', $guru->id)->first();
        
        if (!$kelas) {
            return view('Guru.absensi', ['kelas' => null, 'absensiHariIni' => collect()]);
        }

        $tanggalHariIni = date('Y-m-d');
        
        // Ambil semua murid di kelas ini
        $murids = $kelas->murids;
        
        // Ambil absensi hari ini untuk kelas ini
        $absensiHariIni = Absensi::where('kelas_id', $kelas->id)
            ->where('tanggal', $tanggalHariIni)
            ->get()
            ->keyBy('user_id');
        
        // Siapkan data untuk view
        $dataMurid = [];
        foreach ($murids as $murid) {
            $absen = $absensiHariIni->get($murid->id);
            $dataMurid[] = (object) [
                'id' => $murid->id,
                'nama' => $murid->name,
                'nis' => $murid->murid->nis ?? '-',
                'status' => $absen ? $absen->status : 'belum',
                'waktu' => $absen ? $absen->waktu_absen->format('H:i:s') : '-',
            ];
        }
        
        return view('Guru.absensi', compact('kelas', 'dataMurid'));
    }
    
    // Optional: untuk mengubah status absensi (jika guru ingin mengedit)
    public function updateStatus(Request $request, $userId)
    {
        $request->validate([
            'status' => 'required|in:hadir,izin,sakit,alpha',
        ]);
        
        $guru = Auth::user();
        $kelas = Kelas::where('wali_kelas_id', $guru->id)->first();
        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelas.');
        }
        
        $absensi = Absensi::where('user_id', $userId)
            ->where('kelas_id', $kelas->id)
            ->where('tanggal', date('Y-m-d'))
            ->first();
            
        if ($absensi) {
            $absensi->update(['status' => $request->status]);
        } else {
            // Jika belum absen, buatkan dengan status manual
            Absensi::create([
                'user_id' => $userId,
                'kelas_id' => $kelas->id,
                'tanggal' => date('Y-m-d'),
                'waktu_absen' => now(),
                'status' => $request->status,
            ]);
        }
        
        return redirect()->back()->with('success', 'Status absensi diperbarui.');
    }
}
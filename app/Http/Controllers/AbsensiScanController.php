<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiScanController extends Controller
{
    public function scan(Request $request)
    {
        $kelas_id = $request->query('kelas_id');
        $token = $request->query('token');
        
        if (!$kelas_id || !$token) {
            return response()->json(['error' => 'QR Code tidak valid'], 400);
        }
        
        // Verifikasi token
        $secret = config('app.key');
        $currentTimestamp = floor(time() / 5) * 5;
        $expectedToken = hash_hmac('sha256', $kelas_id . $currentTimestamp, $secret);
        $prevTimestamp = $currentTimestamp - 5;
        $expectedPrevToken = hash_hmac('sha256', $kelas_id . $prevTimestamp, $secret);
        
        if (!hash_equals($expectedToken, $token) && !hash_equals($expectedPrevToken, $token)) {
            return response()->json(['error' => 'QR Code sudah kadaluarsa'], 400);
        }
        
        // Cek kelas
        $kelas = Kelas::find($kelas_id);
        if (!$kelas) {
            return response()->json(['error' => 'Kelas tidak ditemukan'], 404);
        }
        
        $user = Auth::user();
        if ($user->role !== 'murid') {
            return response()->json(['error' => 'Hanya murid yang dapat absen'], 403);
        }
        
        if ($user->kelas_id != $kelas_id) {
            return response()->json(['error' => 'Anda tidak terdaftar di kelas ini'], 403);
        }
        
        $today = date('Y-m-d');
        $existing = Absensi::where('user_id', $user->id)->where('tanggal', $today)->first();
        if ($existing) {
            return response()->json(['error' => 'Anda sudah melakukan absen hari ini'], 400);
        }
        
        Absensi::create([
            'user_id' => $user->id,
            'kelas_id' => $kelas_id,
            'tanggal' => $today,
            'waktu_absen' => now(),
            'status' => 'hadir',
        ]);
        
        return response()->json(['success' => 'Absensi berhasil dicatat']);
    }
}
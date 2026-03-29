<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function index()
    {
        $guru = Auth::user();
        $kelas = Kelas::where('wali_kelas_id', $guru->id)->first();
        
        if (!$kelas) {
            return view('Guru.qrcode', ['kelas' => null, 'qrData' => null]);
        }
        
        // Generate token untuk QR code (valid 5 detik)
        $secret = config('app.key');
        $timestamp = floor(time() / 5) * 5; // rounded to 5 seconds
        $token = hash_hmac('sha256', $kelas->id . $timestamp, $secret);
        
        $qrData = route('absensi.scan', ['kelas_id' => $kelas->id, 'token' => $token]);
        
        return view('Guru.qrcode', compact('kelas', 'qrData'));
    }
    
    // Endpoint untuk refresh QR via AJAX
    public function refresh(Request $request)
    {
        $guru = Auth::user();
        $kelas = Kelas::where('wali_kelas_id', $guru->id)->first();
        if (!$kelas) {
            return response()->json(['error' => 'Kelas tidak ditemukan'], 404);
        }
        
        $secret = config('app.key');
        $timestamp = floor(time() / 5) * 5;
        $token = hash_hmac('sha256', $kelas->id . $timestamp, $secret);
        $url = route('absensi.scan', ['kelas_id' => $kelas->id, 'token' => $token]);
        
        return response()->json(['url' => $url]);
    }
}
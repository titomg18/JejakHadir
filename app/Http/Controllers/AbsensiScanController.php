<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Kelas;
use App\Services\WhatsappService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiScanController extends Controller
{
    protected WhatsappService $whatsapp;

    public function __construct(WhatsappService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

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
            'user_id'     => $user->id,
            'kelas_id'    => $kelas_id,
            'tanggal'     => $today,
            'waktu_absen' => now(),
            'status'      => 'hadir',
        ]);

        // Kirim notifikasi WhatsApp ke orang tua
        $this->kirimNotifikasiOrangTua($user, $kelas);

        return response()->json(['success' => 'Absensi berhasil dicatat']);
    }

    /**
     * Kirim pesan WhatsApp ke nomor orang tua murid.
     */
    protected function kirimNotifikasiOrangTua($user, Kelas $kelas): void
    {
        // Load relasi murid jika belum ter-load
        $murid = $user->murid;

        if (!$murid || empty($murid->no_telp_orang_tua)) {
            return; // Lewati jika nomor orang tua tidak tersedia
        }

        $waktu     = now()->format('H:i');
        $tanggal   = now()->locale('id')->translatedFormat('l, d F Y');
        $namaKelas = $kelas->nama_kelas;

        $pesan = "✅ *Notifikasi Kehadiran JejakHadir*\n\n"
            . "Assalamu'alaikum Wr. Wb.\n\n"
            . "Kami ingin memberitahukan bahwa putra/putri Bapak/Ibu:\n\n"
            . "👤 *Nama*  : {$user->name}\n"
            . "🏫 *Kelas* : {$namaKelas}\n"
            . "📅 *Tanggal* : {$tanggal}\n"
            . "🕐 *Waktu Masuk* : {$waktu} WIB\n"
            . "📋 *Status* : ✅ *HADIR*\n\n"
            . "Terima kasih atas kepercayaan Bapak/Ibu.\n\n"
            . "_Pesan ini dikirim otomatis oleh sistem JejakHadir._";

        $this->whatsapp->kirimPesan($murid->no_telp_orang_tua, $pesan);
    }
}
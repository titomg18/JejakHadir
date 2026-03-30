<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappService
{
    protected string $token;
    protected string $apiUrl = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->token = config('services.fonnte.token', '');
    }

    /**
     * Kirim pesan WhatsApp ke nomor tujuan.
     *
     * @param  string  $nomorTujuan  Nomor HP (format 08xxx atau 628xxx)
     * @param  string  $pesan
     * @return bool
     */
    public function kirimPesan(string $nomorTujuan, string $pesan): bool
    {
        if (empty($this->token)) {
            Log::warning('WhatsApp: FONNTE_TOKEN belum dikonfigurasi di .env');
            return false;
        }

        $nomor = $this->formatNomor($nomorTujuan);

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token,
            ])->post($this->apiUrl, [
                'target'  => $nomor,
                'message' => $pesan,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['status']) && $data['status'] === true) {
                    Log::info("WhatsApp terkirim ke {$nomor}");
                    return true;
                }
                Log::warning("WhatsApp gagal ke {$nomor}: " . ($data['reason'] ?? 'Unknown error'));
                return false;
            }

            Log::error("WhatsApp HTTP error ke {$nomor}: " . $response->status());
            return false;

        } catch (\Exception $e) {
            Log::error("WhatsApp exception ke {$nomor}: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Format nomor HP ke format internasional Indonesia (628xxx).
     */
    protected function formatNomor(string $nomor): string
    {
        // Hapus karakter non-digit
        $nomor = preg_replace('/\D/', '', $nomor);

        // Konversi 08xxx → 628xxx
        if (str_starts_with($nomor, '08')) {
            return '62' . substr($nomor, 1);
        }

        // Konversi 8xxx → 628xxx
        if (str_starts_with($nomor, '8')) {
            return '62' . $nomor;
        }

        return $nomor;
    }
}
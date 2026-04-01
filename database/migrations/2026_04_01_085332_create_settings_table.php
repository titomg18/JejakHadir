<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed nilai default
        $defaults = [
            // Profil Sekolah
            ['key' => 'nama_sekolah',    'value' => 'SMA Negeri 1'],
            ['key' => 'alamat_sekolah',  'value' => 'Jl. Pendidikan No. 1'],
            ['key' => 'telp_sekolah',    'value' => '031-0000000'],
            ['key' => 'email_sekolah',   'value' => 'info@sekolah.sch.id'],
            ['key' => 'logo_sekolah',    'value' => null],

            // Jam Masuk
            ['key' => 'jam_masuk',       'value' => '07:00'],
            ['key' => 'toleransi_menit', 'value' => '15'],
            ['key' => 'jam_pulang',      'value' => '15:00'],

            // Notifikasi WA
            ['key' => 'notif_wa_aktif',  'value' => '1'],
            ['key' => 'notif_wa_template', 'value' => "✅ *Notifikasi Kehadiran {nama_sekolah}*\n\nAssalamu'alaikum Wr. Wb.\n\nKami ingin memberitahukan bahwa putra/putri Bapak/Ibu:\n\n👤 *Nama*  : {nama_murid}\n🏫 *Kelas* : {kelas}\n📅 *Tanggal* : {tanggal}\n🕐 *Waktu Masuk* : {waktu} WIB\n📋 *Status* : ✅ *HADIR*\n\nTerima kasih atas kepercayaan Bapak/Ibu.\n\n_Pesan ini dikirim otomatis oleh sistem JejakHadir._"],
        ];

        foreach ($defaults as $row) {
            DB::table('settings')->insert([
                'key'        => $row['key'],
                'value'      => $row['value'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
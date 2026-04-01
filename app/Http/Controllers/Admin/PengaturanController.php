<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HariLibur;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengaturanController extends Controller
{
    public function index()
    {
        $settings   = Setting::all()->pluck('value', 'key');
        $hariLibur  = HariLibur::orderBy('tanggal')->get();
        return view('Admin.pengaturan', compact('settings', 'hariLibur'));
    }

    // ── Profil Sekolah ───────────────────────────────────────────
    public function simpanProfil(Request $request)
    {
        $request->validate([
            'nama_sekolah'   => 'required|string|max:255',
            'alamat_sekolah' => 'nullable|string',
            'telp_sekolah'   => 'nullable|string|max:20',
            'email_sekolah'  => 'nullable|email|max:100',
            'logo_sekolah'   => 'nullable|image|max:2048',
        ]);

        Setting::set('nama_sekolah',   $request->nama_sekolah);
        Setting::set('alamat_sekolah', $request->alamat_sekolah);
        Setting::set('telp_sekolah',   $request->telp_sekolah);
        Setting::set('email_sekolah',  $request->email_sekolah);

        if ($request->hasFile('logo_sekolah')) {
            $path = $request->file('logo_sekolah')->store('logo', 'public');
            Setting::set('logo_sekolah', $path);
        }

        return back()->with('success_profil', 'Profil sekolah berhasil disimpan.');
    }

    // ── Jam Masuk ────────────────────────────────────────────────
    public function simpanJam(Request $request)
    {
        $request->validate([
            'jam_masuk'       => 'required|date_format:H:i',
            'toleransi_menit' => 'required|integer|min:0|max:60',
            'jam_pulang'      => 'required|date_format:H:i',
        ]);

        Setting::set('jam_masuk',       $request->jam_masuk);
        Setting::set('toleransi_menit', $request->toleransi_menit);
        Setting::set('jam_pulang',      $request->jam_pulang);

        return back()->with('success_jam', 'Pengaturan jam berhasil disimpan.');
    }

    // ── Hari Libur ───────────────────────────────────────────────
    public function tambahLibur(Request $request)
    {
        $request->validate([
            'tanggal'     => 'required|date|unique:hari_libur,tanggal',
            'keterangan'  => 'required|string|max:100',
        ]);

        HariLibur::create($request->only('tanggal', 'keterangan'));

        return back()->with('success_libur', 'Hari libur berhasil ditambahkan.');
    }

    public function hapusLibur($id)
    {
        HariLibur::findOrFail($id)->delete();
        return back()->with('success_libur', 'Hari libur berhasil dihapus.');
    }

    // ── Notifikasi WA ────────────────────────────────────────────
    public function simpanNotifWa(Request $request)
    {
        $request->validate([
            'notif_wa_template' => 'required|string',
        ]);

        Setting::set('notif_wa_aktif',    $request->has('notif_wa_aktif') ? '1' : '0');
        Setting::set('notif_wa_template', $request->notif_wa_template);

        return back()->with('success_wa', 'Pengaturan WhatsApp berhasil disimpan.');
    }
}
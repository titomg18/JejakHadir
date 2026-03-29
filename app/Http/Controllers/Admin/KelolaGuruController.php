<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Guru;

class KelolaGuruController extends Controller
{
    public function index()
    {
        // Ambil user dengan role guru beserta relasi guru
        $gurus = User::with('guru')->where('role', 'guru')->get();

        // Pastikan setiap guru memiliki record di tabel guru
        foreach ($gurus as $user) {
            if (!$user->guru) {
                Guru::create(['user_id' => $user->id]);
            }
        }

        // Reload dengan data yang sudah dipastikan ada
        $gurus = User::with('guru')->where('role', 'guru')->get();

        return view('Admin.kelola-guru', compact('gurus'));
    }
}
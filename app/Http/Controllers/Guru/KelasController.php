<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function index()
    {
        $guru = Auth::user();
        // Ambil kelas yang wali kelasnya adalah guru yang login, serta muat murid dan data pribadi murid
        $kelas = Kelas::with(['murids', 'murids.murid'])->where('wali_kelas_id', $guru->id)->get();
        
        return view('Guru.kelas', compact('kelas'));
    }
}
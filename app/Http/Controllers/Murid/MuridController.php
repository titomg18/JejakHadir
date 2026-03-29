<?php

namespace App\Http\Controllers\Murid;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;

class MuridController extends Controller
{
    public function dashboard()
    {
        return view('Murid.dashboard');
    }

    public function scan()
    {
        return view('Murid.scan');
    }

    public function history()
    {
        $histories = Absensi::where('user_id', Auth::id())->orderBy('tanggal', 'desc')->get();
        return view('Murid.history', compact('histories'));
    }

    public function profile()
    {
        return view('Murid.profile');
    }
}
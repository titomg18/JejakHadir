<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class KelolaMuridController extends Controller
{
    public function index()
    {
        // Ambil hanya user dengan role 'murid'
        $murids = User::where('role', 'murid')->get();
        return view('Admin.kelola-murid', compact('murids'));
    }
}
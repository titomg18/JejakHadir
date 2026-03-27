<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class KelolaGuruController extends Controller
{
    public function index()
    {
        // Only users with role 'guru'
        $gurus = User::where('role', 'guru')->get();
        return view('Admin.kelola-guru', compact('gurus'));
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Murid;

class KelolaMuridController extends Controller
{
    public function index()
    {
        // Get all murid users with their murid relation
        $murids = User::with('murid')->where('role', 'murid')->get();

        // Ensure each murid user has a Murid record
        foreach ($murids as $user) {
            if (!$user->murid) {
                Murid::create(['user_id' => $user->id]);
            }
        }

        // Reload the collection with the newly created records
        $murids = User::with('murid')->where('role', 'murid')->get();

        return view('Admin.kelola-murid', compact('murids'));
    }
}
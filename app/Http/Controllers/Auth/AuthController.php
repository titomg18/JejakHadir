<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Home page
    public function home()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return redirect($this->redirectTo($user));
        } else {
            return redirect('/login');
        }
    }

    // Tampilkan form login
    public function showLoginForm()
    {
        return view('Auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            $user = Auth::user();
            return redirect()->intended($this->redirectTo($user));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Tentukan redirect path berdasarkan role
    protected function redirectTo($user)
    {
        if ($user->role === 'admin') {
            return '/admin/dashboard';
        } elseif ($user->role === 'guru') {
            return '/guru/dashboard';
        } else {
            return '/murid/dashboard';
        }
    }
}
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// Halaman utama
Route::get('/', [AuthController::class, 'home'])->name('home');

// Halaman login & register (guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Logout (harus sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard berdasarkan role (dilindungi middleware auth dan role)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('Admin.dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    Route::get('/guru/dashboard', function () {
        return view('Guru.dashboard');
    })->middleware('role:guru')->name('guru.dashboard');

    Route::get('/murid/dashboard', function () {
        return view('Murid.dashboard');
    })->middleware('role:murid')->name('murid.dashboard');
});
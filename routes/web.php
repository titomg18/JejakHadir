<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\KelolaUserController;
use App\Http\Controllers\Admin\KelolaGuruController;

// Halaman utama
Route::get('/', [AuthController::class, 'home'])->name('home');

// Halaman login & register (guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Logout (harus sudah login)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard berdasarkan role (dilindungi middleware auth dan role)
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('Admin.dashboard');
    })->middleware('role:admin')->name('admin.dashboard');

    // Kelola Users
    Route::prefix('admin/users')->middleware('role:admin')->group(function () {
        Route::get('/', [KelolaUserController::class, 'index'])->name('admin.users');
        Route::get('/create', [KelolaUserController::class, 'create'])->name('admin.users.create');
        Route::post('/', [KelolaUserController::class, 'store'])->name('admin.users.store');
        Route::get('/{id}/edit', [KelolaUserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{id}', [KelolaUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/{id}', [KelolaUserController::class, 'destroy'])->name('admin.users.destroy');
    });

    // NEW: Kelola Guru (read-only)
    Route::get('/admin/guru', [App\Http\Controllers\Admin\KelolaGuruController::class, 'index'])
        ->middleware('role:admin')
        ->name('admin.guru');

    // Kelola Murid (read-only) - tambahkan ini
    Route::get('/admin/murid', [App\Http\Controllers\Admin\KelolaMuridController::class, 'index'])
        ->middleware('role:admin')
        ->name('admin.murid');

    Route::get('/guru/dashboard', function () {
        return view('Guru.dashboard');
    })->middleware('role:guru')->name('guru.dashboard');

    Route::get('/murid/dashboard', function () {
        return view('Murid.dashboard');
    })->middleware('role:murid')->name('murid.dashboard');
});
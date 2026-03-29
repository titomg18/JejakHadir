<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\KelolaUserController;
use App\Http\Controllers\Admin\KelolaGuruController;
use App\Http\Controllers\Admin\KelolaMuridController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Guru\KelasController as GuruKelasController;

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
    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('Admin.dashboard');
        })->name('admin.dashboard');

        // Kelola Users
        Route::prefix('admin/users')->group(function () {
            Route::get('/', [KelolaUserController::class, 'index'])->name('admin.users');
            Route::get('/create', [KelolaUserController::class, 'create'])->name('admin.users.create');
            Route::post('/', [KelolaUserController::class, 'store'])->name('admin.users.store');
            Route::get('/{id}/edit', [KelolaUserController::class, 'edit'])->name('admin.users.edit');
            Route::put('/{id}', [KelolaUserController::class, 'update'])->name('admin.users.update');
            Route::delete('/{id}', [KelolaUserController::class, 'destroy'])->name('admin.users.destroy');
        });

        // Kelola Guru (read-only)
        Route::get('/admin/guru', [KelolaGuruController::class, 'index'])->name('admin.guru');

        // Kelola Murid (read-only)
        Route::get('/admin/murid', [KelolaMuridController::class, 'index'])->name('admin.murid');

        // Kelola Kelas (CRUD)
        Route::prefix('admin/kelas')->group(function () {
            Route::get('/', [KelasController::class, 'index'])->name('admin.kelas');
            Route::post('/', [KelasController::class, 'store'])->name('admin.kelas.store');
            Route::put('/{id}', [KelasController::class, 'update'])->name('admin.kelas.update');
            Route::delete('/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');

            // Detail dan manajemen murid
            Route::get('/{id}', [KelasController::class, 'show'])->name('admin.kelas.detail');
            Route::post('/{id}/add-murid', [KelasController::class, 'addMurid'])->name('admin.kelas.addMurid');
            Route::delete('/{kelasId}/remove-murid/{muridId}', [KelasController::class, 'removeMurid'])->name('admin.kelas.removeMurid');
        });
    });

    // Guru routes
    Route::middleware('role:guru')->group(function () {
        Route::get('/guru/dashboard', function () {
            return view('Guru.dashboard');
        })->name('guru.dashboard');

        Route::get('/guru/kelas', [GuruKelasController::class, 'index'])->name('guru.kelas');
    });

    // Murid routes
    Route::middleware('role:murid')->group(function () {
        Route::get('/murid/dashboard', function () {
            return view('Murid.dashboard');
        })->name('murid.dashboard');
    });

    // Kelola Murid Detail (edit data pribadi)
    Route::prefix('admin/murid')->middleware('role:admin')->group(function () {
    Route::get('/{id}/edit', [App\Http\Controllers\Admin\KelolaMuridDetailController::class, 'edit'])->name('admin.murid.detail.edit');
    Route::put('/{id}', [App\Http\Controllers\Admin\KelolaMuridDetailController::class, 'update'])->name('admin.murid.detail.update');
    });

    // Kelola Guru Detail (edit data pribadi)
    Route::prefix('admin/guru')->middleware('role:admin')->group(function () {
        Route::put('/{id}', [App\Http\Controllers\Admin\KelolaGuruDetailController::class, 'update'])->name('admin.guru.detail.update');
    });
});
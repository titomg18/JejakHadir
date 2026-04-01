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

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard berdasarkan role
Route::middleware(['auth'])->group(function () {
    
    // ===================== ADMIN ROUTES =====================
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/admin/pengaturan', [App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('admin.pengaturan');
        Route::post('/admin/pengaturan/profil', [App\Http\Controllers\Admin\PengaturanController::class, 'simpanProfil'])->name('admin.pengaturan.profil');
        Route::post('/admin/pengaturan/jam', [App\Http\Controllers\Admin\PengaturanController::class, 'simpanJam'])->name('admin.pengaturan.jam');
        Route::post('/admin/pengaturan/libur', [App\Http\Controllers\Admin\PengaturanController::class, 'tambahLibur'])->name('admin.pengaturan.libur.tambah');
        Route::delete('/admin/pengaturan/libur/{id}', [App\Http\Controllers\Admin\PengaturanController::class, 'hapusLibur'])->name('admin.pengaturan.libur.hapus');
        Route::post('/admin/pengaturan/wa', [App\Http\Controllers\Admin\PengaturanController::class, 'simpanNotifWa'])->name('admin.pengaturan.wa');

        Route::get('/admin/laporan', [App\Http\Controllers\Admin\LaporanAbsensiController::class, 'index'])->name('admin.laporan');

        Route::prefix('admin/users')->group(function () {
            Route::get('/', [KelolaUserController::class, 'index'])->name('admin.users');
            Route::get('/create', [KelolaUserController::class, 'create'])->name('admin.users.create');
            Route::post('/', [KelolaUserController::class, 'store'])->name('admin.users.store');
            Route::get('/{id}/edit', [KelolaUserController::class, 'edit'])->name('admin.users.edit');
            Route::put('/{id}', [KelolaUserController::class, 'update'])->name('admin.users.update');
            Route::delete('/{id}', [KelolaUserController::class, 'destroy'])->name('admin.users.destroy');
        });

        Route::get('/admin/guru', [KelolaGuruController::class, 'index'])->name('admin.guru');
        Route::get('/admin/murid', [KelolaMuridController::class, 'index'])->name('admin.murid');

        Route::prefix('admin/kelas')->group(function () {
            Route::get('/', [KelasController::class, 'index'])->name('admin.kelas');
            Route::post('/', [KelasController::class, 'store'])->name('admin.kelas.store');
            Route::put('/{id}', [KelasController::class, 'update'])->name('admin.kelas.update');
            Route::delete('/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');
            Route::get('/{id}', [KelasController::class, 'show'])->name('admin.kelas.detail');
            Route::post('/{id}/add-murid', [KelasController::class, 'addMurid'])->name('admin.kelas.addMurid');
            Route::delete('/{kelasId}/remove-murid/{muridId}', [KelasController::class, 'removeMurid'])->name('admin.kelas.removeMurid');
        });

        // Detail murid & guru (edit data pribadi)
        Route::prefix('admin/murid')->group(function () {
            Route::get('/{id}/edit', [App\Http\Controllers\Admin\KelolaMuridDetailController::class, 'edit'])->name('admin.murid.detail.edit');
            Route::put('/{id}', [App\Http\Controllers\Admin\KelolaMuridDetailController::class, 'update'])->name('admin.murid.detail.update');
        });
        Route::prefix('admin/guru')->group(function () {
            Route::put('/{id}', [App\Http\Controllers\Admin\KelolaGuruDetailController::class, 'update'])->name('admin.guru.detail.update');
        });
    });

    // ===================== GURU ROUTES =====================
    Route::middleware('role:guru')->group(function () {
        Route::get('/guru/dashboard', [App\Http\Controllers\Guru\DashboardController::class, 'index'])->name('guru.dashboard');
        Route::get('/guru/kelas', [GuruKelasController::class, 'index'])->name('guru.kelas');
        Route::get('/guru/absensi', [App\Http\Controllers\Guru\AbsensiController::class, 'index'])->name('guru.absensi');
        Route::post('/guru/absensi/{userId}/update', [App\Http\Controllers\Guru\AbsensiController::class, 'updateStatus'])->name('guru.absensi.update');
        Route::get('/guru/qrcode', [App\Http\Controllers\Guru\QRCodeController::class, 'index'])->name('guru.qrcode');
        Route::get('/guru/qrcode/refresh', [App\Http\Controllers\Guru\QRCodeController::class, 'refresh'])->name('guru.qrcode.refresh');
    });

    // ===================== MURID ROUTES =====================
    Route::middleware('role:murid')->group(function () {
        Route::get('/murid/dashboard', [App\Http\Controllers\Murid\MuridController::class, 'dashboard'])->name('murid.dashboard');
        Route::get('/murid/scan', [App\Http\Controllers\Murid\MuridController::class, 'scan'])->name('murid.scan');
        Route::get('/murid/history', [App\Http\Controllers\Murid\MuridController::class, 'history'])->name('murid.history');
        Route::get('/murid/profile', [App\Http\Controllers\Murid\MuridController::class, 'profile'])->name('murid.profile');
        
        // Endpoint untuk scan QR (dipanggil saat murid melakukan scan)
        Route::get('/absensi/scan', [App\Http\Controllers\AbsensiScanController::class, 'scan'])->name('absensi.scan');
    });
});
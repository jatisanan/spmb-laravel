<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ============ PUBLIK ============
Route::get('/', [WelcomeController::class, 'index'])->name('landing');

Route::post('/daftar', [PendaftaranController::class, 'store'])->name('daftar.store');
Route::post('/cek-status', [PendaftaranController::class, 'cekStatus'])->name('cek-status');
Route::get('/gelombang/{jenjangId}', [PendaftaranController::class, 'getGelombang'])->name('gelombang.by-jenjang');

// ============ SETELAH LOGIN ============
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('student.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============ ADMIN ============
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // ---------- Pendaftaran ----------
        Route::get('/pendaftaran', [\App\Http\Controllers\Admin\PendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::get('/pendaftaran/export', [\App\Http\Controllers\Admin\PendaftaranController::class, 'export'])->name('pendaftaran.export');
        Route::get('/pendaftaran/{pendaftaran}', [\App\Http\Controllers\Admin\PendaftaranController::class, 'show'])->name('pendaftaran.show');
        Route::get('/pendaftaran/{pendaftaran}/edit', [\App\Http\Controllers\Admin\PendaftaranController::class, 'edit'])->name('pendaftaran.edit');
        Route::patch('/pendaftaran/{pendaftaran}', [\App\Http\Controllers\Admin\PendaftaranController::class, 'update'])->name('pendaftaran.update');
        Route::patch('/pendaftaran/{pendaftaran}/verifikasi', [\App\Http\Controllers\Admin\PendaftaranController::class, 'updateVerifikasi'])->name('pendaftaran.verifikasi');
        Route::patch('/pendaftaran/{pendaftaran}/ujian', [\App\Http\Controllers\Admin\PendaftaranController::class, 'updateUjian'])->name('pendaftaran.ujian');
        Route::patch('/pendaftaran/{pendaftaran}/kelulusan', [\App\Http\Controllers\Admin\PendaftaranController::class, 'updateKelulusan'])->name('pendaftaran.kelulusan');
        Route::patch('/pendaftaran/{pendaftaran}/daftar-ulang', [\App\Http\Controllers\Admin\PendaftaranController::class, 'updateDaftarUlang'])->name('pendaftaran.daftar-ulang');
        Route::delete('/pendaftaran/{pendaftaran}', [\App\Http\Controllers\Admin\PendaftaranController::class, 'destroy'])->name('pendaftaran.destroy');

        // ---------- Jenjang ----------
        Route::get('/jenjang', [\App\Http\Controllers\Admin\JenjangController::class, 'index'])->name('jenjang.index');
        Route::get('/jenjang/{jenjang}/edit', [\App\Http\Controllers\Admin\JenjangController::class, 'edit'])->name('jenjang.edit');
        Route::patch('/jenjang/{jenjang}', [\App\Http\Controllers\Admin\JenjangController::class, 'update'])->name('jenjang.update');
        Route::patch('/jenjang/{jenjang}/toggle', [\App\Http\Controllers\Admin\JenjangController::class, 'toggle'])->name('jenjang.toggle');

        // ---------- Gelombang ----------
        Route::post('/jenjang/{jenjang}/gelombang', [\App\Http\Controllers\Admin\GelombangController::class, 'store'])->name('gelombang.store');
        Route::patch('/gelombang/{gelombang}', [\App\Http\Controllers\Admin\GelombangController::class, 'update'])->name('gelombang.update');
        Route::patch('/gelombang/{gelombang}/toggle', [\App\Http\Controllers\Admin\GelombangController::class, 'toggle'])->name('gelombang.toggle');
        Route::delete('/gelombang/{gelombang}', [\App\Http\Controllers\Admin\GelombangController::class, 'destroy'])->name('gelombang.destroy');

        // ---------- Pengaturan Situs ----------
        Route::get('/pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::post('/pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'update'])->name('pengaturan.update');

        // ---------- Pengumuman ----------
        Route::get('/pengumuman', [\App\Http\Controllers\Admin\PengumumanController::class, 'index'])->name('pengumuman.index');
        Route::post('/pengumuman', [\App\Http\Controllers\Admin\PengumumanController::class, 'store'])->name('pengumuman.store');
        Route::patch('/pengumuman/{pengumuman}', [\App\Http\Controllers\Admin\PengumumanController::class, 'update'])->name('pengumuman.update');
        Route::patch('/pengumuman/{pengumuman}/toggle', [\App\Http\Controllers\Admin\PengumumanController::class, 'toggle'])->name('pengumuman.toggle');
        Route::delete('/pengumuman/{pengumuman}', [\App\Http\Controllers\Admin\PengumumanController::class, 'destroy'])->name('pengumuman.destroy');

        // ---------- Pengguna ----------
        Route::get('/pengguna', [\App\Http\Controllers\Admin\PenggunaController::class, 'index'])->name('pengguna.index');
        Route::get('/pengguna/{pengguna}', [\App\Http\Controllers\Admin\PenggunaController::class, 'show'])->name('pengguna.show');
        Route::patch('/pengguna/{pengguna}', [\App\Http\Controllers\Admin\PenggunaController::class, 'update'])->name('pengguna.update');
        Route::patch('/pengguna/{pengguna}/reset-password', [\App\Http\Controllers\Admin\PenggunaController::class, 'resetPassword'])->name('pengguna.reset-password');
        Route::patch('/pengguna/{pengguna}/toggle', [\App\Http\Controllers\Admin\PenggunaController::class, 'toggle'])->name('pengguna.toggle');
        Route::delete('/pengguna/{pengguna}', [\App\Http\Controllers\Admin\PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    });

// ============ STUDENT ============
Route::middleware(['auth', 'student'])
    ->prefix('santri')
    ->name('student.')
    ->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');

        // Download kartu ujian
        Route::get('/kartu/download', [\App\Http\Controllers\Student\KartuController::class, 'download'])->name('kartu.download');
    });

    
require __DIR__.'/auth.php';
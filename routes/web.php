<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\PenghuniController as AdminPenghuniController;
use App\Http\Controllers\Penghuni\LaporanController as PenghuniLaporanController;
use App\Http\Controllers\Penghuni\PembayaranController as PenghuniPembayaranController;
use App\Http\Controllers\ProfileController; // <--- PASTIKAN INI ADA DI PALING ATAS

// 1. Halaman Publik
Route::get('/', function () {
    return view('welcome');
});

// 2. Rute Profile (BAGIAN INI YANG KURANG)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. Rute Admin
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/kamar', [KamarController::class, 'index'])->name('admin.kamar.index');
    Route::post('/kamar', [KamarController::class, 'store'])->name('admin.kamar.store');
    Route::put('/kamar/{kamar}', [KamarController::class, 'update'])->name('admin.kamar.update');
    Route::patch('/pembayaran/{pembayaran}/verify', [AdminPembayaranController::class, 'verify'])->name('admin.pembayaran.verify');
    Route::patch('/laporan/{laporan}/complete', [AdminLaporanController::class, 'complete'])->name('admin.laporan.complete');
    Route::delete('/penghuni/{penghuni}', [AdminPenghuniController::class, 'destroy'])->name('admin.penghuni.destroy');
});

// 4. Rute Penghuni
Route::middleware(['auth', 'role:penghuni'])->prefix('penghuni')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return view('penghuni.dashboard', [
            'pembayaranBulanIni' => $user->pembayaranBulanIni,
            'laporanAktif' => $user->laporanAktif()->latest()->get(),
            'laporanTerkirim' => $user->laporans()->count(),
            'nominalTagihan' => 1900000,
        ]);
    })->name('penghuni.dashboard');

    Route::post('/pembayaran', [PenghuniPembayaranController::class, 'store'])->name('penghuni.pembayaran.store');
    Route::post('/laporan', [PenghuniLaporanController::class, 'store'])->name('penghuni.laporan.store');
});

// 5. Rute Autentikasi
require __DIR__.'/auth.php';

// Rute Jembatan (Fix untuk error sebelumnya)
Route::get('/dashboard', function () {
    return auth()->user()->role === 'admin' 
        ? redirect()->route('admin.dashboard') 
        : redirect()->route('penghuni.dashboard');
})->middleware(['auth'])->name('dashboard');

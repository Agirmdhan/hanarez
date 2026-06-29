<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KamarController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\PembayaranController as AdminPembayaranController;
use App\Http\Controllers\Admin\PenghuniController as AdminPenghuniController;
use App\Http\Controllers\Penghuni\LaporanController as PenghuniLaporanController;
use App\Http\Controllers\Penghuni\PembayaranController as PenghuniPembayaranController;
use App\Http\Controllers\ProfileController;
use App\Models\Kamar;

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Schema::hasTable('kamars')) {
        \App\Models\Kamar::ensureDefaultRooms();

        $kamars = Kamar::query()
            ->orderByRaw("CAST(nomor_kamar AS UNSIGNED), nomor_kamar")
            ->get();
    } else {
        $kamars = collect();
    }

    return view('welcome', compact('kamars'));
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
    Route::patch('/penghuni/{penghuni}/remind', [AdminDashboardController::class, 'remind'])->name('admin.penghuni.remind');

    Route::get('/kamar', [KamarController::class, 'index'])->name('admin.kamar.index');
    Route::post('/kamar', [KamarController::class, 'store'])->name('admin.kamar.store');
    Route::put('/kamar/{kamar}', [KamarController::class, 'update'])->name('admin.kamar.update');
    Route::patch('/pembayaran/{pembayaran}/verify', [AdminPembayaranController::class, 'verify'])->name('admin.pembayaran.verify');
    Route::patch('/pembayaran/{pembayaran}/reject', [AdminPembayaranController::class, 'reject'])->name('admin.pembayaran.reject');
    Route::patch('/laporan/{laporan}/complete', [AdminLaporanController::class, 'complete'])->name('admin.laporan.complete');
    Route::delete('/penghuni/{penghuni}', [AdminPenghuniController::class, 'destroy'])->name('admin.penghuni.destroy');
});

// 4. Rute Penghuni
Route::middleware(['auth', 'role:penghuni'])->prefix('penghuni')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // Cari tagihan aktif = pembayaran status 'menunggu' terbaru
        // Bisa dari bulan ini (aktivasi) atau bulan depan (setelah remind)
        $tagihanAktif = $user->pembayarans()
            ->where('status', 'menunggu')
            ->orderByDesc('bulan')
            ->first();

        // Jika ada tagihan aktif, pakai itu sebagai pembayaran yang ditampilkan
        // Jika tidak ada, pakai pembayaran bulan ini (mungkin lunas)
        $pembayaranBulanIni = $tagihanAktif ?? $user->pembayaranBulanIni;

        return view('penghuni.dashboard', [
            'pembayaranBulanIni' => $pembayaranBulanIni,
            'tagihanAktif' => $tagihanAktif,
            'laporanAktif' => $user->laporanAktif()->latest()->get(),
            'laporanTerkirim' => $user->laporans()->count(),
            'nominalTagihan' => 1900000,
        ]);
    })->name('penghuni.dashboard');

    Route::get('/pembayaran/pending', function () {
        return view('penghuni.pembayaran-awal');
    })->name('penghuni.pembayaran.pending');

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

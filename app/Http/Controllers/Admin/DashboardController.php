<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Laporan;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        Kamar::ensureDefaultRooms();

        $currentMonth = now()->format('Y-m');
        $kamars = Kamar::with([
            'penghuni.pembayaranBulanIni',
            'penghuni.laporanAktif' => fn ($query) => $query->latest(),
        ])
            ->orderBy('nomor_kamar')
            ->get();

        return view('admin.dashboard', [
            'kamars' => $kamars,
            'totalKamar' => 6,
            'totalPenghuni' => User::where('role', 'penghuni')->count(),
            'pembayaranMenunggu' => Pembayaran::where('bulan', $currentMonth)
                ->where('status', 'menunggu')
                ->count(),
            'keluhanAktif' => Laporan::where('status', 'aktif')->count(),
        ]);
    }
}

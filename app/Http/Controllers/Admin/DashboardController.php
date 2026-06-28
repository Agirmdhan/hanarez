<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Laporan;
use App\Models\Pembayaran;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function remind(User $penghuni): RedirectResponse
    {
        if ($penghuni->role !== 'penghuni' || $penghuni->status_pendaftaran !== 'aktif') {
            return back()->withErrors(['penghuni' => 'Penghuni tidak valid untuk diingatkan.']);
        }

        $targetMonth = now()->format('Y-m');

        $currentMonthPembayaran = Pembayaran::where('id_user', $penghuni->id_user)
            ->where('bulan', $targetMonth)
            ->first();

        if ($currentMonthPembayaran && $currentMonthPembayaran->status === 'lunas') {
            $targetMonth = now()->addMonth()->format('Y-m');
        }

        $pembayaran = Pembayaran::firstOrNew([
            'id_user' => $penghuni->id_user,
            'bulan' => $targetMonth,
        ]);

        if (! $pembayaran->exists || $pembayaran->status !== 'lunas') {
            $pembayaran->status = 'menunggu';
            $pembayaran->save();
        }

        $penghuni->update([
            'payment_deadline' => now()->addDays(3),
        ]);

        return back()->with('success', 'Tagihan bulan baru sudah dibuat. Status pembayaran direset menjadi menunggu dan bukti pembayaran dihapus.');
    }

    public function index(): View
    {
        Kamar::ensureDefaultRooms();

        $currentMonth = now()->format('Y-m');
        $kamars = Kamar::with([
            'penghuni.pembayaranBulanIni',
            'penghuni.pembayarans' => fn ($query) => $query->orderByDesc('bulan'),
            'penghuni.laporanAktif' => fn ($query) => $query->latest(),
        ])
            ->orderBy('nomor_kamar')
            ->get();

        $pendingUsers = Schema::hasColumn('users', 'status_pendaftaran')
            ? User::with(['kamar', 'pembayaranBulanIni'])
                ->where('role', 'penghuni')
                ->where('status_pendaftaran', 'pending')
                ->orderBy('payment_deadline')
                ->get()
            : collect();

        return view('admin.dashboard', [
            'kamars' => $kamars,
            'pendingUsers' => $pendingUsers,
            'totalKamar' => 6,
            'totalPenghuni' => Schema::hasColumn('users', 'status_pendaftaran')
                ? User::where('role', 'penghuni')->where('status_pendaftaran', 'aktif')->count()
                : User::where('role', 'penghuni')->count(),
            'pembayaranMenunggu' => Pembayaran::where('bulan', $currentMonth)
                ->where('status', 'menunggu')
                ->count(),
            'keluhanAktif' => Laporan::where('status', 'aktif')->count(),
        ]);
    }
}

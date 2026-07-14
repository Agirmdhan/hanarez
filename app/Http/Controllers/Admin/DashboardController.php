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

        // Mulai dari bulan ini
        $targetMonth = now()->format('Y-m');

        // Cari bulan yang belum ada tagihan lunas (maju terus sampai ketemu)
        for ($attempts = 0; $attempts < 12; $attempts++) {
            $existing = Pembayaran::where('id_user', $penghuni->id_user)
                ->where('bulan', $targetMonth)
                ->first();

            if (! $existing || $existing->status !== 'lunas') {
                break;
            }

            // Kalau bulan ini sudah lunas, lanjut ke bulan berikutnya
            $targetMonth = date('Y-m', strtotime($targetMonth . '-01 +1 month'));
        }

        // Buat atau set status menunggu untuk bulan target
        $pembayaran = Pembayaran::firstOrNew([
            'id_user' => $penghuni->id_user,
            'bulan' => $targetMonth,
        ]);

        if (! $pembayaran->exists || $pembayaran->status !== 'lunas') {
            $pembayaran->nominal = 1900000;
            $pembayaran->status = 'menunggu';
            $pembayaran->verified_at = null;
            $pembayaran->save();
        }

        $penghuni->update([
            'payment_deadline' => now()->addDays(3),
        ]);

        return back()->with('success', 'Tagihan bulan baru (' . $targetMonth . ') sudah dibuat.');
    }

    public function index(): View
    {
        Kamar::ensureDefaultRooms();

        $currentMonth = now()->format('Y-m');
        $kamars = Kamar::with([
            'penghuni.pembayaranTagihanAktif',
            'penghuni.pembayaranBulanIni',
            'penghuni.pembayarans' => fn ($query) => $query->orderByDesc('bulan'),
            'penghuni.laporans' => fn ($query) => $query->latest(),
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

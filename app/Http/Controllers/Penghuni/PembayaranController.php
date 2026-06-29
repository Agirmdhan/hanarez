<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Kamar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'bukti_pembayaran' => ['required', 'image', 'mimes:png', 'max:2048'],
        ]);

        $user = $request->user();

        if ($user->status_pendaftaran === 'pending' && $user->payment_deadline && now()->gt($user->payment_deadline)) {
            return back()->withErrors([
                'bukti_pembayaran' => 'Waktu pembayaran sudah habis. Silakan daftar ulang.',
            ]);
        }

        $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

        DB::transaction(function () use ($request, $user, $path) {
            // Cari tagihan yang masih menunggu (bisa dari remind bulan ini/bulan depan)
            $tagihanMenunggu = Pembayaran::where('id_user', $user->id_user)
                ->where('status', 'menunggu')
                ->latest('bulan')
                ->first();

            if ($tagihanMenunggu) {
                // Update tagihan yang sudah ada dengan bukti pembayaran
                $tagihanMenunggu->update([
                    'bukti_pembayaran' => $path,
                ]);
            } else {
                // Tidak ada tagihan menunggu, buat baru di bulan ini
                Pembayaran::create([
                    'id_user' => $user->id_user,
                    'bulan' => now()->format('Y-m'),
                    'bukti_pembayaran' => $path,
                    'status' => 'menunggu',
                ]);
            }

            // User stays in pending status until admin verifies
            // No automatic status change here
        });

        return redirect()
            ->route('penghuni.dashboard')
            ->with('success', 'Bukti pembayaran berhasil dikirim. Silakan tunggu admin memverifikasi pembayaran Anda.');
    }
}

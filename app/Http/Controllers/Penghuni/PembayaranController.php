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
            Pembayaran::updateOrCreate(
                [
                    'id_user' => $user->id_user,
                    'bulan' => now()->format('Y-m'),
                ],
                [
                    'bukti_pembayaran' => $path,
                    'status' => 'menunggu',
                ],
            );

            if ($user->status_pendaftaran === 'pending') {
                $user->update([
                    'status_pendaftaran' => 'aktif',
                    'payment_completed_at' => now(),
                ]);

                Kamar::where('id_kamar', $user->id_kamar)->update([
                    'status' => 'Terisi',
                ]);
            }
        });

        return redirect()
            ->route('penghuni.dashboard')
            ->with('success', 'Bukti pembayaran berhasil dikirim dan status calon penghuni sudah diaktifkan.');
    }
}

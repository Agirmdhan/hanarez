<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'bukti_pembayaran' => ['required', 'image', 'mimes:png', 'max:2048'],
        ]);

        $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');

        Pembayaran::updateOrCreate(
            [
                'id_user' => $request->user()->id_user,
                'bulan' => now()->format('Y-m'),
            ],
            [
                'bukti_pembayaran' => $path,
                'status' => 'menunggu',
            ],
        );

        return redirect()
            ->route('penghuni.dashboard')
            ->with('success', 'Bukti pembayaran berhasil dikirim dan menunggu verifikasi admin.');
    }
}

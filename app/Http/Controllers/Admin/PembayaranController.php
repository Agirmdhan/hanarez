<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Pembayaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    public function verify(Pembayaran $pembayaran): RedirectResponse
    {
        DB::transaction(function () use ($pembayaran) {
            $pembayaran->update(['status' => 'lunas']);

            $user = $pembayaran->user;

            if ($user) {
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
            ->route('admin.dashboard')
            ->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function reject(Pembayaran $pembayaran): RedirectResponse
    {
        DB::transaction(function () use ($pembayaran) {
            $user = $pembayaran->user;

            if ($user) {
                $kamarId = $user->id_kamar;

                $pembayaran->delete();
                $user->delete();

                Kamar::where('id_kamar', $kamarId)->update([
                    'status' => 'Tersedia',
                ]);
            } else {
                $pembayaran->delete();
            }
        });

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Calon penghuni berhasil ditolak dan datanya dihapus.');
    }
}

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
        $user = $pembayaran->user;

        if ($user?->status_pendaftaran === 'pending' && ! $user->syarat_ketentuan) {
            return redirect()
                ->route('admin.dashboard')
                ->with('error', 'Dokumen syarat dan ketentuan belum diunggah.');
        }

        DB::transaction(function () use ($pembayaran) {
            $pembayaran->update([
                'status' => 'lunas',
                'verified_at' => now(),
            ]);

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
        $user = $pembayaran->user;

        if (! $user) {
            $pembayaran->delete();
            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Pembayaran berhasil ditolak.');
        }

        // Penghuni aktif (sudah pernah verifikasi) → jangan hapus akun, reset tagihan saja
        if ($user->status_pendaftaran === 'aktif') {
            DB::transaction(function () use ($pembayaran, $user) {
                // Reset tagihan: hapus bukti, kembalikan ke status menunggu
                $pembayaran->update([
                    'bukti_pembayaran' => null,
                    'status' => 'menunggu',
                    'verified_at' => null,
                ]);
            });

            // Kirim peringatan ke akun penghuni via session (akan terbaca saat user akses dashboard)
            session()->flash('peringatan_tolak_' . $user->id_user, 'Pembayaran Anda ditolak. Silakan upload ulang bukti pembayaran yang benar.');

            return redirect()
                ->route('admin.dashboard')
                ->with('success', 'Pembayaran ' . $user->name . ' ditolak. Tagihan direset, silakan hubungi penghuni untuk upload ulang.');
        }

        // Calon penghuni (pending) → hapus semua datanya
        DB::transaction(function () use ($pembayaran, $user) {
            $kamarId = $user->id_kamar;

            $pembayaran->delete();
            $user->delete();

            Kamar::where('id_kamar', $kamarId)->update([
                'status' => 'Tersedia',
            ]);
        });

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Calon penghuni berhasil ditolak dan datanya dihapus.');
    }
}

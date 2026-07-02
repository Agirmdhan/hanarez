<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Kamar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\File;

class PembayaranController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $isInitialPayment = $user->status_pendaftaran === 'pending';

        $request->validate([
            'bukti_pembayaran' => ['required', 'image', 'mimes:png', 'max:2048'],
            'syarat_ketentuan' => [
                $user->status_pendaftaran === 'pending' && ! $user->syarat_ketentuan ? 'required' : 'nullable',
                File::types(['pdf', 'doc', 'docx'])->max(5 * 1024),
            ],
        ], [
            'syarat_ketentuan.required' => 'Dokumen syarat dan ketentuan yang sudah diisi wajib diunggah.',
            'syarat_ketentuan.max' => 'Ukuran dokumen syarat dan ketentuan maksimal 5 MB.',
        ]);

        if ($user->status_pendaftaran === 'pending' && $user->payment_deadline && now()->gt($user->payment_deadline)) {
            return back()->withErrors([
                'bukti_pembayaran' => 'Waktu pembayaran sudah habis. Silakan daftar ulang.',
            ]);
        }

        $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');
        $syaratKetentuanPath = $request->file('syarat_ketentuan')
            ?->store('syarat-ketentuan', 'public');

        DB::transaction(function () use ($user, $path, $syaratKetentuanPath) {
            if ($syaratKetentuanPath) {
                $user->update(['syarat_ketentuan' => $syaratKetentuanPath]);
            }

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
                    'nominal' => 1900000,
                    'bukti_pembayaran' => $path,
                    'status' => 'menunggu',
                ]);
            }

            // User stays in pending status until admin verifies
            // No automatic status change here
        });

        if (! $isInitialPayment) {
            return redirect()
                ->route('penghuni.riwayat-tagihan.index')
                ->with('success', 'Bukti pembayaran berhasil dikirim dan sedang menunggu verifikasi admin.');
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('status', 'Bukti pembayaran dan dokumen syarat & ketentuan berhasil dikirim. Silakan tunggu verifikasi admin sebelum masuk kembali.');
    }
}

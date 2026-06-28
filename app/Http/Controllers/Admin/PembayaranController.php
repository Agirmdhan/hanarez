<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\RedirectResponse;

class PembayaranController extends Controller
{
    public function verify(Pembayaran $pembayaran): RedirectResponse
    {
        $pembayaran->update(['status' => 'lunas']);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Pembayaran berhasil diverifikasi.');
    }
}

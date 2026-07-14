<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;

class LaporanController extends Controller
{
    public function proses(Laporan $laporan): RedirectResponse
    {
        if ($laporan->status === 'aktif') {
            $laporan->update(['status' => 'proses']);
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Laporan ditandai sedang diproses.');
    }

    public function selesai(Laporan $laporan): RedirectResponse
    {
        $laporan->update(['status' => 'selesai']);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Laporan berhasil ditandai selesai.');
    }

    public function batalkan(Laporan $laporan): RedirectResponse
    {
        $laporan->update(['status' => 'dibatalkan']);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Laporan dibatalkan (bukti fiktif/ditolak).');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;

class LaporanController extends Controller
{
    public function complete(Laporan $laporan): RedirectResponse
    {
        $laporan->update(['status' => 'selesai']);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Keluhan berhasil ditandai selesai.');
    }
}

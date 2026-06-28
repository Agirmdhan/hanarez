<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
        ]);

        if (! $request->user()->id_kamar) {
            return back()->withErrors(['judul' => 'Akun ini belum memiliki kamar.']);
        }

        Laporan::create([
            'id_user' => $request->user()->id_user,
            'id_kamar' => $request->user()->id_kamar,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status' => 'aktif',
        ]);

        return redirect()
            ->route('penghuni.dashboard')
            ->with('success', 'Laporan berhasil dikirim.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;

class KamarController extends Controller
{
    public function index()
    {
        $kamar = Kamar::all();
        return view('admin.kamar.index', compact('kamar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|unique:kamars,nomor_kamar',
            'tipe' => 'required',
            'harga' => 'required|numeric',
        ]);

    \App\Models\Kamar::create([
        'nomor_kamar' => $request->nomor_kamar,
        'tipe' => $request->tipe,
        'harga' => $request->harga,
        'status' => 'Tersedia', // Default saat buat kamar baru
    ]);

    return redirect()->route('admin.kamar.index')->with('success', 'Kamar berhasil ditambahkan.');
}

    public function update(Request $request, Kamar $kamar)
    {
        $kamar->update($request->all());
        return redirect()->route('admin.kamar.index')->with('success', 'Status kamar diperbarui.');
    }
}
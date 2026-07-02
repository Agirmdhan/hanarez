<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriKamar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GaleriController extends Controller
{
    public function index(): View
    {
        $galeri = GaleriKamar::with('user')->latest()->get();
        return view('admin.galeri.index', compact('galeri'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string|max:500',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data['gambar'] = $request->file('gambar')->store('galeri', 'public');
        $data['id_user'] = auth()->id();

        GaleriKamar::create($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Gambar berhasil ditambahkan.');
    }

    public function destroy(GaleriKamar $galeri): RedirectResponse
    {
        Storage::disk('public')->delete($galeri->gambar);
        $galeri->delete();

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Gambar berhasil dihapus.');
    }
}
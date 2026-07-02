<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\View\View;

class PengumumanController extends Controller
{
    public function index(): View
    {
        $pengumumen = Pengumuman::aktif()
            ->with('user')
            ->latest()
            ->get();

        return view('penghuni.pengumuman.index', compact('pengumumen'));
    }
}
<?php

namespace App\Http\Controllers\Penghuni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RiwayatTagihanController extends Controller
{
    public function index(Request $request): View
    {
        $records = $request->user()
            ->pembayarans()
            ->orderByDesc('bulan')
            ->orderByDesc('created_at')
            ->get();

        return view('penghuni.riwayat-tagihan.index', [
            'records' => $records,
            'totalLunas' => $records->where('status', 'lunas')->sum('nominal'),
            'totalMenunggu' => $records->where('status', 'menunggu')->sum('nominal'),
        ]);
    }
}

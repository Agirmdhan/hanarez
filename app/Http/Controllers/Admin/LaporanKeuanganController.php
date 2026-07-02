<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request): View
    {
        $bulan = $this->validBulan($request);
        $records = $this->laporanQuery($bulan)->get();

        return view('admin.laporan-keuangan.index', [
            'records' => $records,
            'bulan' => $bulan,
            'totalLunas' => $records->where('status', 'lunas')->sum('nominal'),
            'totalMenunggu' => $records->where('status', 'menunggu')->sum('nominal'),
            'jumlahLunas' => $records->where('status', 'lunas')->count(),
        ]);
    }

    public function cetak(Request $request): View
    {
        $bulan = $this->validBulan($request);
        $records = $this->laporanQuery($bulan)->get();

        return view('admin.laporan-keuangan.cetak', [
            'records' => $records,
            'bulan' => $bulan,
            'totalLunas' => $records->where('status', 'lunas')->sum('nominal'),
            'totalMenunggu' => $records->where('status', 'menunggu')->sum('nominal'),
            'jumlahLunas' => $records->where('status', 'lunas')->count(),
        ]);
    }

    private function laporanQuery(string $bulan): Builder
    {
        return Pembayaran::with(['user.kamar'])
            ->when($bulan !== '', fn (Builder $query) => $query->where('bulan', $bulan))
            ->orderByDesc('bulan')
            ->orderByDesc('created_at');
    }

    private function validBulan(Request $request): string
    {
        $bulan = $request->string('bulan')->toString();

        return preg_match('/^\d{4}-\d{2}$/', $bulan) ? $bulan : '';
    }
}

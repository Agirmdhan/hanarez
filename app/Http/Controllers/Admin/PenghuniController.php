<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class PenghuniController extends Controller
{
    public function destroy(User $penghuni): RedirectResponse
    {
        if ($penghuni->role !== 'penghuni') {
            abort(404);
        }

        $kamar = $penghuni->kamar;
        $penghuni->delete();

        if ($kamar) {
            $kamar->update(['status' => 'Tersedia']);
        }

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'Data penghuni berhasil dihapus dan kamar dikosongkan.');
    }
}

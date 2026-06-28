<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $selectedKamarId = $request->query('kamar');
        $kamars = Kamar::query()
            ->where('status', 'Tersedia')
            ->orderByRaw("CAST(nomor_kamar AS UNSIGNED), nomor_kamar")
            ->get();

        return view('auth.register', compact('kamars', 'selectedKamarId'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        Kamar::ensureDefaultRooms();

        if (User::where('role', 'penghuni')->count() >= 6) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['email' => 'Kamar sudah penuh. Maksimal hanya 6 penghuni yang bisa terdaftar.']);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'kamar_id' => ['required', 'exists:kamars,id_kamar'],
        ]);

        $kamar = Kamar::where('id_kamar', $request->kamar_id)
            ->where('status', 'Tersedia')
            ->first();

        if (! $kamar) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['kamar_id' => 'Kamar yang dipilih sudah tidak tersedia.']);
        }

        $user = User::create([
            'name' => $request->name,
            'id_kamar' => $kamar->id_kamar,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'penghuni',
            'status' => 'aktif',
        ]);

        $kamar->update(['status' => 'Terisi']);

        event(new Registered($user));

        return redirect()
            ->route('login')
            ->with('status', 'Registrasi berhasil. Silakan login dengan akun yang baru dibuat.');
    }
}

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
    public function create(): View
    {
        return view('auth.register');
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
        ]);

        $occupiedRoomIds = User::whereNotNull('id_kamar')->pluck('id_kamar');

        $kamar = Kamar::whereNotIn('id_kamar', $occupiedRoomIds)
            ->orderBy('nomor_kamar')
            ->first();

        if (! $kamar) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['email' => 'Semua kamar sudah terisi.']);
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

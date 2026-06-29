<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
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
        if (Schema::hasTable('kamars')) {
            Kamar::ensureDefaultRooms();
        }

        if (Schema::hasTable('kamars') && User::where('role', 'penghuni')->where('status_pendaftaran', 'aktif')->count() >= 6) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['email' => 'Kamar aktif sudah penuh.']);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'kamar_id' => ['nullable', 'exists:kamars,id_kamar'],
        ]);

        $kamar = null;

        if ($request->filled('kamar_id')) {
            $kamar = Kamar::where('id_kamar', $request->kamar_id)
                ->where('status', 'Tersedia')
                ->first();
        } elseif (Schema::hasTable('kamars')) {
            $occupiedRoomIds = User::whereNotNull('id_kamar')->pluck('id_kamar')->all();

            $kamar = Kamar::where('status', 'Tersedia')
                ->whereNotIn('id_kamar', $occupiedRoomIds)
                ->orderByRaw("CAST(nomor_kamar AS UNSIGNED), nomor_kamar")
                ->first();
        }

        if (! $kamar) {
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->withErrors(['email' => 'Kamar yang dipilih sudah tidak tersedia.']);
        }

        DB::transaction(function () use ($request, $kamar) {
            $user = User::create([
                'name' => $request->name,
                'id_kamar' => $kamar->id_kamar,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'penghuni',
                'status' => 'aktif',
                'status_pendaftaran' => 'pending',
                'payment_deadline' => now()->addMinutes(5),
            ]);

            event(new Registered($user));

            // Auto login user after registration
            Auth::login($user);
        });

        return redirect()
            ->route('penghuni.pembayaran.pending')
            ->with('status', 'Registrasi berhasil. Silakan lakukan pembayaran awal untuk mengkonfirmasi keikutsertaan Anda.');
    }
}

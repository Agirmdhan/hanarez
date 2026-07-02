<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Perbarui informasi akun dan data diri Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @if ($user->role === 'penghuni')
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-base font-medium text-gray-900">Data Penghuni</h3>
                <p class="mt-1 text-sm text-gray-600">Lengkapi data berikut sesuai identitas Anda.</p>
            </div>

            <div>
                <x-input-label for="nik" value="NIK" />
                <x-text-input id="nik" name="nik" type="text" inputmode="numeric" maxlength="16" class="mt-1 block w-full" :value="old('nik', $user->penghuni?->nik)" required autocomplete="off" />
                <x-input-error class="mt-2" :messages="$errors->get('nik')" />
            </div>

            <div>
                <x-input-label for="no_telepon" value="Nomor Telepon" />
                <x-text-input id="no_telepon" name="no_telepon" type="tel" inputmode="numeric" maxlength="15" class="mt-1 block w-full" :value="old('no_telepon', $user->penghuni?->no_telepon)" required autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('no_telepon')" />
            </div>

            <div>
                <x-input-label for="alamat" value="Alamat" />
                <textarea id="alamat" name="alamat" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('alamat', $user->penghuni?->alamat) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
            </div>

            <div>
                <x-input-label for="kontak_darurat" value="Kontak Darurat" />
                <x-text-input id="kontak_darurat" name="kontak_darurat" type="tel" inputmode="numeric" maxlength="15" class="mt-1 block w-full" :value="old('kontak_darurat', $user->penghuni?->kontak_darurat)" autocomplete="tel" />
                <p class="mt-1 text-xs text-gray-500">Opsional. Masukkan nomor keluarga atau wali yang dapat dihubungi.</p>
                <x-input-error class="mt-2" :messages="$errors->get('kontak_darurat')" />
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>Simpan Profil</x-primary-button>
        </div>
    </form>
</section>

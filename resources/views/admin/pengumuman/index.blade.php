<x-admin-layout>
    <x-slot name="header">
        Kelola Pengumuman
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-md bg-green-100 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                {{-- Form Buat Pengumuman --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow">
                        <div class="border-b border-gray-200 p-5">
                            <h3 class="text-lg font-semibold text-gray-900">Buat Pengumuman Baru</h3>
                        </div>
                        <div class="p-5">
                            <form method="POST" action="{{ route('admin.pengumuman.store') }}">
                                @csrf
                                <div class="mb-4">
                                    <label for="judul" class="block text-sm font-medium text-gray-700">Judul</label>
                                    <input id="judul" name="judul" type="text" value="{{ old('judul') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                        required>
                                    @error('judul')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="konten" class="block text-sm font-medium text-gray-700">Konten</label>
                                    <textarea id="konten" name="konten" rows="4"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                                        required>{{ old('konten') }}</textarea>
                                    @error('konten')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="tanggal_expired" class="block text-sm font-medium text-gray-700">
                                        Tanggal Kadaluarsa <span class="text-gray-400 font-normal">(opsional)</span>
                                    </label>
                                    <input id="tanggal_expired" name="tanggal_expired" type="date" value="{{ old('tanggal_expired') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    <p class="mt-1 text-xs text-gray-500">Pengumuman akan otomatis hilang setelah tanggal ini.</p>
                                    @error('tanggal_expired')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit"
                                    class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                                    Simpan Pengumuman
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Daftar Pengumuman --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow">
                        <div class="border-b border-gray-200 p-5">
                            <h3 class="text-lg font-semibold text-gray-900">Daftar Pengumuman Aktif</h3>
                            <p class="mt-1 text-sm text-gray-500">Pengumuman yang masih berlaku dan akan tampil di dashboard penghuni.</p>
                        </div>
                        <div class="p-5 space-y-4">
                            @forelse ($pengumumen as $pengumuman)
                                <div class="rounded-md border border-gray-200 bg-gray-50 p-4">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1">
                                            <h4 class="font-semibold text-gray-900">{{ $pengumuman->judul }}</h4>
                                            <p class="mt-1 text-sm text-gray-600 whitespace-pre-line">{{ $pengumuman->konten }}</p>
                                            <div class="mt-2 flex flex-wrap gap-3 text-xs text-gray-500">
                                                <span>Dibuat oleh: {{ $pengumuman->user?->name ?? 'Admin' }}</span>
                                                <span>{{ $pengumuman->created_at->format('d M Y H:i') }}</span>
                                                @if ($pengumuman->tanggal_expired)
                                                    <span class="text-amber-600">Kadaluarsa: {{ $pengumuman->tanggal_expired->format('d M Y') }}</span>
                                                @else
                                                    <span class="text-green-600">Tanpa batas waktu</span>
                                                @endif
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('admin.pengumuman.destroy', $pengumuman) }}"
                                            onsubmit="return confirm('Hapus pengumuman ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="rounded bg-red-600 px-3 py-1 text-xs font-semibold text-white hover:bg-red-700">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-gray-500">Belum ada pengumuman.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Link kembali ke dashboard --}}
            <div class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                    &larr; Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>

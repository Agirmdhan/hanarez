<x-admin-layout>
    <x-slot name="header">
        Kelola Galeri Kamar
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-md bg-green-100 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                {{-- Form Tambah Gambar --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow">
                        <div class="border-b border-gray-200 p-5">
                            <h3 class="text-lg font-semibold text-gray-900">Tambah Gambar Baru</h3>
                        </div>
                        <div class="p-5">
                            <form method="POST" action="{{ route('admin.galeri.store') }}" enctype="multipart/form-data">
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
                                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi <span class="text-gray-400 font-normal">(opsional)</span></label>
                                    <input id="deskripsi" name="deskripsi" type="text" value="{{ old('deskripsi') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    @error('deskripsi')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar</label>
                                    <input id="gambar" name="gambar" type="file" accept="image/jpeg,image/png,image/jpg,image/webp"
                                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                                        required>
                                    <p class="mt-1 text-xs text-gray-500">Format: JPEG, PNG, JPG, WebP. Maks: 2MB.</p>
                                    @error('gambar')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit"
                                    class="w-full rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                                    Simpan Gambar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Daftar Galeri --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow">
                        <div class="border-b border-gray-200 p-5">
                            <h3 class="text-lg font-semibold text-gray-900">Galeri Kamar</h3>
                            <p class="mt-1 text-sm text-gray-500">Gambar-gambar yang tampil di halaman About Us.</p>
                        </div>
                        <div class="p-5 space-y-4">
                            @forelse ($galeri as $item)
                                <div class="rounded-md border border-gray-200 bg-gray-50 p-4">
                                    <div class="flex items-start gap-4">
                                        <img src="{{ asset('storage/'.$item->gambar) }}" 
                                             alt="{{ $item->judul }}" 
                                             class="w-28 h-20 object-cover rounded-md flex-shrink-0">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-900">{{ $item->judul }}</h4>
                                            @if ($item->deskripsi)
                                                <p class="mt-1 text-sm text-gray-600">{{ $item->deskripsi }}</p>
                                            @endif
                                            <div class="mt-2 flex flex-wrap gap-3 text-xs text-gray-500">
                                                <span>Ditambah oleh: {{ $item->user?->name ?? 'Admin' }}</span>
                                                <span>{{ $item->created_at->format('d M Y H:i') }}</span>
                                            </div>
                                        </div>
                                        <form method="POST" action="{{ route('admin.galeri.destroy', $item) }}"
                                            onsubmit="return confirm('Hapus gambar ini?')">
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
                                <p class="text-sm text-gray-500">Belum ada gambar galeri.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
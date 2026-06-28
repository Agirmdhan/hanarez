<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin Kost') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-md bg-green-100 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Total Kamar</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $totalKamar }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Penghuni Aktif</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $totalPenghuni }}/6</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Pembayaran Menunggu</p>
                    <p class="mt-1 text-2xl font-bold text-yellow-600">{{ $pembayaranMenunggu }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Keluhan Aktif</p>
                    <p class="mt-1 text-2xl font-bold text-red-600">{{ $keluhanAktif }}</p>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-5 lg:grid-cols-2">
                @foreach ($kamars as $kamar)
                    @php
                        $penghuni = $kamar->penghuni;
                        $pembayaran = $penghuni?->pembayaranBulanIni;
                        $laporans = $penghuni?->laporanAktif ?? collect();
                    @endphp

                    <div class="bg-white rounded-lg shadow">
                        <div class="border-b border-gray-200 p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Kamar {{ $kamar->nomor_kamar }}</p>
                                    <h3 class="mt-1 text-lg font-semibold text-gray-900">
                                        {{ $penghuni?->name ?? 'Kosong' }}
                                    </h3>
                                </div>
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $penghuni ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $penghuni ? 'Terisi' : 'Kosong' }}
                                </span>
                            </div>
                        </div>

                        <div class="space-y-5 p-5">
                            @if ($penghuni)
                                <div>
                                    <p class="mb-2 text-sm font-semibold text-gray-800">Status Pembayaran Bulan Ini</p>
                                    @if (! $pembayaran)
                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            Belum bayar
                                        </span>
                                    @elseif ($pembayaran->status === 'menunggu')
                                        <div class="flex flex-wrap items-center gap-3">
                                            <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">
                                                Menunggu verifikasi
                                            </span>
                                            <a href="{{ asset('storage/'.$pembayaran->bukti_pembayaran) }}" target="_blank" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                                Lihat bukti PNG
                                            </a>
                                            <form method="POST" action="{{ route('admin.pembayaran.verify', $pembayaran) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button class="rounded bg-green-600 px-3 py-1 text-xs font-semibold text-white hover:bg-green-700" type="submit">
                                                    Tandai lunas
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="flex flex-wrap items-center gap-3">
                                            <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                                Sudah bayar
                                            </span>
                                            <a href="{{ asset('storage/'.$pembayaran->bukti_pembayaran) }}" target="_blank" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                                Lihat bukti PNG
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <p class="mb-2 text-sm font-semibold text-gray-800">Keluhan Aktif</p>
                                    @forelse ($laporans as $laporan)
                                        <div class="mb-3 rounded-md border border-red-200 bg-red-50 p-3">
                                            <p class="font-medium text-gray-900">{{ $laporan->judul }}</p>
                                            <p class="mt-1 text-sm text-gray-600">{{ $laporan->deskripsi }}</p>
                                            <form method="POST" action="{{ route('admin.laporan.complete', $laporan) }}" class="mt-3">
                                                @csrf
                                                @method('PATCH')
                                                <button class="rounded bg-gray-800 px-3 py-1 text-xs font-semibold text-white hover:bg-gray-700" type="submit">
                                                    Tandai selesai
                                                </button>
                                            </form>
                                        </div>
                                    @empty
                                        <p class="text-sm text-gray-500">Tidak ada keluhan aktif.</p>
                                    @endforelse
                                </div>

                                <div class="border-t border-gray-200 pt-4">
                                    <form method="POST" action="{{ route('admin.penghuni.destroy', $penghuni) }}" onsubmit="return confirm('Hapus penghuni ini dan kosongkan kamar?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700" type="submit">
                                            Hapus penghuni
                                        </button>
                                    </form>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Kamar ini belum ditempati penghuni.</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>

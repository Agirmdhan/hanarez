<x-admin-layout>
    <x-slot name="header">
        Dashboard Admin Kost
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 rounded-md bg-green-100 px-4 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 rounded-md bg-red-100 px-4 py-3 text-sm text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 gap-4 md:grid-cols-5">
                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Total Kamar</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $totalKamar }}</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Penghuni Aktif</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">{{ $totalPenghuni }}/6</p>
                </div>
                <div class="bg-white p-5 rounded-lg shadow">
                    <p class="text-sm text-gray-500">Calon Penghuni Pending</p>
                    <p class="mt-1 text-2xl font-bold text-amber-600">{{ $pendingUsers->count() }}</p>
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
                <div class="lg:col-span-2 rounded-lg bg-white shadow">
                    <div class="border-b border-gray-200 p-5">
                        <h3 class="text-lg font-semibold text-gray-900">Calon Penghuni Pending</h3>
                        <p class="mt-1 text-sm text-gray-500">Pengguna yang sudah registrasi tetapi belum mengunggah bukti pembayaran dalam batas waktu 5 menit.</p>
                    </div>
                    <div class="p-5">
                        @forelse ($pendingUsers as $pendingUser)
                            @php
                                $buktiPending = $pendingUser->pembayaranBulanIni;
                            @endphp
                            <div class="mb-3 rounded-md border border-amber-200 bg-amber-50 p-4">
                                <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $pendingUser->name }}</p>
                                        <p class="text-sm text-gray-600">Kamar: {{ $pendingUser->kamar?->nomor_kamar ?? '-' }}</p>
                                        <p class="text-sm text-gray-600">Deadline: {{ optional($pendingUser->payment_deadline)->format('d M Y H:i') ?? '-' }}</p>
                                    </div>
                                    <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">
                                        Pending
                                    </span>
                                </div>

                                <div class="mt-4 grid gap-4 lg:grid-cols-3">
                                    <div class="rounded-md bg-white p-3">
                                        <p class="mb-2 text-sm font-semibold text-gray-800">Bukti Pembayaran</p>
                                        @if ($buktiPending && $buktiPending->bukti_pembayaran)
                                            <a href="{{ asset('storage/'.$buktiPending->bukti_pembayaran) }}" target="_blank" class="inline-flex items-center rounded border border-indigo-200 bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700 hover:bg-indigo-100">
                                                Lihat Bukti Pembayaran
                                            </a>
                                            <p class="mt-2 text-xs text-gray-500">Status bukti: {{ $buktiPending->status }}</p>
                                        @else
                                            <p class="text-sm text-gray-500">Belum ada bukti pembayaran yang diunggah.</p>
                                        @endif
                                    </div>

                                    <div class="rounded-md bg-white p-3">
                                        <p class="mb-2 text-sm font-semibold text-gray-800">Syarat & Ketentuan</p>
                                        @if ($pendingUser->syarat_ketentuan)
                                            <a href="{{ asset('storage/'.$pendingUser->syarat_ketentuan) }}" target="_blank" class="inline-flex items-center rounded border border-blue-200 bg-blue-50 px-3 py-2 text-sm font-medium text-blue-700 hover:bg-blue-100">
                                                Lihat Dokumen
                                            </a>
                                            <p class="mt-2 text-xs text-gray-500">Dokumen sudah diunggah.</p>
                                        @else
                                            <p class="text-sm text-gray-500">Belum ada dokumen syarat dan ketentuan.</p>
                                        @endif
                                    </div>

                                    <div class="rounded-md bg-white p-3">
                                        <p class="mb-2 text-sm font-semibold text-gray-800">Aksi Admin</p>
                                        @if ($buktiPending && $buktiPending->bukti_pembayaran && $pendingUser->syarat_ketentuan)
                                            <div class="flex flex-wrap gap-2">
                                                <form method="POST" action="{{ route('admin.pembayaran.verify', $buktiPending) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="rounded bg-green-600 px-3 py-2 text-xs font-semibold text-white hover:bg-green-700" type="submit">
                                                        Terima Calon Penghuni
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.pembayaran.reject', $buktiPending) }}" onsubmit="return confirm('Tolak calon penghuni ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="rounded bg-red-600 px-3 py-2 text-xs font-semibold text-white hover:bg-red-700" type="submit">
                                                        Tolak Calon Penghuni
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <p class="text-sm text-gray-500">Tombol verifikasi muncul setelah bukti pembayaran dan dokumen syarat & ketentuan diunggah.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">Tidak ada calon penghuni pending.</p>
                        @endforelse
                    </div>
                </div>

                @foreach ($kamars as $kamar)
                    @php
                        $penghuni = $kamar->penghuni;
                        // Prioritaskan tagihan aktif (status=menunggu, untuk verifikasi/tolak)
                        // Fallback ke pembayaran bulan ini
                        // Fallback ke pembayaran terakhir (agar status "sudah dibayar" tetap tampil setelah verifikasi)
                        $pembayaranTerakhir = $penghuni ? $penghuni->pembayarans()->latest('bulan')->first() : null;
                        $pembayaran = $penghuni?->pembayaranTagihanAktif
                            ?? $penghuni?->pembayaranBulanIni
                            ?? $pembayaranTerakhir;
                        // Hanya tampilkan laporan yang masih aktif/diproses (riwayat selesai/dibatalkan tidak ditampilkan)
                        $laporans = $penghuni
                            ? $penghuni->laporans()->whereIn('status', ['aktif', 'proses'])->latest()->get()
                            : collect();
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
                                    @if ($pembayaran)
                                        <div class="flex flex-wrap items-center gap-3">
                                            @if ($pembayaran->status === 'lunas')
                                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                                    Sudah dibayar
                                                </span>
                                                @if ($pembayaran->bukti_pembayaran)
                                                    <a href="{{ asset('storage/'.$pembayaran->bukti_pembayaran) }}" target="_blank" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                                        Lihat bukti pembayaran
                                                    </a>
                                                @endif
                                            @elseif ($pembayaran->status === 'menunggu')
                                                <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">
                                                    {{ $pembayaran->bukti_pembayaran ? 'Menunggu konfirmasi' : 'Belum bayar' }}
                                                </span>
                                                @if ($pembayaran->bukti_pembayaran)
                                                    <a href="{{ asset('storage/'.$pembayaran->bukti_pembayaran) }}" target="_blank" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                                        Lihat bukti pembayaran
                                                    </a>
                                                @endif
                                            @endif
                                        </div>

                                        @if ($pembayaran->status === 'menunggu')
                                            <div class="mt-3 flex flex-wrap gap-2">
                                                <form method="POST" action="{{ route('admin.pembayaran.verify', $pembayaran) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="rounded bg-green-600 px-3 py-1 text-xs font-semibold text-white hover:bg-green-700" type="submit">
                                                        Verifikasi
                                                    </button>
                                                </form>

                                                <form method="POST" action="{{ route('admin.pembayaran.reject', $pembayaran) }}" onsubmit="return confirm('Tolak pembayaran ini?')">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="rounded bg-red-600 px-3 py-1 text-xs font-semibold text-white hover:bg-red-700" type="submit">
                                                        Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @else
                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            Belum bayar
                                        </span>
                                    @endif

                                    @if ($penghuni)
                                        <form method="POST" action="{{ route('admin.penghuni.remind', $penghuni) }}" class="mt-4">
                                            @csrf
                                            @method('PATCH')
                                            <button class="rounded bg-indigo-600 px-3 py-2 text-xs font-semibold text-white hover:bg-indigo-700" type="submit">
                                                Ingatkan tagihan bulanan
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <div>
                                    <p class="mb-2 text-sm font-semibold text-gray-800">Keluhan / Laporan</p>
                                    @forelse ($laporans as $laporan)
                                        <div class="mb-3 rounded-md border border-red-200 bg-red-50 p-3">
                                            <p class="font-medium text-gray-900">{{ $laporan->judul }}</p>
                                            <p class="mt-1 text-sm text-gray-600">{{ $laporan->deskripsi }}</p>
                                            @if ($laporan->foto && count($laporan->foto) > 0)
                                                <div class="mt-2 flex flex-wrap gap-2">
                                                    @foreach ($laporan->foto as $index => $fotoPath)
                                                        <a href="{{ asset('storage/'.$fotoPath) }}" target="_blank" class="inline-flex items-center rounded border border-indigo-200 bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700 hover:bg-indigo-100">
                                                            Lihat Foto {{ $index + 1 }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <div class="mt-3 flex flex-wrap gap-2">
                                                @if ($laporan->status === 'aktif')
                                                    <form method="POST" action="{{ route('admin.laporan.proses', $laporan) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="rounded bg-yellow-500 px-3 py-1 text-xs font-semibold text-white hover:bg-yellow-600" type="submit">
                                                            Proses
                                                        </button>
                                                    </form>
                                                @endif
                                                @if ($laporan->status === 'aktif' || $laporan->status === 'proses')
                                                    <form method="POST" action="{{ route('admin.laporan.selesai', $laporan) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="rounded bg-green-600 px-3 py-1 text-xs font-semibold text-white hover:bg-green-700" type="submit">
                                                            Selesai
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('admin.laporan.batalkan', $laporan) }}" onsubmit="return confirm('Batalkan laporan ini? Bukti dianggap fiktif.')">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button class="rounded bg-red-600 px-3 py-1 text-xs font-semibold text-white hover:bg-red-700" type="submit">
                                                            Batalkan (Fiktif)
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                            <p class="mt-2 text-xs text-gray-500">
                                                Status: 
                                                @if ($laporan->status === 'aktif')
                                                    <span class="font-semibold text-red-600">Aktif</span>
                                                @elseif ($laporan->status === 'proses')
                                                    <span class="font-semibold text-yellow-600">Diproses</span>
                                                @elseif ($laporan->status === 'selesai')
                                                    <span class="font-semibold text-green-600">Selesai</span>
                                                @elseif ($laporan->status === 'dibatalkan')
                                                    <span class="font-semibold text-gray-600">Dibatalkan</span>
                                                @endif
                                            </p>
                                        </div>
                                    @empty
                                        <p class="text-sm text-gray-500">Tidak ada laporan.</p>
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
</x-admin-layout>

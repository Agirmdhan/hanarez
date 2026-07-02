<x-admin-layout>
    <x-slot name="header">Laporan Keuangan</x-slot>

    <div class="mx-auto max-w-7xl space-y-5">
        <form method="GET" class="flex flex-wrap items-end gap-3 bg-white p-4 shadow rounded-md">
            <div>
                <label for="bulan" class="mb-1 block text-sm font-medium text-gray-700">Filter Bulan</label>
                <input id="bulan" name="bulan" type="month" value="{{ $bulan }}" class="rounded-md border-gray-300 text-sm shadow-sm">
            </div>
            <button class="rounded bg-gray-800 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-700">Tampilkan</button>
            <button type="submit" formaction="{{ route('admin.laporan-keuangan.cetak') }}" formtarget="_blank" class="rounded bg-green-700 px-4 py-2 text-sm font-semibold text-white hover:bg-green-600">Cetak PDF</button>
            @if ($bulan)<a href="{{ route('admin.laporan-keuangan.index') }}" class="px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">Reset</a>@endif
        </form>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-md bg-white p-5 shadow"><p class="text-sm text-gray-500">Pemasukan Terverifikasi</p><p class="mt-1 text-2xl font-semibold text-green-700">Rp {{ number_format($totalLunas, 0, ',', '.') }}</p></div>
            <div class="rounded-md bg-white p-5 shadow"><p class="text-sm text-gray-500">Pembayaran Lunas</p><p class="mt-1 text-2xl font-semibold text-gray-900">{{ $jumlahLunas }} transaksi</p></div>
            <div class="rounded-md bg-white p-5 shadow"><p class="text-sm text-gray-500">Menunggu Verifikasi</p><p class="mt-1 text-2xl font-semibold text-amber-700">Rp {{ number_format($totalMenunggu, 0, ',', '.') }}</p></div>
        </div>

        <div class="overflow-hidden rounded-md bg-white shadow">
            <div class="border-b border-gray-200 px-5 py-4"><h2 class="font-semibold text-gray-900">Rincian Pembayaran Penghuni</h2></div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600"><tr><th class="px-5 py-3">Penghuni</th><th class="px-5 py-3">Kamar</th><th class="px-5 py-3">Bulan</th><th class="px-5 py-3">Nominal</th><th class="px-5 py-3">Status</th><th class="px-5 py-3">Diverifikasi</th><th class="px-5 py-3">Bukti</th></tr></thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($records as $record)
                            <tr>
                                <td class="px-5 py-4 font-medium">{{ $record->user?->name ?? 'Pengguna dihapus' }}</td>
                                <td class="px-5 py-4">{{ $record->user?->kamar?->nomor_kamar ?? '-' }}</td>
                                <td class="px-5 py-4">{{ $record->bulan }}</td>
                                <td class="px-5 py-4">Rp {{ number_format($record->nominal, 0, ',', '.') }}</td>
                                <td class="px-5 py-4"><span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $record->status === 'lunas' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">{{ $record->status === 'lunas' ? 'Lunas' : 'Menunggu' }}</span></td>
                                <td class="px-5 py-4">{{ $record->verified_at?->format('d M Y H:i') ?? '-' }}</td>
                                <td class="px-5 py-4">@if ($record->bukti_pembayaran)<a target="_blank" href="{{ asset('storage/'.$record->bukti_pembayaran) }}" class="font-medium text-indigo-600 hover:text-indigo-800">Lihat bukti</a>@else - @endif</td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-5 py-10 text-center text-gray-500">Belum ada data pembayaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>


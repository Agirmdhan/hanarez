<x-penghuni-layout>
    <x-slot name="header">Riwayat Tagihan</x-slot>

    <div class="mx-auto max-w-6xl space-y-5">
        @if (session('success'))
            <div class="rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-md bg-white p-5 shadow">
                <p class="text-sm text-gray-500">Total Pembayaran Lunas</p>
                <p class="mt-1 text-2xl font-semibold text-green-700">Rp {{ number_format($totalLunas, 0, ',', '.') }}</p>
            </div>
            <div class="rounded-md bg-white p-5 shadow">
                <p class="text-sm text-gray-500">Tagihan Menunggu</p>
                <p class="mt-1 text-2xl font-semibold text-amber-700">Rp {{ number_format($totalMenunggu, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-md bg-white shadow">
            <div class="border-b border-gray-200 px-5 py-4">
                <h2 class="font-semibold text-gray-900">Rekap Tagihan Bulanan</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50 text-left text-gray-600">
                        <tr><th class="px-5 py-3">Bulan</th><th class="px-5 py-3">Nominal</th><th class="px-5 py-3">Status</th><th class="px-5 py-3">Tanggal Verifikasi</th><th class="px-5 py-3">Bukti</th></tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($records as $record)
                            <tr>
                                <td class="px-5 py-4 font-medium">{{ \Carbon\Carbon::createFromFormat('Y-m', $record->bulan)->translatedFormat('F Y') }}</td>
                                <td class="px-5 py-4">Rp {{ number_format($record->nominal, 0, ',', '.') }}</td>
                                <td class="px-5 py-4"><span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $record->status === 'lunas' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">{{ $record->status === 'lunas' ? 'Lunas' : 'Menunggu Verifikasi' }}</span></td>
                                <td class="px-5 py-4">{{ $record->verified_at?->format('d M Y H:i') ?? '-' }}</td>
                                <td class="px-5 py-4">@if ($record->bukti_pembayaran)<a class="font-medium text-indigo-600 hover:text-indigo-800" target="_blank" href="{{ asset('storage/'.$record->bukti_pembayaran) }}">Lihat bukti</a>@else - @endif</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-5 py-10 text-center text-gray-500">Belum ada riwayat tagihan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-penghuni-layout>

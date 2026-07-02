<x-penghuni-layout>
    <x-slot name="header">
        Pengumuman
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow">
                <div class="border-b border-gray-200 p-5">
                    <h3 class="text-lg font-semibold text-gray-900">Pengumuman Terbaru</h3>
                    <p class="mt-1 text-sm text-gray-500">Pengumuman dari admin.</p>
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
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">Belum ada pengumuman.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-penghuni-layout>
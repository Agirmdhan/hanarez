<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Pembayaran Awal Calon Penghuni</h1>
        <p class="mt-2 text-sm text-gray-600">
            Silakan upload bukti pembayaran awal untuk mengaktifkan kamar Anda. Batas waktu pembayaran adalah 5 menit sejak registrasi.
        </p>
    </div>

    @if ($errors->any())
        <div class="mb-4 rounded-md bg-red-50 p-4 text-sm text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    @if (session('status'))
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="mb-6 rounded-lg border border-gray-200 bg-gray-50 p-4 text-sm text-gray-700">
        <p><span class="font-semibold">Nama:</span> {{ auth()->user()->name }}</p>
        <p><span class="font-semibold">Kamar:</span> {{ auth()->user()->kamar?->nomor_kamar ?? '-' }}</p>
        <p><span class="font-semibold">Status Pendaftaran:</span> {{ strtoupper(auth()->user()->status_pendaftaran) }}</p>
        <p><span class="font-semibold">Biaya Pembayaran Awal:</span> Rp1.900.000</p>
        <p><span class="font-semibold">Deadline Pembayaran:</span> {{ optional(auth()->user()->payment_deadline)->format('d M Y H:i') ?? '-' }}</p>
    </div>

    <form method="POST" action="{{ route('penghuni.pembayaran.store') }}" enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="bukti_pembayaran" value="Upload Bukti Pembayaran PNG" />
            <input
                id="bukti_pembayaran"
                type="file"
                name="bukti_pembayaran"
                accept="image/png"
                required
                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
            <x-input-error :messages="$errors->get('bukti_pembayaran')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="syarat_ketentuan" value="Upload Syarat & Ketentuan yang Sudah Diisi" />
            <input
                id="syarat_ketentuan"
                type="file"
                name="syarat_ketentuan"
                accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                required
                class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
            <p class="mt-1 text-xs text-gray-500">Format PDF, DOC, atau DOCX. Maksimal 5 MB.</p>
            <x-input-error :messages="$errors->get('syarat_ketentuan')" class="mt-2" />
        </div>

        <div class="mt-6 flex items-center justify-end">
            <x-primary-button>
                Upload Dokumen
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

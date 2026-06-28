<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 mb-6">Manajemen Kamar</h2>

            <!-- Form Tambah Kamar -->
            <div class="bg-white p-6 mb-6 shadow-sm sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tambah Kamar Baru</h3>
                
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.kamar.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @csrf
                    <input type="text" name="nomor_kamar" placeholder="Nomor Kamar" class="border rounded px-3 py-2" required>
                    <input type="text" name="tipe" placeholder="Tipe (Contoh: VIP/Ekonomi)" class="border rounded px-3 py-2" required>
                    <input type="number" name="harga" placeholder="Harga" class="border rounded px-3 py-2" required>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
                </form>
            </div>

            <!-- Tabel Kamar -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left">Nomor Kamar</th>
                            <th class="px-6 py-3 text-left">Tipe</th>
                            <th class="px-6 py-3 text-left">Harga</th>
                            <th class="px-6 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kamar as $k)
                        <tr>
                            <td class="px-6 py-4">{{ $k->nomor_kamar }}</td>
                            <td class="px-6 py-4">{{ $k->tipe }}</td>
                            <td class="px-6 py-4">Rp {{ number_format($k->harga) }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded {{ $k->status == 'Tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $k->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
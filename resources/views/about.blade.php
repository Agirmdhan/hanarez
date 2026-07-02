<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us - Hanarez</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #FAFAFB;
        }
    </style>
</head>
<body class="antialiased">

    @php
        $availableKamars = \App\Models\Kamar::where('status', 'Tersedia')->count();
        $galeri = \App\Models\GaleriKamar::latest()->get();
    @endphp

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 py-4 px-8 md:px-16 flex items-center justify-between sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <img src="https://g.top4top.io/p_3832whs151.png" alt="Hanarez" class="w-7 h-7 object-contain">
            <span class="text-xl font-bold text-gray-900 tracking-tight">Hanarez</span>
        </div>

        <div class="hidden md:flex items-center gap-10">
            <a href="{{ url('/') }}" class="text-sm font-medium text-gray-600 hover:text-blue-500">Home</a>
            <a href="{{ route('about') }}" class="text-sm font-semibold text-blue-500">About Us</a>
            <a href="https://wa.me/6285664325521" target="_blank" class="text-sm font-medium text-gray-600 hover:text-blue-500">Contact</a>
        </div>

        <div class="flex items-center gap-3">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2 text-sm font-semibold text-white bg-blue-500 rounded-md hover:bg-blue-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-semibold text-gray-600 border border-gray-300 rounded-md hover:bg-gray-50">Login</a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero About -->
    <section class="bg-gradient-to-br from-gray-900 to-gray-800 text-white py-20 md:py-28">
        <div class="max-w-7xl mx-auto px-8 md:px-16 text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-4">Tentang Hanarez Kost</h1>
            <p class="text-gray-300 max-w-2xl mx-auto text-lg">Hunian kos eksklusif dengan fasilitas lengkap dan lokasi strategis untuk kenyamanan Anda.</p>
        </div>
    </section>

    <!-- About Content -->
    <section class="max-w-7xl mx-auto px-8 md:px-16 py-16 md:py-24">
        <div class="flex flex-col md:flex-row items-center gap-12 mb-20">
            <div class="w-full md:w-1/2">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-6">Tentang Hanarez Kost</h2>
                <p class="text-gray-600 leading-7 mb-4">
                    Hanarez Kost adalah hunian kos eksklusif yang terletak di kawasan strategis, dekat dengan pusat kota, kampus, dan pusat perbelanjaan. 
                    Kami menyediakan lingkungan yang nyaman, aman, dan kondusif untuk para mahasiswa, pekerja, atau siapa pun yang mencari tempat tinggal sementara di kota.
                </p>
                <p class="text-gray-600 leading-7 mb-6">
                    Setiap kamar dilengkapi dengan AC, WiFi berkecepatan tinggi, dan kamar mandi dalam. 
                    Dengan sistem manajemen yang terintegrasi, kami memudahkan Anda dalam mengelola pembayaran, laporan kerusakan, dan informasi terbaru.
                </p>
                <div class="flex flex-wrap gap-4 text-sm">
                    <div class="flex items-center gap-2 px-4 py-3 bg-blue-50 rounded-lg">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="text-gray-700 font-medium">Jl. Pancoran Barat XIJ No.4, RT.12/RW.3, Pancoran, Kec. Pancoran, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12780</span>
                    </div>
                    <div class="flex items-center gap-2 px-4 py-3 bg-green-50 rounded-lg">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <span class="text-gray-700 font-medium">+62 856-6432-5521</span>
                    </div>
                </div>
            </div>
            <div class="w-full md:w-1/2">
                <div class="relative">
                    <img src="https://h.top4top.io/p_38323ffb62.png" 
                         alt="Interior Kamar Hanarez" 
                         class="w-full h-[300px] md:h-[400px] object-cover rounded-xl shadow-lg">
                    <div class="absolute -bottom-4 -right-4 bg-white rounded-xl shadow-lg p-4 hidden md:block">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            <div>
                                <p class="text-sm font-bold text-gray-900">Kamar Tersedia</p>
                                <p class="text-xs text-gray-500">{{ $availableKamars }} kamar siap huni</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Galeri Kamar -->
        @if ($galeri->isNotEmpty())
        <div>
            <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Galeri Kamar</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($galeri as $item)
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">
                    <img src="{{ asset('storage/'.$item->gambar) }}" 
                         alt="{{ $item->judul }}" 
                         class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-900">{{ $item->judul }}</h4>
                        @if ($item->deskripsi)
                            <p class="text-sm text-gray-500 mt-1">{{ $item->deskripsi }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="mt-16 text-center">
            <a href="{{ url('/') }}" class="inline-block px-6 py-3 bg-blue-500 text-white font-semibold rounded-md hover:bg-blue-600 transition">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </section>

</body>
</html>
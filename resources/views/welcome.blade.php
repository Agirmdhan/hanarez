<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hanarez</title>

    <!-- Google Fonts untuk tipografi yang modern sesuai desain -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Memuat Tailwind CSS -->
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
        $availableKamars = $kamars->where('status', 'Tersedia');
    @endphp

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 py-4 px-8 md:px-16 flex items-center justify-between sticky top-0 z-50">
        <div class="flex items-center gap-2">
            <div class="flex items-center text-blue-500">
                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 21V9H8V21H4ZM10 21V5H18V21H10ZM12 7H16V9H12V7ZM12 11H16V13H12V11ZM12 15H16V17H12V15ZM6 11H8V13H6V11ZM6 15H8V17H6V15Z" fill="#3B82F6"/>
                    <circle cx="19.5" cy="18.5" r="2.5" fill="#10B981"/>
                </svg>
            </div>
            <span class="text-xl font-bold text-gray-900 tracking-tight">Hanarez</span>
        </div>

        <div class="hidden md:flex items-center gap-10">
            <a href="/" class="text-sm font-semibold text-blue-500">Home</a>
            <a href="#contact" class="text-sm font-medium text-gray-600 hover:text-blue-500">Contact</a>
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

    <!-- Hero Section -->
    <header class="max-w-7xl mx-auto px-8 md:px-16 py-16 md:py-20 flex flex-col md:flex-row items-center justify-between gap-10">
        <div class="w-full md:w-1/2">
            <h1 class="text-[2.5rem] md:text-[2.75rem] font-bold text-gray-900 leading-[1.2] mb-6">
                Sistem Manajemen Kamar Modern.<br>
                Temukan Kamar Kosong Anda &<br>
                Bergabunglah Bersama Kami!
            </h1>
            <p class="text-gray-600 max-w-xl leading-7">
                Klik kamar yang statusnya tersedia untuk langsung menuju halaman register, lalu pilih kamar tersebut saat pendaftaran.
            </p>
        </div>
        <div class="w-full md:w-1/2 flex justify-end">
            <img src="{{ asset('images/kos.png') }}" alt="Ilustrasi" class="w-full max-w-lg object-contain">
        </div>
    </header>

    <!-- Section Ketersediaan Kamar -->
    <section class="max-w-7xl mx-auto px-8 md:px-16 pb-24">
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Ketersediaan Kamar Saat Ini</h2>
                <p class="text-sm text-gray-500 mt-1">Kamar yang tersedia bisa dipilih langsung untuk proses register.</p>
            </div>
            <div class="flex gap-3 text-sm">
                <div class="px-3 py-2 rounded-full bg-green-50 text-green-700 border border-green-100">Tersedia: {{ $availableKamars->count() }}</div>
                <div class="px-3 py-2 rounded-full bg-red-50 text-red-700 border border-red-100">Terisi: {{ $kamars->where('status', 'Terisi')->count() }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($kamars as $kamar)
                @php
                    $isAvailable = strtolower($kamar->status) === 'tersedia';
                    $cardContent = '
                        <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] h-full transition hover:shadow-lg hover:-translate-y-0.5">
                    ';
                @endphp

                @if ($isAvailable)
                    <a href="{{ route('register', ['kamar' => $kamar->id_kamar]) }}" class="block group">
                @else
                    <div class="opacity-90">
                @endif
                    <div class="bg-white border border-gray-200 rounded-lg p-5 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.1)] h-full transition hover:shadow-lg hover:-translate-y-0.5 {{ $isAvailable ? 'cursor-pointer' : '' }}">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">{{ $kamar->nomor_kamar ?? 'Kamar ' . $loop->iteration }}</h3>
                                <p class="text-[11px] font-semibold text-gray-500 uppercase tracking-wide mt-0.5">{{ $kamar->tipe ?? 'SINGLE ROOM' }}</p>
                            </div>
                            <div class="text-[#344054]">
                                <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 11V18H6V15H18V18H20V11C20 9.89543 19.1046 9 18 9H6C4.89543 9 4 9.89543 4 11ZM15 7H18C19.1046 7 20 7.89543 20 9V10H4V9C4 7.89543 4.89543 7 6 7H9C9.55228 7 10 7.44772 10 8V10H14V8C14 7.44772 14.4477 7 15 7Z" />
                                </svg>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 text-xs font-medium text-gray-600 mb-4">
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                AC
                            </div>
                            <div class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"></path></svg>
                                WiFi
                            </div>
                            <div class="flex items-center gap-1.5">
                                Kmr Mandi Dalam
                            </div>
                        </div>

                        <hr class="border-gray-200 mb-4">

                        <div class="flex items-center text-[13px]">
                            <span class="text-gray-700 mr-2">Status:</span>

                            @if (strtolower($kamar->status) == 'tersedia')
                                <span class="bg-[#2D8A4E] text-white px-2.5 py-0.5 rounded-full font-medium flex items-center text-[11px]">
                                    TERSEDIA ✓
                                </span>
                            @else
                                <span class="bg-[#D33E43] text-white px-2.5 py-0.5 rounded-full font-medium flex items-center text-[11px]">
                                    TERISI x
                                </span>
                            @endif
                        </div>

                        
                    </div>
                @if ($isAvailable)
                    </a>
                @else
                    </div>
                @endif
            @empty
                <div class="col-span-1 md:col-span-3 py-10 text-center text-gray-500 bg-white border border-gray-200 rounded-lg">
                    Data kamar belum tersedia di database.
                </div>
            @endforelse
        </div>
    </section>

</body>
</html>
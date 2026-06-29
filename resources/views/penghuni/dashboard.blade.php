<x-app-layout>
    <x-slot name="header">
        <h2 class="resident-title">
            {{ __('Dashboard Penghuni') }}
        </h2>
    </x-slot>

    @php
        $user = auth()->user();
        $kamar = $user->kamar?->nomor_kamar ?? '-';
        $tagihanAktif = $tagihanAktif ?? null;
        $tagihanLunas = $pembayaranBulanIni?->status === 'lunas';
        $tagihanTampil = $tagihanAktif ? $nominalTagihan : 0;
    @endphp

    <style>
        .resident-page {
            position: relative;
            min-height: calc(100vh - 112px);
            overflow: hidden;
            background: #f6f7f5;
            padding: 42px 18px 58px;
            color: #172335;
        }

        .resident-page::before,
        .resident-page::after {
            content: "";
            position: absolute;
            width: min(34vw, 420px);
            height: min(42vw, 520px);
            bottom: 22px;
            opacity: .08;
            background-repeat: no-repeat;
            background-size: contain;
            pointer-events: none;
        }

        .resident-page::before {
            left: 22px;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 360 430' xmlns='http://www.w3.org/2000/svg' fill='none'%3E%3Cpath d='M28 410V190L180 96l152 94v220M66 410V220l114-70 114 70v190' stroke='%23172335' stroke-width='8'/%3E%3Cpath d='M112 270h44v72h-44zM204 270h44v72h-44z' stroke='%23172335' stroke-width='8'/%3E%3C/svg%3E");
        }

        .resident-page::after {
            right: 22px;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 360 430' xmlns='http://www.w3.org/2000/svg' fill='none'%3E%3Cpath d='M28 410V165L180 70l152 95v245M66 410V197l114-71 114 71v213' stroke='%23172335' stroke-width='8'/%3E%3Cpath d='M114 238h40v66h-40zM206 238h40v66h-40zM114 334h40v66h-40zM206 334h40v66h-40z' stroke='%23172335' stroke-width='8'/%3E%3C/svg%3E");
        }

        .resident-shell {
            position: relative;
            z-index: 1;
            width: min(100%, 1120px);
            margin: 0 auto;
        }

        .resident-title {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: #172335;
        }

        .resident-alert {
            margin-bottom: 18px;
            border-radius: 8px;
            padding: 12px 14px;
            font-size: 14px;
            box-shadow: 0 8px 20px rgba(23, 35, 53, .08);
        }

        .resident-alert.success {
            background: #e4f5e9;
            color: #176136;
        }

        .resident-alert.error {
            background: #fde8e8;
            color: #9b1c1c;
        }

        .resident-top-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(190px, .7fr) minmax(190px, .7fr);
            gap: 18px;
            align-items: stretch;
        }

        .resident-content-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 18px;
            margin-top: 18px;
            align-items: start;
        }

        .resident-stack {
            display: grid;
            gap: 18px;
        }

        .resident-card {
            border-radius: 8px;
            background: rgba(255, 255, 255, .96);
            box-shadow: 0 14px 28px rgba(23, 35, 53, .14);
        }

        .resident-welcome {
            min-height: 124px;
            overflow: hidden;
            background: linear-gradient(135deg, #1d2f45, #233c59);
            color: white;
            padding: 22px 24px;
        }

        .resident-welcome-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            height: 100%;
        }

        .resident-welcome h3 {
            margin: 0;
            font-size: clamp(24px, 3vw, 32px);
            line-height: 1.05;
            font-weight: 800;
            color: #d9dde3;
        }

        .resident-welcome p {
            margin: 10px 0 0;
            font-size: 14px;
            color: #c7d0da;
        }

        .resident-person {
            width: 148px;
            height: 104px;
            flex: 0 0 auto;
        }

        .resident-stat {
            min-height: 124px;
            padding: 22px;
            display: flex;
            justify-content: space-between;
            gap: 16px;
        }

        .resident-stat-label {
            margin: 0;
            font-size: 18px;
            line-height: 1.15;
            font-weight: 800;
            color: #111827;
        }

        .resident-stat-value {
            margin: 14px 0 0;
            font-size: 26px;
            line-height: 1;
            font-weight: 900;
            color: #111827;
        }

        .resident-stat-icon,
        .resident-section-icon {
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            width: 42px;
            height: 42px;
            border-radius: 8px;
            background: #eef4f1;
            color: #607875;
        }

        .resident-panel {
            padding: 20px;
        }

        .resident-payment {
            min-height: 510px;
            border: 2px solid #8aa4a0;
            display: flex;
            flex-direction: column;
        }

        .resident-section-head {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 18px;
        }

        .resident-section-head h3 {
            margin: 0;
            font-size: 22px;
            line-height: 1.2;
            font-weight: 800;
            color: #172335;
        }

        .resident-wallet-wrap {
            display: flex;
            justify-content: center;
            margin: 6px 0 22px;
        }

        .resident-wallet {
            width: clamp(140px, 34vw, 210px);
            height: auto;
        }

        .resident-payment h4 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
            color: #111827;
        }

        .resident-payment p,
        .resident-complaints p {
            margin: 10px 0 0;
            font-size: 15px;
            color: #27364a;
        }

        .resident-list {
            margin: 18px 0 0;
            padding-left: 20px;
            color: #1f2937;
            font-size: 15px;
            line-height: 1.8;
        }

        .resident-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
        }

        .resident-badge {
            border-radius: 7px;
            background: #eee1cc;
            padding: 5px 10px;
            font-size: 13px;
            color: #4f4030;
        }

        .resident-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-top: auto;
            padding-top: 26px;
        }

        .resident-button,
        .resident-upload {
            width: 100%;
            min-height: 42px;
            border: 0;
            border-radius: 7px;
            background: #1f354d;
            color: white;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 700;
            box-shadow: 0 6px 14px rgba(31, 53, 77, .22);
            transition: transform .16s ease, background .16s ease;
        }

        .resident-button:hover,
        .resident-upload:hover {
            transform: translateY(-1px);
            background: #17283b;
        }

        .resident-upload input {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
        }

        .resident-form-card {
            padding: 20px;
        }

        .resident-section-icon.warm {
            background: #eadcc6;
            color: #816b4a;
        }

        .resident-form {
            display: grid;
            gap: 14px;
            margin-top: 18px;
        }

        .resident-field label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 700;
            color: #172335;
        }

        .resident-field input,
        .resident-field textarea {
            width: 100%;
            border: 1px solid #c8cfd8;
            border-radius: 8px;
            background: #f7f7f7;
            padding: 10px 12px;
            font-size: 14px;
            color: #172335;
            box-shadow: inset 0 1px 2px rgba(23, 35, 53, .06);
        }

        .resident-field textarea {
            min-height: 86px;
            resize: vertical;
        }

        .resident-complaints {
            min-height: 188px;
            padding: 20px;
        }

        .resident-complaint-list {
            display: grid;
            gap: 10px;
            margin-top: 18px;
        }

        .resident-complaint-item {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
            width: fit-content;
            max-width: 100%;
            border-radius: 8px;
            background: #f6f5f2;
            padding: 10px 12px;
            box-shadow: 0 6px 14px rgba(23, 35, 53, .12);
            font-size: 14px;
        }

        .resident-complaint-mark,
        .resident-complaint-status {
            border-radius: 7px;
            background: #efe2cc;
            color: #806843;
            padding: 4px 8px;
            font-weight: 700;
            font-size: 12px;
        }

        .resident-empty {
            border-radius: 8px;
            background: #f6f5f2;
            padding: 12px;
            color: #6b7280;
            font-size: 14px;
        }

        .resident-proof {
            display: inline-block;
            margin-top: 10px;
            font-size: 14px;
            font-weight: 700;
            color: #1f354d;
            text-decoration: none;
        }

        .resident-proof:hover {
            text-decoration: underline;
        }

        @media (max-width: 980px) {
            .resident-top-grid,
            .resident-content-grid {
                grid-template-columns: 1fr;
            }

            .resident-payment {
                min-height: auto;
            }
        }

        @media (max-width: 640px) {
            .resident-page {
                padding: 24px 12px 38px;
            }

            .resident-page::before,
            .resident-page::after {
                display: none;
            }

            .resident-welcome-inner,
            .resident-stat {
                align-items: flex-start;
            }

            .resident-person {
                display: none;
            }

            .resident-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="resident-page">
        <div class="resident-shell">
            @if (session('success'))
                <div class="resident-alert success">
                    {{ session('success') }}
                </div>
            @endif

            @php
                $peringatanKey = 'peringatan_tolak_' . $user->id_user;
            @endphp
            @if (session($peringatanKey))
                <div class="resident-alert error">
                    {{ session($peringatanKey) }}
                </div>
            @endif

            @if ($errors->any())
                <div class="resident-alert error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="resident-top-grid">
                <section class="resident-card resident-welcome">
                    <div class="resident-welcome-inner">
                    <div>
                        <h3>Selamat datang, {{ $user->name }}</h3>
                        @if ($user->status_pendaftaran === 'pending')
                            <p>Kamar {{ $kamar }}. Akun Anda masih dalam status pending. Silakan upload bukti pembayaran untuk mengaktivasi akun.</p>
                        @else
                            <p>Kamar {{ $kamar }}. Akun Anda sudah aktif sebagai penghuni.</p>
                        @endif
                    </div>
                        <svg class="resident-person" viewBox="0 0 180 128" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <circle cx="118" cy="38" r="24" fill="#F2B08B"/>
                            <path d="M86 99c8-34 57-34 65 0l5 24H81l5-24Z" fill="#4F86BC"/>
                            <path d="M95 34c4-25 45-28 51 0 2 11-2 22-7 31-10-9-27-9-38 0-6-9-8-20-6-31Z" fill="#1A2435"/>
                            <path d="M68 89c18-1 26-16 38-23" stroke="#F2B08B" stroke-width="9" stroke-linecap="round"/>
                            <path d="M28 49h29v38H28z" fill="#D8E7E4" stroke="#172335" stroke-width="4"/>
                            <path d="M36 67h14M43 49V38" stroke="#172335" stroke-width="4" stroke-linecap="round"/>
                            <circle cx="34" cy="35" r="9" fill="#D8E7E4" stroke="#172335" stroke-width="4"/>
                            <circle cx="53" cy="35" r="9" fill="#D8E7E4" stroke="#172335" stroke-width="4"/>
                        </svg>
                    </div>
                </section>

                <section class="resident-card resident-stat">
                    <div>
                        <p class="resident-stat-label">Tagihan<br>Bulan Ini</p>
                        @if ($tagihanAktif)
                            <p class="resident-stat-value">Rp {{ number_format($tagihanTampil, 0, ',', '.') }}</p>
                            <p class="mt-2 text-sm font-semibold text-amber-700">
                                Tagihan aktif: {{ $tagihanAktif->bulan }}
                            </p>
                        @elseif ($tagihanLunas)
                            <p class="resident-stat-value text-green-700">Lunas</p>
                            <p class="mt-2 text-sm font-semibold text-green-700">
                                Tidak ada tagihan aktif bulan ini.
                            </p>
                        @else
                            <p class="resident-stat-value">Rp 0</p>
                            <p class="mt-2 text-sm font-semibold text-gray-500">
                                Belum ada tagihan aktif.
                            </p>
                        @endif
                    </div>
                    <span class="resident-stat-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M6 3h12v18l-3-2-3 2-3-2-3 2V3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                            <path d="M9 8h6M9 12h6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </span>
                </section>

                <section class="resident-card resident-stat">
                    <div>
                        <p class="resident-stat-label">Laporan<br>Terkirim</p>
                        <p class="resident-stat-value">{{ $laporanTerkirim }}</p>
                    </div>
                    <span class="resident-stat-icon">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M7 3h7l4 4v14H7V3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                            <path d="M14 3v5h5M10 13h5M10 17h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                    </span>
                </section>
            </div>

            <div class="resident-content-grid">
                <section class="resident-card resident-panel resident-payment">
                    <div class="resident-section-head">
                        <span class="resident-section-icon">
                            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M5 8h14a2 2 0 0 1 2 2v7a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V10a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.8"/>
                                <path d="M7 8l7-4 3 4M16 14h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <h3>Informasi Pembayaran</h3>
                    </div>

                    <div class="resident-wallet-wrap">
                        <svg class="resident-wallet" viewBox="0 0 160 160" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <circle cx="80" cy="80" r="70" fill="#EAF1F0"/>
                            <path d="M45 60h70a9 9 0 0 1 9 9v44a9 9 0 0 1-9 9H45a9 9 0 0 1-9-9V69a9 9 0 0 1 9-9Z" fill="#CFE1DE" stroke="#1B2D3D" stroke-width="5"/>
                            <path d="M51 53l48-19 11 26H51v-7Z" fill="#DDBD78" stroke="#1B2D3D" stroke-width="5"/>
                            <path d="M92 80h34v29H92a15 15 0 0 1 0-29Z" fill="#9CB9B5" stroke="#1B2D3D" stroke-width="5"/>
                            <circle cx="100" cy="95" r="5" fill="#1B2D3D"/>
                            <path d="M50 78h32M50 92h26" stroke="#1B2D3D" stroke-width="5" stroke-linecap="round"/>
                        </svg>
                    </div>

                    <h4>Informasi Pembayaran</h4>
                    @if ($tagihanAktif)
                        @if ($tagihanAktif->bukti_pembayaran)
                            <p>Bukti pembayaran sudah dikirim dan menunggu verifikasi admin.</p>
                        @else
                            <p>Tagihan bulan aktif sudah dibuat dan belum dibayar.</p>
                        @endif
                    @elseif ($tagihanLunas)
                        <p>Pembayaran bulan ini sudah lunas.</p>
                    @else
                        <p>Belum ada tagihan aktif.</p>
                    @endif

                    <ul class="resident-list">
                        <li>Sewa</li>
                        <li>Listrik</li>
                        <li>Kebersihan</li>
                    </ul>

                    <p><strong>Pembayaran yang diikuti untuk bulan ini:</strong></p>
                    <div class="resident-badges">
                        <span class="resident-badge">Kebersihan</span>
                        <span class="resident-badge">Sewa</span>
                    </div>

                    @if ($tagihanAktif && $tagihanAktif->bukti_pembayaran)
                        <a href="{{ asset('storage/'.$tagihanAktif->bukti_pembayaran) }}" target="_blank" class="resident-proof">
                            Lihat bukti PNG
                        </a>
                    @elseif ($pembayaranBulanIni && $pembayaranBulanIni->status === 'lunas' && $pembayaranBulanIni->bukti_pembayaran)
                        <a href="{{ asset('storage/'.$pembayaranBulanIni->bukti_pembayaran) }}" target="_blank" class="resident-proof">
                            Lihat bukti PNG
                        </a>
                    @endif

                    <form method="POST" action="{{ route('penghuni.pembayaran.store') }}" enctype="multipart/form-data" class="resident-actions">
                        @csrf
                        <label class="resident-upload">
                            Unggah Bukti
                            <input type="file" name="bukti_pembayaran" accept="image/png" required onchange="document.getElementById('nama-file').textContent = this.files[0]?.name || 'Belum ada file dipilih';">
                        </label>
                        <button class="resident-button" type="submit">
                            Bayar Sekarang
                        </button>
                        <div style="grid-column: 1 / -1; font-size: 13px; text-align: center; color: #6b7280; margin-top: -4px;" id="nama-file">Belum ada file dipilih</div>
                    </form>
                </section>

                <div class="resident-stack">
                    <section class="resident-card resident-form-card">
                        <div class="resident-section-head">
                            <span class="resident-section-icon warm">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M6 4h9l3 3v13H6V4Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                    <path d="M15 4v4h4M9 12h6M9 16h4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <h3>Buat Laporan Kerusakan/Keluhan</h3>
                        </div>

                        <form method="POST" action="{{ route('penghuni.laporan.store') }}" class="resident-form">
                            @csrf
                            <div class="resident-field">
                                <label for="judul">Judul</label>
                                <input id="judul" name="judul" type="text" value="{{ old('judul') }}" placeholder="Judul" required>
                            </div>
                            <div class="resident-field">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea id="deskripsi" name="deskripsi" placeholder="Ceritakan detailnya di sini..." required>{{ old('deskripsi') }}</textarea>
                            </div>
                            <button class="resident-button" type="submit">
                                Kirim Laporan
                            </button>
                        </form>
                    </section>

                    <section class="resident-card resident-complaints">
                        <div class="resident-section-head">
                            <span class="resident-section-icon warm">
                                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M5 4h14v16H5V4Z" stroke="currentColor" stroke-width="1.8"/>
                                    <path d="M9 8h6M9 12h6M9 16h3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <h3>Keluhan Aktif</h3>
                        </div>

                        <p>{{ $laporanAktif->count() === 0 ? 'Belum ada laporan kerusakan atau keluhan aktif.' : 'Laporan yang masih diproses admin.' }}</p>

                        <div class="resident-complaint-list">
                            @forelse ($laporanAktif as $laporan)
                                <div class="resident-complaint-item">
                                    <span class="resident-complaint-mark">!</span>
                                    <strong>{{ $laporan->judul }}</strong>
                                    <span>-</span>
                                    <span class="resident-complaint-status">Diproses</span>
                                </div>
                            @empty
                                <div class="resident-empty">
                                    Total laporan aktif: 0
                                </div>
                            @endforelse
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

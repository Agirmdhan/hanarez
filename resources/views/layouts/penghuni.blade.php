<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: 'Figtree', sans-serif; }
            .penghuni-wrap { display: flex; min-height: 100vh; background: #f3f4f6; }

            /* Sidebar */
            .penghuni-sidebar {
                width: 220px;
                background: #1f2937;
                color: #d1d5db;
                display: flex;
                flex-direction: column;
                flex-shrink: 0;
                overflow: hidden;
            }
            .penghuni-sidebar-brand {
                padding: 14px 16px;
                display: flex;
                align-items: center;
                gap: 10px;
                border-bottom: 1px solid #374151;
                white-space: nowrap;
            }
            .penghuni-sidebar-brand span {
                font-size: 16px;
                font-weight: 700;
                color: #f9fafb;
            }
            .penghuni-sidebar-nav { flex: 1; padding: 10px 0; }
            .penghuni-sidebar-link {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 9px 16px;
                color: #d1d5db;
                text-decoration: none;
                font-size: 13px;
                transition: .15s;
                white-space: nowrap;
            }
            .penghuni-sidebar-link:hover { background: #374151; color: #f9fafb; }
            .penghuni-sidebar-link.active { background: #374151; color: #fff; font-weight: 600; border-right: 3px solid #6366f1; }
            .penghuni-sidebar-link svg { width: 18px; height: 18px; flex-shrink: 0; }

            /* Main area */
            .penghuni-main {
                flex: 1;
                display: flex;
                flex-direction: column;
                min-width: 0;
            }

            /* Topbar */
            .penghuni-topbar {
                background: #fff;
                padding: 10px 22px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                box-shadow: 0 1px 2px rgba(0,0,0,.06);
                min-height: 50px;
            }
            .penghuni-topbar h2 { font-size: 16px; font-weight: 700; color: #111827; }
            .penghuni-topbar-right {
                display: flex;
                align-items: center;
                gap: 14px;
                font-size: 13px;
                color: #6b7280;
            }
            .penghuni-topbar-right a {
                color: #6b7280;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 4px 8px;
                border-radius: 4px;
                transition: .15s;
            }
            .penghuni-topbar-right a:hover { background: #f3f4f6; color: #111827; }
            .penghuni-topbar-right a.logout-link:hover { color: #dc2626; }
            .penghuni-topbar-right svg { width: 15px; height: 15px; }

            /* Content */
            .penghuni-content { flex: 1; padding: 22px; overflow-y: auto; }

            @media (max-width: 768px) {
                .penghuni-sidebar { position: fixed; z-index: 50; height: 100vh; }
                .penghuni-content { padding: 14px; }
            }
        </style>
    </head>
    <body>
        <div class="penghuni-wrap">
            {{-- SIDEBAR --}}
            <aside class="penghuni-sidebar">
                <div class="penghuni-sidebar-brand">
                    <span>Hanarez</span>
                </div>
                <nav class="penghuni-sidebar-nav">
                    <a href="{{ route('penghuni.dashboard') }}"
                       class="penghuni-sidebar-link {{ request()->routeIs('penghuni.dashboard') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('penghuni.pengumuman.index') }}"
                       class="penghuni-sidebar-link {{ request()->routeIs('penghuni.pengumuman.*') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.5-1.8 9.44-3.51a.5.5 0 01.728.445V13.5a.5.5 0 01-.728.445C16.332 12.2 12.932 11 8.832 11H7a4.002 4.002 0 01-1.564-3.317z"/>
                        </svg>
                        <span>Pengumuman</span>
                    </a>
                    <a href="{{ route('penghuni.riwayat-tagihan.index') }}"
                       class="penghuni-sidebar-link {{ request()->routeIs('penghuni.riwayat-tagihan.*') ? 'active' : '' }}">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 14l2 2 4-4M6 3h12a2 2 0 012 2v14a2 2 0 01-2 2H6a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                        </svg>
                        <span>Riwayat Tagihan</span>
                    </a>
                </nav>
            </aside>

            {{-- MAIN --}}
            <div class="penghuni-main">
                <header class="penghuni-topbar">
                    <h2>{{ $header ?? 'Penghuni' }}</h2>
                    <div class="penghuni-topbar-right">
                        <a href="{{ route('profile.edit') }}">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            {{ Auth::user()->name }}
                        </a>
                        <form method="POST" action="{{ route('logout') }}" style="display:inline">
                            @csrf
                            <a href="{{ route('logout') }}"
                               class="logout-link"
                               onclick="event.preventDefault(); window.dispatchEvent(new CustomEvent('open-logout-confirm', { detail: { form: this.closest('form') } }));">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Logout
                            </a>
                        </form>
                    </div>
                </header>
                <main class="penghuni-content">
                    {{ $slot }}
                </main>
            </div>
        </div>
        <x-logout-confirmation />
    </body>
</html>

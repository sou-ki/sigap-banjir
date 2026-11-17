<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — SIGAP Banjir</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-900 antialiased" style="font-family:'Inter',sans-serif">

<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside id="sidebar" class="flex flex-col w-52 flex-shrink-0 overflow-y-auto"
           style="background: linear-gradient(180deg,#0f1f3d 0%,#0d1b35 100%)">

        {{-- Logo --}}
        <div class="flex items-center px-4 py-3 border-b border-white/10">
            <a href="{{ route('home') }}">
                <img src="{{ asset('logo.png') }}" alt="SIGAP Banjir" class="h-10 w-auto brightness-0 invert">
            </a>
        </div>

        {{-- User info --}}
        <div class="px-4 py-3 border-b border-white/10">
            <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-0.5">Masyarakat</p>
            <p class="text-sm font-semibold text-white truncate">Report Telegram</p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-2 py-3 space-y-0.5">
            @php
            $navItems = [
                ['route' => 'dashboard.beranda',             'label' => 'Beranda',              'icon' => 'home'],
                ['route' => 'dashboard.peta-banjir',         'label' => 'Peta Banjir',          'icon' => 'map'],
                ['route' => 'dashboard.laporan-banjir',      'label' => 'Laporkan Banjir',      'icon' => 'warning'],
                ['route' => 'dashboard.laporan-saya',        'label' => 'Laporan Saya',         'icon' => 'doc'],
                ['route' => 'dashboard.rute-evakuasi',       'label' => 'Rute Evakuasi',        'icon' => 'route'],
                ['route' => 'dashboard.lokasi-pengungsian',  'label' => 'Lokasi Pengungsian',   'icon' => 'building'],
                ['route' => 'dashboard.permintaan-evakuasi', 'label' => 'Permintaan Evakuasi',  'icon' => 'run'],
                ['route' => 'dashboard.notifikasi',          'label' => 'Notifikasi',           'icon' => 'bell'],
                ['route' => 'dashboard.profil',              'label' => 'Profil',               'icon' => 'user'],
            ];
            $icons = [
                'home'     => '<path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>',
                'map'      => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>',
                'warning'  => '<path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>',
                'doc'      => '<path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>',
                'route'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>',
                'building' => '<path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/>',
                'run'      => '<path d="M13.49 5.48c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm-3.6 13.9l1-4.4 2.1 2v6h2v-7.5l-2.1-2 .6-3c1.3 1.5 3.3 2.5 5.5 2.5v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1l-5.2 2.2v4.7h2v-3.4l1.8-.7-1.6 8.1-4.9-1-.4 2 7 1.4z"/>',
                'bell'     => '<path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>',
                'user'     => '<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>',
            ];
            $useStroke = ['map', 'route'];
            @endphp

            @foreach($navItems as $item)
            @php $active = request()->routeIs($item['route']); @endphp
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium transition-all
                      {{ $active ? 'bg-blue-600/30 text-white border-l-2 border-blue-400' : 'text-blue-200 hover:bg-white/10 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-4 h-4 flex-shrink-0"
                     {{ in_array($item['icon'], $useStroke) ? 'fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"' : 'viewBox="0 0 24 24" fill="currentColor"' }}>
                    {!! $icons[$item['icon']] !!}
                </svg>
                <span class="truncate">{{ $item['label'] }}</span>
                @if($item['icon'] === 'bell')
                <span class="ml-auto w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center hidden" id="notif-badge">0</span>
                @endif
            </a>
            @endforeach
        </nav>

        {{-- Logout --}}
        <div class="px-2 py-3 border-t border-white/10">
            <a href="{{ route('home') }}"
               class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm font-medium text-red-300 hover:bg-red-500/20 hover:text-red-200 transition-colors w-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                </svg>
                Keluar
            </a>
        </div>
    </aside>

    {{-- ===== MAIN AREA ===== --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top header --}}
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-gray-900 leading-tight">@yield('title', 'Dashboard')</h1>
                <p class="text-xs text-gray-500 mt-0.5">
                    Kota Lhokseumawe, Aceh
                </p>
            </div>
            <div class="flex items-center gap-3">
                {{-- Ganti Peran --}}
                <button class="flex items-center gap-1.5 text-xs font-medium text-gray-600 border border-gray-200 rounded-lg px-3 py-1.5 hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Ganti Peran (Demo)
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                {{-- Bell --}}
                <button class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-500 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                    </svg>
                </button>
                {{-- Avatar --}}
                <div class="w-8 h-8 rounded-full bg-teal-500 flex items-center justify-center text-white text-xs font-bold">RT</div>
            </div>
        </header>

        {{-- Page content --}}
        <main class="flex-1 overflow-y-auto bg-gray-50">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
@stack('scripts')
</body>
</html>

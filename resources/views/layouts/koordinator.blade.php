<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard Koordinator') — SIGAP Banjir</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 antialiased" style="font-family:'Inter',sans-serif">
<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="flex flex-col w-52 flex-shrink-0 overflow-y-auto" style="background:#0d1b35">
        <style>
            aside a { color: rgba(255,255,255,0.75); }
            aside a:hover { color: #fff; background: rgba(255,255,255,0.08); }
        </style>

        {{-- Logo --}}
        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-white/10 flex-shrink-0">
            <div class="w-7 h-7 rounded-lg bg-teal-500 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
            </div>
            <div class="leading-tight">
                <p class="text-sm font-extrabold text-white leading-none">SIGAP</p>
                <p class="text-xs font-bold text-teal-300 leading-none">BANJIR</p>
            </div>
        </div>

        {{-- User --}}
        <div class="px-4 py-3 border-b border-white/10 flex-shrink-0">
            <p class="text-xs font-bold text-teal-400 uppercase tracking-widest mb-0.5">Koordinator</p>
            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-2 py-2 overflow-y-auto space-y-3">

            {{-- Relawan --}}
            <div>
                <p class="text-xs font-bold text-teal-400/50 uppercase tracking-widest px-2 mb-1 mt-1">Relawan</p>
                @php
                $rel = [
                    ['route'=>'koordinator.dashboard',         'label'=>'Dashboard',         'svg'=>'<path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>'],
                    ['route'=>'koordinator.kebutuhan-relawan', 'label'=>'Kebutuhan Relawan', 'svg'=>'<path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>'],
                    ['route'=>'koordinator.data-relawan',      'label'=>'Data Relawan',      'svg'=>'<path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>'],
                    ['route'=>'koordinator.alokasi-relawan',   'label'=>'Alokasi Relawan',   'svg'=>'<path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>'],
                    ['route'=>'koordinator.penugasan-aktif',   'label'=>'Penugasan Aktif',   'svg'=>'<path d="M3.5 18.49l6-6.01 4 4L22 6.92l-1.41-1.41-7.09 7.97-4-4L2 16.99z"/>', 'badge'=>2],
                    ['route'=>'koordinator.riwayat-penugasan', 'label'=>'Riwayat Penugasan', 'svg'=>'<path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/>'],
                ];
                @endphp
                @foreach($rel as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs font-medium transition-all mb-0.5
                          {{ $active ? 'bg-teal-500/20 text-white border-l-2 border-teal-400' : 'hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 opacity-80" style="width:15px;height:15px;min-width:15px" viewBox="0 0 24 24" fill="currentColor">
                        {!! $item['svg'] !!}
                    </svg>
                    <span class="truncate">{{ $item['label'] }}</span>
                    @if(!empty($item['badge']) && $item['badge'] > 0)
                    <span class="ml-auto min-w-[16px] h-[16px] bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold px-1 flex-shrink-0">{{ $item['badge'] }}</span>
                    @endif
                </a>
                @endforeach
            </div>

            {{-- Logistik --}}
            <div>
                <p class="text-xs font-bold text-teal-400/50 uppercase tracking-widest px-2 mb-1">Logistik</p>
                @php
                $log = [
                    ['route'=>'koordinator.dashboard-logistik',             'label'=>'Dashboard Logistik', 'svg'=>'<path d="M20 7l-8-4-8 4v10l8 4 8-4V7zm-8 1.5L18 11l-6 3-6-3 6-2.5zM4 12.3l7 3.5V20l-7-3.5V12.3zm9 3.5l7-3.5v4.2l-7 3.5V15.8z"/>'],
                    ['route'=>'koordinator.bantuan-dihimpun',               'label'=>'Bantuan Dihimpun',   'svg'=>'<path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/>'],
                    ['route'=>'koordinator.kebutuhan-lapangan',             'label'=>'Kebutuhan Lapangan', 'svg'=>'<path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>'],
                    ['route'=>'koordinator.kebutuhan-berdasarkan-prioritas','label'=>'Prioritas Kebutuhan','svg'=>'<path d="M4 6H2v14c0 1.1.9 2 2 2h14v-2H4V6zm16-4H8c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 9H9V9h10v2zm-4 4H9v-2h6v2zm4-8H9V5h10v2z"/>'],
                    ['route'=>'koordinator.alokasi-penyaluran',             'label'=>'Alokasi & Penyaluran','svg'=>'<path d="M20 8h-3V4H3c-1.1 0-2 .9-2 2v11h2c0 1.66 1.34 3 3 3s3-1.34 3-3h6c0 1.66 1.34 3 3 3s3-1.34 3-3h2v-5l-3-4zM6 18.5c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5zm13.5-9l1.96 2.5H17V9.5h2.5zm-1.5 9c-.83 0-1.5-.67-1.5-1.5s.67-1.5 1.5-1.5 1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/>'],
                    ['route'=>'koordinator.konfirmasi-penerimaan',          'label'=>'Konfirmasi Penerimaan','svg'=>'<path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/>'],
                    ['route'=>'koordinator.riwayat-distribusi',             'label'=>'Riwayat Distribusi',  'svg'=>'<path d="M13 3c-4.97 0-9 4.03-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42C8.27 19.99 10.51 21 13 21c4.97 0 9-4.03 9-9s-4.03-9-9-9zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/>'],
                ];
                @endphp
                @foreach($log as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs font-medium transition-all mb-0.5
                          {{ $active ? 'bg-teal-500/20 text-white border-l-2 border-teal-400' : 'hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 opacity-80" style="width:15px;height:15px;min-width:15px" viewBox="0 0 24 24" fill="currentColor">
                        {!! $item['svg'] !!}
                    </svg>
                    <span class="truncate">{{ $item['label'] }}</span>
                </a>
                @endforeach
            </div>

            {{-- Lainnya --}}
            <div>
                <p class="text-xs font-bold text-teal-400/50 uppercase tracking-widest px-2 mb-1">Lainnya</p>
                @php
                $lain = [
                    ['route'=>'koordinator.laporan-kegiatan', 'label'=>'Laporan Kegiatan', 'svg'=>'<path d="M5 9.2h3V19H5V9.2zM10.6 5h2.8v14h-2.8V5zm5.6 8H19v6h-2.8v-6z"/>'],
                    ['route'=>'koordinator.profil',           'label'=>'Profil',            'svg'=>'<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>'],
                ];
                @endphp
                @foreach($lain as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs font-medium transition-all mb-0.5
                          {{ $active ? 'bg-teal-500/20 text-white border-l-2 border-teal-400' : 'hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 opacity-80" style="width:15px;height:15px;min-width:15px" viewBox="0 0 24 24" fill="currentColor">
                        {!! $item['svg'] !!}
                    </svg>
                    <span class="truncate">{{ $item['label'] }}</span>
                </a>
                @endforeach
            </div>
        </nav>

        {{-- Keluar --}}
        <div class="px-2 py-3 border-t border-white/10 flex-shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 w-full px-2.5 py-1.5 rounded-lg text-xs font-medium text-red-300 hover:bg-red-500/20 hover:text-red-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 opacity-80" style="width:15px;height:15px;min-width:15px" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ===== MAIN ===== --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-gray-900">@yield('title')</h1>
                <p class="text-xs text-gray-500 mt-0.5">Kota Lhokseumawe, Aceh</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-teal-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">{{ auth()->user()->initials() }}</div>
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-semibold text-gray-900 leading-none">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Koordinator Relawan</p>
                </div>
            </div>
        </header>
        <main class="flex-1 overflow-y-auto bg-gray-50">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
@stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard Petugas') — SIGAP Banjir</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 antialiased" style="font-family:'Inter',sans-serif">
<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="flex flex-col w-56 flex-shrink-0 overflow-y-auto" style="background:#0f1f3d">
        <style>
            aside a { color: rgba(255,255,255,0.75); }
            aside a:hover { color: #fff; background: rgba(255,255,255,0.08); }
        </style>

        {{-- Logo --}}
        <div class="flex items-center gap-2.5 px-4 py-3.5 border-b border-white/10">
            <div class="w-8 h-8 rounded-lg bg-blue-500 flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
            </div>
            <div class="leading-tight">
                <p class="text-sm font-extrabold text-white leading-none">SIGAP</p>
                <p class="text-xs font-bold text-blue-300 leading-none">BANJIR</p>
            </div>
        </div>

        {{-- User --}}
        <div class="px-4 py-3 border-b border-white/10">
            <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-0.5">Petugas BPBD</p>
            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
        </div>

        {{-- Nav groups --}}
        <nav class="flex-1 px-2 py-2 overflow-y-auto space-y-3">

            {{-- Operasional --}}
            <div>
                <p class="text-xs font-bold text-blue-400/50 uppercase tracking-widest px-2 mb-1 mt-1">Operasional</p>
                @php
                $op = [
                    ['route'=>'petugas.dashboard',          'label'=>'Dashboard',           'icon'=>'home'],
                    ['route'=>'petugas.peta-monitoring',     'label'=>'Peta Monitoring',     'icon'=>'map'],
                    ['route'=>'petugas.verifikasi-laporan',  'label'=>'Verifikasi Laporan',  'icon'=>'check', 'badge'=>$pendingFloodReportsCount],
                    ['route'=>'petugas.data-kejadian',       'label'=>'Data Kejadian',       'icon'=>'list'],
                    ['route'=>'petugas.kondisi-jalan',       'label'=>'Kondisi Jalan',       'icon'=>'road'],
                    ['route'=>'petugas.rute-evakuasi',       'label'=>'Rute Evakuasi',       'icon'=>'route'],
                    ['route'=>'petugas.permintaan-evakuasi', 'label'=>'Permintaan Evakuasi', 'icon'=>'run'],
                    ['route'=>'petugas.lokasi-pengungsian',  'label'=>'Lokasi Pengungsian',  'icon'=>'building'],
                ];
                @endphp
                @foreach($op as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs font-medium transition-all mb-0.5
                          {{ $active ? 'bg-blue-600/25 text-white border-l-2 border-blue-400' : 'hover:text-white' }}">
                    @include('layouts._petugas_icon', ['icon'=>$item['icon']])
                    <span class="truncate flex-1">{{ $item['label'] }}</span>
                    @if(!empty($item['badge']) && $item['badge'] > 0)
                    <span class="ml-auto min-w-[16px] h-[16px] bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold px-1 flex-shrink-0">{{ $item['badge'] }}</span>
                    @endif
                </a>
                @endforeach
            </div>

            {{-- Logistik --}}
            <div>
                <p class="text-xs font-bold text-blue-400/50 uppercase tracking-widest px-2 mb-1">Logistik</p>
                @php
                $log = [
                    ['route'=>'petugas.dashboard-logistik', 'label'=>'Dashboard Logistik', 'icon'=>'box'],
                    ['route'=>'petugas.stok-bantuan',       'label'=>'Stok Bantuan',       'icon'=>'stock'],
                    ['route'=>'petugas.kebutuhan-logistik', 'label'=>'Kebutuhan',          'icon'=>'need'],
                    ['route'=>'petugas.prioritas-kebutuhan','label'=>'Prioritas',          'icon'=>'priority'],
                    ['route'=>'petugas.alokasi-bantuan',    'label'=>'Alokasi Bantuan',    'icon'=>'alloc'],
                    ['route'=>'petugas.penyaluran-bantuan', 'label'=>'Penyaluran',         'icon'=>'send'],
                    ['route'=>'petugas.riwayat-logistik',   'label'=>'Riwayat Logistik',   'icon'=>'history'],
                ];
                @endphp
                @foreach($log as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs font-medium transition-all mb-0.5
                          {{ $active ? 'bg-blue-600/25 text-white border-l-2 border-blue-400' : 'hover:text-white' }}">
                    @include('layouts._petugas_icon', ['icon'=>$item['icon']])
                    <span class="truncate flex-1">{{ $item['label'] }}</span>
                </a>
                @endforeach
            </div>

            {{-- Lainnya --}}
            <div>
                <p class="text-xs font-bold text-blue-400/50 uppercase tracking-widest px-2 mb-1">Lainnya</p>
                @php
                $lap = [
                    ['route'=>'petugas.statistik', 'label'=>'Statistik & Riwayat', 'icon'=>'chart'],
                    ['route'=>'petugas.profil',    'label'=>'Profil',              'icon'=>'user'],
                ];
                @endphp
                @foreach($lap as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs font-medium transition-all mb-0.5
                          {{ $active ? 'bg-blue-600/25 text-white border-l-2 border-blue-400' : 'hover:text-white' }}">
                    @include('layouts._petugas_icon', ['icon'=>$item['icon']])
                    <span class="truncate">{{ $item['label'] }}</span>
                </a>
                @endforeach
            </div>
        </nav>

        {{-- Keluar --}}
        <div class="px-2 py-3 border-t border-white/10 flex-shrink-0">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs font-medium text-red-300 hover:bg-red-500/20 hover:text-red-200 transition-colors w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 opacity-80" style="width:15px;height:15px;min-width:15px" viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
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
                <div class="w-8 h-8 rounded-full bg-blue-700 flex items-center justify-center text-white text-xs font-bold">{{ auth()->user()->initials() }}</div>
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-semibold text-gray-900 leading-none">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Petugas BPBD</p>
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

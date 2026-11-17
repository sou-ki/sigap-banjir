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
    <aside class="flex flex-col w-52 flex-shrink-0 overflow-y-auto" style="background:#0f1f3d">

        {{-- Logo --}}
        <div class="flex items-center px-4 py-3 border-b border-white/10">
            <a href="{{ route('petugas.dashboard') }}">
                <img src="{{ asset('logo.png') }}" alt="SIGAP Banjir" class="h-10 w-auto brightness-0 invert">
            </a>
        </div>

        {{-- User --}}
        <div class="px-4 py-3 border-b border-white/10">
            <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-0.5">Petugas BPBD</p>
            <p class="text-sm font-semibold text-white truncate">Cut Nurmala</p>
        </div>

        {{-- Nav groups --}}
        <nav class="flex-1 px-2 py-3 overflow-y-auto space-y-3">

            {{-- Operasional --}}
            <div>
                <p class="text-xs font-bold text-blue-500/70 uppercase tracking-widest px-2 mb-1">Operasional Informasi</p>
                @php
                $op = [
                    ['route'=>'petugas.dashboard',          'label'=>'Dashboard',           'icon'=>'home'],
                    ['route'=>'petugas.peta-monitoring',     'label'=>'Peta Monitoring Banjir','icon'=>'map', 'badge'=>0],
                    ['route'=>'petugas.verifikasi-laporan',  'label'=>'Verifikasi Laporan',  'icon'=>'check','badge'=>$pendingFloodReportsCount],
                    ['route'=>'petugas.data-kejadian',       'label'=>'Data Kejadian Banjir','icon'=>'list'],
                    ['route'=>'petugas.kondisi-jalan',       'label'=>'Kondisi Jalan',       'icon'=>'road'],
                    ['route'=>'petugas.rute-evakuasi',       'label'=>'Rute Evakuasi',       'icon'=>'route'],
                    ['route'=>'petugas.permintaan-evakuasi', 'label'=>'Permintaan Evakuasi', 'icon'=>'run'],
                    ['route'=>'petugas.lokasi-pengungsian',  'label'=>'Lokasi Pengungsian',  'icon'=>'building'],
                ];
                @endphp
                @foreach($op as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium transition-all mb-0.5 {{ $active ? 'bg-blue-600/30 text-white border-l-2 border-blue-400' : 'text-blue-200 hover:bg-white/10 hover:text-white' }}">
                    @include('layouts._petugas_icon', ['icon'=>$item['icon']])
                    <span class="truncate flex-1">{{ $item['label'] }}</span>
                    @if(!empty($item['badge']) && $item['badge']>0)
                    <span class="ml-auto w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $item['badge'] }}</span>
                    @endif
                </a>
                @endforeach
            </div>

            {{-- Manajemen Logistik --}}
            <div>
                <p class="text-xs font-bold text-blue-500/70 uppercase tracking-widest px-2 mb-1">Manajemen Logistik</p>
                @php
                $log = [
                    ['route'=>'petugas.dashboard-logistik', 'label'=>'Dashboard Logistik','icon'=>'box','badge'=>2],
                    ['route'=>'petugas.stok-bantuan',       'label'=>'Stok Bantuan',      'icon'=>'stock'],
                    ['route'=>'petugas.kebutuhan-logistik', 'label'=>'Kebutuhan Logistik','icon'=>'need'],
                    ['route'=>'petugas.prioritas-kebutuhan','label'=>'Prioritas Kebutuhan','icon'=>'priority'],
                    ['route'=>'petugas.alokasi-bantuan',    'label'=>'Alokasi Bantuan',   'icon'=>'alloc'],
                    ['route'=>'petugas.penyaluran-bantuan', 'label'=>'Penyaluran Bantuan','icon'=>'send'],
                    ['route'=>'petugas.riwayat-logistik',   'label'=>'Riwayat Logistik',  'icon'=>'history'],
                ];
                @endphp
                @foreach($log as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium transition-all mb-0.5 {{ $active ? 'bg-blue-600/30 text-white border-l-2 border-blue-400' : 'text-blue-200 hover:bg-white/10 hover:text-white' }}">
                    @include('layouts._petugas_icon', ['icon'=>$item['icon']])
                    <span class="truncate flex-1">{{ $item['label'] }}</span>
                    @if(!empty($item['badge']) && $item['badge']>0)
                    <span class="ml-auto w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $item['badge'] }}</span>
                    @endif
                </a>
                @endforeach
            </div>

            {{-- Laporan --}}
            <div>
                <p class="text-xs font-bold text-blue-500/70 uppercase tracking-widest px-2 mb-1">Laporan</p>
                @php
                $lap = [
                    ['route'=>'petugas.statistik', 'label'=>'Statistik & Riwayat','icon'=>'chart'],
                    ['route'=>'petugas.profil',    'label'=>'Profil',             'icon'=>'user'],
                ];
                @endphp
                @foreach($lap as $item)
                @php $active = request()->routeIs($item['route']); @endphp
                <a href="{{ route($item['route']) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium transition-all mb-0.5 {{ $active ? 'bg-blue-600/30 text-white border-l-2 border-blue-400' : 'text-blue-200 hover:bg-white/10 hover:text-white' }}">
                    @include('layouts._petugas_icon', ['icon'=>$item['icon']])
                    <span class="truncate">{{ $item['label'] }}</span>
                </a>
                @endforeach
            </div>
        </nav>

        {{-- Keluar --}}
        <div class="px-2 py-3 border-t border-white/10">
            <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium text-red-300 hover:bg-red-500/20 hover:text-red-200 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                Keluar
            </a>
        </div>
    </aside>

    {{-- ===== MAIN ===== --}}
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-gray-900">@yield('title')</h1>
                <p class="text-xs text-gray-500 mt-0.5">
                    Kota Lhokseumawe, Aceh
                </p>
            </div>
            <div class="flex items-center gap-3">
                <button class="flex items-center gap-1.5 text-xs font-medium text-gray-600 border border-gray-200 rounded-lg px-3 py-1.5 hover:bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Ganti Peran (Demo)
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <button class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100 text-gray-500 relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.64-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.63 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/></svg>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center text-white text-xs font-bold">CN</div>
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

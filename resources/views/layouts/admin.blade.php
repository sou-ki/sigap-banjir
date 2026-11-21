<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') — SIGAP Banjir</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 antialiased" style="font-family:'Inter',sans-serif">
<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="flex flex-col w-52 flex-shrink-0 overflow-y-auto" style="background:#0f1f3d">

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

        {{-- User info --}}
        <div class="px-4 py-3 border-b border-white/10">
            <p class="text-xs font-bold text-blue-400 uppercase tracking-widest mb-0.5">Admin Sistem</p>
            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-2 py-2 space-y-0.5">
            @php
            $nav = [
                ['route'=>'admin.dashboard',           'label'=>'Dashboard',           'icon'=>'home'],
                ['route'=>'admin.manajemen-pengguna',   'label'=>'Manajemen Pengguna',  'icon'=>'users'],
                ['route'=>'admin.peran-hak-akses',      'label'=>'Peran & Hak Akses',   'icon'=>'shield'],
                ['route'=>'admin.log-aktivitas',        'label'=>'Log Aktivitas',       'icon'=>'log'],
                ['route'=>'admin.pengaturan-sistem',    'label'=>'Pengaturan Sistem',   'icon'=>'settings'],
                ['route'=>'admin.profil',               'label'=>'Profil',              'icon'=>'user'],
            ];
            $icons = [
                'home'     => '<path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>',
                'users'    => '<path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>',
                'shield'   => '<path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z"/>',
                'log'      => '<path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>',
                'settings' => '<path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/>',
                'user'     => '<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>',
            ];
            @endphp
            @foreach($nav as $item)
            @php $active = request()->routeIs($item['route']); @endphp
            <a href="{{ route($item['route']) }}"
               class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg text-xs font-medium transition-all mb-0.5
                      {{ $active ? 'bg-blue-600/25 text-white border-l-2 border-blue-400' : 'hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 opacity-80" style="width:15px;height:15px;min-width:15px" viewBox="0 0 24 24" fill="currentColor">{!! $icons[$item['icon']] !!}</svg>
                <span class="truncate">{{ $item['label'] }}</span>
            </a>
            @endforeach
        </nav>

        {{-- Keluar --}}
        <div class="px-2 py-3 border-t border-white/10">
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

        {{-- Top header --}}
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between flex-shrink-0">
            <div>
                <h1 class="text-base font-bold text-gray-900">@yield('title', 'Dashboard')</h1>
                <p class="text-xs text-gray-500 mt-0.5">Kota Lhokseumawe, Aceh</p>
            </div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-700 flex items-center justify-center text-white text-xs font-bold">{{ auth()->user()->initials() }}</div>
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-semibold text-gray-900 leading-none">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">Admin Sistem</p>
                </div>
            </div>
        </header>

        <main class="flex-1 overflow-y-auto bg-gray-50">
            @yield('content')
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>

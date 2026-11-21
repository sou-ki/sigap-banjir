<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SIGAP Banjir - Sistem Informasi Geografis Banjir Kota Lhokseumawe')</title>
    <meta name="description" content="Platform informasi geografis berbasis partisipasi masyarakat untuk mendukung pemantauan banjir, informasi evakuasi, dan koordinasi bantuan di Kota Lhokseumawe.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-white text-gray-900 antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                        </svg>
                    </div>
                    <div class="leading-tight">
                        <p class="text-sm font-extrabold text-gray-900 leading-none">SIGAP</p>
                        <p class="text-xs font-bold text-blue-600 leading-none">BANJIR</p>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }} rounded-md transition-colors">Beranda</a>
                    <a href="{{ route('peta-banjir') }}" class="px-4 py-2 text-sm font-medium {{ request()->routeIs('peta-banjir') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }} rounded-md transition-colors">Peta Banjir</a>
                    <a href="{{ route('lokasi-pengungsian') }}" class="px-4 py-2 text-sm font-medium {{ request()->routeIs('lokasi-pengungsian') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }} rounded-md transition-colors">Lokasi Pengungsian</a>
                    <a href="{{ route('panduan-evakuasi') }}" class="px-4 py-2 text-sm font-medium {{ request()->routeIs('panduan-evakuasi') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }} rounded-md transition-colors">Panduan Evakuasi</a>
                    <a href="{{ route('permintaan-evakuasi') }}" class="px-4 py-2 text-sm font-medium {{ request()->routeIs('permintaan-evakuasi') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }} rounded-md transition-colors">Permintaan Evakuasi</a>
                    <a href="{{ route('status-warga') }}" class="px-4 py-2 text-sm font-medium {{ request()->routeIs('status-warga') ? 'text-blue-700' : 'text-gray-600 hover:text-blue-700' }} rounded-md transition-colors">Cek Status</a>
                </div>

                <!-- Right side buttons -->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                    <a href="{{ auth()->user()->dashboardRoute() }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors flex items-center gap-1.5">
                        <div class="w-6 h-6 rounded-full bg-blue-600 flex items-center justify-center text-white text-xs font-bold">{{ auth()->user()->initials() }}</div>
                        {{ auth()->user()->name }}
                    </a>
                    @else
                    <a href="{{ route('masuk') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 transition-colors">Masuk</a>
                    @endauth
                    <a href="{{ route('lapor-banjir') }}" class="px-4 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg flex items-center gap-2 transition-colors shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                        </svg>
                        Laporkan Banjir
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100">
                    <svg id="menu-icon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg id="close-icon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 bg-white">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">Beranda</a>
                <a href="{{ route('peta-banjir') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">Peta Banjir</a>
                <a href="{{ route('lokasi-pengungsian') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">Lokasi Pengungsian</a>
                <a href="{{ route('panduan-evakuasi') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">Panduan Evakuasi</a>
                <a href="{{ route('permintaan-evakuasi') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">Permintaan Evakuasi</a>
                <a href="{{ route('status-warga') }}" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">Cek Status Laporan</a>
                <div class="pt-2 border-t border-gray-100 flex flex-col gap-2">
                    @auth
                    <a href="{{ auth()->user()->dashboardRoute() }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">Dashboard</a>
                    @else
                    <a href="{{ route('masuk') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">Masuk</a>
                    @endauth
                    <a href="{{ route('lapor-banjir') }}" class="px-3 py-2 text-sm font-semibold text-white bg-red-600 hover:bg-red-700 rounded-lg flex items-center gap-2 justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                        </svg>
                        Laporkan Banjir
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Brand -->
                <div class="col-span-1">
                    <div class="flex items-center gap-2 mb-4">
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
                    <p class="text-sm text-gray-400 leading-relaxed">
                        Sistem Informasi Geografis dan Koordinasi Respons Banjir Kota Lhokseumawe. Prototipe Web GIS berbasis partisipasi masyarakat (crowdsourcing).
                    </p>
                </div>

                <!-- Menu -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Menu</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('peta-banjir') }}" class="hover:text-white transition-colors">Peta Banjir</a></li>
                        <li><a href="{{ route('lokasi-pengungsian') }}" class="hover:text-white transition-colors">Lokasi Pengungsian</a></li>
                        <li><a href="{{ route('panduan-evakuasi') }}" class="hover:text-white transition-colors">Panduan Evakuasi</a></li>
                        <li><a href="{{ route('masuk') }}" class="hover:text-white transition-colors">Masuk</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Kontak Proyek</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                            bpbd@lhokseumawekota.go.id
                        </li>
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                             Permata Hijau, Alue Awe, Kec. Muara Dua, Kota Lhokseumawe, Aceh
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <p class="text-xs text-center text-gray-500">
                    <span class="text-yellow-400 font-medium">Prototipe penelitian Proyek Capstone</span>
                    &mdash; bukan layanan darurat resmi pemerintah. Seluruh data pada aplikasi ini adalah simulasi dan bukan informasi bencana yang sebenarnya.
                </p>
            </div>
        </div>
    </footer>

    <!-- Mobile menu toggle -->
    <script>
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            menuIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });
    </script>

    @stack('scripts')
</body>
</html>

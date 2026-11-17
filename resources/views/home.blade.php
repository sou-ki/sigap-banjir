@extends('layouts.app')

@section('title', 'Beranda — SIGAP Banjir Kota Lhokseumawe')

@section('content')

{{-- HERO SECTION --}}
<section class="hero-bg text-white py-16 lg:py-24 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            {{-- Left: text --}}
            <div class="flex-1 max-w-xl">
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-2 text-sm mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Web GIS Kota Lhokseumawe · Prototipe Capstone
                </div>
                <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-4">
                    Informasi Banjir Lebih Cepat,
                    <span class="text-blue-400"> Respons Lebih Terarah</span>
                </h1>
                <p class="text-gray-300 text-lg leading-relaxed mb-8">
                    Platform informasi geografis berbasis partisipasi masyarakat untuk mendukung pemantauan banjir, informasi evakuasi, dan koordinasi bantuan di Kota Lhokseumawe.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('lapor-banjir') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors shadow-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                        </svg>
                        Laporkan Kejadian Banjir
                    </a>
                    <a href="{{ route('peta-banjir') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/20 border border-white/30 text-white font-semibold rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                        Lihat Peta Banjir
                    </a>
                </div>

            </div>

            {{-- Right: mini map mockup --}}
            <div class="flex-1 w-full max-w-lg">
                <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-white/20">
                    <div class="bg-yellow-50 border-b border-yellow-200 px-4 py-2 flex items-center gap-2 text-yellow-700 text-xs font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                        </svg>
                        PROTOTIPE · Peta simulasi Kota Lhokseumawe
                    </div>
                    <div id="hero-map" class="w-full bg-gray-100 relative" style="height:288px"></div>
                    <script>
                    // Init langsung setelah div ada di DOM
                    window.addEventListener('load', function() {
                        if (typeof L === 'undefined') return;
                        var m = L.map('hero-map', { zoomControl:true, attributionControl:false, scrollWheelZoom:false })
                                  .setView([5.1801, 97.1500], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom:18 }).addTo(m);
                        [[5.183,97.148,'Mon Geudong','#dc2626'],
                         [5.178,97.153,'Keude Aceh','#d97706'],
                         [5.175,97.145,'Hagu Selatan','#dc2626'],
                         [5.185,97.155,'Banda Sakti','#16a34a']]
                        .forEach(function(p){
                            L.circleMarker([p[0],p[1]],{radius:12,fillColor:p[3],color:'#fff',weight:2,fillOpacity:0.85})
                             .addTo(m).bindPopup('<b>'+p[2]+'</b>');
                        });
                        m.invalidateSize();
                    });
                    </script>
                    <div class="px-4 py-3 bg-white border-t border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 bg-red-100 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                                </svg>
                            </span>
                            <div>
                                <p class="text-xs text-gray-500">Kejadian aktif terverifikasi</p>
                                <p class="text-lg font-bold text-gray-900">4 titik</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                            </svg>
                            DATA SIMULASI
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- STATS SECTION --}}
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-start justify-between mb-6 flex-wrap gap-2">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Ringkasan Informasi Publik</h2>
                <p class="text-sm text-gray-500">Diperbarui otomatis dari laporan terverifikasi.</p>
            </div>
            <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1.5 rounded-full self-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                </svg>
                DATA SIMULASI
            </span>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm card-hover">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">6</p>
                <p class="text-sm text-gray-500">Laporan Banjir Terverifikasi</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm card-hover">
                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2c-5.33 4.55-8 8.48-8 11.8 0 4.98 3.8 8.2 8 8.2s8-3.22 8-8.2c0-3.32-2.67-7.25-8-11.8z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">4</p>
                <p class="text-sm text-gray-500">Lokasi Terdampak</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm card-hover">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">5</p>
                <p class="text-sm text-gray-500">Titik Pengungsian</p>
            </div>
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm card-hover">
                <div class="w-10 h-10 bg-indigo-100 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-indigo-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                    </svg>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">3</p>
                <p class="text-sm text-gray-500">Laporan Dalam Penanganan</p>
            </div>
        </div>
    </div>
</section>

{{-- FEATURES SECTION --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide mb-2">FITUR UTAMA</p>
        <h2 class="text-2xl lg:text-3xl font-bold text-gray-900 mb-10 max-w-lg">
            Satu platform dari laporan warga hingga koordinasi lapangan
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Feature 1 --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm card-hover">
                <div class="w-12 h-12 bg-gray-900 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>
                    </svg>
                </div>
                <p class="text-xs text-gray-400 font-medium mb-1">01</p>
                <h3 class="font-bold text-gray-900 mb-2">Pelaporan Banjir</h3>
                <p class="text-sm text-gray-500 mb-4 leading-relaxed">Kirim laporan lengkap dengan lokasi di peta, ketinggian air, dan foto langsung dari ponsel.</p>
                <a href="{{ route('lapor-banjir') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    Selengkapnya
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
                </a>
            </div>

            {{-- Feature 2 --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm card-hover">
                <div class="w-12 h-12 bg-gray-900 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <p class="text-xs text-gray-400 font-medium mb-1">02</p>
                <h3 class="font-bold text-gray-900 mb-2">Peta Persebaran Banjir</h3>
                <p class="text-sm text-gray-500 mb-4 leading-relaxed">Pantau titik banjir terverifikasi, area terdampak, dan kondisi jalan secara visual.</p>
                <a href="{{ route('peta-banjir') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    Selengkapnya
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
                </a>
            </div>

            {{-- Feature 3 --}}
            <div class="bg-blue-600 rounded-2xl p-6 border border-blue-500 shadow-sm card-hover">
                <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M3 17h18v2H3v-2zm0-7h18v5H3v-5zm0-4h18v2H3V6z"/>
                    </svg>
                </div>
                <p class="text-xs text-blue-200 font-medium mb-1">03</p>
                <h3 class="font-bold text-white mb-2">Informasi Jalur Evakuasi</h3>
                <p class="text-sm text-blue-100 mb-4 leading-relaxed">Lihat rute pendukung menuju pengungsian berdasarkan data kondisi jalan terkini.</p>
                <a href="{{ route('panduan-evakuasi') }}" class="text-sm font-semibold text-white hover:text-blue-200 flex items-center gap-1">
                    Selengkapnya
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
                </a>
            </div>

            {{-- Feature 4 --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm card-hover">
                <div class="w-12 h-12 bg-gray-900 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/>
                    </svg>
                </div>
                <p class="text-xs text-gray-400 font-medium mb-1">04</p>
                <h3 class="font-bold text-gray-900 mb-2">Informasi Pengungsian</h3>
                <p class="text-sm text-gray-500 mb-4 leading-relaxed">Cek lokasi, kapasitas tersisa, dan fasilitas di setiap titik pengungsian.</p>
                <a href="{{ route('lokasi-pengungsian') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1">
                    Selengkapnya
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6z"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- HOW TO REPORT SECTION --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gray-50 rounded-3xl p-8 lg:p-12">
            <div class="flex flex-col lg:flex-row gap-10">
                <div class="flex-shrink-0 max-w-xs">
                    <p class="text-xs font-bold uppercase tracking-widest text-blue-600 mb-3">CARA MELAPORKAN BANJIR</p>
                    <h2 class="text-2xl lg:text-3xl font-extrabold text-gray-900 mb-3">
                        Empat langkah, kurang dari tiga menit
                    </h2>
                    <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                        Laporan Anda akan diverifikasi petugas sebelum tampil sebagai informasi terkonfirmasi di peta.
                    </p>
                    <a href="{{ route('lapor-banjir') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                        </svg>
                        Mulai Melapor
                    </a>
                </div>
                <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">1. Masuk atau daftar</h4>
                            <p class="text-sm text-gray-500 mt-1">Buat akun warga gratis untuk mengirim laporan.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">2. Tandai lokasi</h4>
                            <p class="text-sm text-gray-500 mt-1">Klik peta atau gunakan lokasi Anda saat ini.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">3. Isi detail &amp; foto</h4>
                            <p class="text-sm text-gray-500 mt-1">Tulis kondisi, ketinggian air, dan unggah foto.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 text-sm">4. Pantau verifikasi</h4>
                            <p class="text-sm text-gray-500 mt-1">Lacak status laporan hingga ditangani petugas.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- RECENT REPORTS SECTION --}}
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-start justify-between mb-6 flex-wrap gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Informasi Kondisi Wilayah</h2>
                <p class="text-sm text-gray-500">Laporan terverifikasi terbaru — kontak pelapor tidak ditampilkan.</p>
            </div>
            <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-700 text-xs font-semibold px-3 py-1.5 rounded-full self-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                </svg>
                DATA SIMULASI
            </span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            {{-- Report Card 1 --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm card-hover">
                <div class="flex items-center justify-between mb-3">
                    <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                        </svg>
                        Bahaya Tinggi
                    </span>
                    <span class="text-xs text-gray-400">24 Okt 2026, 05:40</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Jalan Perdagangan terendam setinggi paha</h3>
                <p class="text-sm text-gray-500 flex items-center gap-1 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    Mon Geudong, Lhokseumawe
                </p>
                <p class="text-sm text-gray-700">Tinggi air: <span class="font-semibold">Lebih dari 100 cm</span></p>
            </div>

            {{-- Report Card 2 --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm card-hover">
                <div class="flex items-center justify-between mb-3">
                    <span class="inline-flex items-center gap-1.5 bg-orange-100 text-orange-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                        </svg>
                        Bahaya Sedang
                    </span>
                    <span class="text-xs text-gray-400">24 Okt 2026, 06:05</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Genangan di depan pasar Keude Aceh</h3>
                <p class="text-sm text-gray-500 flex items-center gap-1 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    Keude Aceh, Lhokseumawe
                </p>
                <p class="text-sm text-gray-700">Tinggi air: <span class="font-semibold">30–60 cm</span></p>
            </div>

            {{-- Report Card 3 --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm card-hover">
                <div class="flex items-center justify-between mb-3">
                    <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                        </svg>
                        Bahaya Tinggi
                    </span>
                    <span class="text-xs text-gray-400">24 Okt 2026, 04:55</span>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Air sungai meluap ke permukiman Hagu Selatan</h3>
                <p class="text-sm text-gray-500 flex items-center gap-1 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    Hagu Selatan, Lhokseumawe
                </p>
                <p class="text-sm text-gray-700">Tinggi air: <span class="font-semibold">61–100 cm</span></p>
            </div>
        </div>
    </div>
</section>

{{-- SAFETY GUIDE SECTION --}}
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-xl font-bold text-gray-900 mb-2">Panduan Keselamatan Singkat</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            {{-- Before --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-3">Sebelum Banjir</h3>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                        Siapkan tas siaga: dokumen, obat, senter, dan air minum.
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                        Kenali lokasi pengungsian terdekat dan jalur menuju ke sana.
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                        Simpan kontak keluarga dan ketua lingkungan.
                    </li>
                </ul>
            </div>

            {{-- During --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11 2v20c-5.07-.5-9-4.79-9-10s3.93-9.5 9-10zm2.03 0v8.99H22c-.47-4.74-4.24-8.52-8.97-8.99zm0 11.01V22c4.74-.47 8.5-4.25 8.97-8.99h-8.97z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-3">Saat Banjir</h3>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                        Matikan listrik dan hindari kabel terendam.
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                        Jangan berjalan atau berkendara melewati air yang mengalir deras.
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                        Utamakan lansia, anak-anak, dan ibu hamil.
                    </li>
                </ul>
            </div>

            {{-- After --}}
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-3">Setelah Banjir</h3>
                <ul class="space-y-2">
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                        Periksa kondisi bangunan sebelum masuk kembali.
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                        Bersihkan area dengan alat pelindung.
                    </li>
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                        Laporkan kerusakan atau kebutuhan bantuan melalui platform.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

@endsection

{{-- map init sudah inline di atas --}}

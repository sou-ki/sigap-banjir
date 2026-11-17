@extends('layouts.dashboard')
@section('title', 'Beranda')

@push('styles')
<style> #dash-map { height: 280px; } </style>
@endpush

@section('content')
<div class="p-6">

    {{-- Breadcrumb & title --}}
    <div class="flex items-start justify-between mb-5 flex-wrap gap-3">
        <div>
            <p class="text-xs text-gray-400 mb-1">Peta / <span class="text-gray-600">Beranda</span></p>
            <h2 class="text-xl font-extrabold text-gray-900">Selamat Datang di SIGAP BANJIR</h2>
            <p class="text-sm text-gray-500 mt-0.5">Halo, <strong>Report Telegram</strong>. Pantau kondisi banjir dan kelola laporan Anda.</p>
        </div>
        <a href="{{ route('dashboard.laporan-banjir') }}"
           class="inline-flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
            </svg>
            Laporkan Banjir
        </a>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php $stats = [
            ['label' => 'Ya Laporan Baru',       'val' => 0, 'bg' => 'bg-blue-100',   'color' => 'text-blue-600',   'icon' => '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>'],
            ['label' => 'Menunggu Verifikasi',   'val' => 0, 'bg' => 'bg-orange-100', 'color' => 'text-orange-500', 'icon' => '<path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>'],
            ['label' => 'Sedang Di-proses',      'val' => 0, 'bg' => 'bg-purple-100', 'color' => 'text-purple-600', 'icon' => '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>'],
            ['label' => 'Selesai',                'val' => 0, 'bg' => 'bg-green-100',  'color' => 'text-green-600',  'icon' => '<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>'],
        ]; @endphp
        @foreach($stats as $s)
        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm flex items-start justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">{{ $s['label'] }}</p>
                <p class="text-2xl font-extrabold text-gray-900">{{ $s['val'] }}</p>
            </div>
            <div class="w-9 h-9 {{ $s['bg'] }} rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $s['color'] }}" viewBox="0 0 24 24" fill="currentColor">{!! $s['icon'] !!}</svg>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Two column --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5 mb-5">

        {{-- Map --}}
        <div class="lg:col-span-3 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <div>
                    <p class="text-sm font-bold text-gray-900">Pemantauan Banjir Terkini</p>
                    <p class="text-xs text-gray-500">Laporan yang sudah terverifikasi.</p>
                </div>
                <a href="{{ route('dashboard.peta-banjir') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Buka Peta →</a>
            </div>
            <div class="relative">
                <div class="absolute top-2 left-2 z-10 inline-flex items-center gap-1 bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs font-medium px-2.5 py-1 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
                    PROTOTIPE · Peta simulasi Kota Lhokseumawe
                </div>
                <div id="dash-map"></div>
            </div>
        </div>

        {{-- Right column --}}
        <div class="lg:col-span-2 flex flex-col gap-4">
            {{-- Latest reports --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm flex-1">
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-bold text-gray-900">Daftar Laporan Terbaru</p>
                </div>
                <div class="flex flex-col items-center justify-center py-8 px-4 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-200 mb-3" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"/>
                    </svg>
                    <p class="text-sm font-semibold text-gray-600">Belum ada laporan</p>
                    <p class="text-xs text-gray-400 mt-1">Laporan yang Anda kirim beserta statusnya akan muncul di sini.</p>
                </div>
            </div>

            {{-- Nearest shelters --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-bold text-gray-900">Pengungsian Terdekat</p>
                    <a href="{{ route('dashboard.lokasi-pengungsian') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Semua</a>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach([['GOR Kota Lhokseumawe', 'Sisa 188'], ['SDN 1 Banda Sakti', 'Sisa 156'], ['Gedung Serbaguna Muara Satu', 'Sisa 203']] as $sh)
                    <div class="flex items-center justify-between px-4 py-3">
                        <div class="flex items-center gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-green-500 flex-shrink-0"></span>
                            <span class="text-sm text-gray-800">{{ $sh[0] }}</span>
                        </div>
                        <span class="text-xs font-semibold text-green-600">{{ $sh[1] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Lapor bencana baru --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 text-center">
        <p class="text-sm font-bold text-gray-700 mb-1">Lapor Bencana Baru</p>
        <div class="flex flex-col items-center py-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-200 mb-3" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 6h-2.18c.07-.44.18-.87.18-1.33C18 2.54 15.66 1 13 1c-1.18 0-2.36.35-3.37.97L8.24 3.63C7.33 4.16 6.5 4.84 5.83 5.67L5 6.5V3H3v5l-2 3v2h2v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-8h2v-2l-3-5zM6.7 7.83C7.66 7.05 8.8 6.5 10 6.14V8h4V6.14c1.2.36 2.34.91 3.3 1.69L19 9H5l1.7-1.17zM18 20H6v-9h12v9z"/>
            </svg>
            <p class="text-sm font-semibold text-gray-600">Baru satu laporan</p>
            <p class="text-xs text-gray-400 mt-1 mb-4 max-w-xs">Kirim laporan banjir untuk membantu koordinasi petugas dan warga di sekitar Anda.</p>
            <a href="{{ route('dashboard.laporan-banjir') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                Laporkan Banjir
            </a>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('dash-map', { zoomControl: false, attributionControl: false }).setView([5.1801, 97.1500], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);
    [[5.183,97.148,'#dc2626'],[5.178,97.153,'#f97316'],[5.175,97.145,'#dc2626'],[5.188,97.152,'#eab308']].forEach(function(p){
        L.circleMarker([p[0],p[1]],{radius:14,fillColor:p[2],color:p[2],weight:2,fillOpacity:0.35}).addTo(map);
        const ic=L.divIcon({html:'<div style="width:14px;height:14px;background:'+p[2]+';border-radius:50%;border:2px solid #fff;box-shadow:0 1px 3px rgba(0,0,0,.3)"></div>',className:'',iconSize:[14,14],iconAnchor:[7,7]});
        L.marker([p[0],p[1]],{icon:ic}).addTo(map);
    });
    const si=L.divIcon({html:'<div style="background:#1d4ed8;width:22px;height:22px;border-radius:50%;border:2px solid #fff;display:flex;align-items:center;justify-content:center;"><svg width="11" height="11" viewBox="0 0 24 24" fill="white"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>',className:'',iconSize:[22,22],iconAnchor:[11,11]});
    [[5.182,97.142],[5.170,97.150],[5.195,97.165]].forEach(s=>L.marker(s,{icon:si}).addTo(map));
});
</script>
@endpush

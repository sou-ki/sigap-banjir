@extends('layouts.app')

@section('title', 'Peta Banjir — SIGAP Banjir Kota Lhokseumawe')

@push('styles')
<style>
    #main-map { height: 520px; }
    .dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
    .filter-btn.active { background: #1e3a5f; color: #fff; }
    .tab-btn.active { background: #1e3a5f; color: #fff; }
</style>
@endpush

@section('content')

{{-- Header --}}
<div class="bg-white border-b border-gray-100 pt-6 pb-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-1">Peta Banjir Kota Lhokseumawe</h1>
        <p class="text-sm text-gray-500 mb-4">Peta publik hanya menampilkan laporan yang telah diverifikasi petugas.</p>

        {{-- Danger filter buttons --}}
        <div class="flex flex-wrap items-center gap-2 mb-4">
            <button onclick="setDanger('semua')" id="btn-semua" class="filter-btn active text-sm font-semibold px-4 py-2 rounded-full border border-gray-200 transition-colors bg-gray-900 text-white">Semua tingkat</button>
            <button onclick="setDanger('tinggi')" id="btn-tinggi" class="filter-btn text-sm font-medium px-4 py-2 rounded-full border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition-colors">Bahaya Tinggi</button>
            <button onclick="setDanger('sedang')" id="btn-sedang" class="filter-btn text-sm font-medium px-4 py-2 rounded-full border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition-colors">Bahaya Sedang</button>
            <button onclick="setDanger('rendah')" id="btn-rendah" class="filter-btn text-sm font-medium px-4 py-2 rounded-full border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 transition-colors">Bahaya Rendah</button>
        </div>

        {{-- Tab buttons --}}
        <div class="flex gap-1">
            <button onclick="setTab('semua')" id="tab-semua" class="tab-btn active text-sm font-semibold px-4 py-2 rounded-t-lg border border-b-0 border-gray-200 bg-gray-900 text-white transition-colors">Semua Kejadian</button>
            <button onclick="setTab('terbaru')" id="tab-terbaru" class="tab-btn text-sm font-medium px-4 py-2 rounded-t-lg border border-b-0 border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition-colors">Terbaru</button>
            <button onclick="setTab('terverifikasi')" id="tab-terverifikasi" class="tab-btn text-sm font-medium px-4 py-2 rounded-t-lg border border-b-0 border-gray-200 bg-white text-gray-600 hover:bg-gray-50 transition-colors">Terverifikasi</button>
        </div>
    </div>
</div>

{{-- Checkbox filter --}}
<div class="bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
        <label class="flex items-center gap-2 cursor-pointer w-fit">
            <input type="checkbox" id="only-new" class="w-4 h-4 rounded border-gray-300 text-blue-600">
            <span class="text-sm text-gray-700">Hanya Tampilkan Titik Baru</span>
        </label>
    </div>
</div>

{{-- Map + Sidebar layout --}}
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
    <div class="flex flex-col lg:flex-row gap-5">

        {{-- Map container --}}
        <div class="flex-1 relative">
            <div class="border border-gray-200 rounded-xl overflow-hidden relative">
                {{-- Prototipe badge --}}
                <div class="absolute top-3 left-3 z-20 inline-flex items-center gap-1.5 bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs font-medium px-3 py-1.5 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>
                    </svg>
                    PROTOTIPE · Peta simulasi Kota Lhokseumawe
                </div>

                {{-- Map zoom controls overlay --}}
                <div class="absolute top-3 right-3 z-20 flex flex-col gap-1">
                    <button class="w-8 h-8 bg-white border border-gray-200 rounded-lg shadow-sm text-lg font-bold text-gray-700 hover:bg-gray-50 flex items-center justify-center" onclick="mapZoomIn()">+</button>
                    <button class="w-8 h-8 bg-white border border-gray-200 rounded-lg shadow-sm text-lg font-bold text-gray-700 hover:bg-gray-50 flex items-center justify-center" onclick="mapZoomOut()">−</button>
                    <button class="w-8 h-8 bg-white border border-gray-200 rounded-lg shadow-sm text-gray-600 hover:bg-gray-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3"/>
                        </svg>
                    </button>
                    <button class="w-8 h-8 bg-white border border-gray-200 rounded-lg shadow-sm text-gray-600 hover:bg-gray-50 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h4M3 12h4M3 17h4m6-10h8M13 12h8M13 17h8"/>
                        </svg>
                    </button>
                </div>

                {{-- Legenda di-render via Leaflet control (lihat script) --}}

                <div id="main-map"></div>
            </div>

            {{-- Info simulasi --}}
            <div class="mt-4 bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                </svg>
                <div>
                    <p class="text-sm font-semibold text-blue-800">Informasi simulasi</p>
                    <p class="text-sm text-blue-600 mt-0.5">Data pada peta ini adalah simulasi untuk demonstrasi prototipe dan bukan informasi bencana yang sebenarnya. Kondisi jalan dapat berubah sewaktu-waktu.</p>
                </div>
            </div>
        </div>

        {{-- Right sidebar: Laporan Terbaru --}}
        <div class="w-full lg:w-72 flex-shrink-0 flex flex-col">
            <h3 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                </svg>
                Laporan Banjir Terbaru
            </h3>
            <div class="space-y-3 overflow-y-auto pr-1" id="laporan-list" style="max-height:520px">
                @php
                $reports = [
                    ['loc' => 'Kuta Blang', 'desc' => 'Air masuk ke SD di Kuta Blang', 'date' => '24 Okt 2026, 06.30', 'level' => 'Bahaya Sedang', 'color' => 'orange', 'verified' => true],
                    ['loc' => 'Keude Aceh', 'desc' => 'Genangan di depan pasar Keude Aceh', 'date' => '24 Okt 2026, 06.05', 'level' => 'Bahaya Sedang', 'color' => 'orange', 'verified' => true],
                    ['loc' => 'Mon Geudong', 'desc' => 'Jalan Perdagangan terendam setinggi paha', 'date' => '24 Okt 2026, 05.40', 'level' => 'Bahaya Tinggi', 'color' => 'red', 'verified' => true],
                    ['loc' => 'Hagu Selatan', 'desc' => 'Air sungai meluap ke permukiman', 'date' => '24 Okt 2026, 04.55', 'level' => 'Bahaya Tinggi', 'color' => 'red', 'verified' => true],
                    ['loc' => 'Banda Sakti', 'desc' => 'Genangan ringan di Jalan Merdeka', 'date' => '24 Okt 2026, 07.15', 'level' => 'Bahaya Rendah', 'color' => 'yellow', 'verified' => false],
                ];
                $dotColors = ['red' => 'bg-red-500', 'orange' => 'bg-orange-400', 'yellow' => 'bg-yellow-400'];
                @endphp
                @foreach($reports as $r)
                <div class="bg-white border border-gray-100 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow cursor-pointer">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="dot {{ $dotColors[$r['color']] }}"></span>
                        <span class="text-sm font-semibold text-gray-900">{{ $r['loc'] }}</span>
                    </div>
                    <p class="text-xs text-gray-500 mb-1">{{ $r['desc'] }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400">{{ $r['date'] }} · {{ $r['level'] }}</span>
                    </div>
                    @if($r['verified'])
                    <div class="mt-2">
                        <span class="inline-flex items-center gap-1 text-xs font-medium text-green-700 bg-green-50 border border-green-100 px-2 py-0.5 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>
                            </svg>
                            Terverifikasi
                        </span>
                    </div>
                    @else
                    <div class="mt-2">
                        <span class="inline-flex items-center gap-1 text-xs font-medium text-yellow-700 bg-yellow-50 border border-yellow-100 px-2 py-0.5 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                            </svg>
                            Menunggu Verifikasi
                        </span>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
let mapInstance;
document.addEventListener('DOMContentLoaded', function () {
    mapInstance = L.map('main-map', { zoomControl: false, attributionControl: false }).setView([5.1801, 97.1500], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18
    }).addTo(mapInstance);

    const floodData = [
        { lat: 5.190, lng: 97.142, title: 'Air masuk ke SD di Kuta Blang', loc: 'Kuta Blang', level: 'Bahaya Sedang', water: '30–60 cm', color: '#f97316', verified: true },
        { lat: 5.178, lng: 97.153, title: 'Genangan di depan pasar Keude Aceh', loc: 'Keude Aceh', level: 'Bahaya Sedang', water: '30–60 cm', color: '#f97316', verified: true },
        { lat: 5.183, lng: 97.148, title: 'Jalan Perdagangan terendam setinggi paha', loc: 'Mon Geudong', level: 'Bahaya Tinggi', water: '>100 cm', color: '#dc2626', verified: true },
        { lat: 5.175, lng: 97.145, title: 'Air sungai meluap ke permukiman', loc: 'Hagu Selatan', level: 'Bahaya Tinggi', water: '61–100 cm', color: '#dc2626', verified: true },
        { lat: 5.188, lng: 97.152, title: 'Genangan ringan di Jalan Merdeka', loc: 'Banda Sakti', level: 'Bahaya Rendah', water: '10–30 cm', color: '#eab308', verified: false },
        { lat: 5.174, lng: 97.158, title: 'Banjir permukiman Pusong', loc: 'Pusong Lama', level: 'Bahaya Sedang', water: '40–70 cm', color: '#f97316', verified: true },
    ];

    floodData.forEach(function(p) {
        const strokeColor = p.verified ? p.color : '#9ca3af';
        const dashArray = p.verified ? null : '6,4';
        const circle = L.circleMarker([p.lat, p.lng], {
            radius: 18,
            fillColor: p.verified ? p.color : 'transparent',
            color: strokeColor,
            weight: p.verified ? 2 : 2,
            opacity: 1,
            fillOpacity: p.verified ? 0.35 : 0,
            dashArray: dashArray
        }).addTo(mapInstance);

        // Inner dot
        const inner = L.circleMarker([p.lat, p.lng], {
            radius: 7,
            fillColor: p.color,
            color: '#fff',
            weight: 2,
            opacity: 1,
            fillOpacity: 1
        }).addTo(mapInstance);

        // Check icon for verified
        if (p.verified) {
            const icon = L.divIcon({
                html: '<div style="width:18px;height:18px;background:' + p.color + ';border-radius:50%;border:2px solid white;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(0,0,0,.3)"><svg width="10" height="10" viewBox="0 0 24 24" fill="white"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg></div>',
                className: '', iconSize: [18, 18], iconAnchor: [9, 9]
            });
            L.marker([p.lat, p.lng], { icon }).addTo(mapInstance)
                .bindPopup('<div style="min-width:190px;font-family:sans-serif"><strong style="font-size:13px">' + p.title + '</strong><br><span style="color:#6b7280;font-size:11px">📍 ' + p.loc + '</span><br><span style="background:' + p.color + ';color:#fff;font-size:10px;padding:2px 8px;border-radius:9999px;display:inline-block;margin-top:4px">' + p.level + '</span><br><span style="font-size:11px;display:block;margin-top:4px">Tinggi air: <strong>' + p.water + '</strong></span></div>');
        }
    });

    const shelterData = [
        { lat: 5.182, lng: 97.142, name: 'GOR Kota Lhokseumawe', cap: '400 orang' },
        { lat: 5.170, lng: 97.150, name: 'SDN 1 Banda Sakti', cap: '220 orang' },
        { lat: 5.195, lng: 97.165, name: 'Aula Kantor Camat Banda Sakti', cap: '150 orang' },
        { lat: 5.180, lng: 97.160, name: 'Gedung Serbaguna Muara Satu', cap: '300 orang' },
        { lat: 5.173, lng: 97.138, name: 'Meunasah Blang Pulo', cap: '90 orang' },
    ];

    const shelterIcon = L.divIcon({
        html: '<div style="background:#1d4ed8;width:28px;height:28px;border-radius:50%;border:2px solid white;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 6px rgba(0,0,0,.25)"><svg width="14" height="14" viewBox="0 0 24 24" fill="white"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>',
        className: '', iconSize: [28, 28], iconAnchor: [14, 14]
    });
    shelterData.forEach(function(s) {
        L.marker([s.lat, s.lng], { icon: shelterIcon }).addTo(mapInstance)
            .bindPopup('<strong>' + s.name + '</strong><br><span style="font-size:11px">Kapasitas: ' + s.cap + '</span>');
    });

    // ── Legenda custom control ─────────────────────────────────────────────
    var LegendControl = L.Control.extend({
        options: { position: 'bottomleft' },
        onAdd: function () {
            var div = L.DomUtil.create('div', '');
            div.style.cssText = 'background:#fff;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.12);padding:10px 12px;font-family:sans-serif;min-width:190px;';
            div.innerHTML = [
                '<div style="display:flex;align-items:center;justify-content:space-between;cursor:pointer;margin-bottom:8px" onclick="toggleLegendControl(this)">',
                '  <span style="font-size:12px;font-weight:700;color:#1f2937">Legenda</span>',
                '  <svg id="leg-chev" xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="#9ca3af" stroke-width="2" style="transition:transform .2s"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>',
                '</div>',
                '<div id="leg-body" style="display:flex;flex-direction:column;gap:7px;font-size:11px;color:#374151">',
                  // Tingkat bahaya
                  row(dot('#ef4444'), 'Bahaya Tinggi'),
                  row(dot('#f97316'), 'Bahaya Sedang'),
                  row(dot('#eab308'), 'Bahaya Rendah'),
                  // Status
                  row('<span style="width:12px;height:12px;border-radius:50%;border:2px dashed #9ca3af;display:inline-block;flex-shrink:0"></span>', 'Belum diverifikasi'),
                  row('<span style="width:12px;height:12px;border-radius:50%;border:2px solid #60a5fa;display:inline-block;flex-shrink:0"></span>', 'Menunggu verifikasi (outline biru)'),
                  // Titik baru
                  row('<span style="background:#2563eb;color:#fff;border-radius:4px;padding:1px 5px;font-size:8px;font-weight:700;flex-shrink:0">BARU</span>', 'Titik baru (24 jam terakhir)'),
                  // Cluster
                  row('<span style="width:18px;height:18px;border-radius:50%;background:#1d4ed8;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:9px;font-weight:700;flex-shrink:0">3</span>', 'Kelompok kejadian berdekatan'),
                  // Pengungsian
                  row('<span style="width:16px;height:16px;background:#16a34a;border-radius:3px;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0"><svg width="10" height="10" viewBox="0 0 24 24" fill="white"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></span>', 'Titik pengungsian'),
                  // Jalan
                  row('<span style="width:20px;height:2px;background:#dc2626;display:inline-block;flex-shrink:0;border-radius:2px"></span>', 'Jalan tidak dapat dilalui'),
                  row('<span style="width:20px;height:2px;display:inline-block;flex-shrink:0;background:repeating-linear-gradient(90deg,#f97316 0,#f97316 4px,transparent 4px,transparent 7px)"></span>', 'Jalan terbatas'),
                  row('<span style="width:20px;height:2px;background:#3b82f6;display:inline-block;flex-shrink:0;border-radius:2px"></span>', 'Rute evakuasi'),
                '</div>'
            ].join('');
            L.DomEvent.disableClickPropagation(div);
            L.DomEvent.disableScrollPropagation(div);
            return div;
        }
    });

    function dot(color) {
        return '<span style="width:12px;height:12px;border-radius:50%;background:' + color + ';display:inline-block;flex-shrink:0"></span>';
    }
    function row(icon, label) {
        return '<div style="display:flex;align-items:center;gap:8px">' + icon + '<span>' + label + '</span></div>';
    }

    new LegendControl().addTo(mapInstance);
});

function mapZoomIn() { if (mapInstance) mapInstance.zoomIn(); }
function mapZoomOut() { if (mapInstance) mapInstance.zoomOut(); }

function toggleLegendControl(header) {
    var body = document.getElementById('leg-body');
    var chev = document.getElementById('leg-chev');
    if (!body) return;
    var hidden = body.style.display === 'none';
    body.style.display = hidden ? 'flex' : 'none';
    if (chev) chev.style.transform = hidden ? '' : 'rotate(180deg)';
}

const dangerBtns = ['btn-semua','btn-tinggi','btn-sedang','btn-rendah'];
function setDanger(active) {
    dangerBtns.forEach(id => {
        const el = document.getElementById(id);
        if (id === 'btn-' + active) {
            el.classList.add('bg-gray-900','text-white');
            el.classList.remove('bg-white','text-gray-700');
        } else {
            el.classList.remove('bg-gray-900','text-white');
            el.classList.add('bg-white','text-gray-700');
        }
    });
}

const tabBtns = ['tab-semua','tab-terbaru','tab-terverifikasi'];
function setTab(active) {
    tabBtns.forEach(id => {
        const el = document.getElementById(id);
        if (id === 'tab-' + active) {
            el.classList.add('bg-gray-900','text-white');
            el.classList.remove('bg-white','text-gray-600');
        } else {
            el.classList.remove('bg-gray-900','text-white');
            el.classList.add('bg-white','text-gray-600');
        }
    });
}
</script>
@endpush

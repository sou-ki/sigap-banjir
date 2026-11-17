@extends('layouts.dashboard')
@section('title', 'Rute Evakuasi')

@push('styles')
<style>
#rute-map { height: 520px; }
.suggest-list {
    position: absolute; top: 100%; left: 0; right: 0;
    background: #fff; border: 1px solid #e5e7eb; border-top: none;
    border-radius: 0 0 8px 8px; z-index: 50;
    box-shadow: 0 4px 12px rgba(0,0,0,.1); max-height: 200px; overflow-y: auto;
}
.suggest-item { padding: 10px 14px; font-size: 13px; cursor: pointer; }
.suggest-item:hover, .suggest-item.active { background: #eff6ff; color: #1d4ed8; }
</style>
@endpush

@section('content')
<div class="p-6">
    <div class="flex items-start justify-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Rute Evakuasi</h2>
            <p class="text-sm text-gray-500 mt-0.5">Rencanakan jalur menuju pengungsian berdasarkan kondisi jalan yang dilaporkan.</p>
        </div>
    </div>

    <div class="flex gap-5 items-start">

        {{-- ===== Left Panel ===== --}}
        <div class="w-80 flex-shrink-0 bg-white rounded-xl border border-gray-100 shadow-sm p-5 space-y-4">

            {{-- Lokasi Awal --}}
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi Awal</label>
                <input type="text" id="awal-input" value="Mon Geudong" autocomplete="off"
                       class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       oninput="filterSuggest('awal')" onfocus="showSuggest('awal')" onblur="hideSuggest('awal', 300)">
                <div id="awal-suggest" class="suggest-list hidden">
                    @foreach(['Kuta Blang','Banda Sakti','Mon Geudong','Hagu Selatan','Pusong','Uteunkot','Cunda','Blang Pulo','Lancang Garam','Batuphat','Ujong Blang','Keude Aceh'] as $loc)
                    <div class="suggest-item {{ $loc === 'Mon Geudong' ? 'active' : '' }}"
                         onclick="selectAwal('{{ $loc }}')">{{ $loc }}</div>
                    @endforeach
                </div>
            </div>

            {{-- Tujuan Pengungsian --}}
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tujuan Pengungsian</label>
                <input type="text" id="tujuan-input" value="GOR Kota Lhokseumawe (sisa 188)" autocomplete="off"
                       class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                       oninput="filterSuggest('tujuan')" onfocus="showSuggest('tujuan')" onblur="hideSuggest('tujuan', 300)">
                <div id="tujuan-suggest" class="suggest-list hidden">
                    @foreach(['GOR Kota Lhokseumawe (sisa 188)','Aula Kantor Camat Banda Sakti (sisa 2)','SDN 1 Banda Sakti (sisa 156)','Meunasah Blang Pulo (sisa 90)','Gedung Serbaguna Muara Satu (sisa 203)'] as $sh)
                    <div class="suggest-item {{ $sh === 'GOR Kota Lhokseumawe (sisa 188)' ? 'active' : '' }}"
                         onclick="selectTujuan('{{ $sh }}')">{{ $sh }}</div>
                    @endforeach
                </div>
            </div>

            {{-- Pilih titik pada peta --}}
            <button type="button" onclick="activatePickMode()"
                    class="flex items-center gap-2 text-sm font-medium text-blue-600 border border-blue-200 rounded-lg px-3.5 py-2.5 w-full justify-center hover:bg-blue-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                </svg>
                Pilih Titik pada Peta
            </button>

            {{-- Cari Rute --}}
            <button type="button" id="btn-cari" onclick="cariRute()"
                    class="flex items-center gap-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg px-3.5 py-3 w-full justify-center transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Cari Rute
            </button>

            {{-- Tampilkan Alternatif --}}
            <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-700">
                <input type="checkbox" id="show-alt" checked class="w-4 h-4 rounded border-gray-300 text-blue-600">
                Tampilkan Alternatif
            </label>

            {{-- Catatan estimasi --}}
            <p class="text-xs text-gray-400 flex items-start gap-1.5 pt-1 border-t border-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 mt-0.5 flex-shrink-0 text-gray-400" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                </svg>
                Estimasi waktu dihitung berdasarkan kecepatan per kondisi jalan.
            </p>

            {{-- Route result (tersembunyi sampai klik Cari Rute) --}}
            <div id="rute-result" class="hidden space-y-3">
                {{-- Rute A --}}
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-bold text-blue-800">Rute A – Disarankan</p>
                        <span class="text-xs font-semibold text-green-700 bg-green-100 px-2 py-0.5 rounded-full">Ditempuh</span>
                    </div>
                    <p class="text-xs text-blue-700">≈ 2.7 km · ≈ 7 menit</p>
                    <p class="text-xs text-green-600 mt-1 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                        Dapat Dilalui
                    </p>
                    <p class="text-xs text-gray-500 mt-1">Via Jl. Merdeka</p>
                    <p class="text-xs text-gray-400 mt-0.5">Tidak ada kondisi jalan yang diperlukan</p>
                    <div class="border-t border-blue-100 mt-3 pt-3">
                        <p class="text-xs font-semibold text-blue-800">Tujuan: GOR Kota Lhokseumawe</p>
                        <p class="text-xs text-gray-500">Jl. Merdeka Barat, Kec. Banda Sakti · sisa kapasitas 188 orang.</p>
                    </div>
                </div>
                {{-- Rute B (alternatif) --}}
                <div id="rute-alt" class="bg-gray-50 border border-gray-200 rounded-xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-xs font-bold text-gray-700">Rute B – Alternatif</p>
                        <span class="text-xs font-semibold text-yellow-700 bg-yellow-100 px-2 py-0.5 rounded-full">Terbatas</span>
                    </div>
                    <p class="text-xs text-gray-600">≈ 3.4 km · ≈ 12 menit</p>
                    <p class="text-xs text-yellow-600 mt-1 flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
                        Sebagian terbatas
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Via Jl. Samudera</p>
                </div>
            </div>
        </div>

        {{-- ===== Map ===== --}}
        <div class="flex-1 relative">
            <div class="rounded-xl border border-gray-200 overflow-hidden relative">

                {{-- PROTOTIPE badge --}}
                <div class="absolute top-3 left-3 z-20 inline-flex items-center gap-1.5 bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs font-medium px-3 py-1.5 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
                    PROTOTIPE · Peta simulasi Kota Lhokseumawe
                </div>

                {{-- Legenda (collapsible, pojok kiri bawah) --}}
                <div class="absolute bottom-4 left-4 bg-white border border-gray-200 rounded-2xl shadow-lg p-4" style="min-width:220px;z-index:1000">
                    <button onclick="toggleLegenda()"
                            class="flex items-center justify-between w-full mb-3">
                        <span class="text-sm font-bold text-gray-900">Legenda</span>
                        <svg id="legenda-chevron" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="legenda-content" class="space-y-2 text-sm text-gray-700">
                        <div class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full bg-red-500 flex-shrink-0"></span>
                            <span>Bahaya Tinggi</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full bg-orange-400 flex-shrink-0"></span>
                            <span>Bahaya Sedang</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full bg-yellow-400 flex-shrink-0"></span>
                            <span>Bahaya Rendah</span>
                        </div>
                        <div class="flex items-center gap-3">
                            {{-- Dashed circle with ? --}}
                            <span class="w-4 h-4 rounded-full border-2 border-dashed border-gray-500 flex items-center justify-center flex-shrink-0" style="font-size:9px;font-weight:bold;color:#6b7280">?</span>
                            <span>Belum diverifikasi</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-full border-2 border-dashed border-blue-400 flex-shrink-0"></span>
                            <span>Menunggu verifikasi (outline biru)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center bg-blue-600 text-white rounded-full px-2 py-0.5 text-xs font-bold flex-shrink-0">BARU</span>
                            <span>Titik baru (24 jam terakhir)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-5 h-5 rounded-full bg-gray-800 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">3</span>
                            <span>Kelompok kejadian berdekatan</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-4 h-4 rounded-sm bg-green-600 flex-shrink-0"></span>
                            <span>Titik pengungsian</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-0.5 bg-red-600 flex-shrink-0 rounded"></span>
                            <span>Jalan tidak dapat dilalui</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-6 flex-shrink-0" style="height:2px;background:repeating-linear-gradient(90deg,#f97316 0,#f97316 5px,transparent 5px,transparent 9px)"></span>
                            <span>Jalan terbatas</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="w-6 h-1 bg-blue-600 flex-shrink-0 rounded"></span>
                            <span>Rute evakuasi</span>
                        </div>
                    </div>
                </div>

                <div id="rute-map"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let ruteMap, routeLineA, routeLineB, pickMode = false, pickMarker = null;

document.addEventListener('DOMContentLoaded', function () {
    ruteMap = L.map('rute-map', { zoomControl: false, attributionControl: false })
               .setView([5.1801, 97.1500], 14);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(ruteMap);
    L.control.zoom({ position: 'topright' }).addTo(ruteMap);

    // Awal marker
    const awalIc = L.divIcon({
        html: '<div style="background:#2563eb;padding:3px 10px;border-radius:9999px;color:#fff;font-size:11px;font-weight:700;white-space:nowrap;box-shadow:0 2px 6px rgba(0,0,0,.3)">Awal</div>',
        className: '', iconAnchor: [26, 10]
    });
    L.marker([5.1801, 97.1500], { icon: awalIc }).addTo(ruteMap);
    L.circleMarker([5.1801, 97.1500], { radius: 10, fillColor: '#2563eb', color: '#fff', weight: 2, fillOpacity: 1 }).addTo(ruteMap);

    // Tujuan marker
    const tujuanIc = L.divIcon({
        html: '<div style="background:#16a34a;padding:3px 10px;border-radius:9999px;color:#fff;font-size:11px;font-weight:700;white-space:nowrap;box-shadow:0 2px 6px rgba(0,0,0,.3)">Tujuan</div>',
        className: '', iconAnchor: [30, 10]
    });
    L.marker([5.1845, 97.1420], { icon: tujuanIc }).addTo(ruteMap);
    L.circleMarker([5.1845, 97.1420], { radius: 10, fillColor: '#16a34a', color: '#fff', weight: 2, fillOpacity: 1 }).addTo(ruteMap);

    // Flood markers
    [[5.1790,97.1530,'#f97316'],[5.1750,97.1450,'#dc2626'],[5.1830,97.1520,'#eab308'],[5.1740,97.1580,'#f97316']].forEach(function(p){
        L.circleMarker([p[0],p[1]],{radius:16,fillColor:p[2],color:p[2],weight:2,fillOpacity:0.3}).addTo(ruteMap);
        const ic = L.divIcon({
            html: '<div style="width:16px;height:16px;background:'+p[2]+';border-radius:50%;border:2px solid #fff;box-shadow:0 1px 4px rgba(0,0,0,.3)"></div>',
            className: '', iconSize:[16,16], iconAnchor:[8,8]
        });
        L.marker([p[0],p[1]],{icon:ic}).addTo(ruteMap);
    });

    // Blocked road (red line)
    L.polyline([[5.1801,97.1500],[5.1780,97.1500]],{color:'#dc2626',weight:5,opacity:0.9}).addTo(ruteMap);

    // Limited road (orange dashed)
    L.polyline([[5.1810,97.1530],[5.1810,97.1600]],{color:'#f97316',weight:3,dashArray:'8,5',opacity:0.8}).addTo(ruteMap);

    // Shelters (green squares)
    const si = L.divIcon({
        html: '<div style="background:#16a34a;width:22px;height:22px;border-radius:4px;border:2px solid #fff;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(0,0,0,.3)"><svg width="11" height="11" viewBox="0 0 24 24" fill="white"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>',
        className: '', iconSize:[22,22], iconAnchor:[11,11]
    });
    [[5.1845,97.1420],[5.1700,97.1500],[5.1950,97.1650],[5.1800,97.1600],[5.1730,97.1380]].forEach(s => L.marker(s,{icon:si}).addTo(ruteMap));

    // Click on map when pick mode active
    ruteMap.on('click', function(e) {
        if (!pickMode) return;
        if (pickMarker) ruteMap.removeLayer(pickMarker);
        pickMarker = L.marker(e.latlng, { draggable: true }).addTo(ruteMap);
        document.getElementById('awal-input').value = 'Titik: (' + e.latlng.lat.toFixed(4) + ', ' + e.latlng.lng.toFixed(4) + ')';
        pickMode = false;
        ruteMap.getContainer().style.cursor = '';
    });
});

// Legenda toggle
function toggleLegenda() {
    const content = document.getElementById('legenda-content');
    const chevron = document.getElementById('legenda-chevron');
    const hidden = content.classList.toggle('hidden');
    chevron.style.transform = hidden ? 'rotate(-90deg)' : '';
}

// Suggest
function showSuggest(id) {
    document.getElementById(id + '-suggest').classList.remove('hidden');
}
function hideSuggest(id, delay) {
    setTimeout(() => document.getElementById(id + '-suggest').classList.add('hidden'), delay);
}
function filterSuggest(id) {
    const val = document.getElementById(id + '-input').value.toLowerCase();
    document.querySelectorAll('#' + id + '-suggest .suggest-item').forEach(function(el) {
        el.style.display = el.textContent.toLowerCase().includes(val) ? '' : 'none';
    });
    document.getElementById(id + '-suggest').classList.remove('hidden');
}
function selectAwal(v) {
    document.getElementById('awal-input').value = v;
    document.getElementById('awal-suggest').classList.add('hidden');
}
function selectTujuan(v) {
    document.getElementById('tujuan-input').value = v;
    document.getElementById('tujuan-suggest').classList.add('hidden');
}

// Pick mode
function activatePickMode() {
    pickMode = true;
    ruteMap.getContainer().style.cursor = 'crosshair';
}

// Cari rute
function cariRute() {
    // Remove old routes
    if (routeLineA) ruteMap.removeLayer(routeLineA);
    if (routeLineB) ruteMap.removeLayer(routeLineB);

    // Draw rute A (blue solid)
    routeLineA = L.polyline(
        [[5.1801,97.1500],[5.1810,97.1480],[5.1825,97.1455],[5.1840,97.1435],[5.1845,97.1420]],
        { color:'#2563eb', weight:5, opacity:0.9, lineCap:'round', lineJoin:'round' }
    ).addTo(ruteMap);

    // Draw rute B (gray dashed) if alternatif checked
    if (document.getElementById('show-alt').checked) {
        routeLineB = L.polyline(
            [[5.1801,97.1500],[5.1785,97.1510],[5.1770,97.1490],[5.1760,97.1465],[5.1750,97.1445],[5.1845,97.1420]],
            { color:'#9ca3af', weight:4, opacity:0.7, dashArray:'10,6', lineCap:'round' }
        ).addTo(ruteMap);
    }

    // Show result panel
    const result = document.getElementById('rute-result');
    const altBox  = document.getElementById('rute-alt');
    result.classList.remove('hidden');
    if (!document.getElementById('show-alt').checked) {
        altBox.classList.add('hidden');
    } else {
        altBox.classList.remove('hidden');
    }

    // Fit map to route
    ruteMap.fitBounds(routeLineA.getBounds(), { padding: [50, 50] });
}

// Toggle alternatif realtime
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('show-alt').addEventListener('change', function() {
        if (routeLineB) {
            if (this.checked) routeLineB.addTo(ruteMap);
            else ruteMap.removeLayer(routeLineB);
        }
        const altBox = document.getElementById('rute-alt');
        if (altBox) {
            if (this.checked) altBox.classList.remove('hidden');
            else altBox.classList.add('hidden');
        }
    });
});
</script>
@endpush

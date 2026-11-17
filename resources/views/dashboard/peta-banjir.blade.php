@extends('layouts.dashboard')
@section('title', 'Peta Banjir')

@push('styles')
<style>
#db-map { height: 580px; }
.dot { width:10px;height:10px;border-radius:50%;display:inline-block;flex-shrink:0; }
.filter-tag { display:inline-flex;align-items:center;gap:4px;font-size:11px;font-weight:600;padding:2px 8px;border-radius:9999px; }
</style>
@endpush

@section('content')
<div class="p-6">
    <div class="flex items-start justify-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Peta Banjir</h2>
            <p class="text-sm text-gray-500 mt-0.5">6 laporan sesuai filter. Laporan yang belum diverifikasi ditandai tanda tanya putus-putus.</p>
        </div>
    </div>

    <div class="flex gap-5">
        {{-- Left sidebar --}}
        <div class="w-80 flex-shrink-0 bg-white rounded-xl border border-gray-100 shadow-sm overflow-y-auto" style="max-height:620px">

            {{-- Panel Laporan: header tetap, konten scroll sendiri --}}
            <div class="border-b border-gray-200">
                {{-- Header sticky --}}
                <div class="px-4 py-3 border-b border-gray-100 sticky top-0 bg-white z-10">
                    <p class="text-xs font-bold text-gray-700 flex items-center gap-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                        Laporan Banjir Terbaru
                    </p>
                </div>
                {{-- Konten scroll terbatas --}}
                <div class="overflow-y-auto p-3 space-y-2" style="max-height:220px">
                    @php $reports = [
                        ['loc'=>'Kuta Blang','desc'=>'Air masuk ke SD di Kuta Blang','date'=>'24 Okt 2026, 06.30','lvl'=>'Bahaya Sedang','c'=>'bg-orange-400'],
                        ['loc'=>'Keude Aceh','desc'=>'Genangan di depan pasar Keude Aceh','date'=>'24 Okt 2026, 06.05','lvl'=>'Bahaya Sedang','c'=>'bg-orange-400'],
                        ['loc'=>'Mon Geudong','desc'=>'Jalan Perdagangan terendam setinggi...','date'=>'24 Okt 2026, 05.40','lvl'=>'Bahaya Tinggi','c'=>'bg-red-500'],
                        ['loc'=>'Hagu Selatan','desc'=>'Air sungai meluap ke permukiman...','date'=>'24 Okt 2026, 04.55','lvl'=>'Bahaya Tinggi','c'=>'bg-red-500'],
                        ['loc'=>'Banda Sakti','desc'=>'Genangan ringan di Jalan Merdeka','date'=>'24 Okt 2026, 07.15','lvl'=>'Bahaya Rendah','c'=>'bg-yellow-400'],
                        ['loc'=>'Pusong Lama','desc'=>'Banjir permukiman kawasan Pusong','date'=>'24 Okt 2026, 03.30','lvl'=>'Bahaya Sedang','c'=>'bg-orange-400'],
                    ]; @endphp
                    @foreach($reports as $r)
                    <div class="rounded-lg border border-gray-100 p-3 hover:bg-blue-50 hover:border-blue-100 cursor-pointer transition-colors">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="dot {{ $r['c'] }}"></span>
                            <span class="text-sm font-semibold text-gray-900">{{ $r['loc'] }}</span>
                        </div>
                        <p class="text-xs text-gray-500 mb-1">{{ $r['desc'] }}</p>
                        <p class="text-xs text-gray-400">{{ $r['date'] }} · {{ $r['lvl'] }}</p>
                        <span class="inline-flex items-center gap-1 mt-1.5 text-xs font-medium text-green-700 bg-green-50 border border-green-100 px-2 py-0.5 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                            Terverifikasi
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Tampilan kejadian tabs --}}
            <div class="p-4 border-b border-gray-100">
                <p class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-2">Tampilan Kejadian</p>
                <div class="flex gap-1 flex-wrap mb-3">
                    <button class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-gray-900 text-white">Semua Kejadian</button>
                    <button class="text-xs font-medium px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200">Terbaru</button>
                    <button class="text-xs font-medium px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200">Terverifikasi</button>
                </div>
                <label class="flex items-center gap-2 cursor-pointer mb-3">
                    <input type="checkbox" class="rounded border-gray-300 text-blue-600 w-3.5 h-3.5">
                    <span class="text-xs text-gray-700">Hanya Tampilkan Titik Baru</span>
                </label>
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="Cari lokasi atau laporan..." class="w-full text-xs border border-gray-200 rounded-lg pl-8 pr-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
            </div>

            {{-- Tingkat bahaya --}}
            <div class="p-4 border-b border-gray-100">
                <p class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-2">Tingkat Bahaya</p>
                <div class="space-y-1.5">
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked class="rounded border-gray-300 text-red-500 w-3.5 h-3.5"><span class="filter-tag bg-red-100 text-red-700">⚠ Bahaya Tinggi</span></label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked class="rounded border-gray-300 text-orange-500 w-3.5 h-3.5"><span class="filter-tag bg-orange-100 text-orange-700">⚠ Bahaya Sedang</span></label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked class="rounded border-gray-300 text-yellow-500 w-3.5 h-3.5"><span class="filter-tag bg-yellow-100 text-yellow-700">⚠ Bahaya Rendah</span></label>
                </div>
            </div>

            {{-- Status verifikasi --}}
            <div class="p-4 border-b border-gray-100">
                <p class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-2">Status Verifikasi</p>
                <div class="space-y-1.5">
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked class="rounded border-gray-300 w-3.5 h-3.5"><span class="filter-tag bg-green-100 text-green-700">✓ Terverifikasi</span></label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked class="rounded border-gray-300 w-3.5 h-3.5"><span class="filter-tag bg-gray-100 text-gray-600">⌛ Menunggu Verifikasi</span></label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked class="rounded border-gray-300 w-3.5 h-3.5"><span class="filter-tag bg-yellow-100 text-yellow-700">? Perlu Klarifikasi</span></label>
                </div>
            </div>

            {{-- Tanggal laporan --}}
            <div class="p-4 border-b border-gray-100">
                <p class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-2">Tanggal Laporan</p>
                <select class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500">
                    <option>Semua tanggal</option>
                    <option>Hari ini</option>
                    <option>7 hari terakhir</option>
                </select>
            </div>

            {{-- Kondisi jalan --}}
            <div class="p-4 border-b border-gray-100">
                <p class="text-xs font-bold uppercase tracking-wide text-gray-500 mb-2">Kondisi Jalan</p>
                <div class="space-y-1.5">
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked class="rounded border-gray-300 w-3.5 h-3.5"><span class="filter-tag bg-green-100 text-green-700">✓ Dapat Dilalui</span></label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked class="rounded border-gray-300 w-3.5 h-3.5"><span class="filter-tag bg-yellow-100 text-yellow-700">⚠ Terbatas</span></label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked class="rounded border-gray-300 w-3.5 h-3.5"><span class="filter-tag bg-red-100 text-red-700">✗ Tidak Dapat Dilalui</span></label>
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked class="rounded border-gray-300 w-3.5 h-3.5"><span class="filter-tag bg-gray-100 text-gray-600">? Belum Diketahui</span></label>
                </div>
            </div>

            {{-- Tampilkan pengungsian --}}
            <div class="p-4 border-b border-gray-100">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" checked class="rounded border-gray-300 w-3.5 h-3.5 text-blue-600">
                    <span class="text-xs text-gray-700">Tampilkan lokasi pengungsian</span>
                </label>
            </div>

            {{-- Reset --}}
            <div class="p-4">
                <button class="flex items-center gap-2 text-xs text-gray-500 hover:text-gray-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Atur Ulang Filter
                </button>
            </div>
        </div>

        {{-- Map --}}
        <div class="flex-1 relative">
            <div class="rounded-xl border border-gray-200 overflow-hidden relative">
                <div class="absolute top-3 left-3 z-20 inline-flex items-center gap-1.5 bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs font-medium px-3 py-1.5 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
                    PROTOTIPE · Peta simulasi Kota Lhokseumawe
                </div>
                {{-- Legenda --}}
                <div class="absolute bottom-3 left-3 z-20 bg-white border border-gray-200 rounded-xl shadow-md p-3 text-xs" style="min-width:200px">
                    <button class="flex items-center justify-between w-full mb-2" onclick="this.nextElementSibling.classList.toggle('hidden')">
                        <span class="font-bold text-gray-800">Legenda</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                    </button>
                    <div class="space-y-1.5 text-gray-700">
                        <div class="flex items-center gap-2"><span class="dot bg-red-500"></span> Bahaya Tinggi</div>
                        <div class="flex items-center gap-2"><span class="dot bg-orange-400"></span> Bahaya Sedang</div>
                        <div class="flex items-center gap-2"><span class="dot bg-yellow-400"></span> Bahaya Rendah</div>
                        <div class="flex items-center gap-2"><span class="w-4 h-2 border-2 border-dashed border-gray-400 inline-block rounded"></span> Belum diverifikasi</div>
                        <div class="flex items-center gap-2"><span class="w-4 h-2 border-2 border-blue-400 inline-block rounded"></span> Menunggu verifikasi</div>
                        <div class="flex items-center gap-2"><span class="inline-flex items-center bg-blue-600 text-white text-xs px-1.5 py-0 rounded font-bold">BARU</span> Titik baru (24 jam terakhir)</div>
                        <div class="flex items-center gap-2"><span class="dot bg-gray-500"></span> Kelompok kejadian berdekatan</div>
                        <div class="flex items-center gap-2"><span class="dot bg-green-600"></span> Titik pengungsian</div>
                        <div class="flex items-center gap-2"><span class="w-4 h-0.5 bg-red-600 inline-block"></span> Jalan tidak dapat dilalui</div>
                        <div class="flex items-center gap-2"><span class="w-4 h-0.5 border-t-2 border-dashed border-orange-400 inline-block"></span> Jalan terbatas</div>
                        <div class="flex items-center gap-2"><span class="w-4 h-0.5 bg-blue-500 inline-block"></span> Rute evakuasi</div>
                    </div>
                </div>
                <div id="db-map"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('db-map', { zoomControl: false, attributionControl: false }).setView([5.1801, 97.1500], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);
    L.control.zoom({ position: 'topright' }).addTo(map);
    const pts = [
        [5.190,97.142,'#f97316','Kuta Blang','Bahaya Sedang'],
        [5.178,97.153,'#f97316','Keude Aceh','Bahaya Sedang'],
        [5.183,97.148,'#dc2626','Mon Geudong','Bahaya Tinggi'],
        [5.175,97.145,'#dc2626','Hagu Selatan','Bahaya Tinggi'],
        [5.188,97.152,'#eab308','Banda Sakti','Bahaya Rendah'],
        [5.174,97.158,'#f97316','Pusong Lama','Bahaya Sedang'],
    ];
    pts.forEach(function(p){
        L.circleMarker([p[0],p[1]],{radius:18,fillColor:p[2],color:p[2],weight:2,fillOpacity:0.3}).addTo(map);
        const ic=L.divIcon({html:'<div style="width:18px;height:18px;background:'+p[2]+';border-radius:50%;border:2px solid #fff;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(0,0,0,.3)"><svg width="10" height="10" viewBox="0 0 24 24" fill="white"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg></div>',className:'',iconSize:[18,18],iconAnchor:[9,9]});
        L.marker([p[0],p[1]],{icon:ic}).addTo(map).bindPopup('<strong>'+p[3]+'</strong><br>'+p[4]);
    });
    const si=L.divIcon({html:'<div style="background:#16a34a;width:24px;height:24px;border-radius:50%;border:2px solid #fff;display:flex;align-items:center;justify-content:center;"><svg width="12" height="12" viewBox="0 0 24 24" fill="white"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>',className:'',iconSize:[24,24],iconAnchor:[12,12]});
    [[5.182,97.142],[5.170,97.150],[5.195,97.165],[5.180,97.160],[5.173,97.138]].forEach(s=>L.marker(s,{icon:si}).addTo(map));
});
</script>
@endpush

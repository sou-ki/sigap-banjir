@extends('layouts.petugas')
@section('title', 'Rute Evakuasi')
{{-- Reuse dashboard rute evakuasi style --}}

@push('styles')
<style>#petugas-rute-map{height:500px}.suggest-list{position:absolute;top:100%;left:0;right:0;background:#fff;border:1px solid #e5e7eb;border-top:none;border-radius:0 0 8px 8px;z-index:50;box-shadow:0 4px 12px rgba(0,0,0,.1);max-height:200px;overflow-y:auto}.suggest-item{padding:10px 14px;font-size:12px;cursor:pointer}.suggest-item:hover,.suggest-item.active{background:#eff6ff;color:#1d4ed8}</style>
@endpush

@section('content')
<div class="p-5">
    <div class="flex items-start justify-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Rute Evakuasi</h2>
            <p class="text-sm text-gray-500">Rencanakan satu jalur menuju pengungsian berdasarkan kondisi jalan yang dilaporkan.</p>
        </div>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-start gap-3 mb-5">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-600 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
        <div>
            <p class="text-sm font-semibold text-yellow-800">Rute ini merupakan informasi pendukung dan perlu dikonfirmasi oleh petugas. Kondisi jalan dapat berubah sewaktu-waktu.</p>
            <p class="text-xs text-yellow-700 mt-0.5">Hasil perhitungan di bawah adalah simulasi dan tidak menjamin keselamatan rute.</p>
        </div>
    </div>

    <div class="flex gap-4">
        <div class="w-64 flex-shrink-0 bg-white rounded-xl border border-gray-100 shadow-sm p-4 space-y-4">
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi Awal</label>
                <input type="text" id="p-awal" value="Mon Geudong" autocomplete="off" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onfocus="showSugP('awal')" onblur="hideSugP('awal',300)">
                <div id="awal-sug-p" class="suggest-list hidden">
                    @foreach(['Kuta Blang','Banda Sakti','Mon Geudong','Hagu Selatan','Pusong','Cunda','Blang Pulo','Lancang Garam','Batuphat','Ujong Blang','Keude Aceh'] as $l)
                    <div class="suggest-item {{ $l==='Mon Geudong'?'active':'' }}" onclick="document.getElementById('p-awal').value='{{ $l }}';document.getElementById('awal-sug-p').classList.add('hidden')">{{ $l }}</div>
                    @endforeach
                </div>
            </div>
            <div class="relative">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tujuan Pengungsian</label>
                <input type="text" id="p-tujuan" value="GOR Kota Lhokseumawe (sisa 188)" autocomplete="off" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onfocus="showSugP('tujuan')" onblur="hideSugP('tujuan',300)">
                <div id="tujuan-sug-p" class="suggest-list hidden">
                    @foreach(['GOR Kota Lhokseumawe (sisa 188)','Aula Kantor Camat Banda Sakti (sisa 2)','SDN 1 Banda Sakti (sisa 156)','Meunasah Blang Pulo (sisa 90)','Gedung Serbaguna Muara Satu (sisa 203)'] as $s)
                    <div class="suggest-item {{ $s==='GOR Kota Lhokseumawe (sisa 188)'?'active':'' }}" onclick="document.getElementById('p-tujuan').value='{{ $s }}';document.getElementById('tujuan-sug-p').classList.add('hidden')">{{ $s }}</div>
                    @endforeach
                </div>
            </div>
            <button type="button" class="flex items-center gap-2 text-sm font-medium text-blue-600 border border-blue-200 rounded-lg px-3 py-2 w-full justify-center hover:bg-blue-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                Pilih Titik pada Peta
            </button>
            <button onclick="cariRuteP()" class="flex items-center gap-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-lg px-3 py-2.5 w-full justify-center">
                🔍 Cari Rute
            </button>
            <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer"><input type="checkbox" checked class="w-4 h-4 rounded"> Tampilkan Alternatif</label>
            <div id="rute-result-p" class="hidden bg-blue-50 border border-blue-100 rounded-xl p-3 text-xs">
                <p class="font-bold text-blue-800 mb-1">Rute A – Disarankan <span class="text-green-600 ml-1">Ditempuh</span></p>
                <p class="text-blue-700">≈ 2.7 km · ≈ 7 menit</p>
                <p class="text-green-600 mt-1">✓ Dapat Dilalui</p>
                <p class="text-gray-500 mt-1">Via Jl. Merdeka</p>
                <p class="text-gray-400">Tidak ada kondisi jalan yang diperlukan</p>
                <div class="border-t border-blue-100 pt-2 mt-2">
                    <p class="font-semibold text-blue-800">Tujuan: GOR Kota Lhokseumawe</p>
                    <p class="text-gray-500">Jl. Merdeka Barat, Kec. Banda Sakti · sisa kapasitas 188 orang.</p>
                </div>
            </div>
        </div>

        <div class="flex-1 rounded-xl border border-gray-200 overflow-hidden relative">
            <div class="absolute top-3 left-3 z-20 inline-flex items-center gap-1.5 bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs font-medium px-3 py-1.5 rounded-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
                PROTOTIPE · Peta simulasi Kota Lhokseumawe
            </div>
            <div id="petugas-rute-map"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let petugasRuteMap, petugasRouteLine;
document.addEventListener('DOMContentLoaded', function() {
    petugasRuteMap = L.map('petugas-rute-map',{zoomControl:false,attributionControl:false}).setView([5.1801,97.1500],13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:18}).addTo(petugasRuteMap);
    L.control.zoom({position:'topright'}).addTo(petugasRuteMap);
    const awalIc=L.divIcon({html:'<div style="background:#2563eb;padding:3px 8px;border-radius:9999px;color:#fff;font-size:10px;font-weight:700;white-space:nowrap;box-shadow:0 1px 4px rgba(0,0,0,.3)">Awal</div>',className:'',iconAnchor:[24,10]});
    L.marker([5.183,97.148],{icon:awalIc}).addTo(petugasRuteMap);
    L.circleMarker([5.183,97.148],{radius:10,fillColor:'#2563eb',color:'#fff',weight:2,fillOpacity:1}).addTo(petugasRuteMap);
    const tujuanIc=L.divIcon({html:'<div style="background:#16a34a;padding:3px 8px;border-radius:9999px;color:#fff;font-size:10px;font-weight:700;white-space:nowrap;box-shadow:0 1px 4px rgba(0,0,0,.3)">Tujuan</div>',className:'',iconAnchor:[28,10]});
    L.marker([5.182,97.142],{icon:tujuanIc}).addTo(petugasRuteMap);
    L.circleMarker([5.182,97.142],{radius:10,fillColor:'#16a34a',color:'#fff',weight:2,fillOpacity:1}).addTo(petugasRuteMap);
    [[5.178,97.153,'#f97316'],[5.175,97.145,'#dc2626'],[5.188,97.152,'#eab308']].forEach(function(p){L.circleMarker([p[0],p[1]],{radius:14,fillColor:p[2],color:p[2],weight:2,fillOpacity:0.3}).addTo(petugasRuteMap);});
    const si=L.divIcon({html:'<div style="background:#16a34a;width:20px;height:20px;border-radius:50%;border:2px solid #fff;display:flex;align-items:center;justify-content:center;"><svg width="10" height="10" viewBox="0 0 24 24" fill="white"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>',className:'',iconSize:[20,20],iconAnchor:[10,10]});
    [[5.182,97.142],[5.170,97.150],[5.195,97.165],[5.180,97.160],[5.173,97.138]].forEach(s=>L.marker(s,{icon:si}).addTo(petugasRuteMap));
});
function showSugP(id){document.getElementById(id+'-sug-p').classList.remove('hidden');}
function hideSugP(id,d){setTimeout(()=>document.getElementById(id+'-sug-p').classList.add('hidden'),d);}
function cariRuteP(){
    if(petugasRouteLine)petugasRuteMap.removeLayer(petugasRouteLine);
    petugasRouteLine=L.polyline([[5.183,97.148],[5.185,97.145],[5.184,97.143],[5.182,97.142]],{color:'#2563eb',weight:4,opacity:0.8}).addTo(petugasRuteMap);
    document.getElementById('rute-result-p').classList.remove('hidden');
}
</script>
@endpush

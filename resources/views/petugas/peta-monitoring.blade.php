@extends('layouts.petugas')
@section('title', 'Peta Monitoring Banjir')

@push('styles')
<style>#mon-map{height:580px}.dot{width:10px;height:10px;border-radius:50%;display:inline-block;flex-shrink:0}</style>
@endpush

@section('content')
<div class="p-5">
    <div class="flex items-start justify-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Peta Monitoring</h2>
            <p class="text-sm text-gray-500">11 laporan sesuai filter. Laporan yang belum diverifikasi ditandai tanda tanya putus-putus.</p>
        </div>
        <div class="flex gap-2">
            <button onclick="document.getElementById('catat-modal').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-lg transition-colors">
                + Catat Kejadian
            </button>
        </div>
    </div>

    <div class="flex gap-4">
        {{-- Sidebar --}}
        <div class="w-64 flex-shrink-0 bg-white rounded-xl border border-gray-100 shadow-sm overflow-y-auto" style="max-height:600px">
            <div class="p-3 border-b border-gray-100">
                <p class="text-xs font-bold text-gray-700 mb-2">Laporan Banjir Terbaru</p>
                @foreach([['Blang Pulo','Rumah warga: Rahmad Ilyas di...','24 Okt 2026, 07:32','Bahaya Tinggi','red','Menunggu Verifikasi'],['Batuphat','Sedikit luap. Laporan datang dari...','24 Okt 2026, 07:22','Bahaya Rendah','yellow','Menunggu Verifikasi']] as $r)
                <div class="rounded-lg border border-gray-100 p-2.5 mb-2 hover:bg-blue-50 cursor-pointer">
                    <div class="flex items-center gap-2 mb-1"><span class="dot {{ $r[4]==='red'?'bg-red-500':'bg-yellow-400' }}"></span><span class="text-xs font-semibold text-gray-900">{{ $r[0] }}</span></div>
                    <p class="text-xs text-gray-500 truncate">{{ $r[1] }}</p>
                    <p class="text-xs text-gray-400">{{ $r[2] }} · {{ $r[3] }}</p>
                    <span class="inline-flex items-center gap-1 mt-1 text-xs font-medium text-orange-700 bg-orange-50 border border-orange-100 px-2 py-0.5 rounded-full">⌛ {{ $r[5] }}</span>
                </div>
                @endforeach
            </div>
            <div class="p-3 border-b border-gray-100">
                <p class="text-xs font-bold uppercase text-gray-400 tracking-wide mb-2">Tampilan Kejadian</p>
                <div class="flex gap-1 mb-2">
                    <button class="text-xs font-bold px-2.5 py-1.5 rounded-lg bg-gray-900 text-white">Semua Kejadian</button>
                    <button class="text-xs font-medium px-2.5 py-1.5 rounded-lg bg-gray-100 text-gray-600">Terbaru</button>
                </div>
                <button class="text-xs font-medium px-2.5 py-1.5 rounded-lg bg-gray-100 text-gray-600 w-full mb-2 text-left">Terverifikasi</button>
                <label class="flex items-center gap-2 text-xs text-gray-700 mb-2 cursor-pointer"><input type="checkbox" class="w-3.5 h-3.5 rounded"> Hanya Tampilkan Titik Baru</label>
                <div class="relative"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg><input type="text" placeholder="Cari lokasi atau laporan..." class="w-full text-xs border border-gray-200 rounded-lg pl-7 pr-2 py-1.5 focus:outline-none focus:ring-1 focus:ring-blue-500"></div>
            </div>
            <div class="p-3 border-b border-gray-100">
                <p class="text-xs font-bold uppercase text-gray-400 tracking-wide mb-2">Tingkat Bahaya</p>
                @foreach([['Bahaya Tinggi','red'],['Bahaya Sedang','orange'],['Bahaya Rendah','yellow']] as $f)
                <label class="flex items-center gap-2 mb-1.5 cursor-pointer"><input type="checkbox" checked class="w-3.5 h-3.5 rounded"><span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ ['red'=>'bg-red-100 text-red-700','orange'=>'bg-orange-100 text-orange-700','yellow'=>'bg-yellow-100 text-yellow-700'][$f[1]] }}">{{ $f[0] }}</span></label>
                @endforeach
            </div>
            <div class="p-3 border-b border-gray-100">
                <p class="text-xs font-bold uppercase text-gray-400 tracking-wide mb-2">Status Verifikasi</p>
                @foreach([['Terverifikasi','green'],['Menunggu Verifikasi','orange'],['Perlu Klarifikasi','yellow']] as $s)
                <label class="flex items-center gap-2 mb-1.5 cursor-pointer"><input type="checkbox" checked class="w-3.5 h-3.5 rounded"><span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ ['green'=>'bg-green-100 text-green-700','orange'=>'bg-orange-100 text-orange-700','yellow'=>'bg-yellow-100 text-yellow-700'][$s[1]] }}">{{ $s[0] }}</span></label>
                @endforeach
            </div>
            <div class="p-3 border-b border-gray-100">
                <p class="text-xs font-bold uppercase text-gray-400 tracking-wide mb-2">Tanggal Laporan</p>
                <select class="w-full text-xs border border-gray-200 rounded-lg px-2 py-1.5 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500"><option>Semua tanggal</option></select>
            </div>
            <div class="p-3 border-b border-gray-100">
                <p class="text-xs font-bold uppercase text-gray-400 tracking-wide mb-2">Kondisi Jalan</p>
                @foreach([['Dapat Dilalui','green'],['Terbatas','yellow'],['Tidak Dapat Dilalui','red'],['Belum Diketahui','gray']] as $j)
                <label class="flex items-center gap-2 mb-1.5 cursor-pointer"><input type="checkbox" checked class="w-3.5 h-3.5 rounded"><span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ ['green'=>'bg-green-100 text-green-700','yellow'=>'bg-yellow-100 text-yellow-700','red'=>'bg-red-100 text-red-700','gray'=>'bg-gray-100 text-gray-600'][$j[1]] }}">{{ $j[0] }}</span></label>
                @endforeach
            </div>
            <div class="p-3 border-b border-gray-100">
                <label class="flex items-center gap-2 text-xs text-gray-700 cursor-pointer"><input type="checkbox" checked class="w-3.5 h-3.5 rounded text-blue-600"> Tampilkan lokasi pengungsian</label>
            </div>
            <div class="p-3">
                <button class="flex items-center gap-1.5 text-xs text-gray-500 hover:text-gray-800">
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
                <div class="absolute bottom-3 left-3 z-20 bg-white border border-gray-200 rounded-xl shadow-md p-3 text-xs" style="min-width:190px">
                    <button class="flex items-center justify-between w-full mb-2" onclick="this.nextElementSibling.classList.toggle('hidden')">
                        <span class="font-bold text-gray-800">Legenda</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/></svg>
                    </button>
                    <div class="space-y-1.5 text-gray-700">
                        <div class="flex items-center gap-2"><span class="dot bg-red-500"></span> Bahaya Tinggi</div>
                        <div class="flex items-center gap-2"><span class="dot bg-orange-400"></span> Bahaya Sedang</div>
                        <div class="flex items-center gap-2"><span class="dot bg-yellow-400"></span> Bahaya Rendah</div>
                        <div class="flex items-center gap-2"><span class="w-4 h-2 border-2 border-dashed border-gray-400 inline-block rounded"></span> Belum diverifikasi</div>
                        <div class="flex items-center gap-2"><span class="w-4 h-2 border-2 border-blue-400 inline-block rounded"></span> Menunggu verifikasi (outline biru)</div>
                        <div class="flex items-center gap-2"><span class="inline-flex items-center bg-blue-600 text-white text-xs px-1.5 py-0 rounded font-bold">BARU</span> Titik baru (24 jam terakhir)</div>
                        <div class="flex items-center gap-2"><span class="dot bg-gray-500"></span> Kelompok kejadian berdekatan</div>
                        <div class="flex items-center gap-2"><span class="dot bg-green-600"></span> Titik pengungsian</div>
                        <div class="flex items-center gap-2"><span class="w-4 h-0.5 bg-red-600 inline-block"></span> Jalan tidak dapat dilalui</div>
                        <div class="flex items-center gap-2"><span class="w-4 h-0.5 border-t-2 border-dashed border-orange-400 inline-block"></span> Jalan terbatas</div>
                        <div class="flex items-center gap-2"><span class="w-4 h-0.5 bg-blue-500 inline-block"></span> Rute evakuasi</div>
                    </div>
                </div>
                <div id="mon-map"></div>
            </div>
        </div>
    </div>
</div>

{{-- Catat Kejadian Modal --}}
<div id="catat-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-gray-900">Catat Kejadian Banjir</h3>
            <button onclick="document.getElementById('catat-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Atasi Kejadian <span class="text-red-500">*</span></label>
                <input type="text" placeholder="Contoh: Genangan di simpang pasar" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi Banjir</label>
                    <input type="text" value="Kuta Blang" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Perkiraan Ketinggian Air</label>
                    <input type="text" value="30–60 cm" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi Singkat</label>
                <textarea rows="2" placeholder="Kondisi dan situasi terkini..." class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">⊙ Titik Lokasi — klik peta untuk menempatkan</label>
                <div id="modal-map" class="h-32 rounded-xl border border-gray-200"></div>
            </div>
        </div>
        <div class="flex gap-3 mt-5">
            <button onclick="document.getElementById('catat-modal').classList.add('hidden')" class="flex-1 border border-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-xl hover:bg-gray-50">Batal</button>
            <button onclick="simpanCatat()" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2.5 rounded-xl">Simpan &amp; Tampilkan di Peta</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let monMap;
document.addEventListener('DOMContentLoaded', function() {
    monMap = L.map('mon-map',{zoomControl:false,attributionControl:false}).setView([5.1801,97.1500],13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:18}).addTo(monMap);
    L.control.zoom({position:'topright'}).addTo(monMap);
    [[5.183,97.148,'#dc2626',true],[5.178,97.153,'#f97316',true],[5.175,97.145,'#dc2626',true],[5.188,97.152,'#eab308',false],[5.174,97.158,'#f97316',true],[5.192,97.162,'#dc2626',false],[5.186,97.157,'#f97316',true],[5.168,97.144,'#eab308',false]].forEach(function(p){
        L.circleMarker([p[0],p[1]],{radius:18,fillColor:p[3]?p[2]:'transparent',color:p[3]?p[2]:'#9ca3af',weight:2,fillOpacity:p[3]?0.3:0,dashArray:p[3]?null:'6,4'}).addTo(monMap);
        if(p[3]){const ic=L.divIcon({html:'<div style="width:18px;height:18px;background:'+p[2]+';border-radius:50%;border:2px solid #fff;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 3px rgba(0,0,0,.3)"><svg width="10" height="10" viewBox="0 0 24 24" fill="white"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg></div>',className:'',iconSize:[18,18],iconAnchor:[9,9]});L.marker([p[0],p[1]],{icon:ic}).addTo(monMap);}
        else{const qi=L.divIcon({html:'<div style="width:18px;height:18px;background:#9ca3af;border-radius:50%;border:2px dashed #6b7280;display:flex;align-items:center;justify-content:center;font-size:11px;font-weight:bold;color:#fff">?</div>',className:'',iconSize:[18,18],iconAnchor:[9,9]});L.marker([p[0],p[1]],{icon:qi}).addTo(monMap);}
    });
    // Warning triangle markers
    [[5.183,97.153],[5.175,97.158]].forEach(function(p){const wi=L.divIcon({html:'<div style="background:#f97316;width:18px;height:18px;border-radius:4px;display:flex;align-items:center;justify-content:center;border:1px solid #ea580c"><svg width="11" height="11" viewBox="0 0 24 24" fill="white"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg></div>',className:'',iconSize:[18,18],iconAnchor:[9,9]});L.marker(p,{icon:wi}).addTo(monMap);});
    const si=L.divIcon({html:'<div style="background:#1d4ed8;width:22px;height:22px;border-radius:50%;border:2px solid #fff;display:flex;align-items:center;justify-content:center;box-shadow:0 1px 4px rgba(0,0,0,.3)"><svg width="11" height="11" viewBox="0 0 24 24" fill="white"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>',className:'',iconSize:[22,22],iconAnchor:[11,11]});
    [[5.182,97.142],[5.170,97.150],[5.195,97.165],[5.180,97.160],[5.173,97.138]].forEach(s=>L.marker(s,{icon:si}).addTo(monMap));
    L.polyline([[5.183,97.148],[5.179,97.148]],{color:'#dc2626',weight:4}).addTo(monMap);
    L.polyline([[5.180,97.153],[5.180,97.162]],{color:'#f97316',weight:3,dashArray:'8,4'}).addTo(monMap);

    // Modal map
    document.getElementById('catat-modal').addEventListener('click', function(e) {
        if(!document.getElementById('modal-map')._leaflet_id) {
            const mm = L.map('modal-map',{zoomControl:false,attributionControl:false}).setView([5.1801,97.1500],13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:18}).addTo(mm);
            let mk=null; mm.on('click',function(e){if(mk)mm.removeLayer(mk);mk=L.marker(e.latlng).addTo(mm);});
        }
    });
});
function simpanCatat(){document.getElementById('catat-modal').classList.add('hidden');alert('Demo: Kejadian berhasil dicatat dan ditampilkan di peta.');}
</script>
@endpush

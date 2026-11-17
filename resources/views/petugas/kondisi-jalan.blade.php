@extends('layouts.petugas')
@section('title', 'Kondisi Jalan')

@push('styles')
<style>#jalan-map{height:320px}</style>
@endpush

@section('content')
<div class="p-5">
    <div class="mb-4">
        <h2 class="text-xl font-extrabold text-gray-900">Kondisi Jalan</h2>
        <p class="text-sm text-gray-500">Perbarui status kesejalanan. Perubahan langsung mempengaruhi peta dan perhitungan rute evakuasi.</p>
    </div>

    <div class="flex gap-4">
        {{-- Map --}}
        <div class="flex-1 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="absolute top-3 left-3 z-20 inline-flex items-center gap-1 bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs font-medium px-2.5 py-1 rounded-lg relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
                PROTOTIPE · Peta simulasi Kota Lhokseumawe
            </div>
            <div id="jalan-map"></div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50 border-t border-gray-100">
                        <tr>
                            <th class="text-left px-4 py-2.5 font-bold text-gray-500 uppercase tracking-wide">Ruas Jalan</th>
                            <th class="text-left px-4 py-2.5 font-bold text-gray-500 uppercase tracking-wide">Status</th>
                            <th class="text-left px-4 py-2.5 font-bold text-gray-500 uppercase tracking-wide">Catatan</th>
                            <th class="text-left px-4 py-2.5 font-bold text-gray-500 uppercase tracking-wide">Diperbarui</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php $jalan = [
                            ['Jl. Merdeka','Dapat Dilalui','green','Lalu lintas lancar, genangan lokal di sisi barat','24 Okt 2026, 06:40'],
                            ['Jl. Lintas Sumatera','Dapat Dilalui','green','Dapat dilalui, awas genangan di tempat','24 Okt 2026, 06:55'],
                            ['Jl. Samudera','Terbatas','yellow','Genangan 30–40 cm, hanya kendaraan tinggi','24 Okt 2026, 07:30'],
                            ['Jl. Perdagangan','Tidak Dapat Dilalui','red','Genangan lebih dari 60 cm, dari ruas Mon Geudong','24 Okt 2026, 07:25'],
                            ['Jl. Listrik','Terbatas','yellow','Satu lajur tertutup material oleh jus kecil','24 Okt 2026, 07:05'],
                            ['Jl. Pase','Dapat Dilalui','green','Kondisi baik','23 Okt 2026, 18:30'],
                            ['Jl. Iskandar Muda','Dapat Dilalui','green','Kondisi baik','23 Okt 2026, 18:30'],
                            ['Jl. Lingkar Cunda','Belum Diketahui','gray','Be umnada laporan kondisi terbaru...','22 Okt 2026, 10:00'],
                        ];
                        $jc = ['green'=>'bg-green-100 text-green-700','yellow'=>'bg-yellow-100 text-yellow-700','red'=>'bg-red-100 text-red-700','gray'=>'bg-gray-100 text-gray-600'];
                        @endphp
                        @foreach($jalan as $j)
                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="selectJalan('{{ $j[0] }}','{{ $j[1] }}','{{ $j[4] }}','{{ $j[2] }}')">
                            <td class="px-4 py-2.5 font-semibold text-blue-700">{{ $j[0] }}</td>
                            <td class="px-4 py-2.5"><span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $jc[$j[2]] }}">{{ $j[1] }}</span></td>
                            <td class="px-4 py-2.5 text-gray-500 max-w-xs truncate">{{ $j[3] }}</td>
                            <td class="px-4 py-2.5 text-gray-400">{{ $j[4] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-4 py-3 text-xs text-gray-400 border-t border-gray-100">Menampilkan 8 dari 48 data.</div>
            </div>
        </div>

        {{-- Edit panel --}}
        <div id="jalan-panel" class="w-72 flex-shrink-0 bg-white rounded-xl border border-gray-100 shadow-sm p-5 space-y-4">
            <div>
                <p class="text-sm font-bold text-gray-900" id="jalan-name">Jl. Merdeka</p>
                <span id="jalan-badge" class="text-xs font-semibold px-2 py-0.5 rounded-full bg-green-100 text-green-700 mt-1 inline-block">Dapat Dilalui</span>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-700 mb-2">Ubah Status Akses</p>
                <div class="space-y-2" id="status-radios">
                    @foreach([['Dapat Dilalui','green'],['Terbatas','yellow'],['Tidak Dapat Dilalui','red'],['Belum Diketahui','gray']] as $opt)
                    <label class="flex items-center gap-2.5 cursor-pointer px-3 py-2.5 rounded-lg border border-gray-200 hover:border-blue-300 hover:bg-blue-50 transition-colors {{ $opt[0]==='Dapat Dilalui'?'border-blue-400 bg-blue-50':'' }}">
                        <input type="radio" name="jalan_status" value="{{ $opt[0] }}" {{ $opt[0]==='Dapat Dilalui'?'checked':'' }} class="text-blue-600">
                        <span class="text-sm text-gray-700">{{ $opt[0] }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-700 mb-1.5">Catatan Pendukung</p>
                <textarea rows="3" id="jalan-catatan" placeholder="Contoh: tinggi genangan, area kendaraan yang dapat melintas..." class="w-full text-xs border border-gray-200 rounded-lg px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
            </div>
            <button onclick="saveJalan()" class="w-full bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2.5 rounded-xl transition-colors">Simpan Perubahan</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('jalan-map',{zoomControl:false,attributionControl:false}).setView([5.1801,97.1500],13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:18}).addTo(map);
    L.control.zoom({position:'topright'}).addTo(map);
    // Red blocked road
    L.polyline([[5.183,97.148],[5.179,97.148]],{color:'#dc2626',weight:4}).addTo(map);
    // Orange limited road
    L.polyline([[5.180,97.153],[5.180,97.162]],{color:'#f97316',weight:3,dashArray:'8,4'}).addTo(map);
    [[5.183,97.148,'#dc2626'],[5.178,97.153,'#f97316'],[5.188,97.152,'#eab308']].forEach(function(p){
        L.circleMarker([p[0],p[1]],{radius:12,fillColor:p[2],color:p[2],weight:2,fillOpacity:0.3}).addTo(map);
    });
    const si=L.divIcon({html:'<div style="background:#16a34a;width:18px;height:18px;border-radius:50%;border:2px solid #fff;display:flex;align-items:center;justify-content:center;"><svg width="9" height="9" viewBox="0 0 24 24" fill="white"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>',className:'',iconSize:[18,18],iconAnchor:[9,9]});
    [[5.182,97.142],[5.170,97.150],[5.195,97.165]].forEach(s=>L.marker(s,{icon:si}).addTo(map));
});
function selectJalan(name, status, time, color) {
    document.getElementById('jalan-name').textContent = name;
    const colors = {'green':'bg-green-100 text-green-700','yellow':'bg-yellow-100 text-yellow-700','red':'bg-red-100 text-red-700','gray':'bg-gray-100 text-gray-600'};
    const badge = document.getElementById('jalan-badge');
    badge.className = 'text-xs font-semibold px-2 py-0.5 rounded-full mt-1 inline-block ' + colors[color];
    badge.textContent = status;
    document.querySelectorAll('#status-radios label').forEach(l => {
        l.className = l.className.replace('border-blue-400 bg-blue-50','').trim() + (l.querySelector('input').value===status ? ' border-blue-400 bg-blue-50' : '');
    });
}
function saveJalan() { alert('Demo: Kondisi jalan berhasil diperbarui!'); }
</script>
@endpush

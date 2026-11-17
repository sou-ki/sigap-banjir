@extends('layouts.petugas')
@section('title', 'Dashboard Logistik')

@push('styles')
<style>#log-map{height:280px}</style>
@endpush

@section('content')
<div class="p-5">
    <div class="flex items-start justify-between mb-4 flex-wrap gap-3">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Dashboard Logistik</h2>
            <p class="text-sm text-gray-500">Ringkasan stok, kebutuhan, alokasi, dan penyaluran bantuan.</p>
        </div>
        <a href="{{ route('petugas.stok-bantuan') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-lg">+ Kelola Stok</a>
    </div>

    {{-- Alert banners --}}
    <div class="space-y-2 mb-5">
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-3 flex items-center gap-2 text-xs text-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            Stok Air bersih hampir menipis. Prioritas kebutuhan: ada 3 item kebutuhan mendesak yang memerlukan alokasi dari pemerintah pusat.
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-3 flex items-center gap-2 text-xs text-yellow-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
            2 kebutuhan belum dipenuhi sehinggga belum masuk daftar prioritas.
            <a href="{{ route('petugas.prioritas-kebutuhan') }}" class="font-bold underline ml-1">Tinjau sekarang</a>
        </div>
    </div>

    {{-- 6 stat cards --}}
    @php $stats = [
        ['Jenis Bantuan Tersedia','10','dari 12 jenis tersedia','blue','<path d="M20 7l-8-4-8 4v10l8 4 8-4V7z"/>'],
        ['Stok Total Tersedia','1.688','unit yang dikelola','teal','<path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 14l-5-5 1.41-1.41L12 14.17l7.59-7.59L21 8l-9 9z"/>'],
        ['Kebutuhan Belum Terpenuhi','7','150 satuan belum teralokasi','orange','<path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>'],
        ['Kebutuhan Prioritas Tinggi','4','Mendesak · 1 hari','red','<path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>'],
        ['Bantuan Dalam Penyaluran','2','Unit sedang dianggap','purple','<path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>'],
        ['Penyaluran Selesai','1','permintaan telah terkonfirmasi','green','<path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>'],
    ]; @endphp
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-3 mb-5">
        @foreach($stats as $s)
        @php $colors=['blue'=>['bg-blue-50','text-blue-600'],'teal'=>['bg-teal-50','text-teal-600'],'orange'=>['bg-orange-50','text-orange-500'],'red'=>['bg-red-50','text-red-500'],'purple'=>['bg-purple-50','text-purple-600'],'green'=>['bg-green-50','text-green-600']]; $c=$colors[$s[3]]; @endphp
        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-500 leading-tight">{{ $s[0] }}</p>
                <div class="w-7 h-7 {{ $c[0] }} rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ $c[1] }}" viewBox="0 0 24 24" fill="currentColor">{!! $s[4] !!}</svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-gray-900">{{ $s[1] }}</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ $s[2] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Bar chart + kebutuhan per lokasi --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-4">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-1">Ketersediaan Bantuan per Kategori</p>
            <p class="text-xs text-gray-500 mb-4">Stok tersedia setelah dikurangi yang sudah dialokasikan dan tersalurkan.</p>
            <div class="flex items-end justify-around gap-2 h-32">
                @foreach([['Bahan Makanan','720','bg-orange-400'],['Air Minum','600','bg-blue-500'],['Obat-obatan','55','bg-green-500'],['Pakaian','45','bg-purple-400'],['Selimut','248','bg-teal-400'],['Bayi','30','bg-pink-400'],['Kebersihan','160','bg-yellow-400']] as $b)
                <div class="flex flex-col items-center gap-0.5 flex-1">
                    <span class="text-xs font-bold text-gray-800">{{ $b[1] }}</span>
                    <div class="w-full rounded-t-sm {{ $b[2] }}" style="height:{{ max(intval($b[1])/8,4) }}px"></div>
                    <span class="text-xs text-gray-400 truncate w-full text-center" style="font-size:9px">{{ explode(' ',$b[0])[0] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-3 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-3">Kebutuhan per Lokasi</p>
            <div class="space-y-3">
                @foreach([['Aula Kantor Camat Banda Sakti','LPR-2610-0003 · KBT-0001','Air Minum','0/70 terpenuhi','Mendesak','red'],['Hagu Selatan','LPR-2610-0002 · KBT-0002','Popok Areal','0/20 terpenuhi','Tinggi','orange'],['GOR Kota Lhokseumawe','Tanpa referensi kejadian · KBT-0004','Selimut','Sisa 170 unit','Tinggi','orange']] as $k)
                <div class="flex items-start justify-between bg-gray-50 rounded-xl p-3">
                    <div>
                        <p class="text-xs font-semibold text-gray-900">{{ $k[0] }}</p>
                        <p class="text-xs text-gray-400">{{ $k[1] }}</p>
                        <p class="text-xs text-gray-600 mt-1">{{ $k[2] }} · {{ $k[3] }}</p>
                    </div>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full flex-shrink-0 {{ $k[5]==='red'?'bg-red-100 text-red-700':'bg-orange-100 text-orange-700' }}">{{ $k[4] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Penyaluran terbaru + peta + aktivitas --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
        <div class="lg:col-span-3 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-bold text-gray-900">Pemantauan Penyaluran Terbaru</p>
                <a href="{{ route('petugas.penyaluran-bantuan') }}" class="text-xs text-blue-600 font-semibold">Lihat semua</a>
            </div>
            <table class="w-full text-xs">
                <thead class="bg-gray-50 border-b border-gray-100"><tr>@foreach(['Nomor','Tanggal','Lokasi Asal','Lokasi Tujuan','Jenis Bantuan','Jumlah','Penanggung Jawab','Status','Aksi'] as $h)<th class="text-left px-3 py-2 font-bold text-gray-500 uppercase tracking-wide" style="font-size:10px">{{ $h }}</th>@endforeach</tr></thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach([['PNY-003','23 Okt 2026','Gudang Palang Merah Lhokseumawe','Mon Geudong','Paket Obat Dasar & P3k','25 Paket','Tim Logistik Relawan A','Diterima','green'],['PNY-002','24 Okt 2026','Gudang Logistik BPBD Kota','Hagu Selatan','Popok Bayi & Susu Formula','20 Paket','Tim Logistik Relawan B','Dikiapkan','blue'],['PNY-001','24 Okt 2026','Gudang Logistik BPBD Kota','Aula Kantor Camat Banda Sakti','Air Mineral Kemasan 600 ml','40 Dus','Tim Logistik Relawan A','Dalam Pengiriman','orange']] as $p)
                    <tr class="hover:bg-gray-50"><td class="px-3 py-2 font-mono font-semibold text-blue-700">{{ $p[0] }}</td><td class="px-3 py-2 text-gray-500">{{ $p[1] }}</td><td class="px-3 py-2 text-gray-700 max-w-20 truncate">{{ $p[2] }}</td><td class="px-3 py-2 text-gray-700">{{ $p[3] }}</td><td class="px-3 py-2 text-gray-700">{{ $p[4] }}</td><td class="px-3 py-2 text-gray-700">{{ $p[5] }}</td><td class="px-3 py-2 text-gray-600">{{ $p[6] }}</td><td class="px-3 py-2"><span class="font-medium px-1.5 py-0.5 rounded-full {{ ['green'=>'bg-green-100 text-green-700','blue'=>'bg-blue-100 text-blue-700','orange'=>'bg-orange-100 text-orange-700'][$p[8]] }}">{{ $p[7] }}</span></td><td class="px-3 py-2"><button class="text-blue-600 font-semibold hover:underline">Detail</button></td></tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-4 py-2 text-xs text-gray-400 border-t border-gray-100">Menampilkan 3 data.</div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100"><p class="text-sm font-bold text-gray-900">Peta Logistik</p><p class="text-xs text-gray-500">Persebaran lokasi terdampak, pengungsi, dan tim penyaluran.</p></div>
            <div id="log-map"></div>
            <div class="bg-white border-t border-gray-100 p-3">
                <p class="text-xs font-bold text-gray-700 mb-1">Aktivitas Logistik Terbaru</p>
                <p class="text-xs text-gray-400">Belum ada aktivitas logistik.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('log-map',{zoomControl:false,attributionControl:false}).setView([5.1801,97.1500],13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:18}).addTo(map);
    [[5.183,97.148,'#dc2626'],[5.178,97.153,'#f97316'],[5.175,97.145,'#dc2626'],[5.188,97.152,'#eab308']].forEach(function(p){
        L.circleMarker([p[0],p[1]],{radius:12,fillColor:p[2],color:p[2],weight:2,fillOpacity:0.3}).addTo(map);
    });
    const si=L.divIcon({html:'<div style="background:#16a34a;width:18px;height:18px;border-radius:50%;border:2px solid #fff;display:flex;align-items:center;justify-content:center;"><svg width="9" height="9" viewBox="0 0 24 24" fill="white"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>',className:'',iconSize:[18,18],iconAnchor:[9,9]});
    [[5.182,97.142],[5.170,97.150],[5.195,97.165],[5.180,97.160]].forEach(s=>L.marker(s,{icon:si}).addTo(map));
    // Triangle markers (needs)
    [[5.183,97.153],[5.175,97.145]].forEach(function(p){const wi=L.divIcon({html:'<div style="background:#f97316;width:16px;height:16px;border-radius:4px;display:flex;align-items:center;justify-content:center;"><svg width="9" height="9" viewBox="0 0 24 24" fill="white"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg></div>',className:'',iconSize:[16,16],iconAnchor:[8,8]});L.marker(p,{icon:wi}).addTo(map);});
});
</script>
@endpush

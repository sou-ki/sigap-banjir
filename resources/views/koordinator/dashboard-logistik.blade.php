@extends('layouts.koordinator')
@section('title', 'Dashboard Logistik')

@push('styles')
<style>#logistik-map{height:260px}</style>
@endpush

@section('content')
<div class="p-5">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Dashboard Logistik</h2>
            <p class="text-sm text-gray-500">Koordinasi lapangan oleh Teuku Faisal. Data inventaris dan kebutuhan diperbarui tiap petugas.</p>
        </div>
        <button onclick="alert('Demo: Catatan bantuan')" class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold px-4 py-2.5 rounded-xl shadow-sm">
            + Catat Bantuan
        </button>
    </div>

    {{-- Alert --}}
    <div class="bg-teal-50 border border-teal-200 rounded-xl px-4 py-3 mb-5 flex items-start gap-2 text-xs text-teal-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-teal-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
        Selaku koordinator logistik, kamu menerima data dari petugas sekaligus bertanggung jawab mengoordinasi dan menyalurkan bantuan kepada penerima.
    </div>

    {{-- Stats --}}
    @php $stats = [
        ['Bantuan Dihimpun','425','Satuan','bg-teal-50','text-teal-600'],
        ['Kebutuhan Dilaporan','4','2 menunggu verifikasi','bg-orange-50','text-orange-500'],
        ['Kebutuhan Mendesak','2','Verifikasi belum terpenuhi','bg-red-50','text-red-500'],
        ['Alokasi Ditugaskan','3','total penugasan','bg-blue-50','text-blue-600'],
        ['Dalam Pengiriman','2','Belum diterima','bg-purple-50','text-purple-600'],
        ['Penyaluran Selesai','1','2 hari terakhir dikonfirmasi','bg-green-50','text-green-600'],
    ]; @endphp
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-3 mb-5">
        @foreach($stats as $s)
        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-500 leading-tight mb-2">{{ $s[0] }}</p>
            <p class="text-2xl font-extrabold text-gray-900 mb-0.5">{{ $s[1] }}</p>
            <p class="text-xs text-gray-400">{{ $s[2] }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-4">
        {{-- Bantuan Tersedia --}}
        <div class="lg:col-span-3 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-4">Bantuan Tersedia</p>
            <p class="text-xs text-gray-400 mb-3">Stok bantuan yang berhasil dihimpun, dialokasikan dan tersedia.</p>
            <div class="flex items-end gap-3 h-24 mb-3">
                @foreach([['Bahan Makanan','720','bg-orange-400'],['Air Minum','600','bg-teal-500'],['Obat-obatan','55','bg-green-500'],['Pakaian','45','bg-blue-400'],['Selimut','268','bg-purple-400'],['Siku','50','bg-yellow-400'],['Kebersihan','150','bg-pink-400']] as $b)
                <div class="flex flex-col items-center gap-1 flex-1">
                    <span class="text-xs font-bold text-gray-700" style="font-size:10px">{{ $b[1] }}</span>
                    <div class="w-full rounded-t {{ $b[2] }}" style="height:{{ min(intval($b[1])/10,60) }}px"></div>
                    <span class="text-center text-gray-400 leading-none" style="font-size:8px">{{ $b[0] }}</span>
                </div>
                @endforeach
            </div>
            <div class="space-y-1 text-xs text-gray-600">
                <div class="flex justify-between"><span>Minyak</span><span class="font-semibold">120 Dus</span></div>
                <div class="flex justify-between"><span>Selimut Dewasa</span><span class="font-semibold">240 Lembar</span></div>
                <div class="flex justify-between"><span>Pakaian Layak Pakai Dewasa & Anak</span><span class="font-semibold">45 Dus</span></div>
            </div>
        </div>

        {{-- Lokasi Mendesak --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-bold text-gray-900">Lokasi Mendesak</p>
                <p class="text-xs text-gray-400 mt-0.5">3 lokasi membutuhkan bantuan</p>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach([
                    ['Aula Kantor Camat Banda Sakti','LPB-2610-0003','Air Mineral','170 satuan','0/150','Mendesak','red'],
                    ['Hagu Selatan','LPB-2610-0002','Pangan','Sia 10 satuan','0/50','Tinggi','orange'],
                    ['GOR Kota Lhokseumawe','LPB-2610-0001','—','Sia 170 satuan','0/170','Tinggi','orange'],
                ] as $l)
                <div class="px-4 py-3">
                    <div class="flex items-start justify-between mb-1">
                        <p class="text-xs font-semibold text-gray-900">{{ $l[0] }}</p>
                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $l[6]==='red'?'bg-red-100 text-red-700':'bg-orange-100 text-orange-700' }}">{{ $l[5] }}</span>
                    </div>
                    <p class="text-xs text-gray-400 mb-1.5">{{ $l[1] }}</p>
                    <div class="w-full h-1.5 bg-gray-100 rounded-full"><div class="h-full bg-red-400 rounded-full" style="width:0%"></div></div>
                    <p class="text-xs text-gray-400 mt-1">{{ $l[4] }} terpenuhi</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Penugasan Distribusi --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-4">
        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100">
            <p class="text-sm font-bold text-gray-900">Penugasan Distribusi</p>
            <a href="{{ route('koordinator.riwayat-distribusi') }}" class="text-xs text-teal-600 font-semibold hover:underline">Lihat semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        @foreach(['Nomor','Tanggal','Lokasi Asal','Lokasi Tujuan','Jenis Bantuan','Jumlah','Penanggung Jawab','Status','Aksi'] as $h)
                        <th class="text-left px-4 py-2.5 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $dist = [
                        ['PNY-003','23 Okt 2026','Gudang Palang Merah Lhokseumawe','Mon Geudong','Paket Obat Dasar & P3K','25 Paket','Tim Logistik Relawan A','Diterima','green'],
                        ['PNY-002','24 Okt 2026','Gudang Logistik BPBD Kota','Hagu Selatan','Popok Bayi & Susu Formula','20 Paket','Tim Logistik Relawan B','Disalurkan','blue'],
                        ['PNY-001','24 Okt 2026','Gudang Logistik BPBD Kota','Aula Kantor Camat Banda Sakti','Air Mineral Kemasan 600ml','40 Dus','Tim Logistik Relawan A','Dalam Pengiriman','purple'],
                    ]; @endphp
                    @foreach($dist as $d)
                    @php $sc=['green'=>'bg-green-100 text-green-700','blue'=>'bg-blue-100 text-blue-700','purple'=>'bg-purple-100 text-purple-700']; @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs font-mono font-bold text-gray-700">{{ $d[0] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $d[1] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $d[2] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $d[3] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $d[4] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $d[5] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $d[6] }}</td>
                        <td class="px-4 py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $sc[$d[8]] }}">{{ $d[7] }}</span></td>
                        <td class="px-4 py-3"><button class="text-xs text-teal-600 font-semibold hover:underline">Detail</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Peta Logistik --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-bold text-gray-900">Peta Logistik</p>
                <p class="text-xs text-gray-400">Persebaran bantuan, kebutuhan, dan pengungsian beserta penugasan yang sedang berjalan.</p>
            </div>
            <div id="logistik-map"></div>
        </div>
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-3">Aktivitas Logistik Terbaru</p>
            <div class="flex flex-col items-center justify-center h-32 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <p class="text-xs">Belum ada aktivitas logistik</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
    const map=L.map('logistik-map',{zoomControl:false,attributionControl:false}).setView([5.1801,97.1500],13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:18}).addTo(map);
    [[5.183,97.148,'#dc2626'],[5.178,97.153,'#f97316'],[5.175,97.145,'#dc2626'],[5.188,97.152,'#eab308']].forEach(function(p){
        L.circleMarker([p[0],p[1]],{radius:10,fillColor:p[2],color:p[2],weight:2,fillOpacity:0.4}).addTo(map);
    });
});
</script>
@endpush

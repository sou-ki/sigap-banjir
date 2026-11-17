@extends('layouts.petugas')
@section('title', 'Dashboard Operasional')

@push('styles')
<style>#op-map{height:280px}</style>
@endpush

@section('content')
<div class="p-5">
    <div class="flex items-start justify-between mb-5 flex-wrap gap-3">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Dashboard Petugas</h2>
            <p class="text-sm text-gray-500">Ringkasan situasi banjir Kota Lhokseumawe.</p>
        </div>
        <a href="{{ route('petugas.peta-monitoring') }}" class="text-xs font-semibold text-blue-600 border border-blue-200 rounded-lg px-3 py-2 hover:bg-blue-50">Buka Peta Monitor</a>
    </div>

    {{-- 6 stat cards --}}
    @php $stats = [
        ['label'=>'Total Laporan Masuk','val'=>12,'icon'=>'<path d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6z"/>','bg'=>'bg-blue-50','c'=>'text-blue-600'],
        ['label'=>'Menunggu Verifikasi','val'=>4,'icon'=>'<path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>','bg'=>'bg-orange-50','c'=>'text-orange-500'],
        ['label'=>'Kejadian Aktif','val'=>4,'icon'=>'<path d="M12 2c-5.33 4.55-8 8.48-8 11.8 0 4.98 3.8 8.2 8 8.2s8-3.22 8-8.2c0-3.32-2.67-7.25-8-11.8z"/>','bg'=>'bg-red-50','c'=>'text-red-500'],
        ['label'=>'Permintaan Evakuasi','val'=>3,'icon'=>'<path d="M13.49 5.48c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm-3.6 13.9l1-4.4 2.1 2v6h2v-7.5l-2.1-2 .6-3c1.3 1.5 3.3 2.5 5.5 2.5v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1l-5.2 2.2v4.7h2v-3.4l1.8-.7-1.6 8.1-4.9-1-.4 2 7 1.4z"/>','bg'=>'bg-purple-50','c'=>'text-purple-600'],
        ['label'=>'Jalan Terdampak','val'=>3,'icon'=>'<path d="M1 9l2 2c4.97-4.97 13.03-4.97 18 0l2-2C16.93 2.93 7.08 2.93 1 9zm8 8l3 3 3-3a4.237 4.237 0 0 0-6 0zm-4-4 2 2a7.074 7.074 0 0 1 10 0l2-2C15.14 9.14 8.87 9.14 5 13z"/>','bg'=>'bg-yellow-50','c'=>'text-yellow-600'],
        ['label'=>'Pengungsian Aktif','val'=>4,'icon'=>'<path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/>','bg'=>'bg-green-50','c'=>'text-green-600'],
    ]; @endphp
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-3 mb-5">
        @foreach($stats as $s)
        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-500 leading-tight">{{ $s['label'] }}</p>
                <div class="w-7 h-7 {{ $s['bg'] }} rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ $s['c'] }}" viewBox="0 0 24 24" fill="currentColor">{!! $s['icon'] !!}</svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-gray-900">{{ $s['val'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Map + Right panels --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 mb-4">
        {{-- Map --}}
        <div class="lg:col-span-3 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                <div>
                    <p class="text-sm font-bold text-gray-900">Peta Monitoring Banjir</p>
                    <p class="text-xs text-gray-500">Aktifkan lapisan pada peta untuk informasi.</p>
                </div>
                <a href="{{ route('petugas.peta-monitoring') }}" class="text-xs text-blue-600 font-semibold hover:underline">Layar Penuh</a>
            </div>
            <div class="relative">
                <div class="absolute top-2 left-2 z-10 inline-flex items-center gap-1 bg-yellow-50 border border-yellow-200 text-yellow-700 text-xs font-medium px-2.5 py-1 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
                    PROTOTIPE · Peta simulasi Kota Lhokseumawe
                </div>
                <div id="op-map"></div>
            </div>
        </div>

        {{-- Right --}}
        <div class="lg:col-span-2 flex flex-col gap-4">
            {{-- Antrian laporan --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm flex-1">
                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-bold text-gray-900">Antrian Laporan Masuk</p>
                    <a href="{{ route('petugas.verifikasi-laporan') }}" class="text-xs text-blue-600 font-semibold">4</a>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach([['Banjir lokal di Uteunkot','Uteunkot · 24 Okt 2026, 07:10','red'],['Rumah warga terendam di Lancang Garam','Lancang Garam · 24 Okt 2026, 07:22','orange'],['Parit meluap di Batuphat','Batuphat · 24 Okt 2026, 07:22','orange'],['Jalan Pase tergenang di Blang Pulo','Blang Pulo · 24 Okt 2026, 07:45','red']] as $r)
                    <div class="px-4 py-2.5 flex items-start gap-2 hover:bg-gray-50 cursor-pointer">
                        <span class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0 {{ $r[2]==='red' ? 'bg-red-500' : 'bg-orange-400' }}"></span>
                        <div>
                            <p class="text-xs font-semibold text-gray-900">{{ $r[0] }}</p>
                            <p class="text-xs text-gray-400">{{ $r[1] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Peringatan penting --}}
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
                <div class="px-4 py-3 border-b border-gray-100">
                    <p class="text-sm font-bold text-gray-900">Peringatan Penting</p>
                </div>
                <div class="p-3 space-y-2">
                    @foreach(['4 Permintaan evakuasi tidak ditangani','Aula Kantor Camat Banda Sakti: hampir penuh','LPR-2610-0001: butuh bantuan segera di Mon Geudong','LPR-2610-0003: butuh bantuan segera di Hagu Selatan','LPR-2610-0006: butuh bantuan segera di Lancang Garam'] as $w)
                    <div class="flex items-start gap-2 text-xs text-orange-700 bg-orange-50 rounded-lg px-3 py-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-orange-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
                        {{ $w }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom: Tingkat keparahan + evakuasi + aktivitas --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        {{-- Bar chart tingkat keparahan --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-4">Tingkat Keparahan Kejadian Aktif</p>
            <div class="flex items-end justify-around gap-3 h-28">
                @foreach([['Tinggi','2','bg-red-500'],['Sedang','2','bg-orange-400'],['Rendah','0','bg-yellow-400']] as $b)
                <div class="flex flex-col items-center gap-1 flex-1">
                    <span class="text-sm font-bold text-gray-800">{{ $b[1] }}</span>
                    <div class="w-full rounded-t-lg {{ $b[0] }}h {{ $b[2] }}" style="height:{{ ($b[1]>0 ? intval($b[1])*40 : 6) }}px"></div>
                    <span class="text-xs text-gray-500">{{ $b[0] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Ringkasan permintaan evakuasi --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-3">Ringkasan Permintaan Evakuasi</p>
            <div class="space-y-3">
                @foreach([['EVK–0001','Mon Geudong','5 orang','Dalam Penanganan','blue'],['EVK–0002','Hagu Selatan','8 orang','Diverifikasi','green'],['EVK–0003','Lancang Garam','3 orang','Menunggu','gray']] as $e)
                <div class="flex items-center justify-between bg-gray-50 rounded-lg px-3 py-2">
                    <div>
                        <p class="text-xs font-semibold text-gray-900">{{ $e[0] }} · {{ $e[1] }}</p>
                        <p class="text-xs text-gray-500">{{ $e[2] }}</p>
                    </div>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full
                        {{ $e[4]==='blue' ? 'bg-blue-100 text-blue-700' : ($e[4]==='green' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600') }}">
                        {{ $e[3] }}
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Aktivitas terbaru --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-3">Aktivitas Terbaru</p>
            <div class="space-y-2">
                @foreach(['24 Okt 2026, 08:12','24 Okt 2026, 07:58','24 Okt 2026, 06:44','24 Okt 2026, 04:00'] as $t)
                <div class="flex items-start gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-400 mt-1.5 flex-shrink-0"></span>
                    <div>
                        <p class="text-xs text-gray-700">Masuk ke sistem</p>
                        <p class="text-xs text-gray-400">Cut Nurmala · {{ $t }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const map = L.map('op-map',{zoomControl:false,attributionControl:false}).setView([5.1801,97.1500],13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:18}).addTo(map);
    [[5.183,97.148,'#dc2626'],[5.178,97.153,'#f97316'],[5.175,97.145,'#dc2626'],[5.188,97.152,'#eab308'],[5.174,97.158,'#f97316'],[5.192,97.162,'#dc2626']].forEach(function(p){
        L.circleMarker([p[0],p[1]],{radius:16,fillColor:p[2],color:p[2],weight:2,fillOpacity:0.3}).addTo(map);
        const ic=L.divIcon({html:'<div style="width:16px;height:16px;background:'+p[2]+';border-radius:50%;border:2px solid #fff;box-shadow:0 1px 3px rgba(0,0,0,.3)"></div>',className:'',iconSize:[16,16],iconAnchor:[8,8]});
        L.marker([p[0],p[1]],{icon:ic}).addTo(map);
    });
    const si=L.divIcon({html:'<div style="background:#16a34a;width:20px;height:20px;border-radius:50%;border:2px solid #fff;display:flex;align-items:center;justify-content:center;"><svg width="10" height="10" viewBox="0 0 24 24" fill="white"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg></div>',className:'',iconSize:[20,20],iconAnchor:[10,10]});
    [[5.182,97.142],[5.170,97.150],[5.195,97.165],[5.180,97.160]].forEach(s=>L.marker(s,{icon:si}).addTo(map));
});
</script>
@endpush

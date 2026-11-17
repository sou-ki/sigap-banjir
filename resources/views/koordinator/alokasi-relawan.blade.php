@extends('layouts.koordinator')
@section('title', 'Alokasi Relawan')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Alokasi Relawan</h2>
        <p class="text-sm text-gray-500">Pilih kebutuhan, pilih relawan yang sesuai, lalu konfirmasi penugasan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        {{-- Step 1: Pilih Kebutuhan --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-bold text-gray-900">1. Pilih Kebutuhan</p>
            </div>
            <div class="divide-y divide-gray-50">
                @php $kebutuhan = [
                    ['Evakuasi warga Hagu Selatan','Hagu Selatan · 0 relawan · Prioritas Tinggi','red',true],
                    ['Evakuasi benda Lancang Garam','Lancang Garam · 0 relawan · Prioritas Tinggi','red',false],
                    ['Distribusi logistik Aula Camat','Banda Sakti · 12 relawan · Prioritas Sedang','orange',false],
                    ['Pencatatan korban terdampak Mon Geudong','Mon Geudong · 0 relawan · Prioritas Sedang','orange',false],
                    ['Dukungan dapur umum Muara Satu','Ujong Blang · 0 relawan · Prioritas Rendah','yellow',false],
                ]; @endphp
                @foreach($kebutuhan as $k)
                <div class="px-4 py-3 cursor-pointer {{ $k[3] ? 'bg-teal-50 border-l-2 border-teal-500' : 'hover:bg-gray-50' }}">
                    <p class="text-sm font-semibold text-gray-900">{{ $k[0] }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $k[1] }}</p>
                    @if($k[3])
                    <div class="mt-1.5 flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-teal-500"></span>
                        <span class="text-xs text-teal-600 font-medium">Dipilih</span>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        {{-- Step 2: Pilih Relawan --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-bold text-gray-900">2. Pilih Relawan</p>
                <p class="text-xs text-gray-400 mt-0.5">Evakuasi: Pertolongan Pertama</p>
            </div>
            <div class="px-4 py-2 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <input type="text" placeholder="Hanya yang tersedia" class="text-xs border border-gray-200 rounded-lg px-3 py-1.5 flex-1 focus:outline-none focus:ring-1 focus:ring-teal-500">
                    <select class="text-xs border border-gray-200 rounded-lg px-2 py-1.5 bg-white focus:outline-none">
                        <option>Semua keahlian</option>
                    </select>
                </div>
            </div>
            <div class="divide-y divide-gray-50 max-h-80 overflow-y-auto">
                @php $relawan2 = [
                    ['Nurul Azirah','Kuta Blang',['Pertolongan Pertama','Evakuasi'],'Tersedia',false,true],
                    ['Teuku Ramli','Lancang Garam',['Evakuasi','Pertolongan Pertama'],'Tersedia',true,false],
                    ['Cut Meutia','Hagu Selatan',['Pertolongan Pertama'],'Tersedia',false,true],
                    ['Hendra Saputra','Hagu Selatan',['Evakuasi','Transportasi'],'Tersedia',false,false],
                    ['Mawaddah','Cunda',['Pertolongan Pertama','Pendataan Lapangan'],'Tersedia',false,false],
                    ['Rahmat Hidayat','Uteunkot',['Transportasi','Logistik'],'Tersedia',false,false],
                ]; @endphp
                @foreach($relawan2 as $r)
                <label class="flex items-start gap-3 px-4 py-3 cursor-pointer hover:bg-gray-50 {{ $r[4]?'bg-teal-50':'' }}">
                    <input type="checkbox" {{ $r[4]?'checked':'' }} class="mt-0.5 w-4 h-4 rounded border-gray-300 text-teal-600">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <p class="text-sm font-semibold text-gray-900">{{ $r[0] }}</p>
                            <span class="text-xs font-semibold px-1.5 py-0.5 rounded-full bg-teal-100 text-teal-700">Tersedia</span>
                            @if($r[5])<span class="text-xs font-semibold px-1.5 py-0.5 rounded-full bg-orange-100 text-orange-700">Disamakan</span>@endif
                        </div>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach($r[2] as $k)
                            <span class="text-xs text-gray-500">✓ {{ $k }}</span>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $r[1] }} · satu wilayah dengan lokasi tugas</p>
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Step 3: Ringkasan --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm flex flex-col">
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-bold text-gray-900">3. Ringkasan Penugasan</p>
            </div>
            <div class="flex-1 p-4">
                <div id="map-alokasi" class="w-full rounded-xl bg-gray-100 mb-4" style="height:160px"></div>
                <div class="bg-gray-50 rounded-xl p-3 mb-4">
                    <p class="text-sm font-bold text-gray-900 mb-1">Evakuasi warga Hagu Selatan</p>
                    <p class="text-xs text-gray-500 mb-2">Hagu Selatan · 2 dari 4 relawan dipilih</p>
                    <p class="text-xs text-gray-500 font-medium mb-1">RELAWAN DIPILIH (2)</p>
                    <p class="text-xs text-gray-600">Teuku Ramli</p>
                </div>
            </div>
            <div class="px-4 pb-4">
                <button onclick="alert('Demo: Penugasan dikonfirmasi!')" class="w-full bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold py-2.5 rounded-xl">Konfirmasi Penugasan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded',function(){
    const map=L.map('map-alokasi',{zoomControl:false,attributionControl:false}).setView([5.1801,97.1500],13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:18}).addTo(map);
    const ico=L.divIcon({html:'<div style="background:#dc2626;width:14px;height:14px;border-radius:50%;border:2px solid #fff"></div>',className:'',iconSize:[14,14],iconAnchor:[7,7]});
    L.marker([5.183,97.148],{icon:ico}).addTo(map);
});
</script>
@endpush

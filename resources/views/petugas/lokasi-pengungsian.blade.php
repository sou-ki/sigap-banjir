@extends('layouts.petugas')
@section('title', 'Lokasi Pengungsian')

@section('content')
<div class="p-5">
    <div class="flex items-start justify-between mb-5 flex-wrap gap-3">
        <p class="text-sm text-gray-500">Kelola kapasitas, fasilitas pengungsian, dan status operasional.</p>
        <div class="flex gap-2">
            <button onclick="setView('kartu')" id="btn-kartu" class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-gray-900 text-white">Kartu</button>
            <button onclick="setView('tabel')" id="btn-tabel" class="text-xs font-medium px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200">Tabel</button>
            <button onclick="document.getElementById('tambah-modal').classList.remove('hidden')" class="inline-flex items-center gap-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-1.5 rounded-lg transition-colors">
                + Tambah Pengungsian
            </button>
        </div>
    </div>

    {{-- Card view --}}
    <div id="view-kartu">
        @php $shelters = [
            ['GOR Kota Lhokseumawe','Jl. Merdeka Barat, Kec. Banda Sakti',400,212,'aktif',['Air bersih','Dapur umum','Posko kesehatan']],
            ['Aula Kantor Camat Banda Sakti','Jl. Samudera, Kec. Banda Sakti',150,148,'penuh',['Air bersih','Listrik']],
            ['SDN 1 Banda Sakti','Jl. Pase, Kec. Banda Sakti',220,64,'aktif',['Air bersih','MCK','Ruang kelas']],
            ['Meunasah Blang Pulo','Gampong Blang Pulo, Kec. Muara Satu',90,0,'siaga',['Air bersih']],
            ['Gedung Serbaguna Muara Satu','Jl. Listrik, Kec. Muara Satu',300,97,'aktif',['Air bersih','Dapur umum','Genset']],
        ];
        $badge=['aktif'=>'text-green-700 bg-green-50 border-green-200','penuh'=>'text-red-700 bg-red-50 border-red-200','siaga'=>'text-yellow-700 bg-yellow-50 border-yellow-200'];
        $bl=['aktif'=>'bg-green-500','penuh'=>'bg-red-500','siaga'=>'bg-yellow-400'];
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($shelters as $s)
            @php $pct=round($s[2]>0?$s[3]/$s[2]*100:0); $sisa=$s[2]-$s[3]; @endphp
            <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg></div>
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full border {{ $badge[$s[4]] }}">{{ ucfirst($s[4]) }}</span>
                </div>
                <h3 class="font-bold text-gray-900 text-sm mb-1">{{ $s[0] }}</h3>
                <p class="text-xs text-gray-500 flex items-start gap-1 mb-3"><svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>{{ $s[1] }}</p>
                <div class="mb-3"><div class="flex justify-between text-xs mb-1"><span class="text-gray-500">Terisi {{ $s[3] }}/{{ $s[2] }}</span><span class="font-semibold {{ $pct>=95?'text-red-600':'text-green-600' }}">Sisa {{ $sisa }}</span></div><div class="w-full bg-gray-100 rounded-full h-1.5"><div class="h-1.5 rounded-full {{ $bl[$s[4]] }}" style="width:{{ $pct }}%"></div></div></div>
                <div class="flex flex-wrap gap-1 mb-4">@foreach($s[5] as $f)<span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ $f }}</span>@endforeach</div>
                <div class="flex gap-2 pt-3 border-t border-gray-50">
                    <button class="text-xs font-medium text-blue-600 hover:text-blue-800">Detail</button>
                    <button class="text-xs font-medium text-gray-500 hover:text-gray-800 flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>Ubah</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Table view (hidden) --}}
    <div id="view-tabel" class="hidden">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <table class="w-full text-xs">
                <thead class="bg-gray-50 border-b border-gray-100"><tr>@foreach(['Nama Pengungsian','Alamat','Kapasitas','Pengungsi','Sisa','Status'] as $h)<th class="text-left px-4 py-2.5 font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>@endforeach</tr></thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($shelters as $s)
                    @php $sisa=$s[2]-$s[3]; @endphp
                    <tr class="hover:bg-gray-50"><td class="px-4 py-3 font-semibold text-gray-900">{{ $s[0] }}</td><td class="px-4 py-3 text-gray-500">{{ $s[1] }}</td><td class="px-4 py-3 text-gray-700">{{ $s[2] }}</td><td class="px-4 py-3 text-gray-700">{{ $s[3] }}</td><td class="px-4 py-3 font-semibold {{ $sisa<=2?'text-red-600':'text-green-600' }}">{{ $sisa }}</td><td class="px-4 py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full border {{ $badge[$s[4]] }}">{{ ucfirst($s[4]) }}</span></td></tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-4 py-3 text-xs text-gray-400 border-t border-gray-100">Menampilkan 5 dari 5 data.</div>
        </div>
    </div>
</div>

{{-- Tambah Modal --}}
<div id="tambah-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-6 max-h-screen overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-gray-900">Tambah Lokasi Pengungsian</h3>
            <button onclick="document.getElementById('tambah-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="space-y-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Pengungsian <span class="text-red-500">*</span></label><input type="text" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Alamat <span class="text-red-500">*</span></label><input type="text" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            <div class="grid grid-cols-2 gap-3">
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Kapasitas <span class="text-red-500">*</span></label><input type="number" value="100" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Pengungsi</label><input type="number" value="0" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Status Operasional</label><select class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"><option>Siaga</option><option>Aktif</option><option>Penuh</option></select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Fasilitas</label><input type="text" placeholder="Pisahkan dengan koma" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi Peta — klik untuk menempatkan penanda</label>
                <div id="tambah-map" class="h-40 rounded-xl border border-gray-200"></div>
            </div>
        </div>
        <div class="flex gap-3 mt-5">
            <button onclick="document.getElementById('tambah-modal').classList.add('hidden')" class="flex-1 border border-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-xl hover:bg-gray-50">Batal</button>
            <button onclick="alert('Demo: Pengungsian berhasil ditambahkan!');document.getElementById('tambah-modal').classList.add('hidden')" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2.5 rounded-xl">Simpan</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function setView(v) {
    document.getElementById('view-kartu').classList.toggle('hidden', v!=='kartu');
    document.getElementById('view-tabel').classList.toggle('hidden', v!=='tabel');
    document.getElementById('btn-kartu').className = v==='kartu' ? 'text-xs font-semibold px-3 py-1.5 rounded-lg bg-gray-900 text-white' : 'text-xs font-medium px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200';
    document.getElementById('btn-tabel').className = v==='tabel' ? 'text-xs font-semibold px-3 py-1.5 rounded-lg bg-gray-900 text-white' : 'text-xs font-medium px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200';
}
let tambahMap;
document.getElementById('tambah-modal').addEventListener('click', function() {
    setTimeout(function(){
        if(!tambahMap){tambahMap=L.map('tambah-map',{zoomControl:false,attributionControl:false}).setView([5.1801,97.1500],13);L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:18}).addTo(tambahMap);let mk=null;tambahMap.on('click',function(e){if(mk)tambahMap.removeLayer(mk);mk=L.marker(e.latlng).addTo(tambahMap);});}else{tambahMap.invalidateSize();}
    },200);
});
</script>
@endpush

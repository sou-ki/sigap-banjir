@extends('layouts.dashboard')
@section('title', 'Lokasi Pengungsian')

@section('content')
<div class="p-6">
    <div class="flex items-start justify-between mb-6 flex-wrap gap-3">
        <p class="text-sm text-gray-500">Kapasitas dan status operasional pengungsian.</p>
    </div>

    @php
    $shelters = [
        ['name'=>'GOR Kota Lhokseumawe','address'=>'Jl. Merdeka Barat, Kec. Banda Sakti','capacity'=>400,'occupied'=>212,'status'=>'Aktif','st'=>'aktif','facilities'=>['Air bersih','Dapur umum','Posko kesehatan']],
        ['name'=>'Aula Kantor Camat Banda Sakti','address'=>'Jl. Samudera, Kec. Banda Sakti','capacity'=>150,'occupied'=>148,'status'=>'Penuh','st'=>'penuh','facilities'=>['Air bersih','Listrik']],
        ['name'=>'SDN 1 Banda Sakti','address'=>'Jl. Pase, Kec. Banda Sakti','capacity'=>220,'occupied'=>64,'status'=>'Aktif','st'=>'aktif','facilities'=>['Air bersih','MCK','Ruang kelas']],
        ['name'=>'Meunasah Blang Pulo','address'=>'Gampong Blang Pulo, Kec. Muara Satu','capacity'=>90,'occupied'=>0,'status'=>'Siaga','st'=>'siaga','facilities'=>['Air bersih']],
        ['name'=>'Gedung Serbaguna Muara Satu','address'=>'Jl. Listrik, Kec. Muara Satu','capacity'=>300,'occupied'=>97,'status'=>'Aktif','st'=>'aktif','facilities'=>['Air bersih','Dapur umum','Genset']],
    ];
    $badge = ['aktif'=>'text-green-700 bg-green-50 border-green-200','penuh'=>'text-red-700 bg-red-50 border-red-200','siaga'=>'text-yellow-700 bg-yellow-50 border-yellow-200'];
    $badgeIcon = ['aktif'=>'<path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>','penuh'=>'<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>','siaga'=>'<path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>'];
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($shelters as $s)
        @php
            $pct = $s['capacity'] > 0 ? round($s['occupied']/$s['capacity']*100) : 0;
            $sisa = $s['capacity'] - $s['occupied'];
            $bar = $pct >= 95 ? 'bg-red-500' : ($pct >= 70 ? 'bg-orange-400' : 'bg-green-500');
            $sisaC = $pct >= 95 ? 'text-red-600' : 'text-green-600';
        @endphp
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow flex flex-col">
            <div class="flex items-center justify-between mb-3">
                <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/></svg>
                </div>
                <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full border {{ $badge[$s['st']] }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor">{!! $badgeIcon[$s['st']] !!}</svg>
                    {{ $s['status'] }}
                </span>
            </div>
            <h3 class="font-bold text-gray-900 text-sm mb-1">{{ $s['name'] }}</h3>
            <p class="text-xs text-gray-500 flex items-start gap-1 mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                {{ $s['address'] }}
            </p>
            <div class="mb-3">
                <div class="flex justify-between text-xs mb-1">
                    <span class="text-gray-500">Terisi {{ $s['occupied'] }}/{{ $s['capacity'] }}</span>
                    <span class="font-semibold {{ $sisaC }}">Sisa {{ $sisa }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5">
                    <div class="h-1.5 rounded-full {{ $bar }}" style="width:{{ $pct }}%"></div>
                </div>
            </div>
            <div class="flex flex-wrap gap-1.5 mb-4">
                @foreach($s['facilities'] as $f)
                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ $f }}</span>
                @endforeach
            </div>
            <div class="mt-auto pt-3 border-t border-gray-50">
                <a href="{{ route('dashboard.rute-evakuasi') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Cari Rute →</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

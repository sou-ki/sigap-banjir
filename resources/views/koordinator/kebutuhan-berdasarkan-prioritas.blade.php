@extends('layouts.koordinator')
@section('title', 'Kebutuhan Berdasarkan Prioritas')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Kebutuhan Berdasarkan Prioritas</h2>
        <p class="text-sm text-gray-500">Urutan prioritas tiga distrik petugas. Gunakan sebagai acuan koordinasi lapangan.</p>
    </div>

    {{-- Alert --}}
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3 mb-6 flex items-start gap-2 text-xs text-yellow-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
        7 kebutuhan butuh tindakan lebih lanjut sehingga perlu masuk ke daftar prioritas.
    </div>

    {{-- Mendesak --}}
    <div class="mb-6">
        <p class="text-sm font-bold text-red-700 mb-3 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-red-500"></span>
            Mendesak · 2
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach([
                ['Aula Kantor Camat Banda Sakti','LPB-2610-0003','Paket Sembako','150 Paket',0,150,'24 Okt 2026, 04:00; pembaruan 24 Okt 2026 04:30 oleh Cut Nurmala'],
                ['Aula Kantor Camat Banda Sakti','LPB-2610-0003','Air Mineral Kemasan','60 Dus',0,60,'24 Okt 2026, 04:00; pembaruan 24 Okt 2026 04:30 oleh Cut Nurmala'],
            ] as $k)
            <div class="bg-white rounded-xl border border-red-200 shadow-sm p-4">
                <div class="flex items-start justify-between mb-2">
                    <p class="font-bold text-gray-900 text-sm">{{ $k[0] }}</p>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-red-100 text-red-700">Mendesak</span>
                </div>
                <p class="text-xs text-gray-400 mb-3">{{ $k[1] }}</p>
                <p class="text-sm font-semibold text-gray-800 mb-1">{{ $k[2] }}</p>
                <p class="text-xs text-gray-500 mb-2">{{ $k[3] }} dibutuhkan</p>
                <div class="flex items-center gap-2 mb-2">
                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-red-400 rounded-full" style="width:{{ $k[5]>0?round(($k[4]/$k[5])*100):0 }}%"></div>
                    </div>
                    <span class="text-xs text-gray-500 flex-shrink-0">{{ $k[4] }}/{{ $k[5] }} terpenuhi</span>
                </div>
                <p class="text-xs text-gray-400">{{ $k[6] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Prioritas Tinggi --}}
    <div class="mb-6">
        <p class="text-sm font-bold text-orange-700 mb-3 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-orange-400"></span>
            Prioritas Tinggi · 2
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @foreach([
                ['GOR Kota Lhokseumawe','KBT-004','Selimut Dewasa','121 Lembar',0,121,'24 Okt 2026, 03:50; pembaruan 24 Okt 2026 03:50 oleh Cut Nurmala'],
                ['Hagu Selatan','KBT-003','Popok Bayi & Susu Formula','30 Paket',10,30,'24 Okt 2026, 03:50; pembaruan 24 Okt 2026 03:50 oleh Cut Nurmala'],
            ] as $k)
            <div class="bg-white rounded-xl border border-orange-200 shadow-sm p-4">
                <div class="flex items-start justify-between mb-2">
                    <p class="font-bold text-gray-900 text-sm">{{ $k[0] }}</p>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-orange-100 text-orange-700">Tinggi</span>
                </div>
                <p class="text-xs text-gray-400 mb-3">{{ $k[1] }}</p>
                <p class="text-sm font-semibold text-gray-800 mb-1">{{ $k[2] }}</p>
                <p class="text-xs text-gray-500 mb-2">{{ $k[3] }} dibutuhkan</p>
                <div class="flex items-center gap-2 mb-2">
                    <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-orange-400 rounded-full" style="width:{{ $k[5]>0?round(($k[4]/$k[5])*100):0 }}%"></div>
                    </div>
                    <span class="text-xs text-gray-500 flex-shrink-0">{{ $k[4] }}/{{ $k[5] }} terpenuhi</span>
                </div>
                <p class="text-xs text-gray-400">{{ $k[6] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Prioritas Normal --}}
    <div>
        <p class="text-sm font-bold text-yellow-700 mb-3 flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
            Prioritas Normal · 3
        </p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            @foreach([
                ['Lancang Garam','KBT-006','Paket Kebersihan','90 Paket',30,90,'Sedang'],
                ['Gedung Serbaguna Muara Satu','KBT-007','Pakaian Layak Pakai','20 Dus',17,20,'Sedang'],
                ['SDN I Banda Sakti','KBT-008','Air Bersih Galon 19L','30 Dus',44,30,'Rendah'],
            ] as $k)
            <div class="bg-white rounded-xl border border-yellow-200 shadow-sm p-4">
                <div class="flex items-start justify-between mb-2">
                    <p class="font-bold text-gray-900 text-sm">{{ $k[0] }}</p>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700">{{ $k[6] }}</span>
                </div>
                <p class="text-xs text-gray-400 mb-2">{{ $k[1] }}</p>
                <p class="text-sm font-semibold text-gray-800 mb-1">{{ $k[2] }}</p>
                <div class="flex items-center gap-2 mb-1">
                    <div class="flex-1 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-yellow-400 rounded-full" style="width:{{ $k[5]>0?min(round(($k[4]/$k[5])*100),100):0 }}%"></div>
                    </div>
                    <span class="text-xs text-gray-500 flex-shrink-0">{{ $k[4] }}/{{ $k[5] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

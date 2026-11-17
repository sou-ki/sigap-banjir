@extends('layouts.koordinator')
@section('title', 'Alokasi & Penyaluran')

@section('content')
<div class="p-5">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Alokasi & Penyaluran</h2>
            <p class="text-sm text-gray-500">Alokasi yang ditugaskan kepada tim relawan beserta lokasi tujuannya.</p>
        </div>
        <button onclick="alert('Demo: Ajukan alokasi')" class="inline-flex items-center gap-2 border border-teal-300 text-teal-700 bg-teal-50 hover:bg-teal-100 text-sm font-semibold px-4 py-2 rounded-xl">
            + Ajukan Alokasi
        </button>
    </div>

    {{-- Dalam Pengiriman --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
        @foreach([
            ['PNY-001','Aula Kantor Camat (Banda Sakti)','40 Dus Air Mineral Kemasan 600ml','ALK-002 · juga ALK-003','Tim Logistik Relawan A','Dalam Pengiriman','purple'],
            ['PNY-002','Hagu Selatan','20 Paket Popok Bayi & Susu Formula','YNT-025 · juga ALK-003','Tim Logistik Relawan B','Disalurkan','blue'],
        ] as $p)
        @php $sc=['purple'=>'bg-purple-100 text-purple-700','blue'=>'bg-blue-100 text-blue-700','green'=>'bg-green-100 text-green-700']; @endphp
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <span class="text-xs font-mono text-gray-400">{{ $p[0] }}</span>
                    <p class="font-bold text-gray-900 mt-0.5">{{ $p[1] }}</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $sc[$p[6]] }}">{{ $p[5] }}</span>
            </div>
            <p class="text-sm text-gray-600 mb-1">{{ $p[2] }}</p>
            <p class="text-xs text-gray-400 mb-4">{{ $p[3] }} · {{ $p[4] }}</p>

            {{-- Progress steps --}}
            <div class="flex items-center gap-1 mb-4">
                @foreach(['Alokasi Diterima','Bantuan Disiapkan','Dalam Pengiriman','Sampai di Lokasi','Penerimaan Dikonfirmasi'] as $i => $step)
                <div class="flex-1 flex flex-col items-center gap-1">
                    <div class="w-5 h-5 rounded-full flex items-center justify-center {{ $i <= 2 ? 'bg-teal-500' : 'bg-gray-200' }}">
                        @if($i <= 2)
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                        @else
                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                        @endif
                    </div>
                </div>
                @if(!$loop->last)<div class="flex-1 h-0.5 {{ $i < 2 ? 'bg-teal-300' : 'bg-gray-200' }} -mt-3"></div>@endif
                @endforeach
            </div>

            <div class="flex gap-2">
                <button class="flex-1 text-xs font-semibold text-teal-700 border border-teal-200 bg-teal-50 hover:bg-teal-100 py-2 rounded-lg">Tandai Sampai di Lokasi</button>
                <button class="flex-1 text-xs font-semibold text-teal-700 border border-teal-200 bg-teal-50 hover:bg-teal-100 py-2 rounded-lg">Konfirmasi Penerimaan</button>
                <button class="text-xs text-gray-500 hover:underline px-2">Detail</button>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pengajuan Alokasi Saya --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-5">
        <div class="px-5 py-3 border-b border-gray-100">
            <p class="text-sm font-bold text-gray-900">Pengajuan Alokasi Saya</p>
            <p class="text-xs text-gray-400 mt-0.5">Pengajuan yang dilakukan berbeda terhadap petugas sebelum dialokasikan.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        @foreach(['Kode','Tujuan','Barang','Tanggal','Status'] as $h)
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs font-mono text-gray-500">ALK-004</td>
                        <td class="px-4 py-3 text-xs text-gray-700">GOR Kota Lhokseumawe</td>
                        <td class="px-4 py-3 text-xs text-gray-600">60 Lembar Selimut Dewasa</td>
                        <td class="px-4 py-3 text-xs text-gray-400">24 Okt 2026, 07:30</td>
                        <td class="px-4 py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700">Menunggu Persetujuan</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-4 py-2.5 text-xs text-gray-400 border-t border-gray-100">Menampilkan 1 dari 1 data</div>
    </div>

    {{-- Penyaluran Selesai atau Dibatalkan --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="px-5 py-3 border-b border-gray-100">
            <p class="text-sm font-bold text-gray-900">Penyaluran Selesai atau Dibatalkan</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        @foreach(['Nomor','Tujuan','Jumlah','Status','Pencermatan'] as $h)
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs font-mono text-gray-500">PNY-003</td>
                        <td class="px-4 py-3 text-xs text-gray-700">Mon Geudong</td>
                        <td class="px-4 py-3 text-xs text-gray-600">25 Paket</td>
                        <td class="px-4 py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-teal-100 text-teal-700">Diterima</span></td>
                        <td class="px-4 py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-teal-50 text-teal-600">Dikonfirmasi Petugas</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-4 py-2.5 text-xs text-gray-400 border-t border-gray-100">Menampilkan 1 dari 1 data</div>
    </div>
</div>
@endsection

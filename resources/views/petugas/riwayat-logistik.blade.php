@extends('layouts.petugas')
@section('title', 'Riwayat Logistik')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Riwayat Logistik</h2>
        <p class="text-sm text-gray-500">Jejak penyaluran dan aktivitas logistik di lapangan.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex gap-1 px-4 py-3 border-b border-gray-100">
            <button class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-gray-900 text-white">Penyaluran <span class="ml-1 bg-white/20 px-1.5 rounded-full">3</span></button>
            <button class="text-xs font-medium px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200">Pengiriman Stok 15</button>
            <button class="text-xs font-medium px-3 py-1.5 rounded-lg bg-gray-100 text-gray-600 hover:bg-gray-200">Aktivitas</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead class="bg-gray-50 border-b border-gray-100"><tr>@foreach(['Nomor','Tanggal','Lokasi Asal','Lokasi Tujuan','Jenis Bantuan','Jumlah','Penanggung Jawab','Status','Aksi'] as $h)<th class="text-left px-3 py-2.5 font-bold text-gray-500 uppercase tracking-wide whitespace-nowrap" style="font-size:10px">{{ $h }}</th>@endforeach</tr></thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach([['PNY-001','24 Okt 2026','Gudang Logistik BPBD Kota','Aula Kantor Camat Banda Sakti','Air Mineral Kemasan 600 ml','40 Dus','Tim Logistik Relawan A','Dalam Pengiriman','orange'],['PNY-002','24 Okt 2026','Gudang Logistik BPBD Kota','Hagu Selatan','Popok Bayi & Susu Formula','20 Paket','Tim Logistik Relawan B','Dikiapkan','blue'],['PNY-003','23 Okt 2026','Gudang Palang Merah Lhokseumawe','Mon Geudong','Paket Obat Dasar & P3K','25 Paket','Tim Logistik Relawan A','Diterima','green']] as $p)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2.5 font-mono font-semibold text-blue-700">{{ $p[0] }}</td>
                        <td class="px-3 py-2.5 text-gray-500">{{ $p[1] }}</td>
                        <td class="px-3 py-2.5 text-gray-700">{{ $p[2] }}</td>
                        <td class="px-3 py-2.5 text-gray-700">{{ $p[3] }}</td>
                        <td class="px-3 py-2.5 text-gray-700">{{ $p[4] }}</td>
                        <td class="px-3 py-2.5 text-gray-700">{{ $p[5] }}</td>
                        <td class="px-3 py-2.5 text-gray-600">{{ $p[6] }}</td>
                        <td class="px-3 py-2.5"><span class="font-semibold px-2 py-0.5 rounded-full {{ ['orange'=>'bg-orange-100 text-orange-700','blue'=>'bg-blue-100 text-blue-700','green'=>'bg-green-100 text-green-700'][$p[8]] }}">{{ $p[7] }}</span></td>
                        <td class="px-3 py-2.5"><button class="text-blue-600 font-semibold hover:underline">Detail</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 text-xs text-gray-400 border-t border-gray-100 flex items-center justify-between">
            <span>Menampilkan 3 dari 3 data.</span>
            <div class="flex gap-1"><button class="w-6 h-6 border border-gray-200 rounded text-xs bg-blue-600 text-white">1</button></div>
        </div>
    </div>
</div>
@endsection

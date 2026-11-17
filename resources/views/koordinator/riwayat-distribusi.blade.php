@extends('layouts.koordinator')
@section('title', 'Riwayat Distribusi')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Riwayat Distribusi</h2>
        <p class="text-sm text-gray-500">Jejak perjalanan dan pengelolaan distribusi dan aktivitas logistik di lapangan.</p>
    </div>

    {{-- Tabs --}}
    <div class="flex gap-1 mb-5 bg-gray-100 rounded-xl p-1 w-fit">
        @foreach(['Penyaluran 3','Pengiriman Aktif 13','Aktivitas'] as $t)
        <button class="text-xs font-medium px-3 py-1.5 rounded-lg {{ $loop->first ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">{{ $t }}</button>
        @endforeach
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        @foreach(['Nomor','Tanggal','Lokasi Asal','Lokasi Tujuan','Jenis Bantuan','Jumlah','Penanggung Jawab','Status','Aksi'] as $h)
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $dist = [
                        ['PNY-001','24 Okt 2026','Gudang Logistik BPBD Kota','Aula Kantor Camat Banda Sakti','Air Mineral Kemasan 600ml','40 Dus','Tim Logistik Relawan A','Dalam Pengiriman','purple'],
                        ['PNY-002','24 Okt 2026','Gudang Logistik BPBD Kota','Hagu Selatan','Popok Bayi & Susu Formula','20 Paket','Tim Logistik Relawan B','Disalurkan','blue'],
                        ['PNY-003','23 Okt 2026','Gudang Palang Merah Lhokseumawe','Mon Geudong','Paket Obat Dasar & P3K','25 Paket','Tim Logistik Relawan A','Diterima','green'],
                    ]; @endphp
                    @foreach($dist as $d)
                    @php $sc=['purple'=>'bg-purple-100 text-purple-700','blue'=>'bg-blue-100 text-blue-700','green'=>'bg-teal-100 text-teal-700']; @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs font-mono font-bold text-gray-700">{{ $d[0] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $d[1] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $d[2] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $d[3] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $d[4] }}</td>
                        <td class="px-4 py-3 text-xs font-semibold text-gray-900">{{ $d[5] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-500">{{ $d[6] }}</td>
                        <td class="px-4 py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $sc[$d[8]] }}">{{ $d[7] }}</span></td>
                        <td class="px-4 py-3"><button class="text-xs text-teal-600 font-semibold hover:underline flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg>Detail</button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-2.5 text-xs text-gray-400 border-t border-gray-100 flex items-center justify-between">
            <span>Menampilkan 3 dari 3 data</span>
            <div class="flex gap-1">
                <button class="w-7 h-7 border border-teal-600 bg-teal-600 rounded text-xs text-white font-bold">1</button>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.koordinator')
@section('title', 'Konfirmasi Penerimaan')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Konfirmasi Penerimaan</h2>
        <p class="text-sm text-gray-500">Konfirmasi bahwa bantuan telah diterima di lokasi tujuan. Konfirmasi laporan menjadi sejarah setelah dikonfirmasi.</p>
    </div>

    {{-- Info --}}
    <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 mb-5 flex items-start gap-2 text-xs text-blue-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
        Konfirmasi lapangan belum masuk · Penerimaan "Konfirmasi lapangan" dijembatani sebagai perantara pembaruan. Status umumnya tidak dikonfirmasi berdasarkan lebih dari sekedar pengiriman tanpa diterima oleh penerima yang tepat prioritasnya.
    </div>

    {{-- Siap Dikonfirmasi --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-5">
        <div class="px-5 py-3 border-b border-gray-100">
            <p class="text-sm font-bold text-gray-900">Siap Dikonfirmasi</p>
            <p class="text-xs text-gray-400 mt-0.5">Bantuan yang sudah sampai di lokasi tujuan.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        @foreach(['Nomor','Tujuan','Barang','Status','Aksi'] as $h)
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs font-mono font-bold text-gray-700">PNY-001</td>
                        <td class="px-4 py-3 text-xs text-gray-700">Aula Kantor Camat Banda Sakti</td>
                        <td class="px-4 py-3 text-xs text-gray-600">40 Dus Air Mineral Kemasan 600ml</td>
                        <td class="px-4 py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-purple-100 text-purple-700">Dalam Pengiriman</span></td>
                        <td class="px-4 py-3">
                            <button onclick="alert('Demo: Penerimaan dikonfirmasi!')" class="text-xs font-bold text-white bg-teal-600 hover:bg-teal-700 px-3 py-1.5 rounded-lg transition-colors">Konfirmasi</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-4 py-2.5 text-xs text-gray-400 border-t border-gray-100">Menampilkan 1 dari 1 data</div>
    </div>

    {{-- Konfirmasi Terkini --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="px-5 py-3 border-b border-gray-100">
            <p class="text-sm font-bold text-gray-900">Konfirmasi Terkini</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        @foreach(['Nomor','Penerima','Diterima','Tanggal','Status'] as $h)
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs font-mono text-gray-500">PNY-003</td>
                        <td class="px-4 py-3 text-xs text-gray-700">Ketua RT Mon Geudong</td>
                        <td class="px-4 py-3 text-xs text-gray-600">25 dari 25</td>
                        <td class="px-4 py-3 text-xs text-gray-400">23 Okt 2026</td>
                        <td class="px-4 py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-teal-100 text-teal-700">Dikonfirmasi Petugas</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-4 py-2.5 text-xs text-gray-400 border-t border-gray-100">Menampilkan 1 dari 1 data</div>
    </div>
</div>
@endsection

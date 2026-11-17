@extends('layouts.koordinator')
@section('title', 'Bantuan Dihimpun')

@section('content')
<div class="p-5">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Bantuan Dihimpun</h2>
            <p class="text-sm text-gray-500">Catat bantuan hasil himpunan relawan. Data masuk ke inventaris bersama yang sudah dikelola petugas.</p>
        </div>
        <button onclick="document.getElementById('modal-catat-bantuan').classList.remove('hidden')"
                class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold px-4 py-2.5 rounded-xl shadow-sm">
            + Catat Bantuan Dihimpun
        </button>
    </div>

    {{-- Alert --}}
    <div class="bg-orange-50 border border-orange-200 rounded-xl px-4 py-3 mb-5 flex items-start gap-2 text-xs text-orange-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
        Tanpa catatan gudang · Sebelum kamu mencatat bantuan ini, perlu dicatat terlebih dahulu stok yang sudah ada di inventaris bersama yang sudah dimiliki petugas sebelumnya dan hanya bisa ditambahkan.
    </div>

    {{-- Tabs --}}
    <div class="flex gap-3 mb-4 border-b border-gray-200">
        <button class="pb-2 text-sm font-semibold text-teal-600 border-b-2 border-teal-600">Dihimpun Relawan 3</button>
        <button class="pb-2 text-sm font-medium text-gray-500 hover:text-gray-700">Seluruh Inventaris Bersama 10</button>
        <button class="pb-2 text-sm font-medium text-gray-500 hover:text-gray-700">Riwayat Stok</button>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        @foreach(['Kode','Nama Bantuan','Jenis','Jumlah','Tipedata','Sumber','Penyimpanan','Penanggung Jawab','Diperbarui Oleh'] as $h)
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $bantuan = [
                        ['BNT-007','Minyakan','Bahan Makanan','170 Dus','170','Donasi Masyarakat','Posko Logistik Relawan Banda Sakti','Teuku Faisal · Koordinator Relawan'],
                        ['BNT-006','Selimut Dewasa','Selimut','240 Lembar','240','Donasi Masyarakat','Posko Logistik Relawan Banda Sakti','Teuku Faisal · Koordinator Relawan'],
                        ['BNT-007','Pakaian Layak Pakai Dewasa & Anak','Pakaian','45 Dus','45','Relawan','Posko Logistik Relawan Banda Sakti','Teuku Faisal · Koordinator Relawan'],
                    ]; @endphp
                    @foreach($bantuan as $b)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs font-mono text-gray-500">{{ $b[0] }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $b[1] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $b[2] }}</td>
                        <td class="px-4 py-3 text-xs font-bold text-gray-900">{{ $b[3] }}</td>
                        <td class="px-4 py-3 text-xs text-teal-600 font-semibold">{{ $b[4] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $b[5] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $b[6] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $b[7] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-2.5 text-xs text-gray-400 border-t border-gray-100">Menampilkan 3 dari 3 data</div>
    </div>
</div>

{{-- Modal Catat Bantuan --}}
<div id="modal-catat-bantuan" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-6 max-h-screen overflow-y-auto">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-bold text-gray-900">Catat Bantuan Dihimpun</h3>
            <button onclick="document.getElementById('modal-catat-bantuan').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Langkah 1 · Cari bantuan yang sudah tercatat</label>
                <input type="text" placeholder="Cari nama bantuan, mis. mie, selimut, air, minyak..." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <div class="border-t border-gray-100 pt-4">
                <label class="block text-sm font-medium text-gray-700 mb-3">Langkah 2 · Buat catatan bantuan baru</label>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Nama Bantuan <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="mis. Selimut Dewasa" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Jenis Bantuan</label>
                            <select class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option>Bahan Makanan</option><option>Air Minum</option>
                                <option>Obat-obatan</option><option>Pakaian</option>
                                <option>Selimut</option><option>Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Jumlah <span class="text-red-500">*</span></label>
                            <input type="number" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Satuan</label>
                            <select class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option>Paket</option><option>Dus</option><option>Lembar</option><option>Unit</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Sumber Bantuan</label>
                            <input type="text" value="Pemerintah Daerah" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Lokasi Penyimpanan</label>
                            <input type="text" value="Gudang Logistik BPBD Kota" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Tanggal Penerimaan <span class="text-red-500">*</span></label>
                            <input type="date" value="{{ now()->format('Y-m-d') }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Penanggung Jawab <span class="text-red-500">*</span></label>
                        <input type="text" value="Teuku Faisal" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Keterangan</label>
                        <textarea rows="2" placeholder="Kondisi barang, masa kadaluarsa, dsb." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 resize-none"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button onclick="document.getElementById('modal-catat-bantuan').classList.add('hidden')" class="flex-1 border border-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-xl hover:bg-gray-50">Batal</button>
            <button onclick="alert('Demo: Bantuan dicatat!');document.getElementById('modal-catat-bantuan').classList.add('hidden')" class="flex-1 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold py-2.5 rounded-xl">+ Simpan Bantuan Baru</button>
        </div>
    </div>
</div>
@endsection

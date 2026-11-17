@extends('layouts.koordinator')
@section('title', 'Kebutuhan Logistik Lapangan')

@section('content')
<div class="p-5">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Kebutuhan Logistik Lapangan</h2>
            <p class="text-sm text-gray-500">Laporkan kebutuhan lapanganmu · Petugas akan memverifikasi sebelum kebutuhan dialokasikan.</p>
        </div>
        <button onclick="document.getElementById('modal-laporkan').classList.remove('hidden')"
                class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold px-4 py-2.5 rounded-xl shadow-sm">
            + Laporkan Kebutuhan
        </button>
    </div>

    {{-- Alert --}}
    <div class="bg-teal-50 border border-teal-200 rounded-xl px-4 py-3 mb-5 flex items-start gap-2 text-xs text-teal-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-teal-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
        Selaku koordinator logistik, kamu menerima data dari petugas sekaligus bertanggung jawab mengoordinasi dan menyalurkan bantuan kepada penerima.
    </div>

    {{-- Tabs --}}
    <div class="flex gap-1 mb-4 bg-gray-100 rounded-xl p-1 w-fit">
        @foreach(['Semua 10','Laporan Saya 0','Menunggu 1','Prioritas Tinggi 2','Terverifikasi 8'] as $t)
        <button class="text-xs font-medium px-3 py-1.5 rounded-lg {{ $loop->first ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">{{ $t }}</button>
        @endforeach
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-4 py-2.5 border-b border-gray-100">
            <input type="text" placeholder="Cari lokasi, barang, atau kode..." class="text-sm border border-gray-200 rounded-lg px-3 py-2 w-72 focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        @foreach(['Kode','Lokasi','Barang','Urgensi','Verifikasi','Pemenuhan','Pembaruan Terakhir','Aksi'] as $h)
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $rows = [
                        ['KBT-001','Aula Kantor Camat Banda Sakti','Paket Sembako · 15 Paket','Mendesak','Terverifikasi','Belum Terpenuhi','Cut Nurmala · Petugas BPBD','24 Okt 2026, 05:30'],
                        ['KBT-002','Aula Kantor Camat Banda Sakti','Air Mineral Kemasan · 40 Dus','Mendesak','Terverifikasi','Belum Terpenuhi','Cut Nurmala · Petugas BPBD','24 Okt 2026, 05:30'],
                        ['KBT-003','Hagu Selatan','Popok Bayi & Susu Formula · 30 Paket','Tinggi','Terverifikasi','Belum Terpenuhi','Cut Nurmala · Petugas BPBD','24 Okt 2026, 05:30'],
                        ['KBT-004','GOR Kota Lhokseumawe','Selimut Dewasa · 100 Lembar','Tinggi','Terverifikasi','Belum Terpenuhi','Cut Nurmala · Petugas BPBD','24 Okt 2026, 05:30'],
                        ['KBT-005','Mon Geudong','Paket Obat Dasar & P3K · 25 Paket','Tinggi','Terverifikasi','Terpenuhi','Cut Nurmala · Petugas BPBD','—'],
                        ['KBT-006','Lancang Garam','Paket Kebersihan · 60 Paket','Sedang','Terverifikasi','Belum Terpenuhi','Cut Nurmala · Petugas BPBD','24 Okt 2026, 05:30'],
                        ['KBT-007','Gedung Serbaguna Muara Satu','Pakaian Layak Pakai · 20 Dus','Sedang','Terverifikasi','Belum Terpenuhi','Cut Nurmala · Petugas BPBD','24 Okt 2026, 05:30'],
                        ['KBT-008','SDN I Banda Sakti','Air Bersih Galon 19L · 10 Dus','Rendah','Terverifikasi','Belum Terpenuhi','Cut Nurmala · Petugas BPBD','24 Okt 2026, 05:30'],
                    ]; @endphp
                    @foreach($rows as $r)
                    @php
                        $urgBg=['Mendesak'=>'bg-red-100 text-red-700','Tinggi'=>'bg-orange-100 text-orange-700','Sedang'=>'bg-yellow-100 text-yellow-700','Rendah'=>'bg-gray-100 text-gray-500'];
                        $pemBg=['Terpenuhi'=>'bg-teal-100 text-teal-700','Belum Terpenuhi'=>'bg-gray-100 text-gray-500'];
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-xs font-mono text-gray-500">{{ $r[0] }}</td>
                        <td class="px-4 py-3 text-xs font-semibold text-gray-900">{{ $r[1] }}</td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $r[2] }}</td>
                        <td class="px-4 py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $urgBg[$r[3]] ?? 'bg-gray-100 text-gray-500' }}">{{ $r[3] }}</span></td>
                        <td class="px-4 py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-teal-100 text-teal-700">{{ $r[4] }}</span></td>
                        <td class="px-4 py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $pemBg[$r[5]] ?? 'bg-gray-100 text-gray-500' }}">{{ $r[5] }}</span></td>
                        <td class="px-4 py-3 text-xs text-gray-400">{{ $r[7] }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2">
                                <button class="text-xs text-teal-600 font-semibold hover:underline">Detail</button>
                                <button class="text-xs text-gray-600 font-semibold hover:underline">Perbarui</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-2.5 text-xs text-gray-400 border-t border-gray-100 flex items-center justify-between">
            <span>Menampilkan 1–8 dari 8 data</span>
            <div class="flex gap-1">
                <button class="w-7 h-7 border border-gray-200 rounded text-xs text-gray-500 hover:bg-gray-100">‹</button>
                <button class="w-7 h-7 border border-teal-600 bg-teal-600 rounded text-xs text-white font-bold">1</button>
                <button class="w-7 h-7 border border-gray-200 rounded text-xs text-gray-500 hover:bg-gray-100">2</button>
                <button class="w-7 h-7 border border-gray-200 rounded text-xs text-gray-500 hover:bg-gray-100">›</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Laporkan Kebutuhan --}}
<div id="modal-laporkan" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-6 max-h-screen overflow-y-auto">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-bold text-gray-900">Laporkan Kebutuhan Lapangan</h3>
            <button onclick="document.getElementById('modal-laporkan').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Lokasi Kejadian</label>
                <input type="text" value="GOR Kota Lhokseumawe" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Referensi Kejadian Banjir</label>
                <input type="text" placeholder="Tanpa referensi kejadian" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Jenis Kebutuhan</label>
                    <select class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option>Bahan Makanan</option><option>Air Minum</option>
                        <option>Obat-obatan</option><option>Pakaian</option><option>Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Nama Barang <span class="text-red-500">*</span></label>
                    <input type="text" placeholder="mis. Selimut Dewasa" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Jumlah Dibutuhkan <span class="text-red-500">*</span></label>
                    <input type="number" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Satuan</label>
                    <select class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option>Paket</option><option>Dus</option><option>Lembar</option><option>Unit</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Tingkat Urgensi</label>
                    <select class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option>Sedang</option><option>Rendah</option><option>Tinggi</option><option>Mendesak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Jumlah Jiwa Terdampak</label>
                    <input type="number" placeholder="Masukkan angka approximate" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Kondisi Lapangan</label>
                <textarea rows="2" placeholder="Kondisi sumber, akses, kelompok rentan, dsb." class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500 resize-none"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal Laporan</label>
                    <input type="date" value="{{ now()->format('Y-m-d') }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Nama Pelapor <span class="text-red-500">*</span></label>
                    <input type="text" value="Teuku Faisal" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button onclick="document.getElementById('modal-laporkan').classList.add('hidden')" class="flex-1 border border-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-xl hover:bg-gray-50">Batal</button>
            <button onclick="alert('Demo: Kebutuhan dilaporkan!');document.getElementById('modal-laporkan').classList.add('hidden')" class="flex-1 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold py-2.5 rounded-xl">Kirim Laporan Kebutuhan</button>
        </div>
    </div>
</div>
@endsection

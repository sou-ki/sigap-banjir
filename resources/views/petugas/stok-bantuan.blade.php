@extends('layouts.petugas')
@section('title', 'Stok Bantuan')

@section('content')
<div class="p-5">
    <div class="flex items-start justify-between mb-5 flex-wrap gap-3">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Stok Bantuan Logistik</h2>
            <p class="text-sm text-gray-500">Inventaris bersama petugas dan koordinator relawan. Setiap perubahan tercatat pada riwayat per-item stok.</p>
        </div>
        <button onclick="document.getElementById('tambah-stok-modal').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-lg">+ Tambah Bantuan</button>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-5">
        @foreach([['Stok Tercatat','1.773','item dari 10 jenis','blue'],['Stok Dialokasikan','60','dialokasikan - belum dikirim','orange'],['Stok Tersedia','1.688','dapat disalurkan','green'],['Stok Tersalurkan','25','sudah diterima penerima','teal']] as $s)
        @php $c=['blue'=>['bg-blue-50','text-blue-600'],'orange'=>['bg-orange-50','text-orange-500'],'green'=>['bg-green-50','text-green-600'],'teal'=>['bg-teal-50','text-teal-600']]; @endphp
        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <p class="text-xs text-gray-500 mb-1">{{ $s[0] }}</p>
            <p class="text-2xl font-extrabold text-gray-900">{{ $s[1] }}</p>
            <p class="text-xs text-gray-400 mt-0.5">{{ $s[2] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex items-center gap-3 px-4 py-3 border-b border-gray-100 flex-wrap">
            <div class="relative flex-1 min-w-48">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Cari kode atau nama barang..." class="text-xs border border-gray-200 rounded-lg pl-8 pr-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>
            <select class="text-xs border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500"><option>Semua kategori</option><option>Bahan Makanan</option><option>Air Minum</option><option>Obat-obatan</option><option>Pakaian</option></select>
            <select class="text-xs border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500"><option>Semua lokasi</option></select>
            <select class="text-xs border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500"><option>Semua status</option><option>Tersedia</option><option>Dialokasikan</option><option>Habis</option></select>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>@foreach(['Kode Bantuan','Nama Barang','Kategori','Jumlah Stok','Satuan','Sumber Bantuan','Lokasi Penyimpanan','Stok Tersedia','Status','Aksi'] as $h)
                    <th class="text-left px-3 py-2.5 font-bold text-gray-500 uppercase tracking-wide whitespace-nowrap" style="font-size:10px">{{ $h }}</th>@endforeach</tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $stocks = [
                        ['BNT-001','🍚','Paket Sembako (beras, minyak, gula)','Bahan Makanan','600','Paket','Pemerintah Daerah','Gudang Logistik BPBD Kota','600','Tersedia'],
                        ['BNT-002','🍜','Mi Instan','Bahan Makanan','170','Dus','Donasi Masyarakat (BAZNAS)','Posko Logistik Relawan Banda Sakti','170','Tersedia'],
                        ['BNT-003','💧','Air Mineral Kemasan 400 ml','Air Minum','310','Dus','Donia Jualkan (CSR)','Gudang Logistik BPBD Kota','310','Tersedia'],
                        ['BNT-004','💧','Air Bersih Galon 19L','Air Minum','90','Unit','BPBD (diorder petugas)','Gudang Palang Merah Lhokseumawe','90','Tersedia'],
                        ['BNT-005','💊','Paket Obat Dasar & P3K','Obat-obatan','80','Paket','BPBD (diorder petugas)','Gudang Palang Merah Lhokseumawe','55','Tersedia'],
                        ['BNT-006','🏕️','Selimut Dewasa','Selimut','260','Lembar','Lembaga Sosial','Posko Logistik Relawan Banda Sakti','260','Tersedia'],
                        ['BNT-007','👗','Pakaian Layak Pakai Dewasa & Anak','Pakaian','45','Dus','Donasi Masyarakat','Posko Logistik Relawan Banda Sakti','45','Tersedia'],
                        ['BNT-008','👶','Popok Bayi & Susu Formula','Perlengkapan Bayi','70','Paket','Donasi Masyarakat','Gudang Logistik BPBD Kota','50','Tersedia'],
                    ]; @endphp
                    @foreach($stocks as $s)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2.5 font-mono font-semibold text-gray-700">{{ $s[0] }}</td>
                        <td class="px-3 py-2.5 font-medium text-gray-900">{{ $s[1] }} {{ $s[2] }}</td>
                        <td class="px-3 py-2.5 text-gray-600">{{ $s[3] }}</td>
                        <td class="px-3 py-2.5 font-semibold text-gray-900">{{ $s[4] }}</td>
                        <td class="px-3 py-2.5 text-gray-600">{{ $s[5] }}</td>
                        <td class="px-3 py-2.5 text-gray-500 max-w-32 truncate">{{ $s[6] }}</td>
                        <td class="px-3 py-2.5 text-gray-600 max-w-40 truncate">{{ $s[7] }}</td>
                        <td class="px-3 py-2.5 font-bold text-green-700">{{ $s[8] }}</td>
                        <td class="px-3 py-2.5"><span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-green-100 text-green-700">✓ {{ $s[9] }}</span></td>
                        <td class="px-3 py-2.5">
                            <div class="flex gap-2">
                                <button class="text-blue-600 font-semibold hover:underline">Detail</button>
                                <button class="text-gray-500 font-medium hover:text-gray-800">Stok Masuk</button>
                                <button class="text-gray-400 font-medium hover:text-gray-600">Riwayat</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 text-xs text-gray-400 border-t border-gray-100 flex items-center justify-between">
            <span>Menampilkan 8 dari 10 data.</span>
            <div class="flex gap-1">
                <button class="w-6 h-6 border border-gray-200 rounded text-gray-500 text-xs bg-blue-600 text-white">1</button>
                <button class="w-6 h-6 border border-gray-200 rounded text-gray-500 text-xs">2</button>
            </div>
        </div>
    </div>
</div>

{{-- Tambah Modal --}}
<div id="tambah-stok-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-6 max-h-screen overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-gray-900">Tambah Bantuan Logistik</h3>
            <button onclick="document.getElementById('tambah-stok-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 mb-4 text-xs text-blue-700">
            <p class="font-semibold mb-1">Langkah 1 - Cari bantuan yang sudah tercatat</p>
            <p>Hindari duplikasi. Cari bantuan dan relevan dan naikkan stok pada inventaris bersama.</p>
            <input type="text" placeholder="Ketik nama atau kategori: beras, mi, salsarín, air minum..." class="w-full mt-2 border border-blue-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>
        <p class="text-sm font-semibold text-gray-700 mb-3">Langkah 2 - Buat catatan bantuan baru</p>
        <div class="space-y-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Barang <span class="text-red-500">*</span></label><input type="text" placeholder="Mis. Selimut Dewasa" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori Bantuan</label><select class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"><option>Bahan Makanan</option><option>Air Minum</option><option>Obat-obatan</option><option>Pakaian</option><option>Selimut</option></select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah <span class="text-red-500">*</span></label><input type="number" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Sumber Bantuan</label><input type="text" value="Pemerintah Daerah" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi Penyimpanan</label><input type="text" value="Gudang Logistik BPBD Kota" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Penerimaan <span class="text-red-500">*</span></label><input type="date" value="2026-10-24" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Keterangan</label><textarea rows="2" placeholder="Kondisi barang, masa kedaluwarsa, dll." class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea></div>
        </div>
        <div class="flex gap-3 mt-5">
            <button onclick="document.getElementById('tambah-stok-modal').classList.add('hidden')" class="flex-1 border border-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-xl hover:bg-gray-50">Batal</button>
            <button onclick="alert('Demo: Stok bantuan berhasil ditambahkan!');document.getElementById('tambah-stok-modal').classList.add('hidden')" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2.5 rounded-xl">+ Simpan Bantuan Baru</button>
        </div>
    </div>
</div>
@endsection

@extends('layouts.petugas')
@section('title', 'Kebutuhan Logistik')

@section('content')
<div class="p-5">
    <div class="flex items-start justify-between mb-5 flex-wrap gap-3">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Kebutuhan Logistik</h2>
            <p class="text-sm text-gray-500">Kebutuhan masyarakat terdampak dan pengungsian, termasuk laporan koordinator relawan.</p>
        </div>
        <button onclick="document.getElementById('modal-kebutuhan').classList.remove('hidden')" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold px-4 py-2 rounded-lg">+ Daftarkan Kebutuhan</button>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="flex gap-1 px-4 py-3 border-b border-gray-100 overflow-x-auto">
            @foreach(['Semua 10','Menunggu Verifikasi 3','Perlu Klarifikasi 1'] as $t)
            <button class="text-xs {{ $loop->first?'font-semibold bg-gray-900 text-white':'font-medium bg-gray-100 text-gray-600 hover:bg-gray-200' }} px-3 py-1.5 rounded-lg whitespace-nowrap">{{ $t }}</button>
            @endforeach
        </div>
        <div class="flex items-center gap-3 px-4 py-3 border-b border-gray-100 flex-wrap">
            <div class="relative flex-1 min-w-36">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Cari kode, lokasi, atau barang..." class="text-xs border border-gray-200 rounded-lg pl-8 pr-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>
            @foreach(['Semua lokasi','Semua kategori','Semua prioritas','Semua status'] as $f)
            <select class="text-xs border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500"><option>{{ $f }}</option></select>
            @endforeach
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>@foreach(['Kode','Lokasi','Referensi Banjir','Jenis Bantuan','Dibutuhkan','Terpenuhi','Sisa','Prioritas','Status','Aksi'] as $h)
                    <th class="text-left px-3 py-2.5 font-bold text-gray-500 uppercase tracking-wide whitespace-nowrap" style="font-size:10px">{{ $h }}</th>@endforeach</tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $kebutuhan = [
                        ['KBT-001','Aula Kantor Camat Banda Sakti','LPR-2610-0003','Paket Sembako','150 Paket','0','150','Mendesak','red','Belum Terpenuhi'],
                        ['KBT-002','Aula Kantor Camat Banda Sakti','LPR-2610-0003','Air Mineral Kemasan','60 Dus','0','60','Mendesak','red','Belum Terpenuhi'],
                        ['KBT-003','Hagu Selatan','LPR-2610-0002','Popok Bayi & Susu Formula','30 Paket','0','30','Tinggi','orange','Belum Terpenuhi'],
                        ['KBT-004','GOR Kota Lhokseumawe','–','Selimut Dewasa','120 Lembar','0','120','Tinggi','orange','Belum Terpenuhi'],
                        ['KBT-005','Mon Geudong','LPR-2610-0001','Paket Obat Dasar & P3K','25 Paket','25','0','Tinggi','orange','Terpenuhi'],
                        ['KBT-006','Lancang Garam','LPR-2610-0004','Paket Kebersihan','80 Paket','0','80','Sedang','yellow','Belum Terpenuhi'],
                        ['KBT-007','Gedung Serbaguna Muara Satu','–','Pakaian Layak Pakai','20 Dus','0','20','Sedang','yellow','Belum Terpenuhi'],
                        ['KBT-008','SDN 1 Banda Sakti','–','Air Bersih Galon 19L','30 Unit','0','30','Rendah','gray','Belum Terpenuhi'],
                    ];
                    $pc=['red'=>'bg-red-100 text-red-700','orange'=>'bg-orange-100 text-orange-700','yellow'=>'bg-yellow-100 text-yellow-700','gray'=>'bg-gray-100 text-gray-600'];
                    @endphp
                    @foreach($kebutuhan as $k)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2.5 font-mono font-semibold text-blue-700">{{ $k[0] }}</td>
                        <td class="px-3 py-2.5 text-gray-900 font-medium">{{ $k[1] }}</td>
                        <td class="px-3 py-2.5 text-gray-500 font-mono">{{ $k[2] }}</td>
                        <td class="px-3 py-2.5 text-gray-700">{{ $k[3] }}</td>
                        <td class="px-3 py-2.5 font-semibold text-gray-900">{{ $k[4] }}</td>
                        <td class="px-3 py-2.5 text-gray-700">{{ $k[5] }}</td>
                        <td class="px-3 py-2.5 {{ intval($k[6])>0?'font-bold text-orange-600':'text-gray-400' }}">{{ $k[6] }}</td>
                        <td class="px-3 py-2.5"><span class="font-semibold px-2 py-0.5 rounded-full {{ $pc[$k[8]] }}">{{ ['red'=>'Mendesak','orange'=>'Tinggi','yellow'=>'Sedang','gray'=>'Rendah'][$k[8]] }}</span></td>
                        <td class="px-3 py-2.5"><span class="font-medium px-2 py-0.5 rounded-full {{ $k[9]==='Terpenuhi'?'bg-green-100 text-green-700':'bg-orange-100 text-orange-700' }}">{{ $k[9]==='Terpenuhi'?'✓ Terpenuhi':'Belum Terpenuhi' }}</span></td>
                        <td class="px-3 py-2.5">
                            <div class="flex gap-2">
                                <button class="text-blue-600 font-semibold hover:underline">Detail</button>
                                <button class="text-gray-500 hover:text-gray-800">Ubah</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 text-xs text-gray-400 border-t border-gray-100 flex items-center justify-between">
            <span>Menampilkan 8 dari 10 data.</span>
            <div class="flex gap-1"><button class="w-6 h-6 border border-gray-200 rounded text-xs bg-blue-600 text-white">1</button><button class="w-6 h-6 border border-gray-200 rounded text-xs text-gray-600">2</button></div>
        </div>
    </div>
</div>

{{-- Modal --}}
<div id="modal-kebutuhan" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 p-6 max-h-screen overflow-y-auto">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-gray-900">Daftarkan Kebutuhan Logistik</h3>
            <button onclick="document.getElementById('modal-kebutuhan').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="space-y-4">
            <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Lokasi Terdampak / Pengungsian</label><input type="text" value="GOR Kota Lhokseumawe" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Referensi Kejadian Banjir</label><input type="text" placeholder="Tanpa referensi kejadian" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            <div class="grid grid-cols-3 gap-3">
                <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1.5">Kategori Bantuan</label><select class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"><option>Bahan Makanan</option><option>Air Minum</option><option>Obat-obatan</option></select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Barang <span class="text-red-500">*</span></label><input type="text" placeholder="Mis. Selimut Dewasa" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Dibutuhkan <span class="text-red-500">*</span></label><input type="number" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Satuan</label><input type="text" value="Paket" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Tingkat Urgensi</label><select class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500"><option>Sedang</option><option>Tinggi</option><option>Mendesak</option></select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Jiwa Terdampak</label><input type="number" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
            <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi Kebutuhan</label><textarea rows="2" placeholder="Uraian lengkap kebutuhan..." class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea></div>
            <div class="grid grid-cols-2 gap-3">
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Pencatatan</label><input type="date" value="2026-10-24" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Sumber Informasi</label><input type="text" value="Survei Petugas" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
        </div>
        <div class="flex gap-3 mt-5">
            <button onclick="document.getElementById('modal-kebutuhan').classList.add('hidden')" class="flex-1 border border-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-xl">Batal</button>
            <button onclick="alert('Demo: Kebutuhan berhasil didaftarkan!');document.getElementById('modal-kebutuhan').classList.add('hidden')" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2.5 rounded-xl">Simpan Kebutuhan</button>
        </div>
    </div>
</div>
@endsection

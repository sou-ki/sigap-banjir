@extends('layouts.petugas')
@section('title', 'Penyaluran Bantuan')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Penyaluran Bantuan</h2>
        <p class="text-sm text-gray-500">Pantau status pengiriman. Penerimaan yang dikonfirmasi otomatis memperbarui pemantauan stok.</p>
    </div>

    <div class="flex gap-4">
        {{-- Table --}}
        <div class="flex-1 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-4 py-3 border-b border-gray-100">
                <div class="relative flex-1 min-w-36">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400 absolute left-2.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="Cari nomor, tujuan, atau penanggung jawab..." class="text-xs border border-gray-200 rounded-lg pl-8 pr-3 py-2 w-full focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <select class="text-xs border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-1 focus:ring-blue-500"><option>Semua status</option><option>Dalam Pengiriman</option><option>Dikiapkan</option><option>Diterima</option></select>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead class="bg-gray-50 border-b border-gray-100"><tr>@foreach(['Nomor','Tanggal','Lokasi Asal','Lokasi Tujuan','Jenis Bantuan','Jumlah','Penanggung Jawab','Status','Aksi'] as $h)<th class="text-left px-3 py-2.5 font-bold text-gray-500 uppercase tracking-wide whitespace-nowrap" style="font-size:10px">{{ $h }}</th>@endforeach</tr></thead>
                    <tbody class="divide-y divide-gray-50">
                        @php $pnyaluran = [
                            ['PNY-001','24 Okt 2026','Gudang Logistik BPBD Kota','Aula Kantor Camat Banda Sakti','Air Mineral Kemasan 600 ml','40 Dus','Tim Logistik Relawan A','Dalam Pengiriman','orange'],
                            ['PNY-002','24 Okt 2026','Gudang Logistik BPBD Kota','Hagu Selatan','Popok Bayi & Susu Formula','20 Paket','Tim Logistik Relawan B','Dikiapkan','blue'],
                            ['PNY-003','23 Okt 2026','Gudang Palang Merah Lhokseumawe','Mon Geudong','Paket Obat Dasar & P3K','25 Paket','Tim Logistik Relawan A','Diterima','green'],
                        ]; @endphp
                        @foreach($pnyaluran as $p)
                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="openPenyaluranDetail('{{ $p[0] }}')">
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

        {{-- Detail panel --}}
        <div id="penyaluran-detail" class="hidden w-72 flex-shrink-0 bg-white rounded-xl border border-gray-100 shadow-sm overflow-y-auto" style="max-height:500px">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 sticky top-0 bg-white">
                <p class="text-sm font-bold text-gray-900" id="pny-title">Penyaluran PNY-001</p>
                <button onclick="document.getElementById('penyaluran-detail').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <div class="p-4 space-y-4 text-xs">
                <span class="font-semibold px-2 py-0.5 rounded-full bg-orange-100 text-orange-700">Dalam Pengiriman</span>
                {{-- Stepper mini --}}
                <div class="flex items-center gap-1">
                    @foreach(['Alokasi Diterima','Disiapkan','Dalam Pengiriman','Tanda Terima','Penerimaan Dikonfirmasi'] as $i => $s)
                    <div class="flex items-center gap-1 flex-shrink-0">
                        <div class="w-5 h-5 rounded-full flex items-center justify-center text-xs {{ $i<=2?'bg-blue-600 text-white':'bg-gray-200 text-gray-400' }}">{{ $i+1 }}</div>
                        @if(!$loop->last)<div class="w-3 h-px {{ $i<2?'bg-blue-400':'bg-gray-200' }}"></div>@endif
                    </div>
                    @endforeach
                </div>
                <div class="grid grid-cols-2 gap-x-3 gap-y-2">
                    <div><p class="text-gray-400">Barang</p><p class="font-medium text-gray-800">Air Mineral Kemasan 600 ml (BNT-003)</p></div>
                    <div><p class="text-gray-400">Jumlah</p><p class="font-medium text-gray-800">40 Dus</p></div>
                    <div><p class="text-gray-400">Referensi Alokasi</p><p class="font-medium text-gray-700">ALK-001 · disetujui Cut Nurmala</p></div>
                    <div><p class="text-gray-400">Lokasi Asal</p><p class="font-medium text-gray-800">Gudang Logistik BPBD Kota</p></div>
                    <div><p class="text-gray-400">Lokasi Tujuan</p><p class="font-medium text-gray-800">Aula Kantor Camat Banda Sakti</p></div>
                    <div><p class="text-gray-400">Tanggal</p><p class="font-medium text-gray-800">24 Okt 2026</p></div>
                    <div class="col-span-2"><p class="text-gray-400">Catatan</p><p class="font-medium text-gray-700">Menggunakan truk bak terbuka.</p></div>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-700 mb-2">Konfirmasi Penerimaan</p>
                    <p class="text-xs text-gray-500 mb-2">Setelah konfirmasi, stok tersalurkan.</p>
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-400"></span><p class="text-xs text-gray-600">Bantuan dalam pengiriman</p></div>
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-blue-400"></span><p class="text-xs text-gray-600">Bantuan disiapkan di gudang</p></div>
                        <div class="flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-gray-300"></span><p class="text-xs text-gray-400">Alokasi diterima dan penyaluran direncanakan</p></div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button onclick="alert('Demo: Tandai sampai di lokasi!')" class="flex-1 bg-blue-600 text-white text-xs font-bold py-2.5 rounded-lg">✓ Tandai Sampai di Lokasi</button>
                    <button onclick="document.getElementById('konfirmasi-modal').classList.remove('hidden')" class="flex-1 bg-green-600 text-white text-xs font-bold py-2.5 rounded-lg">✓ Konfirmasi Penerimaan</button>
                </div>
                <button onclick="alert('Demo: Dibatalkan!')" class="w-full border border-red-200 text-red-600 text-xs font-semibold py-2 rounded-lg hover:bg-red-50">Batalkan</button>
            </div>
        </div>
    </div>
</div>

{{-- Konfirmasi penerimaan modal --}}
<div id="konfirmasi-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-gray-900">Konfirmasi Penerimaan Bantuan</h3>
            <button onclick="document.getElementById('konfirmasi-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        <div class="bg-blue-50 rounded-xl p-3 mb-4">
            <p class="text-sm font-semibold text-blue-800">Air Mineral Kemasan 600 ml – 40 Dus</p>
            <p class="text-xs text-blue-600">Tujuan: Aula Kantor Camat Banda Sakti</p>
        </div>
        <div class="space-y-4">
            <div class="grid grid-cols-2 gap-3">
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Penyaluran</label><input type="text" value="PNY-001" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal Penerimaan</label><input type="date" value="2026-10-24" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Penerima <span class="text-red-500">*</span></label><input type="text" placeholder="Pos. Ketua RT / pengelola posko..." class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Jumlah Diterima <span class="text-red-500">*</span></label><input type="number" value="40" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Kondisi Bantuan</label><input type="text" value="Baik" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1.5">Catatan</label><input type="text" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Bukti Foto (opsional maks. 3, hanya dimu aki secara lokal)</label>
                <button class="border-2 border-dashed border-gray-200 rounded-xl p-4 w-full text-center hover:border-blue-300 text-gray-400 text-xs">📷 Tambah foto</button>
            </div>
            <div class="bg-blue-50 rounded-xl p-3 text-xs text-blue-700">Setelah penerima, konfirmasi ini langsung tercatat sebagai penerimaan resmi. Stok tersalurkan dan terlacak dari inventaris (email ke admin jika ada).</div>
        </div>
        <div class="flex gap-3 mt-5">
            <button onclick="document.getElementById('konfirmasi-modal').classList.add('hidden')" class="flex-1 border border-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-xl">Batal</button>
            <button onclick="alert('Demo: Penerimaan dikonfirmasi!');document.getElementById('konfirmasi-modal').classList.add('hidden');document.getElementById('penyaluran-detail').classList.add('hidden');" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold py-2.5 rounded-xl">✓ Konfirmasi Penerimaan Bantuan</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openPenyaluranDetail(no) {
    document.getElementById('pny-title').textContent = 'Penyaluran ' + no;
    document.getElementById('penyaluran-detail').classList.remove('hidden');
}
</script>
@endpush

@extends('layouts.petugas')
@section('title', 'Alokasi Bantuan')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Alokasi Bantuan</h2>
        <p class="text-sm text-gray-500">Tetapkan kebutuhan terhadap stok tersedia. Alokasi mencadangkan stok tanpa memprosesnya dua kali.</p>
    </div>

    {{-- Stepper --}}
    <div class="flex items-center gap-0 mb-6 overflow-x-auto">
        @foreach(['Pilih Kebutuhan','Lihat Stok','Pilih Bantuan','Isi Kuantiti','Tinjau','Konfirmasi','Catat Penyaluran'] as $i => $s)
        <div class="flex items-center flex-shrink-0">
            <div class="flex items-center gap-1.5">
                <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold {{ $i===0?'bg-blue-600 text-white':'bg-gray-200 text-gray-500' }}">{{ $i+1 }}</div>
                <span class="text-xs {{ $i===0?'font-semibold text-blue-700':'text-gray-400' }} whitespace-nowrap">{{ $s }}</span>
            </div>
            @if(!$loop->last)<div class="w-8 h-px bg-gray-200 mx-1"></div>@endif
        </div>
        @endforeach
    </div>

    {{-- Pengajuan koordinator --}}
    <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start justify-between mb-5">
        <div class="flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            <div>
                <p class="text-sm font-semibold text-blue-800">Pengajuan Alokasi Koordinator (1)</p>
                <p class="text-xs text-blue-600">Menunggu persetujuan petugas. Stok baru diubah-dikurangi setelah disetujui.</p>
            </div>
        </div>
        <div class="flex-shrink-0 ml-4 bg-white border border-blue-200 rounded-xl p-3 text-xs flex items-center justify-between gap-4">
            <span class="text-blue-700">🏕️ 60 Lembar Selimut Dewasa → GOR Kota Lhokseumawe<br><span class="text-gray-400">ALK-0014 · diajukan Tsiku Ridae · 24 Okt 2026, 07:30 · Tim Logistik Relawan B</span></span>
            <div class="flex gap-2">
                <button onclick="alert('Demo: Disetujui!')" class="bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg">Setujui</button>
                <button onclick="alert('Demo: Ditolak!')" class="border border-red-200 text-red-600 text-xs font-semibold px-3 py-1.5 rounded-lg">Tolak</button>
            </div>
        </div>
    </div>

    <div class="flex gap-4">
        {{-- Kebutuhan list --}}
        <div class="w-80 flex-shrink-0 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100"><p class="text-sm font-bold text-gray-900">Kebutuhan</p><p class="text-xs text-gray-400">Tanm pilih dari satu kebutuhan</p></div>
            <div class="overflow-y-auto" style="max-height:400px">
                @foreach([['Aula Kantor Camat Banda Sakti','LPR-2610-0003 · KBT-001','Paket Sembako – sisa 150 Paket','Mendesak','red'],['Aula Kantor Camat Banda Sakti','LPR-2610-0003 · KBT-002','Air Mineral Kemasan – sisa 20 Dus','Mendesak','red'],['Hagu Selatan','LPR-2610-0002 · KBT-003','Popok Bayi & Susu Formula – sisa 10 Paket','Tinggi','orange'],['GOR Kota Lhokseumawe','Tanpa referensi kejadian · KBT-004','Selimut Dewasa – sisa 120 Lembar','Tinggi','orange'],['Lancang Garam','LPR-2610-0004 · KBT-006','Paket Kebersihan – sisa 80 Paket','Sedang','yellow'],['Gedung Serbaguna Muara Satu','KBT-007','Pakaian Layak Pakai – sisa 20 Dus','Sedang','yellow']] as $k)
                <div class="px-4 py-3 border-b border-gray-50 hover:bg-blue-50 cursor-pointer flex items-start gap-2">
                    <span class="w-2 h-2 rounded-full mt-1.5 flex-shrink-0 {{ ['red'=>'bg-red-500','orange'=>'bg-orange-400','yellow'=>'bg-yellow-400'][$k[4]] }}"></span>
                    <div><p class="text-xs font-semibold text-gray-900">{{ $k[0] }}</p><p class="text-xs text-gray-400">{{ $k[1] }}</p><p class="text-xs text-gray-600 mt-0.5">{{ $k[2] }}</p></div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Center: Bantuan tersedia --}}
        <div class="flex-1 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100"><p class="text-sm font-bold text-gray-900">Bantuan Tersedia</p><p class="text-xs text-gray-400">Pilih kebutuhan terlebih dahulu.</p></div>
            <div class="flex flex-col items-center justify-center py-16">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <p class="text-sm font-semibold text-gray-600">Belum ada kebutuhan dipilih</p>
                <p class="text-xs text-gray-400 mt-1">Pilih kebutuhan dari panel kiri</p>
            </div>
        </div>

        {{-- Right: Ringkasan --}}
        <div class="w-64 flex-shrink-0 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100"><p class="text-sm font-bold text-gray-900">Ringkasan Alokasi</p></div>
            <div class="p-4">
                <p class="text-xs text-gray-400 mb-4">Ringkasan akan muncul, setelah kebutuhan dipilih.</p>
                <div class="border-t border-gray-100 pt-3">
                    <p class="text-xs font-bold text-gray-700 mb-2">Riwayat Alokasi</p>
                    <table class="w-full text-xs">
                        <thead><tr>@foreach(['Kode','Tujuan','Barang','Diajukan','Tim','Status'] as $h)<th class="text-left text-gray-400 pb-1" style="font-size:10px">{{ $h }}</th>@endforeach</tr></thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach([['ALK-001','Aula Kantor Camat Banda Sakti','40 Dus Air Mineral Kemasan 600 ml','Cut Nurmala · Petugas BPBD','Tim Logistik Relawan A','Diterima'],['ALK-002','Hagu Selatan','20 Paket Popok Bayi & Susu Formula','Cut Nurmala · Petugas BPBD','Tim Logistik Relawan B','Diterima'],['ALK-003','Mon Geudong','25 Paket Paket Obat Dasar & P3K','Cut Nurmala · Petugas BPBD','Tim Logistik Relawan A','Diterima'],['ALK-004','GOR Kota Lhokseumawe','40 1 Lembar Selimut Dewasa','Tsiku Telse · Koordinator Relawan','Tim Logistik Relawan B','Menunggu Persetujuan']] as $a)
                            <tr class="hover:bg-gray-50"><td class="py-1.5 font-mono text-blue-700">{{ $a[0] }}</td><td class="py-1.5 text-gray-700 max-w-12 truncate">{{ $a[1] }}</td><td class="py-1.5 text-gray-600 max-w-16 truncate">{{ $a[2] }}</td><td class="py-1.5 text-gray-400 max-w-12 truncate">{{ $a[3] }}</td><td class="py-1.5 text-gray-400 max-w-12 truncate">{{ $a[4] }}</td><td class="py-1.5"><span class="font-medium px-1 py-0.5 rounded {{ $a[5]==='Diterima'?'text-green-700':'text-orange-700' }}">{{ $a[5]==='Diterima'?'✓':'' }} {{ $a[5] }}</span></td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

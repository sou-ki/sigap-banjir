@extends('layouts.petugas')
@section('title', 'Prioritas Kebutuhan')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Prioritas Kebutuhan</h2>
        <p class="text-sm text-gray-500">Tetapkan prioritas berdasarkan jumlah jiwa, jenis bantuan, stase kebutuhan, kondisi lokal, dan saran dari lapangan.</p>
    </div>

    <div class="space-y-2 mb-6">
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 flex items-center gap-2 text-xs text-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
            Skor prioritas dihitung otomatis. Label AI berarti sistem memberikan rekomendasi otomatis — Prioritas akhir tetap ditentukan oleh petugas penanggung jawab.
        </div>
        <div class="bg-yellow-50 border border-yellow-100 rounded-xl p-3 flex items-center gap-2 text-xs text-yellow-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
            2 kebutuhan belum diverifikasi sehingga belum masuk daftar prioritas.
        </div>
    </div>

    @php $groups = [
        ['Mendesak', 'red', [
            ['Aula Kantor Camat Banda Sakti','Paket Sembako','KBT-001','150 Paket belum terpenuhi dari 150','0% terpenuhi','24 Okt, pembayaran 24/10/74, 05:30 oleh Cut Nurmala','Mendesak','148 jiwa terdampak, hampir seluruh kebutuhan belum terpenuhi 24 kord lokal terkini. Hanya Mendesak'],
            ['Aula Kantor Camat Banda Sakti','Air Mineral Kemasan','KBT-002','60 Dus belum terpenuhi dari 60','0% terpenuhi','14 Okt, pembayaran 24/10/74, 05:30 oleh Cut Nurmala','Mendesak','148 jiwa terdampak, kategori minum (Air Minum), hanya salam'],
        ]],
        ['Prioritas Tinggi', 'orange', [
            ['GOR Kota Lhokseumawe','Selimut Dewasa','KBT-004','120 Lembar belum terpenuhi dari 120','0% terpenuhi','23 lps, pembayaran 24/10/24, 03:20 oleh Cut Nurmala','Tinggi','Rendah: Mendesak (17 pas terdampak, al, dari ya: crit. kebutuhan ini terpenuhi. Barang kondisi ada. Harus ajas'),
            ['Hagu Selatan','Popok Bayi & Susu Formula','KBT-005','30 Paket belum terpenuhi dari 30','0% terpenuhi','10 lps, pembayaran 24/10/24, 03:20 oleh Cut Nurmala','Tinggi','Rendah: Mendesak (alur terdampak bawah sering. Barang kondisi ada. Harus ajas'],
        ]],
        ['Prioritas Normal', 'gray', [
            ['Lancang Garam','Paket Kebersihan','KBT-006','80 Paket belum terpenuhi dari 80','0% terpenuhi','47lps, pembayaran 24/10/24, 05:30 oleh Cut Nurmala','Sedang','Tinggi: 80 pas terdampak, al. stok belum ada.'],
            ['Gedung Serbaguna Muara Satu','Pakaian Layak Pakai','KBT-007','20 Dus belum terpenuhi dari 20','17 pas, pembayaran 24/10/24, 05:30 oleh Cut Nurmala','Sedang','Tinggi: 80 pas terdampak, al. stok belum ada. Hanya 5 pas'],
            ['SDN 1 Banda Sakti','Air Bersih Galon 19L','KBT-008','30 Unit belum terpenuhi dari 30','4lps, pembayaran 24/10/24, 05:30 oleh Cut Nurmala','Rendah','Sedang: 30 pas terdampak, ada yang setoran, harus ajas'],
        ]],
    ];
    $colors = ['red'=>['border-red-200','bg-red-50','bg-red-100 text-red-700','text-red-700'],'orange'=>['border-orange-200','bg-orange-50','bg-orange-100 text-orange-700','text-orange-700'],'gray'=>['border-gray-200','bg-gray-50','bg-gray-100 text-gray-600','text-gray-600']];
    @endphp

    @foreach($groups as $group)
    @php $c = $colors[$group[1]]; @endphp
    <div class="mb-8">
        <h3 class="text-sm font-bold text-gray-800 mb-3 flex items-center gap-2">
            {{ $group[0] }} <span class="text-xs font-medium text-gray-500">{{ count($group[2]) }}</span>
        </h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($group[2] as $k)
            <div class="bg-white rounded-xl border {{ $c[0] }} shadow-sm p-5">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <p class="text-sm font-bold text-gray-900">{{ $k[0] }}</p>
                        <p class="text-xs text-gray-500">{{ $k[2] }} · {{ $k[1] }}</p>
                    </div>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $c[2] }} flex-shrink-0">{{ $k[6] }}</span>
                </div>
                <p class="text-sm font-semibold text-gray-800 mb-1">{{ $k[3] }}</p>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mb-1">
                    <div class="h-1.5 rounded-full bg-blue-400" style="width:{{ intval($k[4])>0?$k[4]:'2' }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mb-2">{{ $k[4] }}</p>
                <p class="text-xs text-gray-400 mb-3">{{ $k[5] }}</p>
                <div class="bg-gray-50 rounded-lg p-2.5 mb-3">
                    <p class="text-xs text-gray-500"><span class="font-semibold text-gray-700">Saran sistem:</span> {{ $k[7] }}</p>
                    <span class="inline-block mt-1.5 text-xs font-semibold px-2 py-0.5 rounded-full {{ $c[2] }}">{{ $k[6] }}</span>
                </div>
                <button onclick="alert('Demo: Dialokasikan!')" class="w-full text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 py-2 rounded-lg transition-colors">→ Alokasikan</button>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@endsection

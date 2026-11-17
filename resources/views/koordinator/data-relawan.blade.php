@extends('layouts.koordinator')
@section('title', 'Data Relawan')

@section('content')
<div class="p-5">
    <div class="flex items-center justify-between mb-5">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Data Relawan</h2>
            <p class="text-sm text-gray-500">Kelola data dan keahlian relawan.</p>
        </div>
        <button onclick="document.getElementById('modal-tambah-relawan').classList.remove('hidden')"
                class="inline-flex items-center gap-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold px-4 py-2.5 rounded-xl transition-colors shadow-sm">
            + Tambah Relawan
        </button>
    </div>

    {{-- Filter --}}
    <div class="flex items-center gap-3 mb-4 flex-wrap">
        <input type="text" placeholder="Cari nama relawan..." class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 flex-1 min-w-48">
        <select class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option>Semua keahlian</option>
            <option>Evakuasi</option><option>Pertolongan Pertama</option>
            <option>Logistik</option><option>Komunikasi</option>
            <option>Transportasi</option><option>Pendataan Lapangan</option>
        </select>
        <select class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option>Semua status</option>
            <option>Tersedia</option><option>Bertugas</option><option>Tidak Tersedia</option>
        </select>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        @foreach(['Nama','Kontak','Keahlian','Domisili','Status','Aksi'] as $h)
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $relawan = [
                        ['Muhammad Iqbal','0812-3001-1001',['Evakuasi','Transportasi'],'Mon Geudong','Bertugas'],
                        ['Nurul Azirah','0812-3001-1002',['Pertolongan Pertama','Evakuasi'],'Kuta Blang','Tersedia'],
                        ['Zulkifli','0812-3001-1003',['Evakuasi','Logistik'],'Banda Sakti','Bertugas'],
                        ['Cut Meutia','0812-3001-1004',['Pertolongan Pertama'],'Hagu Selatan','Tersedia'],
                        ['Rahmat Hidayat','0812-3001-1005',['Transportasi','Logistik'],'Uteunkot','Tersedia'],
                        ['Fitriani','0812-3001-1006',['Pendataan Lapangan','Komunikasi'],'Pusong','Tersedia'],
                        ['Teuku Ramli','0812-3001-1007',['Evakuasi','Pertolongan Pertama'],'Lancang Garam','Tersedia'],
                        ['Dewi Safitri','0812-3001-1008',['Logistik','Pendataan Lapangan'],'Batuphat','Tidak Tersedia'],
                    ]; @endphp
                    @foreach($relawan as $r)
                    @php $sc=['Tersedia'=>'bg-teal-100 text-teal-700','Bertugas'=>'bg-blue-100 text-blue-700','Tidak Tersedia'=>'bg-gray-100 text-gray-500']; @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-semibold text-gray-900">{{ $r[0] }}</td>
                        <td class="px-4 py-3 text-gray-500 text-xs">{{ $r[1] }}</td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap gap-1">
                                @foreach($r[2] as $k)
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-0.5 rounded-full">{{ $k }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $r[3] }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $sc[$r[4]] }}">{{ $r[4] }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <button class="text-xs font-medium text-gray-600 hover:text-teal-700 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Ubah
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-2.5 text-xs text-gray-400 border-t border-gray-100 flex items-center justify-between">
            <span>Menampilkan 1–8 dari 12 data</span>
            <div class="flex gap-1">
                <button class="w-7 h-7 border border-gray-200 rounded text-xs text-gray-500 hover:bg-gray-100">‹</button>
                <button class="w-7 h-7 border border-teal-600 bg-teal-600 rounded text-xs text-white font-bold">1</button>
                <button class="w-7 h-7 border border-gray-200 rounded text-xs text-gray-500 hover:bg-gray-100">2</button>
                <button class="w-7 h-7 border border-gray-200 rounded text-xs text-gray-500 hover:bg-gray-100">›</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Relawan --}}
<div id="modal-tambah-relawan" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
        <div class="flex items-center justify-between mb-5">
            <h3 class="text-base font-bold text-gray-900">Tambah Relawan</h3>
            <button onclick="document.getElementById('modal-tambah-relawan').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nomor Telepon <span class="text-red-500">*</span></label>
                <input type="tel" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Domisili</label>
                <input type="text" value="Kuta Blang" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                <select class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option>Tersedia</option><option>Bertugas</option><option>Tidak Tersedia</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Keahlian <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach(['Evakuasi','Logistik','Transportasi','Pertolongan Pertama','Komunikasi','Pendataan Lapangan'] as $k)
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-teal-600">
                        {{ $k }}
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex gap-3 mt-6">
            <button onclick="document.getElementById('modal-tambah-relawan').classList.add('hidden')" class="flex-1 border border-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-xl hover:bg-gray-50">Batal</button>
            <button onclick="alert('Demo: Relawan ditambahkan!');document.getElementById('modal-tambah-relawan').classList.add('hidden')" class="flex-1 bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold py-2.5 rounded-xl">Simpan</button>
        </div>
    </div>
</div>
@endsection

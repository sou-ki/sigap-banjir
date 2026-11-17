@extends('layouts.petugas')
@section('title', 'Statistik & Riwayat')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Statistik & Riwayat</h2>
        <p class="text-sm text-gray-500">Rekap laporan dan penyaluran.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mb-5">
        {{-- Laporan per hari --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-4">Laporan per Hari</p>
            <div class="flex items-end justify-around gap-3 h-28">
                @foreach([['22 Okt','1','bg-blue-300'],['23 Okt','2','bg-blue-400'],['24 Okt','9','bg-blue-600']] as $b)
                <div class="flex flex-col items-center gap-1 flex-1">
                    <span class="text-sm font-bold text-gray-800">{{ $b[1] }}</span>
                    <div class="w-full rounded-t-lg {{ $b[2] }}" style="height:{{ intval($b[1])*14 }}px"></div>
                    <span class="text-xs text-gray-400">{{ $b[0] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Status verifikasi donut --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-3">Status Verifikasi</p>
            <div class="flex items-center gap-4">
                <div class="relative w-24 h-24 flex-shrink-0">
                    <svg viewBox="0 0 36 36" class="w-24 h-24 -rotate-90">
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e5e7eb" stroke-width="3"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#16a34a" stroke-width="3" stroke-dasharray="33 67" stroke-linecap="round"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#f97316" stroke-width="3" stroke-dasharray="33 67" stroke-dashoffset="-33" stroke-linecap="round"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#eab308" stroke-width="3" stroke-dasharray="8 92" stroke-dashoffset="-66" stroke-linecap="round"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#dc2626" stroke-width="3" stroke-dasharray="8 92" stroke-dashoffset="-74" stroke-linecap="round"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <p class="text-lg font-extrabold text-gray-900">12</p>
                    </div>
                </div>
                <div class="space-y-1.5 text-xs">
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-green-600"></span><span class="text-gray-700">Terverifikasi: <strong>4</strong></span></div>
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-orange-400"></span><span class="text-gray-700">Menunggu Verifikasi: <strong>4</strong></span></div>
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-yellow-400"></span><span class="text-gray-700">Perlu Klarifikasi: <strong>1</strong></span></div>
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-500"></span><span class="text-gray-700">Ditolak: <strong>1</strong></span></div>
                </div>
            </div>
        </div>

        {{-- Tingkat bahaya donut --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-3">Tingkat Bahaya</p>
            <div class="flex items-center gap-4">
                <div class="relative w-24 h-24 flex-shrink-0">
                    <svg viewBox="0 0 36 36" class="w-24 h-24 -rotate-90">
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e5e7eb" stroke-width="3"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#dc2626" stroke-width="3" stroke-dasharray="33 67" stroke-linecap="round"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#f97316" stroke-width="3" stroke-dasharray="33 67" stroke-dashoffset="-33" stroke-linecap="round"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#eab308" stroke-width="3" stroke-dasharray="33 67" stroke-dashoffset="-66" stroke-linecap="round"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <p class="text-lg font-extrabold text-gray-900">12</p>
                    </div>
                </div>
                <div class="space-y-1.5 text-xs">
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-500"></span><span class="text-gray-700">Tinggi: <strong>4</strong></span></div>
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-orange-400"></span><span class="text-gray-700">Sedang: <strong>4</strong></span></div>
                    <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-yellow-400"></span><span class="text-gray-700">Rendah: <strong>4</strong></span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        {{-- Wilayah terbanyak --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-4">Wilayah dengan Laporan Terbanyak</p>
            <div class="space-y-3">
                @foreach(['Mon Geudong','Keude Aceh','Hagu Selatan','Uteunkot','Lancang Garam'] as $w)
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-600 w-32 flex-shrink-0">{{ $w }}</span>
                    <div class="flex-1 bg-gray-100 rounded-full h-2">
                        <div class="h-2 rounded-full bg-blue-500" style="width:{{ rand(30,100) }}%"></div>
                    </div>
                    <span class="text-xs font-semibold text-gray-700 w-4 text-right">1</span>
                </div>
                @endforeach
                <p class="text-xs text-gray-400 mt-2">Menampilkan 5 dari 6 data.</p>
            </div>
        </div>

        {{-- Riwayat kejadian tabel --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100"><p class="text-sm font-bold text-gray-900">Riwayat Kejadian</p></div>
            <table class="w-full text-xs">
                <thead class="bg-gray-50 border-b border-gray-100"><tr>@foreach(['No.','Lokasi','Waktu','Bahaya','Status'] as $h)<th class="text-left px-3 py-2 font-bold text-gray-500 uppercase tracking-wide" style="font-size:10px">{{ $h }}</th>@endforeach</tr></thead>
                <tbody class="divide-y divide-gray-50">
                    @php $riwayat = [
                        ['LPR-2610-0001','Mon Geudong','24 Okt 2026, 05:40','Bahaya Tinggi','red','Terverifikasi'],
                        ['LPR-2610-0002','Keude Aceh','24 Okt 2026, 06:05','Bahaya Sedang','orange','Terverifikasi'],
                        ['LPR-2610-0003','Hagu Selatan','24 Okt 2026, 04:55','Bahaya Tinggi','red','Terverifikasi'],
                        ['LPR-2610-0004','Uteunkot','24 Okt 2026, 07:10','Bahaya Sedang','orange','Menunggu Verifikasi'],
                        ['LPR-2610-0005','Lancang Garam','24 Okt 2026, 07:25','Bahaya Tinggi','red','Menunggu Verifikasi'],
                        ['LPR-2610-0006','Batuphat','24 Okt 2026, 07:32','Bahaya Rendah','yellow','Menunggu Verifikasi'],
                    ]; @endphp
                    @foreach($riwayat as $r)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2 font-mono text-blue-700">{{ $r[0] }}</td>
                        <td class="px-3 py-2 text-gray-700">{{ $r[1] }}</td>
                        <td class="px-3 py-2 text-gray-500">{{ $r[2] }}</td>
                        <td class="px-3 py-2"><span class="font-semibold px-1.5 py-0.5 rounded-full {{ ['red'=>'bg-red-100 text-red-700','orange'=>'bg-orange-100 text-orange-700','yellow'=>'bg-yellow-100 text-yellow-700'][$r[4]] }}">{{ $r[3] }}</span></td>
                        <td class="px-3 py-2"><span class="font-medium text-{{ $r[5]==='Terverifikasi'?'green-700':'orange-600' }}">{{ $r[5]==='Terverifikasi'?'✓':'' }} {{ $r[5] }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-3 py-2.5 text-xs text-gray-400 border-t border-gray-100 flex items-center justify-between">
                <span>Menampilkan 6 dari 12 data.</span>
                <div class="flex gap-1"><button class="w-6 h-6 border border-gray-200 rounded text-xs bg-blue-600 text-white">1</button><button class="w-6 h-6 border border-gray-200 rounded text-xs text-gray-600">2</button></div>
            </div>
        </div>
    </div>
</div>
@endsection

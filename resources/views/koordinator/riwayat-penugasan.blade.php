@extends('layouts.koordinator')
@section('title', 'Riwayat Penugasan')

@section('content')
<div class="p-5">
    <div class="flex items-start justify-between mb-5 flex-wrap gap-3">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Riwayat Penugasan</h2>
            <p class="text-sm text-gray-500">Seluruh penugasan tim relawan yang sudah selesai atau dibatalkan.</p>
        </div>
        <div class="flex gap-2">
            <input type="search" placeholder="Cari tim atau lokasi..."
                   class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-teal-500 w-56">
            <select class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-teal-500">
                <option>Semua status</option>
                <option>Selesai</option>
                <option>Dibatalkan</option>
            </select>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        @foreach(['Nama / Tim','Lokasi Tugas','Tanggal','Status','Aksi'] as $h)
                        <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $riwayat = [
                        ['Tim Relawan A',  'Nurul Azirah, Teuku Ramli, +2',  'Dukungan dapur umum Muara Satu', 'Ujong Blang',    '23 Okt 2026, 20:20', 'Selesai'],
                        ['Tim Medis I',    'Cut Meutia, Mawaddah',           'Pertolongan pertama Mon Geudong', 'Mon Geudong',    '23 Okt 2026, 15:00', 'Selesai'],
                        ['Tim Relawan C',  'Rahmat Hidayat, Alhan, +3',      'Distribusi logistik Hagu Selatan','Hagu Selatan',   '22 Okt 2026, 10:30', 'Selesai'],
                        ['Tim Relawan B',  'Zulkifli, Fitriani',             'Evakuasi Lancang Garam',          'Lancang Garam',  '22 Okt 2026, 08:00', 'Dibatalkan'],
                    ];
                    $sc = ['Selesai' => 'bg-teal-100 text-teal-700', 'Dibatalkan' => 'bg-red-100 text-red-700'];
                    @endphp
                    @foreach($riwayat as $r)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <p class="font-semibold text-gray-900 text-sm">{{ $r[0] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $r[1] }}</p>
                        </td>
                        <td class="px-4 py-3">
                            <p class="text-sm text-gray-700">{{ $r[2] }}</p>
                            <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                                {{ $r[3] }}
                            </p>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500">{{ $r[4] }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $sc[$r[5]] }}">{{ $r[5] }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <button onclick="openDetail('{{ $r[0] }}')"
                                    class="text-xs font-semibold text-teal-600 hover:text-teal-800 hover:underline">
                                Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-4 py-2.5 text-xs text-gray-400 border-t border-gray-100 flex items-center justify-between">
            <span>Menampilkan 4 dari 4 data</span>
            <div class="flex gap-1">
                <button class="w-7 h-7 border border-teal-600 bg-teal-600 rounded text-xs text-white font-bold">1</button>
            </div>
        </div>
    </div>
</div>

{{-- Detail Modal --}}
<div id="detail-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-gray-900" id="detail-title">Detail Penugasan</h3>
            <button onclick="document.getElementById('detail-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Progress steps --}}
        <div class="flex items-center mb-5">
            @foreach(['Ditugaskan','Menuju Lokasi','Berlangsung','Selesai'] as $i => $step)
            <div class="flex flex-col items-center flex-1">
                <div class="w-7 h-7 rounded-full bg-teal-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                </div>
                <p class="text-xs text-gray-500 text-center mt-1 leading-tight">{{ $step }}</p>
            </div>
            @if($loop->index < 3)
            <div class="h-0.5 bg-teal-300 flex-1 -mt-4 mx-1"></div>
            @endif
            @endforeach
        </div>

        <div class="space-y-2 text-sm">
            <div class="flex items-start gap-2 text-xs text-gray-600">
                <span class="w-2 h-2 rounded-full bg-teal-500 mt-1 flex-shrink-0"></span>
                <div>
                    <p class="font-semibold text-gray-800">Ditugaskan oleh koordinator</p>
                    <p class="text-gray-400">23 Okt 2026, 20:20 · Teuku Faisal</p>
                </div>
            </div>
            <div class="flex items-start gap-2 text-xs text-gray-600">
                <span class="w-2 h-2 rounded-full bg-teal-500 mt-1 flex-shrink-0"></span>
                <div>
                    <p class="font-semibold text-gray-800">Penugasan selesai</p>
                    <p class="text-gray-400">23 Okt 2026, 21:10</p>
                </div>
            </div>
        </div>

        <button onclick="document.getElementById('detail-modal').classList.add('hidden')"
                class="mt-5 w-full border border-gray-200 text-gray-700 text-sm font-semibold py-2.5 rounded-xl hover:bg-gray-50">
            Tutup
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
function openDetail(nama) {
    document.getElementById('detail-title').textContent = 'Detail — ' + nama;
    document.getElementById('detail-modal').classList.remove('hidden');
}
</script>
@endpush

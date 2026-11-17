@extends('layouts.admin')
@section('title', 'Log Aktivitas')

@section('content')
<div class="p-6">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Log Aktivitas</h2>
        <p class="text-sm text-gray-500">Jejak aktivitas pengguna dan perubahan operasional.</p>
    </div>

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        {{-- Filters --}}
        <div class="flex items-center gap-3 px-5 py-3 border-b border-gray-100 flex-wrap">
            <div class="relative flex-1 min-w-48">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" placeholder="Cari aktivitas atau pengguna..." class="w-full text-sm border border-gray-200 rounded-lg pl-9 pr-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <select class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option>Semua kategori</option>
                <option>Autentikasi</option>
                <option>Pengguna</option>
                <option>Operasional</option>
                <option>Logistik</option>
            </select>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        @foreach(['Waktu','Pengguna','Kategori','Aktivitas'] as $h)
                        <th class="text-left px-5 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $logs = [
                        ['24 Okt 2026, 08:12','Rizal Hakim','Admin Sistem','Autentikasi','Masuk ke sistem'],
                        ['24 Okt 2026, 08:10','Rizal Hakim','Admin Sistem','Autentikasi','Masuk ke sistem'],
                        ['24 Okt 2026, 08:08','Siti Rahmah','Masyarakat','Autentikasi','Masuk ke sistem'],
                        ['24 Okt 2026, 08:06','Cut Nurmala','Petugas Penanggulangan Bencana','Autentikasi','Masuk ke sistem'],
                        ['24 Okt 2026, 08:04','Report Telegram','Masyarakat','Autentikasi','Masuk ke sistem'],
                        ['24 Okt 2026, 08:02','Sistem','Admin Sistem','Pengguna','Menambahkan pengguna Report Telegram'],
                        ['24 Okt 2026, 07:02','Rizal Hakim','Admin Sistem','Autentikasi','Masuk ke sistem'],
                        ['24 Okt 2026, 07:25','Cut Nurmala','Petugas Penanggulangan Bencana','Operasional','Memperbarui status Jl. Perdagangan menjadi Tidak Dapat Dilalui'],
                    ];
                    $catBadge = ['Autentikasi'=>'bg-blue-100 text-blue-700','Pengguna'=>'bg-purple-100 text-purple-700','Operasional'=>'bg-orange-100 text-orange-700','Logistik'=>'bg-green-100 text-green-700'];
                    @endphp
                    @foreach($logs as $l)
                    <tr class="hover:bg-gray-50">
                        <td class="px-5 py-3.5 text-gray-500 whitespace-nowrap">{{ $l[0] }}</td>
                        <td class="px-5 py-3.5">
                            <p class="font-semibold text-gray-900">{{ $l[1] }}</p>
                            <p class="text-xs text-gray-400">{{ $l[2] }}</p>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full {{ $catBadge[$l[3]] ?? 'bg-gray-100 text-gray-600' }}">{{ $l[3] }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700">{{ $l[4] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-3 text-xs text-gray-400 border-t border-gray-100 flex items-center justify-between">
            <span>Menampilkan 8 dari 48 entri.</span>
            <div class="flex gap-1">
                <button class="w-7 h-7 border border-gray-200 rounded text-xs text-gray-500 hover:bg-gray-100">‹</button>
                <button class="w-7 h-7 border border-blue-600 bg-blue-600 rounded text-xs text-white font-bold">1</button>
                <button class="w-7 h-7 border border-gray-200 rounded text-xs text-gray-500 hover:bg-gray-100">2</button>
                <button class="w-7 h-7 border border-gray-200 rounded text-xs text-gray-500 hover:bg-gray-100">3</button>
                <button class="w-7 h-7 border border-gray-200 rounded text-xs text-gray-500 hover:bg-gray-100">›</button>
            </div>
        </div>
    </div>
</div>
@endsection

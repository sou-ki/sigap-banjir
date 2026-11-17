@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<div class="p-6">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Dashboard Administrator</h2>
        <p class="text-sm text-gray-500">Kondisi sistem dan pengguna.</p>
    </div>

    {{-- 4 stat cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php $stats = [
            ['label'=>'Total Pengguna','val'=>11,'icon'=>'<path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>','bg'=>'bg-blue-100','c'=>'text-blue-600'],
            ['label'=>'Akun Aktif','val'=>10,'icon'=>'<path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/>','bg'=>'bg-green-100','c'=>'text-green-600'],
            ['label'=>'Akun Nonaktif','val'=>1,'icon'=>'<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>','bg'=>'bg-red-100','c'=>'text-red-500'],
            ['label'=>'Total Laporan','val'=>12,'icon'=>'<path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/>','bg'=>'bg-teal-100','c'=>'text-teal-600'],
        ]; @endphp
        @foreach($stats as $s)
        <div class="bg-white rounded-xl border border-gray-100 p-5 shadow-sm flex items-start justify-between">
            <div>
                <p class="text-xs text-gray-500 mb-1">{{ $s['label'] }}</p>
                <p class="text-3xl font-extrabold text-gray-900">{{ $s['val'] }}</p>
            </div>
            <div class="w-9 h-9 {{ $s['bg'] }} rounded-lg flex items-center justify-center flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 {{ $s['c'] }}" viewBox="0 0 24 24" fill="currentColor">{!! $s['icon'] !!}</svg>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pengguna per peran + Aktivitas terbaru --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5 mb-5">

        {{-- Donut chart --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-4">Pengguna per Peran</p>
            <div class="flex items-center gap-6">
                {{-- SVG donut --}}
                <div class="relative flex-shrink-0">
                    <svg width="100" height="100" viewBox="0 0 36 36" class="-rotate-90">
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e5e7eb" stroke-width="3.5"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#1d4ed8" stroke-width="3.5" stroke-dasharray="9 91" stroke-linecap="round"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#3b82f6" stroke-width="3.5" stroke-dasharray="18 82" stroke-dashoffset="-9" stroke-linecap="round"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#22c55e" stroke-width="3.5" stroke-dasharray="18 82" stroke-dashoffset="-27" stroke-linecap="round"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#d1d5db" stroke-width="3.5" stroke-dasharray="55 45" stroke-dashoffset="-45" stroke-linecap="round"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <p class="text-xl font-extrabold text-gray-900 leading-none">11</p>
                        <p class="text-xs text-gray-400">pengguna</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    @foreach([['Admin Sistem','1','bg-blue-800'],['Petugas Penanggulangan Bencana','2','bg-blue-500'],['Koordinator Relawan','2','bg-green-500'],['Masyarakat','6','bg-gray-300']] as $r)
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-sm flex-shrink-0 {{ $r[2] }}"></span>
                        <span class="text-gray-700">{{ $r[0] }}</span>
                        <span class="font-bold text-gray-900 ml-auto">{{ $r[1] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Aktivitas terbaru --}}
        <div class="lg:col-span-3 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100">
                <p class="text-sm font-bold text-gray-900">Aktivitas Terbaru</p>
                <a href="{{ route('admin.log-aktivitas') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach([
                    ['Masuk ke sistem','Rizal Hakim','Admin Sistem','24 Okt 2026, 08:12'],
                    ['Masuk ke sistem','Rizal Hakim','Admin Sistem','24 Okt 2026, 08:10'],
                    ['Masuk ke sistem','Siti Rahmah','Masyarakat','24 Okt 2026, 08:08'],
                    ['Masuk ke sistem','Cut Nurmala','Petugas Penanggulangan Bencana','24 Okt 2026, 08:06'],
                    ['Masuk ke sistem','Report Telegram','Masyarakat','24 Okt 2026, 08:04'],
                    ['Menambahkan pengguna Report Telegram','Sistem','Admin Sistem','24 Okt 2026, 08:02'],
                ] as $a)
                <div class="px-5 py-3 hover:bg-gray-50">
                    <p class="text-sm font-semibold text-gray-900">{{ $a[0] }}</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $a[1] }} · {{ $a[2] }} · {{ $a[3] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Distribusi peran (bar chart) --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
        <p class="text-sm font-bold text-gray-900 mb-5">Distribusi Peran</p>
        <div class="flex items-end justify-around gap-4 h-32">
            @foreach([['Admin','1','bg-blue-600'],['Petugas','2','bg-blue-500'],['Koordinator','2','bg-blue-400'],['Masyarakat','6','bg-blue-300']] as $b)
            <div class="flex flex-col items-center gap-1.5 flex-1">
                <span class="text-sm font-bold text-gray-800">{{ $b[1] }}</span>
                <div class="w-full {{ $b[2] }} rounded-t-lg" style="height:{{ intval($b[1])*18 }}px"></div>
                <span class="text-xs text-gray-500">{{ $b[0] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

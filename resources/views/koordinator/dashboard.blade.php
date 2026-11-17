@extends('layouts.koordinator')
@section('title', 'Dashboard Koordinator Relawan')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Dashboard Koordinator Relawan</h2>
        <p class="text-sm text-gray-500">Kebutuhan relawan dan ketersediaan tim.</p>
    </div>

    {{-- Stat Cards --}}
    @php $stats = [
        ['label'=>'Kebutuhan Relawan',  'val'=>'5',  'icon'=>'<path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/>','bg'=>'bg-orange-50','c'=>'text-orange-500'],
        ['label'=>'Belum Terpenuhi',    'val'=>'5',  'icon'=>'<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>','bg'=>'bg-red-50','c'=>'text-red-500'],
        ['label'=>'Relawan Tersedia',   'val'=>'8',  'icon'=>'<path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>','bg'=>'bg-teal-50','c'=>'text-teal-600'],
        ['label'=>'Sedang Bertugas',    'val'=>'2',  'icon'=>'<path d="M13.49 5.48c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm-3.6 13.9l1-4.4 2.1 2v6h2v-7.5l-2.1-2 .6-3c1.3 1.5 3.3 2.5 5.5 2.5v-2c-1.9 0-3.5-1-4.3-2.4l-1-1.6c-.4-.6-1-1-1.7-1-.3 0-.5.1-.8.1l-5.2 2.2v4.7h2v-3.4l1.8-.7-1.6 8.1-4.9-1-.4 2 7 1.4z"/>','bg'=>'bg-blue-50','c'=>'text-blue-600'],
        ['label'=>'Tidak Tersedia',     'val'=>'2',  'icon'=>'<path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>','bg'=>'bg-gray-50','c'=>'text-gray-500'],
    ]; @endphp
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 mb-5">
        @foreach($stats as $s)
        <div class="bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-500 leading-tight">{{ $s['label'] }}</p>
                <div class="w-7 h-7 {{ $s['bg'] }} rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ $s['c'] }}" viewBox="0 0 24 24" fill="currentColor">{!! $s['icon'] !!}</svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-gray-900">{{ $s['val'] }}</p>
        </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
        {{-- Status Relawan --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-4">Status Relawan</p>
            <div class="flex items-center gap-4">
                <div class="relative w-24 h-24 flex-shrink-0">
                    <svg viewBox="0 0 36 36" class="w-24 h-24 -rotate-90">
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#e5e7eb" stroke-width="3"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#0d9488" stroke-width="3" stroke-dasharray="66.7 33.3" stroke-linecap="round"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#3b82f6" stroke-width="3" stroke-dasharray="16.7 83.3" stroke-dashoffset="-66.7" stroke-linecap="round"/>
                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#d1d5db" stroke-width="3" stroke-dasharray="16.7 83.3" stroke-dashoffset="-83.3" stroke-linecap="round"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center"><p class="text-lg font-extrabold text-gray-900">12</p><p class="text-xs text-gray-400">Relawan</p></div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-teal-500 flex-shrink-0"></span><span class="text-xs text-gray-700">Tersedia <strong>8</strong></span></div>
                    <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-blue-500 flex-shrink-0"></span><span class="text-xs text-gray-700">Bertugas <strong>2</strong></span></div>
                    <div class="flex items-center gap-2"><span class="w-2.5 h-2.5 rounded-full bg-gray-300 flex-shrink-0"></span><span class="text-xs text-gray-700">Tidak Tersedia <strong>2</strong></span></div>
                </div>
            </div>
        </div>

        {{-- Keahlian Tersedia --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-1">Keahlian Tersedia</p>
            <p class="text-xs text-gray-400 mb-4">Berdasarkan relawan tersedia saat ini.</p>
            <div class="flex items-end gap-2 h-20">
                @foreach([['Evakuasi','3','bg-teal-500'],['Pertolongan','4','bg-teal-600'],['Logistik','1','bg-teal-400'],['Komunikasi','2','bg-teal-500'],['Transportasi','3','bg-teal-600'],['Pendataan','2','bg-teal-400']] as $b)
                <div class="flex flex-col items-center gap-1 flex-1">
                    <span class="text-xs font-bold text-gray-700">{{ $b[1] }}</span>
                    <div class="w-full rounded-t {{ $b[2] }}" style="height:{{ intval($b[1])*16 }}px"></div>
                    <span class="text-xs text-gray-400 leading-none text-center" style="font-size:9px">{{ $b[0] }}</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Status Penugasan --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-sm font-bold text-gray-900 mb-1">Status Penugasan</p>
            <p class="text-xs text-gray-400 mb-4">3 penugasan aktif bulan ini.</p>
            <div class="flex items-end gap-3 h-20">
                @foreach([['Ditugaskan','0','bg-gray-200'],['Menuju','1','bg-teal-400'],['Berlangsung','1','bg-teal-500'],['Selesai','1','bg-teal-600']] as $b)
                <div class="flex flex-col items-center gap-1 flex-1">
                    <span class="text-xs font-bold text-gray-700">{{ $b[1] }}</span>
                    <div class="w-full rounded-t {{ $b[2] }}" style="height:{{ max(intval($b[1])*28,6) }}px"></div>
                    <span class="text-xs text-gray-400 leading-none text-center" style="font-size:9px">{{ $b[0] }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Kebutuhan Prioritas --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100">
            <p class="text-sm font-bold text-gray-900">Kebutuhan Prioritas</p>
            <a href="{{ route('koordinator.alokasi-relawan') }}" class="text-xs font-semibold text-teal-600 bg-teal-50 border border-teal-200 px-3 py-1.5 rounded-lg hover:bg-teal-100">Alokasikan Relawan</a>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach([
                ['Evakuasi warga Hagu Selatan','Hagu Selatan · 0 Relawan','Prioritas Tinggi','red'],
                ['Evakuasi benda Lancang Garam','Lancang Garam · 0 Relawan','Prioritas Tinggi','red'],
                ['Distribusi logistik Aula Camat','Banda Sakti · 12 relawan','Prioritas Sedang','orange'],
                ['Pencatatan korban terdampak Mon Geudong','Mon Geudong · 0 relawan','Prioritas Sedang','orange'],
                ['Dukungan dapur umum Muara Satu','Ujong Blang · 0 relawan','Prioritas Rendah','yellow'],
            ] as $k)
            <div class="flex items-center justify-between px-5 py-3 hover:bg-gray-50">
                <div>
                    <p class="text-sm font-semibold text-gray-900">{{ $k[0] }}</p>
                    <p class="text-xs text-gray-400">{{ $k[1] }}</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                    {{ $k[3]==='red' ? 'bg-red-100 text-red-700' : ($k[3]==='orange' ? 'bg-orange-100 text-orange-700' : 'bg-yellow-100 text-yellow-700') }}">
                    {{ $k[2] }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

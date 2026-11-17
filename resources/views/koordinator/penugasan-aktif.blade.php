@extends('layouts.koordinator')
@section('title', 'Penugasan Aktif')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Penugasan Aktif</h2>
        <p class="text-sm text-gray-500">Pantau relawan yang sedang dalam penugasan saat ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @php $aktif = [
            ['A-001','Muhammad Iqbal','Evakuasi warga Hagu Selatan','Hagu Selatan','Berlangsung','Evakuasi, Transportasi','24 Okt 2026, 07:30'],
            ['A-002','Zulkifli','Distribusi logistik Aula Camat','Banda Sakti','Menuju Lokasi','Evakuasi, Logistik','24 Okt 2026, 08:00'],
        ]; @endphp
        @foreach($aktif as $a)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <div class="flex items-start justify-between mb-3">
                <div>
                    <span class="text-xs font-mono text-gray-400">{{ $a[0] }}</span>
                    <p class="font-bold text-gray-900 mt-0.5">{{ $a[1] }}</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-100 text-blue-700">{{ $a[4] }}</span>
            </div>
            <div class="bg-gray-50 rounded-xl p-3 mb-3">
                <p class="text-sm font-semibold text-gray-900">{{ $a[2] }}</p>
                <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/></svg>
                    {{ $a[3] }}
                </p>
            </div>
            <div class="flex flex-wrap gap-1 mb-3">
                @foreach(explode(', ',$a[5]) as $k)
                <span class="text-xs bg-teal-50 text-teal-700 px-2 py-0.5 rounded-full">{{ $k }}</span>
                @endforeach
            </div>
            <p class="text-xs text-gray-400">Ditugaskan: {{ $a[6] }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection

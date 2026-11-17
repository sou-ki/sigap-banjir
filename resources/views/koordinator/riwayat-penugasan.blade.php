@extends('layouts.koordinator')
@section('title', 'Riwayat Penugasan')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Riwayat Penugasan</h2>
        <p class="text-sm text-gray-500">Penugasan yang telah diselesaikan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
        {{-- Table --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            @foreach(['ID','Relawan','Tugas','Ditugaskan','Status'] as $h)
                            <th class="text-left px-4 py-3 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="hover:bg-teal-50 bg-teal-50 cursor-pointer">
                            <td class="px-4 py-3 text-xs font-mono font-bold text-teal-700">A-003</td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-900">Nurul Azirah</td>
                            <td class="px-4 py-3 text-xs text-gray-600">Dukungan dapur umum Muara Satu</td>
                            <td class="px-4 py-3 text-xs text-gray-400">23 Okt 2026, 20:20</td>
                            <td class="px-4 py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-teal-100 text-teal-700">Selesai</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-2.5 text-xs text-gray-400 border-t border-gray-100">Menampilkan 1 dari 1 data</div>
        </div>

        {{-- Detail --}}
        <div class="lg:col-span-3 bg-white rounded-xl border border-gray-100 shadow-sm p-5">
            <p class="text-xs font-mono text-gray-400 mb-1">A-003</p>
            <p class="font-bold text-gray-900 mb-0.5">Nurul Azirah</p>
            <p class="text-xs text-gray-500 mb-4">Dukungan dapur umum Muara Satu · Ujong Blang</p>

            {{-- Progress --}}
            <div class="flex items-center gap-2 mb-6">
                @foreach([['Ditugaskan','teal'],['Menuju Lokasi','teal'],['Berlangsung','teal'],['Selesai','teal']] as $step)
                <div class="flex-1 flex flex-col items-center gap-1">
                    <div class="w-7 h-7 rounded-full bg-{{ $step[1] }}-500 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    </div>
                    <p class="text-xs text-gray-500 text-center leading-tight">{{ $step[0] }}</p>
                </div>
                @if(!$loop->last)<div class="w-6 h-0.5 bg-teal-300 flex-shrink-0 -mt-4"></div>@endif
                @endforeach
            </div>

            <div class="space-y-2">
                <div class="flex items-start gap-2 text-xs text-gray-600">
                    <span class="w-2 h-2 rounded-full bg-teal-500 mt-1 flex-shrink-0"></span>
                    <div><p class="font-semibold">Ditugaskan oleh koordinator</p><p class="text-gray-400">23 Okt 2026, 20:20 · Teuku Faisal</p></div>
                </div>
                <div class="flex items-start gap-2 text-xs text-gray-600">
                    <span class="w-2 h-2 rounded-full bg-teal-500 mt-1 flex-shrink-0"></span>
                    <div><p class="font-semibold">Penugasan selesai</p><p class="text-gray-400">23 Okt 2026, 21:10 · Nurul Azirah</p></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

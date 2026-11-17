@extends('layouts.koordinator')
@section('title', 'Laporan Kegiatan')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Laporan Kegiatan</h2>
        <p class="text-sm text-gray-500">Ringkasan hasil penugasan relawan dan kegiatan logistik.</p>
    </div>

    {{-- Relawan Stats --}}
    <div class="grid grid-cols-3 gap-3 mb-5">
        @foreach([['Penugasan Selesai','1','bg-teal-50','text-teal-600'],['Total Penugasan','3','bg-blue-50','text-blue-600'],['Dibatalkan','0','bg-gray-50','text-gray-500']] as $s)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-500">{{ $s[0] }}</p>
                <div class="w-7 h-7 {{ $s[2] }} rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ $s[3] }}" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-gray-900">{{ $s[1] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Laporan Hasil Tugas --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-5">
        <div class="px-5 py-3 border-b border-gray-100">
            <p class="text-sm font-bold text-gray-900">Laporan Hasil Tugas</p>
        </div>
        <div class="p-4 space-y-3">
            <div class="bg-teal-50 border border-teal-200 rounded-xl p-4">
                <div class="flex items-start justify-between mb-1">
                    <div>
                        <span class="text-xs font-mono text-teal-500">A-003</span>
                        <p class="font-bold text-gray-900 mt-0.5">Nurul Azirah</p>
                    </div>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-teal-100 text-teal-700">Selesai</span>
                </div>
                <p class="text-xs text-gray-500">Ditugaskan: Dapur umum Muara Satu · Ujong Blang</p>
                <p class="text-xs text-gray-400 mt-0.5">Selesai: 23 Okt 2026, 21:10</p>
            </div>
        </div>
    </div>

    {{-- Logistik Stats --}}
    <div class="grid grid-cols-3 gap-3 mb-5">
        @foreach([['Penyaluran Selesai','1','bg-teal-50','text-teal-600'],['Penyaluran Berjalan','2','bg-blue-50','text-blue-600'],['Kebutuhan Dilaporan','4','bg-orange-50','text-orange-500']] as $s)
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="text-xs text-gray-500">{{ $s[0] }}</p>
                <div class="w-7 h-7 {{ $s[2] }} rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 {{ $s[3] }}" viewBox="0 0 24 24" fill="currentColor"><path d="M20 7l-8-4-8 4v10l8 4 8-4V7zm-8 1.5L18 11l-6 3-6-3 6-2.5zM4 12.3l7 3.5V20l-7-3.5V12.3zm9 3.5l7-3.5v4.2l-7 3.5V15.8z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-extrabold text-gray-900">{{ $s[1] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Aktivitas Logistik Terbaru --}}
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
        <div class="px-5 py-3 border-b border-gray-100">
            <p class="text-sm font-bold text-gray-900">Aktivitas Logistik Terbaru</p>
        </div>
        <div class="flex flex-col items-center justify-center py-12 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <p class="text-sm">Belum ada aktivitas logistik</p>
        </div>
    </div>
</div>
@endsection

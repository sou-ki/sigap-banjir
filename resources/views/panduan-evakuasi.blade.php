@extends('layouts.app')

@section('title', 'Panduan Evakuasi — SIGAP Banjir Kota Lhokseumawe')

@section('content')

{{-- Header --}}
<div class="bg-white border-b border-gray-100 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900">Panduan Evakuasi &amp; Keselamatan</h1>
        <p class="text-sm text-gray-500 mt-1 max-w-xl">Langkah umum menghadapi banjir. Selalu ikuti arahan petugas dan perangkat lingkungan setempat.</p>
    </div>
</div>

<div class="py-8 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- 3 cards: Sebelum / Saat / Setelah --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            {{-- Sebelum Banjir --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-3">Sebelum Banjir</h3>
                <ul class="space-y-2">
                    @foreach(['Siapkan tas siaga: dokumen, obat, senter, dan air minum.', 'Kenali lokasi pengungsian terdekat dan jalur menuju ke sana.', 'Simpan kontak keluarga dan ketua lingkungan.'] as $item)
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                        </svg>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Saat Banjir --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11 2v20c-5.07-.5-9-4.79-9-10s3.93-9.5 9-10zm2.03 0v8.99H22c-.47-4.74-4.24-8.52-8.97-8.99zm0 11.01V22c4.74-.47 8.5-4.25 8.97-8.99h-8.97z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-3">Saat Banjir</h3>
                <ul class="space-y-2">
                    @foreach(['Matikan listrik dan hindari kabel terendam.', 'Jangan berjalan atau berkendara melewati air yang mengalir deras.', 'Utamakan lansia, anak-anak, dan ibu hamil.'] as $item)
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                        </svg>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Setelah Banjir --}}
            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-3">Setelah Banjir</h3>
                <ul class="space-y-2">
                    @foreach(['Periksa kondisi bangunan sebelum masuk kembali.', 'Bersihkan area dengan alat pelindung.', 'Laporkan kerusakan atau kebutuhan bantuan melalui platform.'] as $item)
                    <li class="flex items-start gap-2 text-sm text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/>
                        </svg>
                        {{ $item }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Catatan penting --}}
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-600 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
            <div>
                <p class="text-sm font-semibold text-yellow-800">Catatan penting</p>
                <p class="text-sm text-yellow-700 mt-0.5">Platform ini adalah prototipe penelitian, bukan layanan darurat resmi. Dalam keadaan darurat, segera hubungi layanan darurat setempat melalui kanal resmi.</p>
            </div>
        </div>

    </div>
</div>

@endsection

@extends('layouts.koordinator')
@section('title', 'Alokasi Relawan')

@push('styles')
<style>#map-alokasi{height:160px}</style>
@endpush

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Alokasi Relawan</h2>
        <p class="text-sm text-gray-500">Tugaskan tim relawan ke lokasi yang membutuhkan penanganan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

        {{-- Step 1: Pilih Kebutuhan --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-bold text-gray-900">1. Pilih Kebutuhan</p>
                <p class="text-xs text-gray-400 mt-0.5">Klik untuk memilih lokasi yang akan ditugaskan</p>
            </div>
            <div class="divide-y divide-gray-50">
                @php $kebutuhan = [
                    ['Evakuasi warga Hagu Selatan',              'Hagu Selatan',   'Prioritas Tinggi',  'red',    true],
                    ['Evakuasi Lancang Garam',                   'Lancang Garam',  'Prioritas Tinggi',  'red',    false],
                    ['Distribusi logistik Aula Camat',           'Banda Sakti',    'Prioritas Sedang',  'orange', false],
                    ['Pencatatan korban Mon Geudong',            'Mon Geudong',    'Prioritas Sedang',  'orange', false],
                    ['Dukungan dapur umum Muara Satu',           'Ujong Blang',    'Prioritas Rendah',  'yellow', false],
                ];
                $pc = ['red'=>'bg-red-100 text-red-700','orange'=>'bg-orange-100 text-orange-700','yellow'=>'bg-yellow-100 text-yellow-700'];
                @endphp
                @foreach($kebutuhan as $k)
                <div class="px-4 py-3 cursor-pointer {{ $k[4] ? 'bg-teal-50 border-l-2 border-teal-500' : 'hover:bg-gray-50' }}">
                    <div class="flex items-start justify-between gap-2">
                        <p class="text-xs font-semibold text-gray-900 leading-snug">{{ $k[0] }}</p>
                        <span class="text-xs font-semibold px-1.5 py-0.5 rounded-full flex-shrink-0 {{ $pc[$k[3]] }}">{{ $k[2] }}</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $k[1] }}</p>
                    @if($k[4])
                    <p class="text-xs text-teal-600 font-medium mt-1">✓ Dipilih</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        {{-- Step 2: Pilih Tim --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm">
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-bold text-gray-900">2. Pilih Tim</p>
                <p class="text-xs text-gray-400 mt-0.5">Tugaskan satu tim ke lokasi ini</p>
            </div>
            <div class="divide-y divide-gray-50">
                @php $tim = [
                    ['Tim Relawan A', 'Ketua: Muhammad Iqbal', '4 anggota · Tersedia', true],
                    ['Tim Relawan B', 'Ketua: Zulkifli',       '3 anggota · Tersedia', false],
                    ['Tim Relawan C', 'Ketua: Rahmat Hidayat', '5 anggota · Tersedia', false],
                    ['Tim Medis I',   'Ketua: Cut Meutia',     '3 anggota · Bertugas', false],
                ]; @endphp
                @foreach($tim as $t)
                <label class="flex items-start gap-3 px-4 py-3 cursor-pointer {{ $t[3] ? 'bg-teal-50' : 'hover:bg-gray-50' }}">
                    <input type="radio" name="tim" {{ $t[3] ? 'checked' : '' }}
                           class="mt-0.5 w-4 h-4 border-gray-300 text-teal-600 flex-shrink-0">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900">{{ $t[0] }}</p>
                        <p class="text-xs text-gray-500 mt-0.5">{{ $t[1] }}</p>
                        <p class="text-xs text-gray-400">{{ $t[2] }}</p>
                    </div>
                    @if($t[3])
                    <span class="text-xs font-semibold text-teal-600 flex-shrink-0">Dipilih</span>
                    @endif
                </label>
                @endforeach
            </div>
        </div>

        {{-- Step 3: Ringkasan --}}
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm flex flex-col">
            <div class="px-4 py-3 border-b border-gray-100">
                <p class="text-sm font-bold text-gray-900">3. Konfirmasi Penugasan</p>
            </div>
            <div class="flex-1 p-4 space-y-3">
                <div id="map-alokasi" class="rounded-xl border border-gray-200 overflow-hidden"></div>

                <div class="bg-gray-50 rounded-xl p-3 space-y-2">
                    <div>
                        <p class="text-xs text-gray-400 mb-0.5">Lokasi</p>
                        <p class="text-sm font-semibold text-gray-900">Evakuasi warga Hagu Selatan</p>
                        <p class="text-xs text-gray-500">Hagu Selatan</p>
                    </div>
                    <div class="border-t border-gray-200 pt-2">
                        <p class="text-xs text-gray-400 mb-0.5">Tim yang ditugaskan</p>
                        <p class="text-sm font-semibold text-gray-900">Tim Relawan A</p>
                        <p class="text-xs text-gray-500">Ketua: Muhammad Iqbal · 4 anggota</p>
                    </div>
                    <div class="border-t border-gray-200 pt-2">
                        <p class="text-xs text-gray-400 mb-0.5">Tanggal penugasan</p>
                        <p class="text-sm text-gray-700">{{ now()->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
            <div class="px-4 pb-4">
                <button onclick="alert('Demo: Tim Relawan A berhasil ditugaskan ke Hagu Selatan!')"
                        class="w-full bg-teal-600 hover:bg-teal-700 text-white text-sm font-bold py-2.5 rounded-xl transition-colors">
                    Konfirmasi Penugasan Tim
                </button>
            </div>
        </div>
    </div>

    {{-- Penugasan Tim Aktif --}}
    <div class="mt-5 bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-100">
            <p class="text-sm font-bold text-gray-900">Penugasan Tim Aktif</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        @foreach(['Tim','Ketua Tim','Lokasi Tugas','Prioritas','Status','Waktu Mulai'] as $h)
                        <th class="text-left px-4 py-2.5 text-xs font-bold text-gray-500 uppercase tracking-wide">{{ $h }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @php $aktif = [
                        ['Tim Relawan A', 'Muhammad Iqbal', 'Evakuasi warga Hagu Selatan', 'Tinggi',  'Berlangsung', '24 Okt 2026, 07:30'],
                        ['Tim Relawan B', 'Zulkifli',       'Distribusi logistik Aula Camat', 'Sedang', 'Menuju Lokasi', '24 Okt 2026, 08:00'],
                    ];
                    $sc = ['Berlangsung'=>'bg-blue-100 text-blue-700','Menuju Lokasi'=>'bg-yellow-100 text-yellow-700','Selesai'=>'bg-teal-100 text-teal-700'];
                    $pc = ['Tinggi'=>'bg-orange-100 text-orange-700','Sedang'=>'bg-yellow-100 text-yellow-700'];
                    @endphp
                    @foreach($aktif as $a)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-semibold text-gray-900 text-sm">{{ $a[0] }}</td>
                        <td class="px-4 py-3 text-sm text-gray-600">{{ $a[1] }}</td>
                        <td class="px-4 py-3 text-sm text-gray-700">{{ $a[2] }}</td>
                        <td class="px-4 py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $pc[$a[3]] }}">{{ $a[3] }}</span></td>
                        <td class="px-4 py-3"><span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $sc[$a[4]] }}">{{ $a[4] }}</span></td>
                        <td class="px-4 py-3 text-xs text-gray-400">{{ $a[5] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('map-alokasi', { zoomControl: false, attributionControl: false }).setView([5.1801, 97.1500], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);
    const ico = L.divIcon({ html: '<div style="background:#dc2626;width:14px;height:14px;border-radius:50%;border:2px solid #fff;box-shadow:0 1px 3px rgba(0,0,0,.3)"></div>', className: '', iconSize: [14, 14], iconAnchor: [7, 7] });
    L.marker([5.175, 97.145], { icon: ico }).addTo(map);
});
</script>
@endpush

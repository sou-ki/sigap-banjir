@extends('layouts.dashboard')
@section('title', 'Laporkan Banjir')

@push('styles')
<style>
#report-map-db { height: 260px; }
.section-letter { width:28px;height:28px;border-radius:8px;background:#1e3a5f;color:#fff;font-weight:800;font-size:13px;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
</style>
@endpush

@section('content')
<div class="p-6 max-w-4xl">
    <nav class="text-xs text-gray-400 mb-3">
        <a href="{{ route('dashboard.beranda') }}" class="hover:text-gray-600">Beranda</a>
        <span class="mx-1">›</span>
        <span class="text-gray-700">Laporkan Banjir</span>
    </nav>
    <h2 class="text-xl font-extrabold text-gray-900 mb-1">Laporkan Banjir</h2>
    <p class="text-sm text-gray-500 mb-6">Laporan tersimpan sebagai menunggu verifikasi dan hanya tampil sebagai informasi terkonfirmasi setelah ditinjau petugas.</p>

    @if ($errors->any())
    <div role="alert" class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
        <p class="font-bold mb-1">Laporan belum dapat dikirim:</p>
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('dashboard.laporan-banjir.store') }}" enctype="multipart/form-data" class="space-y-5">
        @csrf
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-5"><span class="section-letter">A</span><h3 class="text-base font-bold text-gray-900">Informasi Kejadian</h3></div>
            <div class="space-y-4">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1.5">Judul Laporan <span class="text-red-500">*</span></label>
                    <input id="title" name="title" value="{{ old('title') }}" required maxlength="150" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Jalan depan pasar terendam">
                    @error('title')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="occurred_at" class="block text-sm font-medium text-gray-700 mb-1.5">Tanggal dan Waktu Kejadian <span class="text-red-500">*</span></label>
                    <input id="occurred_at" type="datetime-local" name="occurred_at" value="{{ old('occurred_at') }}" max="{{ now()->format('Y-m-d\TH:i') }}" required class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('occurred_at')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Deskripsi Kondisi Banjir <span class="text-red-500">*</span></label>
                    <textarea id="description" name="description" rows="4" required maxlength="5000" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y" placeholder="Jelaskan kondisi air, arus, dan situasi warga...">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="water_level_cm" class="block text-sm font-medium text-gray-700 mb-1.5">Perkiraan Ketinggian Air <span class="text-red-500">*</span></label>
                    <select id="water_level_cm" name="water_level_cm" required class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih perkiraan ketinggian</option>
                        @foreach([15 => 'Kurang dari 30 cm', 45 => '30–60 cm', 80 => '61–100 cm', 120 => 'Lebih dari 100 cm'] as $cm => $label)
                        <option value="{{ $cm }}" @selected((string) old('water_level_cm') === (string) $cm)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-400">Tingkat bahaya ditentukan otomatis dari perkiraan ini.</p>
                    @error('water_level_cm')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <fieldset>
                    <legend class="block text-sm font-medium text-gray-700 mb-2">Dampak Kejadian</legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 gap-x-4">
                        @foreach([
                            'rumah_terendam' => 'Rumah terendam',
                            'jalan_tergenang' => 'Jalan tergenang',
                            'fasilitas_umum' => 'Fasilitas umum terdampak',
                            'warga_terisolasi' => 'Warga terisolasi',
                            'kerusakan_harta_benda' => 'Kerusakan harta benda',
                        ] as $value => $label)
                        <label class="flex items-center gap-2 cursor-pointer text-sm text-gray-700">
                            <input type="checkbox" name="impacts[]" value="{{ $value }}" @checked(in_array($value, (array) old('impacts', []), true)) class="w-4 h-4 rounded border-gray-300 text-blue-600">
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                    @error('impacts.*')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </fieldset>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-5"><span class="section-letter">B</span><h3 class="text-base font-bold text-gray-900">Lokasi Banjir</h3></div>
            <div class="mb-3">
                <label for="village" class="block text-sm font-medium text-gray-700 mb-1.5">Gampong / Kelurahan <span class="text-red-500">*</span></label>
                <input id="village" name="village" value="{{ old('village') }}" required maxlength="100" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama gampong atau kelurahan">
                @error('village')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="border border-gray-200 rounded-xl overflow-hidden mb-2"><div id="report-map-db"></div></div>
            <p class="text-xs text-gray-500 mb-4">Klik peta untuk menandai titik kejadian. Lokasi peta wajib diisi.</p>
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
            <p id="location-status" class="text-xs text-gray-600 mb-3" aria-live="polite">
                @if(old('latitude') && old('longitude')) Titik lokasi sebelumnya dipilih. Klik peta untuk mengubahnya. @else Belum ada titik lokasi dipilih. @endif
            </p>
            @error('latitude')<p class="mb-1 text-xs text-red-600">{{ $message }}</p>@enderror
            @error('longitude')<p class="mb-3 text-xs text-red-600">{{ $message }}</p>@enderror
            <label for="address" class="block text-sm font-medium text-gray-700 mb-1.5">Detail Alamat Pendukung</label>
            <input id="address" name="address" value="{{ old('address') }}" maxlength="255" class="w-full border border-gray-200 rounded-lg px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama jalan, nomor rumah, atau patokan">
        </div>

        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-3 mb-5"><span class="section-letter">C</span><h3 class="text-base font-bold text-gray-900">Dokumentasi</h3></div>
            <label for="photos" class="block text-sm font-medium text-gray-700 mb-1.5">Foto kejadian (opsional)</label>
            <input id="photos" type="file" name="photos[]" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" multiple class="block w-full text-sm text-gray-700 file:mr-3 file:rounded-lg file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:font-semibold file:text-blue-700 hover:file:bg-blue-100">
            <p class="text-xs text-gray-400 mt-2">Format JPG, PNG, atau WEBP; maksimal 5 foto, 5 MB per foto. Foto hanya dapat dibuka petugas.</p>
            @error('photos')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            @error('photos.*')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
        </div>

        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/></svg>
            <p class="text-xs text-blue-800">Nama dan kontak akun hanya dapat dilihat petugas berwenang. Laporan baru belum terverifikasi dan tidak ditampilkan sebagai kejadian terkonfirmasi.</p>
        </div>
        <label class="flex items-start gap-2.5 cursor-pointer">
            <input type="checkbox" name="agreement" value="1" required @checked(old('agreement')) class="w-4 h-4 mt-0.5 rounded border-gray-300 text-blue-600 flex-shrink-0">
            <span class="text-sm text-gray-600">Saya menyatakan informasi ini benar sesuai pengetahuan saya dan menyetujui pemrosesan data untuk tanggap banjir.</span>
        </label>
        <div class="flex justify-end">
            <button type="submit" class="flex items-center gap-2 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl px-6 py-2.5 transition-colors shadow-sm">Kirim Laporan</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const latitude = document.getElementById('latitude');
    const longitude = document.getElementById('longitude');
    const status = document.getElementById('location-status');
    const map = L.map('report-map-db').setView([5.1801, 97.1500], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);
    L.control.zoom({ position: 'topright' }).addTo(map);
    let marker = null;

    function setLocation(latlng) {
        latitude.value = latlng.lat.toFixed(7);
        longitude.value = latlng.lng.toFixed(7);
        status.textContent = 'Titik dipilih: ' + latitude.value + ', ' + longitude.value;
        if (marker) marker.setLatLng(latlng);
        else {
            marker = L.marker(latlng, { draggable: true }).addTo(map);
            marker.on('dragend', function (event) { setLocation(event.target.getLatLng()); });
        }
    }

    map.on('click', function (event) { setLocation(event.latlng); });
    if (latitude.value && longitude.value) {
        const point = L.latLng(Number(latitude.value), Number(longitude.value));
        marker = L.marker(point, { draggable: true }).addTo(map);
        map.setView(point, 15);
        marker.on('dragend', function (event) { setLocation(event.target.getLatLng()); });
    }
});
</script>
@endpush

@extends('layouts.app')

@section('title', 'Laporkan Banjir — SIGAP Banjir Kota Lhokseumawe')

@push('styles')
<style>
    #report-map { height: 300px; border-radius: 12px; }
</style>
@endpush

@section('content')
<div class="bg-white border-b border-gray-100 py-6">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 mb-1">
            <span class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-red-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5.99L19.53 19H4.47L12 5.99M12 2L1 21h22L12 2zm1 14h-2v2h2v-2zm0-6h-2v4h2v-4z"/></svg>
            </span>
            <h1 class="text-2xl font-bold text-gray-900">Laporkan Kejadian Banjir</h1>
        </div>
        <p class="text-sm text-gray-500 ml-11">Tidak perlu masuk atau membuat akun. Laporan akan ditinjau petugas sebelum dinyatakan terverifikasi.</p>
    </div>
</div>

<div class="py-10 bg-gray-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        @if ($errors->any())
        <div role="alert" class="bg-red-50 border border-red-200 rounded-2xl p-4 mb-6 text-sm text-red-800">
            <p class="font-bold mb-1">Periksa kembali isian berikut:</p>
            <ul class="list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        <form method="POST" action="{{ route('lapor-banjir.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-base font-bold text-gray-900 mb-1 flex items-center gap-2"><span class="w-6 h-6 bg-blue-600 text-white rounded-full text-xs flex items-center justify-center">1</span>Lokasi Kejadian</h2>
                <p class="text-sm text-gray-500 ml-8 mb-4">Klik peta untuk memilih titik kejadian atau gunakan lokasi perangkat. Penanda peta menunjukkan lokasi yang akan dikirim.</p>
                <button type="button" id="locate-me" class="mb-3 rounded-lg border border-blue-200 px-3 py-2.5 text-sm font-medium text-blue-700 hover:bg-blue-50">Gunakan lokasi saya</button>
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                <div id="report-map" class="mb-4 border border-gray-200"></div>
                <p id="location-status" class="text-xs text-gray-500 mb-3" aria-live="polite">
                    {{ old('latitude') && old('longitude') ? 'Lokasi sebelumnya dipilih. Klik peta atau gunakan lokasi perangkat untuk mengubah.' : 'Lokasi belum dipilih. Klik peta atau gunakan lokasi perangkat.' }}
                </p>
                @error('latitude')<p class="text-sm text-red-600 mb-1">{{ $message }}</p>@enderror
                @error('longitude')<p class="text-sm text-red-600 mb-2">{{ $message }}</p>@enderror
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="village" class="block text-sm font-medium text-gray-700 mb-1">Kelurahan / Gampong <span class="text-red-500">*</span></label>
                        <input id="village" name="village" value="{{ old('village') }}" required maxlength="100" placeholder="Contoh: Mon Geudong" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('village')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Nama Jalan / Patokan</label>
                        <input id="address" name="address" value="{{ old('address') }}" maxlength="255" placeholder="Contoh: Jl. Perdagangan No. 5" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2"><span class="w-6 h-6 bg-blue-600 text-white rounded-full text-xs flex items-center justify-center">2</span>Detail Kondisi Banjir</h2>
                <div class="space-y-4">
                    <div>
                        <label for="occurred_at" class="block text-sm font-medium text-gray-700 mb-1">Tanggal dan waktu kejadian <span class="text-red-500">*</span></label>
                        <input id="occurred_at" type="datetime-local" name="occurred_at" value="{{ old('occurred_at', now()->format('Y-m-d\TH:i')) }}" max="{{ now()->format('Y-m-d\TH:i') }}" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('occurred_at')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <fieldset>
                        <legend class="block text-sm font-medium text-gray-700 mb-2">Tingkat bahaya (dihitung dari tinggi air)</legend>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="rounded-xl border-2 border-gray-200 p-3 text-center" data-danger="low"><input type="radio" disabled class="sr-only"><span class="text-xs font-semibold text-green-700">Rendah</span><span class="block text-xs text-gray-400">&le; 0,30 m</span></label>
                            <label class="rounded-xl border-2 border-gray-200 p-3 text-center" data-danger="medium"><input type="radio" disabled class="sr-only"><span class="text-xs font-semibold text-orange-700">Sedang</span><span class="block text-xs text-gray-400">0,31–0,60 m</span></label>
                            <label class="rounded-xl border-2 border-gray-200 p-3 text-center" data-danger="high"><input type="radio" disabled class="sr-only"><span class="text-xs font-semibold text-red-700">Tinggi</span><span class="block text-xs text-gray-400">&gt; 0,60 m</span></label>
                        </div>
                    </fieldset>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="water_level_m" class="block text-sm font-medium text-gray-700 mb-1">Perkiraan tinggi air <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input id="water_level_m" name="water_level_m" type="number" min="0.01" max="10" step="0.01" value="{{ old('water_level_m') }}" required placeholder="Contoh: 0.50" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 pr-12">
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-gray-400">meter</span>
                            </div>
                            @error('water_level_m')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="flow_condition" class="block text-sm font-medium text-gray-700 mb-1">Kondisi aliran air <span class="text-red-500">*</span></label>
                            <select id="flow_condition" name="flow_condition" required class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Pilih kondisi --</option>
                                @foreach(['stagnant' => 'Diam / Menggenang', 'slow' => 'Mengalir Lambat', 'fast' => 'Mengalir Deras', 'dangerous' => 'Sangat Deras / Berbahaya'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('flow_condition') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('flow_condition')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Keterangan kondisi <span class="text-red-500">*</span></label>
                        <textarea id="description" name="description" rows="3" required minlength="20" maxlength="5000" placeholder="Jelaskan kondisi banjir, dampak terhadap warga, dan infrastruktur yang terdampak." class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-y">{{ old('description') }}</textarea>
                        @error('description')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2"><span class="w-6 h-6 bg-blue-600 text-white rounded-full text-xs flex items-center justify-center">3</span>Foto dan Video Kejadian <span class="text-red-500">*</span></h2>
                <div class="space-y-4">
                    <div>
                        <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Foto kejadian <span class="text-red-500">wajib, 1 foto</span></label>
                        <input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required class="block w-full text-sm text-gray-700">
                        <p id="photo-status" class="text-xs text-gray-400 mt-1">Format JPG, PNG, atau WEBP · maksimal 5 MB.</p>
                        @error('photo')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="video" class="block text-sm font-medium text-gray-700 mb-2">Video kejadian <span class="text-red-500">wajib, 1 video MP4</span></label>
                        <input type="file" name="video" id="video" accept=".mp4,video/mp4" required class="block w-full text-sm text-gray-700">
                        <p id="video-status" class="text-xs text-gray-400 mt-1">Format MP4 · maksimal 50 MB.</p>
                        @error('video')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2"><span class="w-6 h-6 bg-blue-600 text-white rounded-full text-xs flex items-center justify-center">4</span>Informasi Pelapor</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="reporter_name" class="block text-sm font-medium text-gray-700 mb-1">Nama (Opsional)</label>
                        <input id="reporter_name" name="reporter_name" value="{{ old('reporter_name') }}" maxlength="150" autocomplete="name" placeholder="Nama Anda" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP <span class="text-red-500">*</span></label>
                        <input id="contact_phone" name="contact_phone" type="tel" value="{{ old('contact_phone') }}" required maxlength="30" autocomplete="tel" placeholder="08XXXXXXXXXX" class="w-full border border-gray-200 rounded-lg px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('contact_phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-3">Nomor HP hanya digunakan petugas untuk verifikasi dan dipakai bersama nomor laporan untuk mengecek status.</p>
            </div>

            <label class="flex items-start gap-2.5 cursor-pointer">
                <input type="checkbox" name="agreement" value="1" required @checked(old('agreement')) class="w-4 h-4 mt-0.5 rounded border-gray-300 text-blue-600">
                <span class="text-sm text-gray-600">Saya menyatakan informasi ini benar sesuai pengetahuan saya dan menyetujui pemrosesan data untuk tanggap banjir.</span>
            </label>
            @error('agreement')<p class="text-sm text-red-600">{{ $message }}</p>@enderror

            <div class="flex flex-col sm:flex-row gap-3">
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-6 rounded-xl transition-colors shadow-sm">Kirim Laporan Banjir</button>
                <a href="{{ route('home') }}" class="px-6 py-3.5 border border-gray-200 text-gray-600 font-semibold rounded-xl text-center hover:bg-gray-50">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const map = L.map('report-map').setView([5.1801, 97.1500], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18, attribution: '© OpenStreetMap contributors' }).addTo(map);
    const latitude = document.getElementById('latitude');
    const longitude = document.getElementById('longitude');
    const locationStatus = document.getElementById('location-status');
    let marker = null;

    function setLocation(point, updateMap) {
        latitude.value = point.lat.toFixed(7);
        longitude.value = point.lng.toFixed(7);
        locationStatus.textContent = 'Titik dipilih: ' + latitude.value + ', ' + longitude.value;
        if (marker) marker.setLatLng(point);
        else {
            marker = L.marker(point, { draggable: true }).addTo(map);
            marker.on('dragend', function (event) { setLocation(event.target.getLatLng(), true); });
        }
        if (updateMap) map.setView(point, Math.max(map.getZoom(), 15));
    }

    map.on('click', function (event) { setLocation(event.latlng, false); });
    if (latitude.value && longitude.value) {
        const point = L.latLng(Number(latitude.value), Number(longitude.value));
        marker = L.marker(point, { draggable: true }).addTo(map);
        marker.on('dragend', function (event) { setLocation(event.target.getLatLng(), true); });
        map.setView(point, 15);
    }

    document.getElementById('locate-me').addEventListener('click', function () {
        if (!navigator.geolocation) {
            locationStatus.textContent = 'Pelacakan lokasi tidak tersedia. Pilih titik kejadian dengan klik pada peta.';
            return;
        }
        locationStatus.textContent = 'Mencari lokasi perangkat...';
        navigator.geolocation.getCurrentPosition(function (position) {
            setLocation(L.latLng(position.coords.latitude, position.coords.longitude), true);
        }, function () {
            locationStatus.textContent = 'Lokasi tidak dapat diakses. Izinkan akses lokasi atau pilih titik dengan klik pada peta.';
        }, { enableHighAccuracy: true, timeout: 10000 });
    });

    const waterLevel = document.getElementById('water_level_m');
    waterLevel.addEventListener('input', function () {
        const level = Number(this.value);
        const danger = level <= 0.3 ? 'low' : (level <= 0.6 ? 'medium' : 'high');
        document.querySelectorAll('[data-danger]').forEach(function (item) {
            item.classList.remove('border-green-500', 'border-orange-500', 'border-red-500', 'bg-gray-50');
            if (item.dataset.danger === danger && waterLevel.value !== '') {
                item.classList.add(danger === 'low' ? 'border-green-500' : (danger === 'medium' ? 'border-orange-500' : 'border-red-500'), 'bg-gray-50');
            }
        });
    });
    waterLevel.dispatchEvent(new Event('input'));

    document.getElementById('photo').addEventListener('change', function () {
        document.getElementById('photo-status').textContent = this.files.length
            ? this.files[0].name + ' · ' + (this.files[0].size / 1024 / 1024).toFixed(2) + ' MB'
            : 'Format JPG, PNG, atau WEBP · maksimal 5 MB.';
    });
    document.getElementById('video').addEventListener('change', function () {
        document.getElementById('video-status').textContent = this.files.length
            ? this.files[0].name + ' · ' + (this.files[0].size / 1024 / 1024).toFixed(2) + ' MB'
            : 'Format MP4 · maksimal 50 MB.';
    });
});
</script>
@endpush

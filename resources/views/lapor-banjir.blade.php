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
                <p class="text-sm text-gray-500 ml-8 mb-4">Gunakan tombol di bawah untuk mendeteksi lokasi otomatis, atau klik langsung pada peta.</p>

                {{-- Locate button --}}
                <button type="button" id="locate-me"
                    class="mb-4 w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl border-2 border-blue-500 bg-blue-50 hover:bg-blue-100 px-4 py-3 text-sm font-semibold text-blue-700 transition-all">
                    <svg id="locate-icon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm8.94 3A8.994 8.994 0 0 0 13 3.06V1h-2v2.06A8.994 8.994 0 0 0 3.06 11H1v2h2.06A8.994 8.994 0 0 0 11 20.94V23h2v-2.06A8.994 8.994 0 0 0 20.94 13H23v-2h-2.06zM12 19c-3.87 0-7-3.13-7-7s3.13-7 7-7 7 3.13 7 7-3.13 7-7 7z"/>
                    </svg>
                    <svg id="locate-spinner" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 hidden animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48 2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48 2.83-2.83"/>
                    </svg>
                    <span id="locate-label">Gunakan Lokasi Saya Sekarang</span>
                </button>

                {{-- GPS status banner --}}
                <div id="gps-banner" class="hidden mb-4 rounded-xl px-4 py-3 text-sm font-medium flex items-center gap-2" aria-live="polite"></div>

                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                <div id="report-map" class="mb-3 border border-gray-200"></div>
                <p class="text-xs text-gray-400 mb-4">Penanda bisa digeser untuk menyesuaikan titik kejadian yang tepat.</p>
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
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    const latInput   = document.getElementById('latitude');
    const lngInput   = document.getElementById('longitude');
    const btn        = document.getElementById('locate-me');
    const btnLabel   = document.getElementById('locate-label');
    const icon       = document.getElementById('locate-icon');
    const spinner    = document.getElementById('locate-spinner');
    const banner     = document.getElementById('gps-banner');
    let marker = null;

    // ── helpers ──────────────────────────────────────────────────────────────

    function setMarker(latlng) {
        latInput.value = latlng.lat.toFixed(7);
        lngInput.value = latlng.lng.toFixed(7);
        if (marker) {
            marker.setLatLng(latlng);
        } else {
            marker = L.marker(latlng, { draggable: true }).addTo(map);
            marker.on('dragend', function (e) {
                const p = e.target.getLatLng();
                latInput.value = p.lat.toFixed(7);
                lngInput.value = p.lng.toFixed(7);
                showBanner('info', 'Penanda digeser. Mengisi alamat otomatis…');
                reverseGeocode(p);
            });
        }
    }

    function showBanner(type, msg) {
        const styles = {
            loading : 'bg-blue-50 border border-blue-200 text-blue-800',
            success : 'bg-green-50 border border-green-200 text-green-800',
            error   : 'bg-red-50 border border-red-200 text-red-800',
            info    : 'bg-gray-50 border border-gray-200 text-gray-700',
        };
        banner.className = 'mb-4 rounded-xl px-4 py-3 text-sm font-medium flex items-center gap-2 ' + (styles[type] || styles.info);
        banner.textContent = msg;
        banner.classList.remove('hidden');
    }

    function setBtnState(state) {
        if (state === 'loading') {
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');
            btnLabel.textContent = 'Mendeteksi lokasi…';
            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
        } else if (state === 'success') {
            icon.classList.remove('hidden');
            spinner.classList.add('hidden');
            btnLabel.textContent = 'Lokasi Terdeteksi ✓';
            btn.disabled = false;
            btn.classList.remove('opacity-70', 'cursor-not-allowed');
            btn.classList.replace('border-blue-500', 'border-green-500');
            btn.classList.replace('bg-blue-50', 'bg-green-50');
            btn.classList.replace('text-blue-700', 'text-green-700');
        } else {
            icon.classList.remove('hidden');
            spinner.classList.add('hidden');
            btnLabel.textContent = 'Coba Lagi';
            btn.disabled = false;
            btn.classList.remove('opacity-70', 'cursor-not-allowed');
        }
    }

    // ── reverse geocoding (Nominatim) ────────────────────────────────────────

    function reverseGeocode(latlng) {
        const url = 'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat='
            + latlng.lat + '&lon=' + latlng.lng + '&addressdetails=1&accept-language=id';

        fetch(url, { headers: { 'Accept-Language': 'id' } })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!data || !data.address) return;
                const a = data.address;

                // ── Kelurahan / Gampong ──────────────────────────────────────
                // Coba dari yang paling spesifik ke paling umum
                const village = a.village || a.suburb || a.neighbourhood
                    || a.quarter || a.town || a.city_district || '';

                // ── Nama Jalan / Patokan ─────────────────────────────────────
                const roadParts = [];
                if (a.road)        roadParts.push(a.road);
                if (a.house_number) roadParts.push('No. ' + a.house_number);
                const road = roadParts.join(' ');

                const villageInput  = document.getElementById('village');
                const addressInput  = document.getElementById('address');

                // Isi hanya jika field masih kosong (tidak timpa isian manual)
                if (village && !villageInput.value.trim()) {
                    villageInput.value = village;
                    villageInput.classList.add('ring-2', 'ring-green-400');
                    setTimeout(function () { villageInput.classList.remove('ring-2', 'ring-green-400'); }, 2000);
                }
                if (road && !addressInput.value.trim()) {
                    addressInput.value = road;
                    addressInput.classList.add('ring-2', 'ring-green-400');
                    setTimeout(function () { addressInput.classList.remove('ring-2', 'ring-green-400'); }, 2000);
                }
            })
            .catch(function () { /* geocoding gagal — biarkan saja, bukan error kritis */ });
    }

    // ── geolocation ──────────────────────────────────────────────────────────

    function requestLocation() {
        if (!navigator.geolocation) {
            showBanner('error', 'Browser ini tidak mendukung GPS. Silakan klik peta untuk memilih lokasi.');
            return;
        }

        setBtnState('loading');
        showBanner('loading', 'Sedang mendeteksi lokasi perangkat Anda…');

        navigator.geolocation.getCurrentPosition(
            function (pos) {
                const latlng = L.latLng(pos.coords.latitude, pos.coords.longitude);
                setMarker(latlng);
                map.setView(latlng, 17);

                const acc = pos.coords.accuracy ? Math.round(pos.coords.accuracy) : null;
                const accText = acc ? ' (akurasi ±' + acc + ' m)' : '';
                showBanner('success', 'Lokasi terdeteksi' + accText + '. Mengisi alamat otomatis…');
                setBtnState('success');

                reverseGeocode(latlng);
            },
            function (err) {
                const msg = {
                    1: 'Izin lokasi ditolak. Izinkan akses lokasi di pengaturan browser, lalu coba lagi.',
                    2: 'Lokasi tidak dapat ditentukan. Pastikan GPS aktif dan coba lagi.',
                    3: 'Waktu deteksi habis. Pastikan sinyal GPS tersedia dan coba lagi.',
                }[err.code] || 'Lokasi tidak dapat diakses. Silakan klik peta untuk memilih titik.';
                showBanner('error', msg);
                setBtnState('error');
            },
            { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
        );
    }

    // ── event listeners ──────────────────────────────────────────────────────

    btn.addEventListener('click', requestLocation);

    map.on('click', function (e) {
        setMarker(e.latlng);
        showBanner('info', 'Titik dipilih. Mengisi alamat otomatis…');
        reverseGeocode(e.latlng);
    });

    // restore old value after validation failure
    if (latInput.value && lngInput.value) {
        const p = L.latLng(Number(latInput.value), Number(lngInput.value));
        setMarker(p);
        map.setView(p, 16);
        showBanner('info', 'Lokasi sebelumnya dipulihkan. Klik atau geser penanda untuk mengubah.');
    } else {
        // auto-request on page load
        requestLocation();
    }

    // ── water level danger indicator ─────────────────────────────────────────

    const waterLevel = document.getElementById('water_level_m');
    waterLevel.addEventListener('input', function () {
        const level = Number(this.value);
        const danger = level <= 0.3 ? 'low' : (level <= 0.6 ? 'medium' : 'high');
        document.querySelectorAll('[data-danger]').forEach(function (item) {
            item.classList.remove('border-green-500', 'border-orange-500', 'border-red-500', 'bg-gray-50');
            if (item.dataset.danger === danger && waterLevel.value !== '') {
                const cls = danger === 'low' ? 'border-green-500' : (danger === 'medium' ? 'border-orange-500' : 'border-red-500');
                item.classList.add(cls, 'bg-gray-50');
            }
        });
    });
    waterLevel.dispatchEvent(new Event('input'));

    // ── file name preview ────────────────────────────────────────────────────

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

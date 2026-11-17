@extends('layouts.app')
@section('title', 'Permintaan Evakuasi — SIGAP Banjir')

@push('styles')
<style>#evak-map { height: 340px; }</style>
@endpush

@section('content')
<div class="bg-white border-b border-gray-100 py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900">Permintaan Evakuasi</h1>
        <p class="mt-1 text-sm text-gray-500">Ajukan bantuan penjemputan tanpa perlu masuk atau membuat akun.</p>
    </div>
</div>
<div class="bg-gray-50 py-8">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        @if ($errors->any())
        <div role="alert" class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
            <p class="mb-1 font-bold">Periksa kembali isian berikut:</p>
            <ul class="list-disc pl-5">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif
        <!-- <div class="mb-6 flex items-start gap-3 rounded-xl border border-yellow-200 bg-yellow-50 p-4">
            <span class="font-bold text-yellow-700">Perhatian</span>
            <p class="text-sm text-yellow-800">Prototipe ini bukan layanan darurat resmi dan pengiriman formulir tidak menjamin penjemputan langsung. Untuk kondisi yang mengancam jiwa, hubungi petugas melalui kanal darurat setempat.</p>
        </div> -->

        <form method="POST" action="{{ route('permintaan-evakuasi.store') }}" class="space-y-5">
            @csrf
            <div class="grid gap-5 lg:grid-cols-2">
                <div class="space-y-5">
                    <section class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                        <h2 class="mb-4 text-base font-bold text-gray-900">Informasi Pemohon</h2>
                        <div class="space-y-4">
                            <div>
                                <label for="requester_name" class="mb-1.5 block text-sm font-medium text-gray-700">Nama Pemohon <span class="text-red-500">*</span></label>
                                <input id="requester_name" name="requester_name" value="{{ old('requester_name') }}" required maxlength="150" autocomplete="name" class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('requester_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="contact_phone" class="mb-1.5 block text-sm font-medium text-gray-700">Nomor Kontak <span class="text-red-500">*</span></label>
                                <input id="contact_phone" name="contact_phone" type="tel" value="{{ old('contact_phone') }}" required maxlength="30" autocomplete="tel" placeholder="08XXXXXXXXXX" class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="mt-1 text-xs text-gray-400">Hanya terlihat petugas dan digunakan untuk mengecek status.</p>
                                @error('contact_phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="village" class="mb-1.5 block text-sm font-medium text-gray-700">Kelurahan / Gampong <span class="text-red-500">*</span></label>
                                <input id="village" name="village" value="{{ old('village') }}" required maxlength="100" placeholder="Nama kelurahan atau gampong" class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('village')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="pickup_address" class="mb-1.5 block text-sm font-medium text-gray-700">Lokasi Penjemputan / Patokan <span class="text-red-500">*</span></label>
                                <input id="pickup_address" name="pickup_address" value="{{ old('pickup_address') }}" required maxlength="255" placeholder="Contoh: rumah cat hijau dekat musala" class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('pickup_address')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="people_count" class="mb-1.5 block text-sm font-medium text-gray-700">Jumlah Warga <span class="text-red-500">*</span></label>
                                    <input id="people_count" name="people_count" type="number" min="1" max="500" value="{{ old('people_count', 1) }}" required class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('people_count')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="emergency_condition" class="mb-1.5 block text-sm font-medium text-gray-700">Kondisi Darurat</label>
                                    <input id="emergency_condition" name="emergency_condition" value="{{ old('emergency_condition') }}" maxlength="255" placeholder="Air masuk rumah" class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <fieldset>
                                <legend class="mb-2 block text-sm font-medium text-gray-700">Kelompok Rentan</legend>
                                <div class="grid grid-cols-2 gap-y-2 gap-x-4">
                                    @foreach(['lansia' => 'Lansia', 'ibu_hamil' => 'Ibu hamil', 'sakit' => 'Sakit / butuh perawatan', 'anak' => 'Anak-anak', 'disabilitas' => 'Penyandang disabilitas'] as $value => $label)
                                    <label class="flex cursor-pointer items-center gap-2 text-sm text-gray-700">
                                        <input type="checkbox" name="vulnerable_groups[]" value="{{ $value }}" @checked(in_array($value, (array) old('vulnerable_groups', []), true)) class="h-4 w-4 rounded border-gray-300 text-blue-600">
                                        {{ $label }}
                                    </label>
                                    @endforeach
                                </div>
                                @error('vulnerable_groups.*')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </fieldset>
                            <div>
                                <label for="additional_information" class="mb-1.5 block text-sm font-medium text-gray-700">Keterangan Tambahan</label>
                                <textarea id="additional_information" name="additional_information" rows="3" maxlength="2000" placeholder="Informasi lain yang perlu diketahui petugas" class="w-full resize-y rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('additional_information') }}</textarea>
                            </div>
                        </div>
                    </section>
                </div>

                <section class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
                    <label class="mb-2 block text-sm font-medium text-gray-700">Lokasi pada Peta <span class="text-red-500">*</span></label>
                    <div class="mb-3 flex gap-2">
                        <button id="locate-me" type="button" class="rounded-lg border border-blue-200 px-3 py-2 text-xs font-medium text-blue-700 hover:bg-blue-50">Gunakan lokasi saya</button>
                        <span id="location-status" class="self-center text-xs text-gray-500" aria-live="polite">
                            {{ old('latitude') && old('longitude') ? 'Titik sebelumnya dipilih; cek kembali.' : 'Pilih titik penjemputan pada peta.' }}
                        </span>
                    </div>
                    <div class="overflow-hidden rounded-xl border border-gray-200"><div id="evak-map"></div></div>
                    <p class="mt-2 text-xs text-gray-400">Klik peta untuk memilih titik. Anda dapat menggeser penanda untuk menyesuaikan.</p>
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
                    @error('latitude')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    @error('longitude')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </section>
            </div>

            <label class="flex cursor-pointer items-start gap-2.5">
                <input type="checkbox" name="agreement" value="1" required @checked(old('agreement')) class="mt-0.5 h-4 w-4 rounded border-gray-300 text-blue-600">
                <span class="text-sm text-gray-600">Saya menyatakan informasi ini benar dan memahami permintaan akan ditinjau petugas.</span>
            </label>
            @error('agreement')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            <button type="submit" class="w-full rounded-xl bg-blue-600 py-3.5 text-sm font-bold text-white shadow-sm transition-colors hover:bg-blue-700">Kirim Permintaan Evakuasi</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const latitude = document.getElementById('latitude');
    const longitude = document.getElementById('longitude');
    const status = document.getElementById('location-status');
    const map = L.map('evak-map', { zoomControl: false }).setView([5.1801, 97.1500], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);
    L.control.zoom({ position: 'topright' }).addTo(map);
    let marker = null;

    function setLocation(point) {
        latitude.value = point.lat.toFixed(7);
        longitude.value = point.lng.toFixed(7);
        status.textContent = 'Titik dipilih: ' + latitude.value + ', ' + longitude.value;
        if (marker) marker.setLatLng(point);
        else {
            marker = L.marker(point, { draggable: true }).addTo(map);
            marker.on('dragend', function (event) { setLocation(event.target.getLatLng()); });
        }
    }

    map.on('click', function (event) { setLocation(event.latlng); });
    if (latitude.value && longitude.value) {
        const point = L.latLng(Number(latitude.value), Number(longitude.value));
        marker = L.marker(point, { draggable: true }).addTo(map);
        marker.on('dragend', function (event) { setLocation(event.target.getLatLng()); });
        map.setView(point, 15);
    }
    document.getElementById('locate-me').addEventListener('click', function () {
        if (!navigator.geolocation) {
            status.textContent = 'Fitur lokasi tidak tersedia. Pilih titik dengan klik pada peta.';
            return;
        }
        status.textContent = 'Mencari lokasi perangkat...';
        navigator.geolocation.getCurrentPosition(function (position) {
            const point = L.latLng(position.coords.latitude, position.coords.longitude);
            map.setView(point, 16);
            setLocation(point);
        }, function () {
            status.textContent = 'Lokasi tidak dapat diakses. Pilih titik dengan klik pada peta.';
        }, { enableHighAccuracy: true, timeout: 10000 });
    });
});
</script>
@endpush

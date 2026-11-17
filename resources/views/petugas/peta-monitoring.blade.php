@extends('layouts.petugas')
@section('title', 'Peta Monitoring Banjir')

@push('styles')
<style>
    #mon-map { height: min(72vh, 720px); min-height: 480px; }
    #incident-map { height: 260px; }
    .dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; flex-shrink: 0; }
</style>
@endpush

@section('content')
@php
    $statusLabels = [
        'pending' => 'Menunggu Verifikasi',
        'needs_clarification' => 'Perlu Klarifikasi',
        'verified' => 'Terverifikasi',
        'in_progress' => 'Dalam Penanganan',
        'resolved' => 'Selesai',
    ];
    $statusClasses = [
        'pending' => 'bg-orange-50 text-orange-700',
        'needs_clarification' => 'bg-yellow-50 text-yellow-700',
        'verified' => 'bg-green-50 text-green-700',
        'in_progress' => 'bg-blue-50 text-blue-700',
        'resolved' => 'bg-gray-100 text-gray-700',
    ];
    $dangerLabels = ['high' => 'Bahaya Tinggi', 'medium' => 'Bahaya Sedang', 'low' => 'Bahaya Rendah'];
    $dangerClasses = [
        'high' => 'bg-red-100 text-red-700',
        'medium' => 'bg-orange-100 text-orange-700',
        'low' => 'bg-yellow-100 text-yellow-700',
    ];
@endphp

<div class="p-5">
    <div class="mb-4 flex flex-wrap items-start justify-between gap-3">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Peta Monitoring</h2>
            <p id="report-count" class="text-sm text-gray-500">{{ $reports->count() }} laporan berkoordinat. Titik berasal dari laporan banjir tersimpan.</p>
        </div>
        <button id="open-incident-modal" type="button" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2 text-xs font-bold text-white transition-colors hover:bg-blue-700">
            + Catat Kejadian
        </button>
    </div>

    @if (session('status'))
    <div role="status" class="mb-4 rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-800">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
    <div role="alert" class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
        <p class="mb-1 font-semibold">Periksa kembali isian kejadian:</p>
        @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
    @endif

    <div class="flex flex-col gap-4 xl:flex-row">
        <aside class="w-full flex-shrink-0 space-y-3 xl:w-72">
            <section class="max-h-72 overflow-y-auto rounded-xl border border-gray-100 bg-white shadow-sm">
                <div class="border-b border-gray-100 p-3">
                    <p class="text-xs font-bold text-gray-700">Laporan Banjir Terbaru</p>
                </div>
                <div id="report-list" class="p-2">
                    @forelse($reports->take(8) as $report)
                    <button type="button" data-report-id="{{ $report->id }}" class="report-list-item mb-2 block w-full rounded-lg border border-gray-100 p-2.5 text-left transition-colors hover:bg-blue-50">
                        <span class="flex items-center justify-between gap-2">
                            <span class="truncate text-xs font-semibold text-gray-900">{{ $report->village ?: 'Lokasi tidak disebutkan' }}</span>
                            <span class="shrink-0 rounded-full px-2 py-0.5 text-[10px] font-semibold {{ $dangerClasses[$report->danger_level] ?? 'bg-gray-100 text-gray-700' }}">{{ $dangerLabels[$report->danger_level] ?? 'Bahaya tidak diketahui' }}</span>
                        </span>
                        <span class="mt-1 block truncate text-xs text-gray-600">{{ $report->title }}</span>
                        <span class="mt-1 block text-[11px] text-gray-400">
                            {{ $report->occurred_at?->format('d M Y, H:i') }}
                            · {{ $statusLabels[$report->status] ?? $report->status }}
                        </span>
                    </button>
                    @empty
                    <p class="p-3 text-xs text-gray-500">Belum ada laporan banjir dengan titik lokasi.</p>
                    @endforelse
                </div>
            </section>

            <section class="space-y-4 rounded-xl border border-gray-100 bg-white p-3 shadow-sm">
                <div>
                    <label for="report-search" class="mb-2 block text-xs font-bold uppercase tracking-wide text-gray-500">Cari laporan</label>
                    <input id="report-search" type="search" placeholder="Nomor, lokasi, atau laporan..." class="w-full rounded-lg border border-gray-200 px-3 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-wide text-gray-500">Tingkat Bahaya</p>
                    @foreach($dangerLabels as $value => $label)
                    <label class="mb-1.5 flex cursor-pointer items-center gap-2">
                        <input type="checkbox" class="danger-filter h-3.5 w-3.5 rounded" value="{{ $value }}" checked>
                        <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $dangerClasses[$value] }}">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
                <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-wide text-gray-500">Status Laporan</p>
                    @foreach($statusLabels as $value => $label)
                    <label class="mb-1.5 flex cursor-pointer items-center gap-2">
                        <input type="checkbox" class="status-filter h-3.5 w-3.5 rounded" value="{{ $value }}" checked>
                        <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $statusClasses[$value] }}">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
                <div>
                    <label for="report-period" class="mb-2 block text-xs font-bold uppercase tracking-wide text-gray-500">Periode Kejadian</label>
                    <select id="report-period" class="w-full rounded-lg border border-gray-200 bg-white px-2 py-2 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="all">Semua tanggal</option>
                        <option value="1">24 jam terakhir</option>
                        <option value="7">7 hari terakhir</option>
                        <option value="30">30 hari terakhir</option>
                    </select>
                </div>
                <button id="reset-filters" type="button" class="text-xs font-semibold text-gray-500 hover:text-gray-800">Atur Ulang Filter</button>
            </section>
        </aside>

        <section class="relative min-w-0 flex-1 overflow-hidden rounded-xl border border-gray-200 bg-white">
            <div class="absolute left-3 top-3 z-[500] rounded-lg border border-blue-100 bg-white/95 px-3 py-1.5 text-xs font-medium text-blue-800 shadow-sm">
                Titik kejadian dari laporan banjir
            </div>
            <div class="absolute bottom-3 left-3 z-[500] rounded-xl border border-gray-200 bg-white/95 p-3 text-xs shadow-md">
                <p class="mb-2 font-bold text-gray-800">Legenda</p>
                <div class="space-y-1.5 text-gray-700">
                    <div class="flex items-center gap-2"><span class="dot bg-red-500"></span> Bahaya tinggi</div>
                    <div class="flex items-center gap-2"><span class="dot bg-orange-400"></span> Bahaya sedang</div>
                    <div class="flex items-center gap-2"><span class="dot bg-yellow-400"></span> Bahaya rendah</div>
                    <div class="flex items-center gap-2"><span class="h-3 w-3 rounded-full border-2 border-dashed border-blue-600"></span> Belum terverifikasi</div>
                </div>
            </div>
            <div id="mon-map"></div>
            <div id="empty-map" class="{{ $reports->isEmpty() ? '' : 'hidden' }} pointer-events-none absolute inset-0 z-[400] flex items-center justify-center bg-white/50">
                <p class="rounded-lg bg-white/95 px-4 py-3 text-sm text-gray-600 shadow">Belum ada laporan berkoordinat untuk ditampilkan.</p>
            </div>
        </section>
    </div>
</div>

<div id="incident-modal" class="{{ $errors->any() ? '' : 'hidden' }} fixed inset-0 z-[1000] flex items-center justify-center overflow-y-auto bg-black/50 p-4">
    <div role="dialog" aria-modal="true" aria-labelledby="incident-modal-title" class="my-auto w-full max-w-2xl rounded-2xl bg-white p-6 shadow-2xl">
        <div class="mb-4 flex items-center justify-between gap-3">
            <div>
                <h3 id="incident-modal-title" class="text-base font-bold text-gray-900">Catat Kejadian Banjir</h3>
                <p class="mt-1 text-xs text-gray-500">Kejadian yang dicatat petugas akan langsung berstatus terverifikasi.</p>
            </div>
            <button id="close-incident-modal" type="button" aria-label="Tutup form" class="rounded-lg p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-700">✕</button>
        </div>

        <form id="incident-form" method="POST" action="{{ route('petugas.peta-monitoring.store') }}" class="space-y-4">
            @csrf
            <div>
                <label for="incident-title" class="mb-1 block text-sm font-medium text-gray-700">Judul kejadian *</label>
                <input id="incident-title" name="title" value="{{ old('title') }}" required minlength="8" maxlength="150" class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Genangan di simpang pasar">
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label for="incident-village" class="mb-1 block text-sm font-medium text-gray-700">Kelurahan / Gampong *</label>
                    <input id="incident-village" name="village" value="{{ old('village') }}" required maxlength="100" class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama kelurahan / gampong">
                </div>
                <div>
                    <label for="incident-address" class="mb-1 block text-sm font-medium text-gray-700">Alamat / patokan</label>
                    <input id="incident-address" name="address" value="{{ old('address') }}" maxlength="255" class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama jalan atau patokan">
                </div>
            </div>

            <div class="grid gap-3 sm:grid-cols-2">
                <div>
                    <label for="incident-occurred-at" class="mb-1 block text-sm font-medium text-gray-700">Waktu kejadian *</label>
                    <input id="incident-occurred-at" name="occurred_at" type="datetime-local" value="{{ old('occurred_at', now()->format('Y-m-d\TH:i')) }}" required class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="incident-water-level" class="mb-1 block text-sm font-medium text-gray-700">Perkiraan tinggi air *</label>
                    <div class="flex items-center gap-2">
                        <input id="incident-water-level" name="water_level_m" type="number" value="{{ old('water_level_m') }}" min="0.01" max="10" step="0.01" required class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0.50">
                        <span class="text-sm text-gray-500">meter</span>
                    </div>
                </div>
            </div>

            <div>
                <label for="incident-flow-condition" class="mb-1 block text-sm font-medium text-gray-700">Kondisi aliran air *</label>
                <select id="incident-flow-condition" name="flow_condition" required class="w-full rounded-lg border border-gray-200 bg-white px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Pilih kondisi aliran</option>
                    <option value="stagnant" @selected(old('flow_condition') === 'stagnant')>Diam / menggenang</option>
                    <option value="slow" @selected(old('flow_condition') === 'slow')>Mengalir lambat</option>
                    <option value="fast" @selected(old('flow_condition') === 'fast')>Mengalir deras</option>
                    <option value="dangerous" @selected(old('flow_condition') === 'dangerous')>Sangat deras / berbahaya</option>
                </select>
            </div>

            <div>
                <label for="incident-description" class="mb-1 block text-sm font-medium text-gray-700">Deskripsi kejadian *</label>
                <textarea id="incident-description" name="description" rows="3" required minlength="20" maxlength="5000" class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Jelaskan kondisi, dampak, dan situasi terkini.">{{ old('description') }}</textarea>
            </div>

            <div>
                <p class="mb-1 text-sm font-medium text-gray-700">Titik lokasi kejadian *</p>
                <p class="mb-2 text-xs text-gray-500">Klik peta untuk memilih titik. Koordinat akan terisi otomatis.</p>
                <div id="incident-map" class="rounded-xl border border-gray-200"></div>
                <input id="incident-latitude" name="latitude" type="hidden" value="{{ old('latitude') }}">
                <input id="incident-longitude" name="longitude" type="hidden" value="{{ old('longitude') }}">
                <p id="incident-coordinate-summary" class="mt-2 text-xs text-gray-500">
                    @if(old('latitude') !== null && old('longitude') !== null)
                    Titik dipilih: {{ old('latitude') }}, {{ old('longitude') }}
                    @else
                    Belum ada titik dipilih.
                    @endif
                </p>
                <p id="incident-coordinate-error" class="mt-1 hidden text-xs font-semibold text-red-600">Pilih titik lokasi pada peta sebelum menyimpan.</p>
            </div>

            <div class="flex flex-col-reverse gap-2 pt-1 sm:flex-row sm:justify-end">
                <button id="cancel-incident-modal" type="button" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50">Batal</button>
                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-blue-700">Simpan Kejadian</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const floodReports = @js($mapReports);
const reportStatusLabels = @js($statusLabels);
const reportDangerLabels = @js($dangerLabels);
const verificationQueueUrl = @js(route('petugas.verifikasi-laporan', ['status' => 'all']));

const monitoringMap = L.map('mon-map', { zoomControl: false }).setView([5.1801, 97.1500], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(monitoringMap);
L.control.zoom({ position: 'topright' }).addTo(monitoringMap);

const markerById = new Map();
const markerEntries = floodReports.map((report) => {
    const dangerColor = { high: '#dc2626', medium: '#f97316', low: '#eab308' }[report.danger_level] || '#6b7280';
    const needsReview = ['pending', 'needs_clarification'].includes(report.status);
    const marker = L.circleMarker([report.latitude, report.longitude], {
        radius: 9,
        fillColor: dangerColor,
        color: needsReview ? '#2563eb' : dangerColor,
        weight: needsReview ? 3 : 2,
        fillOpacity: 0.8,
        dashArray: needsReview ? '5 4' : null,
    }).bindPopup(createReportPopup(report));

    markerById.set(String(report.id), marker);
    return { report, marker };
});

function createReportPopup(report) {
    const container = document.createElement('div');
    const title = document.createElement('strong');
    title.textContent = report.title;
    container.appendChild(title);

    const details = document.createElement('p');
    const date = report.occurred_at
        ? new Date(report.occurred_at).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' })
        : 'Waktu tidak dicantumkan';
    const level = report.water_level_cm === null
        ? 'Tinggi air tidak dicantumkan'
        : `Tinggi air ${Number(report.water_level_cm / 100).toLocaleString('id-ID', { maximumFractionDigits: 2 })} m`;
    details.textContent = `${report.report_number} · ${report.village || 'Lokasi tidak disebutkan'} · ${reportDangerLabels[report.danger_level] || report.danger_level} · ${reportStatusLabels[report.status] || report.status} · ${level} · ${date}`;
    container.appendChild(details);

    const link = document.createElement('a');
    link.href = `${verificationQueueUrl}&search=${encodeURIComponent(report.report_number)}`;
    link.textContent = 'Buka data laporan';
    link.className = 'mt-2 inline-block font-semibold text-blue-700';
    container.appendChild(link);

    return container;
}

if (markerEntries.length) {
    const bounds = L.latLngBounds(markerEntries.map(({ report }) => [report.latitude, report.longitude]));
    monitoringMap.fitBounds(bounds, { padding: [35, 35], maxZoom: 14 });
}

function applyReportFilters() {
    const search = document.getElementById('report-search').value.trim().toLocaleLowerCase('id-ID');
    const selectedStatuses = new Set(Array.from(document.querySelectorAll('.status-filter:checked'), (input) => input.value));
    const selectedDangers = new Set(Array.from(document.querySelectorAll('.danger-filter:checked'), (input) => input.value));
    const period = document.getElementById('report-period').value;
    const cutoff = period === 'all' ? null : Date.now() - Number(period) * 24 * 60 * 60 * 1000;
    let visibleCount = 0;

    markerEntries.forEach(({ report, marker }) => {
        const searchableText = `${report.report_number} ${report.title} ${report.village || ''}`.toLocaleLowerCase('id-ID');
        const reportTime = report.occurred_at ? new Date(report.occurred_at).getTime() : 0;
        const matches = selectedStatuses.has(report.status)
            && selectedDangers.has(report.danger_level)
            && searchableText.includes(search)
            && (cutoff === null || reportTime >= cutoff);

        if (matches) {
            if (!monitoringMap.hasLayer(marker)) marker.addTo(monitoringMap);
            visibleCount++;
        } else if (monitoringMap.hasLayer(marker)) {
            monitoringMap.removeLayer(marker);
        }
    });

    document.querySelectorAll('.report-list-item').forEach((item) => {
        const marker = markerById.get(item.dataset.reportId);
        item.classList.toggle('hidden', !marker || !monitoringMap.hasLayer(marker));
    });
    document.getElementById('report-count').textContent = `${visibleCount} laporan sesuai filter. Titik berasal dari laporan banjir tersimpan.`;
    document.getElementById('empty-map').classList.toggle('hidden', visibleCount > 0);
}

document.getElementById('report-search').addEventListener('input', applyReportFilters);
document.querySelectorAll('.status-filter, .danger-filter').forEach((input) => input.addEventListener('change', applyReportFilters));
document.getElementById('report-period').addEventListener('change', applyReportFilters);
document.getElementById('reset-filters').addEventListener('click', () => {
    document.getElementById('report-search').value = '';
    document.getElementById('report-period').value = 'all';
    document.querySelectorAll('.status-filter, .danger-filter').forEach((input) => { input.checked = true; });
    applyReportFilters();
});
document.querySelectorAll('.report-list-item').forEach((item) => {
    item.addEventListener('click', () => {
        const marker = markerById.get(item.dataset.reportId);
        if (!marker || !monitoringMap.hasLayer(marker)) return;
        monitoringMap.setView(marker.getLatLng(), 16);
        marker.openPopup();
    });
});
applyReportFilters();

let incidentMap = null;
let incidentMarker = null;
const incidentModal = document.getElementById('incident-modal');
const latitudeInput = document.getElementById('incident-latitude');
const longitudeInput = document.getElementById('incident-longitude');

function setIncidentLocation(latitude, longitude) {
    latitudeInput.value = Number(latitude).toFixed(7);
    longitudeInput.value = Number(longitude).toFixed(7);
    document.getElementById('incident-coordinate-summary').textContent = `Titik dipilih: ${latitudeInput.value}, ${longitudeInput.value}`;
    document.getElementById('incident-coordinate-error').classList.add('hidden');

    const location = [Number(latitude), Number(longitude)];
    if (incidentMarker) incidentMarker.setLatLng(location);
    else incidentMarker = L.marker(location).addTo(incidentMap);
}

function openIncidentModal() {
    incidentModal.classList.remove('hidden');
    requestAnimationFrame(() => {
        if (!incidentMap) {
            incidentMap = L.map('incident-map', { zoomControl: true }).setView([5.1801, 97.1500], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(incidentMap);
            incidentMap.on('click', (event) => setIncidentLocation(event.latlng.lat, event.latlng.lng));

            const oldLatitude = Number(latitudeInput.value);
            const oldLongitude = Number(longitudeInput.value);
            if (latitudeInput.value && longitudeInput.value) {
                setIncidentLocation(oldLatitude, oldLongitude);
                incidentMap.setView([oldLatitude, oldLongitude], 15);
            }
        }
        incidentMap.invalidateSize();
    });
}

function closeIncidentModal() {
    incidentModal.classList.add('hidden');
}

document.getElementById('open-incident-modal').addEventListener('click', openIncidentModal);
document.getElementById('close-incident-modal').addEventListener('click', closeIncidentModal);
document.getElementById('cancel-incident-modal').addEventListener('click', closeIncidentModal);
incidentModal.addEventListener('click', (event) => {
    if (event.target === incidentModal) closeIncidentModal();
});
document.getElementById('incident-form').addEventListener('submit', (event) => {
    if (!latitudeInput.value || !longitudeInput.value) {
        event.preventDefault();
        document.getElementById('incident-coordinate-error').classList.remove('hidden');
    }
});

@if($errors->any())
openIncidentModal();
@endif
</script>
@endpush

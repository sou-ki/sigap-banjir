@extends('layouts.admin')
@section('title', 'Pengaturan Sistem')

@section('content')
<div class="p-6 max-w-lg">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Pengaturan Sistem</h2>
        <p class="text-sm text-gray-500">Konfigurasi umum prototipe.</p>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nama Sistem</label>
            <input type="text" value="SIGAP BANJIR"
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Wilayah Layanan</label>
            <input type="text" value="Kota Lhokseumawe"
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Batas Waktu Sesi (menit)</label>
            <input type="number" value="30"
                   class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <div class="border-t border-gray-100 pt-4 space-y-3">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-blue-600">
                <span class="text-sm text-gray-700">Wajibkan verifikasi petugas sebelum laporan tampil di peta</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-blue-600">
                <span class="text-sm text-gray-700">Notifikasi dalam aplikasi</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-blue-600">
                <span class="text-sm text-gray-700">Notifikasi email (simulasi)</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600">
                <span class="text-sm text-gray-700">Mode pemeliharaan</span>
            </label>
        </div>

        {{-- Saved banner --}}
        <div id="saved-banner" class="hidden bg-green-50 border border-green-200 rounded-xl p-3 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600 flex-shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
            <p class="text-sm font-semibold text-green-800">Pengaturan berhasil disimpan.</p>
        </div>

        <button onclick="savePengaturan()"
                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-6 py-2.5 rounded-xl transition-colors shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
            Simpan Pengaturan
        </button>
    </div>
</div>
@endsection

@push('scripts')
<script>
function savePengaturan() {
    const b = document.getElementById('saved-banner');
    b.classList.remove('hidden');
    setTimeout(() => b.classList.add('hidden'), 3000);
}
</script>
@endpush

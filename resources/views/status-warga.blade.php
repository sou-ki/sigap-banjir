@extends('layouts.app')
@section('title', 'Cek Status Laporan — SIGAP Banjir')

@section('content')
<div class="bg-gray-50 py-10">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        @if (session('submitted_reference'))
        <div role="status" class="mb-6 rounded-xl border border-green-200 bg-green-50 p-5 text-green-900">
            <p class="font-bold">Pengiriman berhasil diterima</p>
            <p class="mt-1 text-sm">Simpan nomor referensi ini untuk mengecek status:</p>
            <p class="mt-2 font-mono text-lg font-bold">{{ session('submitted_reference') }}</p>
            <p class="mt-2 text-xs">Masukkan nomor referensi dan nomor HP yang dicantumkan pada formulir. Data baru berstatus menunggu petugas.</p>
        </div>
        @endif

        <section class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm sm:p-8">
            <h1 class="text-2xl font-bold text-gray-900">Cek Status Pengajuan</h1>
            <p class="mt-2 text-sm text-gray-500">Masukkan nomor referensi dan nomor HP yang digunakan saat mengirim laporan banjir atau permintaan evakuasi.</p>

            @if ($errors->has('lookup'))
            <div role="alert" class="mt-5 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-800">{{ $errors->first('lookup') }}</div>
            @endif
            @if ($errors->any() && !$errors->has('lookup'))
            <div role="alert" class="mt-5 rounded-lg border border-red-200 bg-red-50 p-3 text-sm text-red-800">
                @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
            </div>
            @endif

            <form method="POST" action="{{ route('status-warga') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="type" class="mb-1.5 block text-sm font-medium text-gray-700">Jenis pengajuan</label>
                    <select id="type" name="type" required class="w-full rounded-lg border border-gray-200 bg-white px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="flood_report" @selected(old('type', $type) === 'flood_report')>Laporan banjir</option>
                        <option value="evacuation_request" @selected(old('type', $type) === 'evacuation_request')>Permintaan evakuasi</option>
                    </select>
                </div>
                <div>
                    <label for="reference" class="mb-1.5 block text-sm font-medium text-gray-700">Nomor referensi</label>
                    <input id="reference" name="reference" value="{{ old('reference', $reference) }}" required maxlength="40" autocomplete="off" class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label for="contact_phone" class="mb-1.5 block text-sm font-medium text-gray-700">Nomor HP yang didaftarkan</label>
                    <input id="contact_phone" name="contact_phone" type="tel" value="{{ old('contact_phone') }}" required maxlength="30" autocomplete="tel" placeholder="08XXXXXXXXXX" class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button class="w-full rounded-lg bg-blue-600 px-4 py-3 text-sm font-bold text-white hover:bg-blue-700">Cek Status</button>
            </form>

            @if($result)
            @php
                $labels = [
                    'pending' => 'Menunggu verifikasi petugas',
                    'needs_clarification' => 'Petugas meminta klarifikasi',
                    'verified' => 'Terverifikasi',
                    'rejected' => 'Ditolak',
                    'in_progress' => 'Sedang ditangani',
                    'resolved' => 'Selesai',
                    'accepted' => 'Permintaan diterima petugas',
                    'completed' => 'Evakuasi selesai',
                    'cancelled' => 'Permintaan dibatalkan',
                ];
            @endphp
            <div class="mt-6 rounded-xl border border-blue-100 bg-blue-50 p-4" aria-live="polite">
                <p class="text-xs font-semibold uppercase tracking-wide text-blue-700">{{ $result['reference'] }}</p>
                <p class="mt-1 font-bold text-gray-900">{{ $result['title'] }}</p>
                <p class="mt-1 text-sm text-gray-700">Status: {{ $labels[$result['status']] ?? $result['status'] }}</p>
                <p class="mt-1 text-xs text-gray-500">Lokasi: {{ $result['location'] ?: 'Tidak dicantumkan' }} · Diperbarui {{ $result['updated_at']->format('d M Y H:i') }}</p>
                @if(!empty($result['note']))
                <div class="mt-3 rounded-lg border border-blue-100 bg-white p-3">
                    <p class="text-xs font-semibold text-blue-800">Catatan petugas</p>
                    <p class="mt-1 whitespace-pre-line text-sm text-gray-700">{{ $result['note'] }}</p>
                </div>
                @endif
            </div>
            @endif
        </section>
    </div>
</div>
@endsection

@extends('layouts.dashboard')
@section('title', 'Laporan Saya')

@section('content')
<div class="p-6">
    <div class="flex items-start justify-between mb-5 flex-wrap gap-3">
        <div>
            <h2 class="text-xl font-extrabold text-gray-900">Laporan Saya</h2>
            <p class="text-sm text-gray-500 mt-0.5">Hanya laporan yang Anda kirim yang ditampilkan di halaman ini.</p>
        </div>
        <a href="{{ route('dashboard.laporan-banjir') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg shadow-sm">Laporan Baru</a>
    </div>

    @if (session('status'))
    <div role="status" class="mb-4 bg-green-50 border border-green-200 rounded-xl p-4 text-sm font-semibold text-green-800">{{ session('status') }}</div>
    @endif

    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
        <form method="GET" action="{{ route('dashboard.laporan-saya') }}" class="flex items-center gap-3 p-4 border-b border-gray-100 flex-wrap">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nomor, judul, atau lokasi..." class="flex-1 min-w-48 border border-gray-200 rounded-lg px-3.5 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="status" class="border border-gray-200 rounded-lg px-3.5 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua status</option>
                @foreach(['pending' => 'Menunggu Verifikasi', 'verified' => 'Terverifikasi', 'needs_clarification' => 'Perlu Klarifikasi', 'rejected' => 'Ditolak', 'in_progress' => 'Dalam Penanganan', 'resolved' => 'Selesai'] as $value => $label)
                <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white">Cari</button>
        </form>

        @if($reports->isEmpty())
        <div class="py-16 text-center">
            <p class="text-base font-bold text-gray-700">{{ request()->hasAny(['search', 'status']) ? 'Tidak ada laporan yang cocok' : 'Belum ada laporan' }}</p>
            <p class="text-sm text-gray-400 mt-1 mb-5">Laporan yang Anda kirim akan muncul di sini beserta statusnya.</p>
            <a href="{{ route('dashboard.laporan-banjir') }}" class="inline-flex bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg">Laporkan Banjir</a>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left">
                <thead class="bg-gray-50 text-xs font-bold uppercase tracking-wide text-gray-500">
                    <tr><th class="px-4 py-3">Nomor / Judul</th><th class="px-4 py-3">Waktu</th><th class="px-4 py-3">Lokasi</th><th class="px-4 py-3">Air</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Catatan Petugas</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($reports as $report)
                    @php
                        $statusLabels = ['pending' => 'Menunggu Verifikasi', 'verified' => 'Terverifikasi', 'needs_clarification' => 'Perlu Klarifikasi', 'rejected' => 'Ditolak', 'in_progress' => 'Dalam Penanganan', 'resolved' => 'Selesai'];
                        $statusColors = ['pending' => 'bg-amber-100 text-amber-800', 'verified' => 'bg-green-100 text-green-800', 'needs_clarification' => 'bg-yellow-100 text-yellow-800', 'rejected' => 'bg-red-100 text-red-800', 'in_progress' => 'bg-blue-100 text-blue-800', 'resolved' => 'bg-gray-100 text-gray-700'];
                    @endphp
                    <tr class="text-sm align-top">
                        <td class="px-4 py-3"><p class="font-mono text-xs font-semibold text-blue-700">{{ $report->report_number }}</p><p class="mt-1 font-semibold text-gray-800">{{ $report->title }}</p></td>
                        <td class="px-4 py-3 text-gray-600">{{ $report->occurred_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3 text-gray-700">{{ $report->village }}@if($report->address)<p class="text-xs text-gray-500">{{ $report->address }}</p>@endif</td>
                        <td class="px-4 py-3 text-gray-700">{{ $report->water_level_cm }} cm</td>
                        <td class="px-4 py-3"><span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusColors[$report->status] ?? 'bg-gray-100 text-gray-700' }}">{{ $statusLabels[$report->status] ?? $report->status }}</span></td>
                        <td class="px-4 py-3 text-xs text-gray-600">{{ $report->verification_note ?: '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="border-t border-gray-100 px-4 py-3">{{ $reports->links() }}</div>
        @endif
    </div>
</div>
@endsection

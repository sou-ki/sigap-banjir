@extends('layouts.petugas')
@section('title', 'Permintaan Evakuasi')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Permintaan Evakuasi</h2>
        <p class="text-sm text-gray-500">Tinjau dan perbarui permintaan warga. Informasi kontak hanya tersedia untuk petugas.</p>
    </div>

    @if (session('status'))
    <div role="status" class="mb-4 rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-800">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
    <div role="alert" class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">@foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>
    @endif

    @php
        $statusLabels = ['pending' => 'Menunggu', 'accepted' => 'Diterima', 'in_progress' => 'Dalam Penanganan', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
        $priorityLabels = ['urgent' => 'Darurat', 'high' => 'Tinggi', 'medium' => 'Sedang', 'low' => 'Rendah'];
        $groupLabels = ['lansia' => 'Lansia', 'ibu_hamil' => 'Ibu hamil', 'sakit' => 'Sakit / butuh perawatan', 'anak' => 'Anak-anak', 'disabilitas' => 'Penyandang disabilitas'];
    @endphp
    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <div class="flex flex-wrap gap-1">
            @foreach(['pending' => 'Menunggu', 'accepted' => 'Diterima', 'in_progress' => 'Dalam Penanganan', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan', 'all' => 'Semua'] as $value => $label)
            <a href="{{ route('petugas.permintaan-evakuasi', ['status' => $value]) }}" class="rounded-lg px-3 py-1.5 text-xs font-semibold {{ $status === $value ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ $label }} ({{ $value === 'all' ? $counts->sum() : ($counts[$value] ?? 0) }})
            </a>
            @endforeach
        </div>
        <form method="GET" action="{{ route('petugas.permintaan-evakuasi') }}" class="flex gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari referensi, pemohon, lokasi..." class="w-64 max-w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Cari</button>
        </form>
    </div>

    <div class="space-y-4">
        @forelse($requests as $item)
        <article class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="font-mono text-xs font-bold text-blue-700">{{ $item->request_number }}</p>
                    <h3 class="mt-1 text-lg font-bold text-gray-900">{{ $item->requester_name }} · {{ $item->people_count }} orang</h3>
                    <p class="mt-1 text-xs text-gray-500">Dikirim {{ $item->created_at->format('d M Y H:i') }} · {{ $item->village }}</p>
                </div>
                <div class="flex gap-2">
                    <span class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">{{ $priorityLabels[$item->priority] ?? $item->priority }}</span>
                    <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">{{ $statusLabels[$item->status] ?? $item->status }}</span>
                </div>
            </div>
            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div class="space-y-2 text-sm">
                    <p><span class="text-xs text-gray-400">Kontak pemohon:</span> <a href="tel:{{ $item->contact_phone }}" class="font-semibold text-blue-700">{{ $item->contact_phone }}</a></p>
                    <p><span class="text-xs text-gray-400">Lokasi jemput:</span> {{ $item->pickup_address }}, {{ $item->village }}</p>
                    <p><span class="text-xs text-gray-400">Koordinat:</span> {{ $item->latitude }}, {{ $item->longitude }}</p>
                    @if($item->emergency_condition)<p><span class="text-xs text-gray-400">Kondisi:</span> {{ $item->emergency_condition }}</p>@endif
                    @if($item->vulnerable_groups)
                    <p><span class="text-xs text-gray-400">Kelompok rentan:</span> {{ collect($item->vulnerable_groups)->map(fn ($group) => $groupLabels[$group] ?? $group)->join(', ') }}</p>
                    @endif
                    @if($item->additional_information)<p class="whitespace-pre-line"><span class="text-xs text-gray-400">Keterangan:</span> {{ $item->additional_information }}</p>@endif
                    @if($item->shelter)<p><span class="text-xs text-gray-400">Pengungsian tujuan:</span> {{ $item->shelter->name }}</p>@endif
                    @if($item->public_note)<p class="whitespace-pre-line rounded-lg bg-blue-50 p-3 text-blue-900"><span class="font-semibold">Catatan untuk pemohon:</span> {{ $item->public_note }}</p>@endif
                    <div class="rounded-lg border border-gray-100 p-3">
                        <p class="mb-2 text-xs font-semibold text-gray-500">Riwayat penanganan</p>
                        <ol class="space-y-2">
                            @php
                                $activityLabels = ['submitted' => 'Permintaan dikirim', 'accepted' => 'Permintaan diterima', 'in_progress' => 'Penanganan dimulai', 'completed' => 'Evakuasi selesai', 'cancelled' => 'Permintaan dibatalkan'];
                            @endphp
                            @forelse($item->activityLogs as $log)
                            <li class="text-xs text-gray-600">
                                <span class="font-semibold">{{ $activityLabels[$log->action] ?? $log->action }}</span>
                                · {{ $log->user?->name ?? 'Warga' }}
                                · {{ $log->created_at?->format('d M Y H:i') }}
                                @if(data_get($log->properties, 'public_note'))
                                <p class="mt-1 whitespace-pre-line">{{ data_get($log->properties, 'public_note') }}</p>
                                @endif
                            </li>
                            @empty
                            <li class="text-xs text-gray-400">Belum ada riwayat.</li>
                            @endforelse
                        </ol>
                    </div>
                </div>
                @php
                    $nextStatuses = [
                        'pending' => ['accepted' => 'Terima permintaan', 'cancelled' => 'Batalkan'],
                        'accepted' => ['in_progress' => 'Mulai penanganan', 'cancelled' => 'Batalkan'],
                        'in_progress' => ['completed' => 'Tandai selesai', 'cancelled' => 'Batalkan'],
                        'completed' => [],
                        'cancelled' => [],
                    ];
                @endphp
                @if(count($nextStatuses[$item->status] ?? []))
                <form method="POST" action="{{ route('petugas.permintaan-evakuasi.update', $item) }}" class="self-start rounded-xl bg-gray-50 p-4">
                    @csrf
                    @method('PATCH')
                    <label for="status-{{ $item->id }}" class="mb-2 block text-xs font-semibold text-gray-600">Perbarui status</label>
                    <select id="status-{{ $item->id }}" name="status" required class="mb-3 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm">
                        @foreach($nextStatuses[$item->status] as $value => $label)<option value="{{ $value }}">{{ $label }}</option>@endforeach
                    </select>
                    <label for="note-{{ $item->id }}" class="mb-1 block text-xs font-semibold text-gray-600">Catatan untuk pemohon</label>
                    <textarea id="note-{{ $item->id }}" name="public_note" rows="3" maxlength="2000" class="mb-1 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm" placeholder="Catatan akan terlihat saat pemohon mengecek status"></textarea>
                    <p class="mb-3 text-xs text-gray-500">Wajib diisi jika permintaan dibatalkan.</p>
                    <button class="w-full rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-blue-700">Simpan</button>
                </form>
                @else
                <p class="self-start rounded-xl bg-gray-50 p-4 text-sm text-gray-600">Permintaan ini sudah ditutup.</p>
                @endif
            </div>
        </article>
        @empty
        <div class="rounded-xl border border-gray-100 bg-white py-16 text-center shadow-sm">
            <p class="font-bold text-gray-700">Tidak ada permintaan untuk ditampilkan</p>
            <p class="mt-1 text-sm text-gray-400">Permintaan baru dari warga akan muncul di antrean.</p>
        </div>
        @endforelse
    </div>
    @if($requests->hasPages())<div class="mt-4">{{ $requests->links() }}</div>@endif
</div>
@endsection

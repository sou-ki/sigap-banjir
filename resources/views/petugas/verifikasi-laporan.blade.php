@extends('layouts.petugas')
@section('title', 'Verifikasi Laporan')

@section('content')
<div class="p-5">
    <div class="mb-5">
        <h2 class="text-xl font-extrabold text-gray-900">Verifikasi Laporan</h2>
        <p class="text-sm text-gray-500">Tinjau laporan baru dan tindak lanjuti laporan yang sebelumnya diminta klarifikasi.</p>
    </div>

    @if (session('status'))
    <div role="status" class="mb-4 rounded-xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-800">{{ session('status') }}</div>
    @endif
    @if ($errors->any())
    <div role="alert" class="mb-4 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
        @foreach ($errors->all() as $error)<p>{{ $error }}</p>@endforeach
    </div>
    @endif

    <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
        <div class="flex gap-2">
            <a href="{{ route('petugas.verifikasi-laporan', ['status' => 'pending']) }}" class="rounded-lg px-3 py-2 text-xs font-semibold {{ $status === 'pending' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600' }}">Perlu Ditinjau / Klarifikasi</a>
            <a href="{{ route('petugas.verifikasi-laporan', ['status' => 'all']) }}" class="rounded-lg px-3 py-2 text-xs font-semibold {{ $status === 'all' ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600' }}">Semua Laporan</a>
        </div>
        <form method="GET" action="{{ route('petugas.verifikasi-laporan') }}" class="flex gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari nomor, pelapor, lokasi..." class="w-64 max-w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Cari</button>
        </form>
    </div>

    <div class="space-y-4">
        @forelse($reports as $report)
        @php
            $statusLabels = ['pending' => 'Menunggu Verifikasi', 'verified' => 'Terverifikasi', 'needs_clarification' => 'Perlu Klarifikasi', 'rejected' => 'Ditolak', 'in_progress' => 'Dalam Penanganan', 'resolved' => 'Selesai'];
            $statusColors = ['pending' => 'bg-amber-100 text-amber-800', 'verified' => 'bg-green-100 text-green-800', 'needs_clarification' => 'bg-yellow-100 text-yellow-800', 'rejected' => 'bg-red-100 text-red-800', 'in_progress' => 'bg-blue-100 text-blue-800', 'resolved' => 'bg-gray-100 text-gray-700'];
            $dangerLabels = ['low' => 'Rendah', 'medium' => 'Sedang', 'high' => 'Tinggi'];
            $flowLabels = ['stagnant' => 'Diam / menggenang', 'slow' => 'Mengalir lambat', 'fast' => 'Mengalir deras', 'dangerous' => 'Sangat deras / berbahaya'];
            $impactLabels = ['rumah_terendam' => 'Rumah terendam', 'jalan_tergenang' => 'Jalan tergenang', 'fasilitas_umum' => 'Fasilitas umum terdampak', 'warga_terisolasi' => 'Warga terisolasi', 'kerusakan_harta_benda' => 'Kerusakan harta benda'];
        @endphp
        <article class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <p class="font-mono text-xs font-bold text-blue-700">{{ $report->report_number }}</p>
                    <h3 class="mt-1 text-lg font-bold text-gray-900">{{ $report->title }}</h3>
                    <p class="mt-1 text-xs text-gray-500">Dikirim {{ $report->created_at->format('d M Y H:i') }} · Kejadian {{ $report->occurred_at->format('d M Y H:i') }}</p>
                </div>
                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusColors[$report->status] ?? 'bg-gray-100 text-gray-700' }}">{{ $statusLabels[$report->status] ?? $report->status }}</span>
            </div>

            <div class="mt-4 grid gap-4 md:grid-cols-2">
                <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div><p class="text-xs text-gray-400">Pelapor</p><p class="font-medium text-gray-800">{{ $report->reporter_name ?? $report->reporter?->name ?? 'Warga tanpa akun' }}</p><p class="text-xs text-gray-500">{{ $report->contact_phone ?? $report->reporter?->phone ?? 'Kontak tidak tersedia' }}</p></div>
                        <div><p class="text-xs text-gray-400">Lokasi</p><p class="font-medium text-gray-800">{{ $report->village }}</p><p class="text-xs text-gray-500">{{ $report->address ?: 'Alamat rinci tidak dicantumkan' }}</p></div>
                        <div><p class="text-xs text-gray-400">Ketinggian / aliran air</p><p class="font-medium text-gray-800">{{ number_format($report->water_level_cm / 100, 2, ',', '.') }} m · Bahaya {{ $dangerLabels[$report->danger_level] ?? $report->danger_level }}</p><p class="text-xs text-gray-500">{{ $flowLabels[$report->flow_condition] ?? 'Kondisi aliran tidak dicantumkan' }}</p></div>
                        <div><p class="text-xs text-gray-400">Koordinat</p><p class="font-medium text-gray-800">{{ $report->latitude }}, {{ $report->longitude }}</p></div>
                    </div>
                    <div><p class="mb-1 text-xs font-semibold text-gray-500">Deskripsi</p><p class="whitespace-pre-line text-sm text-gray-700">{{ $report->description }}</p></div>
                    @if($report->impacts)
                    <div><p class="mb-1 text-xs font-semibold text-gray-500">Dampak</p><p class="text-sm text-gray-700">{{ collect($report->impacts)->map(fn ($impact) => $impactLabels[$impact] ?? $impact)->join(', ') }}</p></div>
                    @endif
                    @if($report->photos->isNotEmpty())
                    <div>
                        <p class="mb-2 text-xs font-semibold text-gray-500">Foto dan video laporan (akses petugas)</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach($report->photos as $photo)
                            <a href="{{ route('petugas.laporan-foto', [$report, $photo]) }}" target="_blank" rel="noopener" class="rounded-lg border border-blue-200 px-3 py-2 text-xs font-semibold text-blue-700 hover:bg-blue-50">{{ $photo->media_type === 'video' ? 'Tonton video' : 'Lihat foto' }}: {{ $photo->original_name ?: 'media laporan' }}</a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($report->verification_note)
                    <div class="rounded-lg bg-gray-50 p-3"><p class="text-xs font-semibold text-gray-500">Catatan verifikasi</p><p class="mt-1 text-sm text-gray-700">{{ $report->verification_note }}</p></div>
                    @endif
                    <div class="rounded-lg border border-gray-100 p-3">
                        <p class="mb-2 text-xs font-semibold text-gray-500">Riwayat laporan</p>
                        <ol class="space-y-2">
                            @forelse($report->activityLogs as $log)
                            @php
                                $activityLabels = ['submitted' => 'Laporan dikirim', 'verified' => 'Laporan diverifikasi', 'needs_clarification' => 'Klarifikasi diminta', 'rejected' => 'Laporan ditolak'];
                            @endphp
                            <li class="text-xs text-gray-600">
                                <span class="font-semibold">{{ $activityLabels[$log->action] ?? $log->action }}</span>
                                · {{ $log->user?->name ?? 'Warga' }}
                                · {{ $log->created_at?->format('d M Y H:i') }}
                            </li>
                            @empty
                            <li class="text-xs text-gray-400">Belum ada riwayat.</li>
                            @endforelse
                        </ol>
                    </div>
                </div>

                @if(in_array($report->status, ['pending', 'needs_clarification'], true))
                <form method="POST" action="{{ route('petugas.verifikasi-laporan.update', $report) }}" class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    @csrf
                    <h4 class="mb-3 text-sm font-bold text-gray-800">{{ $report->status === 'pending' ? 'Tinjau laporan' : 'Tinjau ulang setelah klarifikasi' }}</h4>
                    <label for="status-{{ $report->id }}" class="mb-1 block text-xs font-medium text-gray-600">Keputusan</label>
                    <select id="status-{{ $report->id }}" name="status" required class="mb-3 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm">
                        <option value="verified">Setujui / verifikasi</option>
                        <option value="needs_clarification">Minta klarifikasi</option>
                        <option value="rejected">Tolak laporan</option>
                    </select>
                    <label for="note-{{ $report->id }}" class="mb-1 block text-xs font-medium text-gray-600">Catatan petugas</label>
                    <textarea id="note-{{ $report->id }}" name="verification_note" rows="3" maxlength="2000" class="mb-3 w-full rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm" placeholder="Wajib untuk klarifikasi atau penolakan"></textarea>
                    <button class="w-full rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-blue-700">Simpan Keputusan</button>
                </form>
                @else
                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4 text-sm text-gray-600">
                    <p class="font-semibold">{{ $report->verifier?->name ?? 'Petugas' }} meninjau laporan ini.</p>
                    @if($report->verified_at)<p class="mt-1 text-xs text-gray-500">{{ $report->verified_at->format('d M Y H:i') }}</p>@endif
                </div>
                @endif
            </div>
        </article>
        @empty
        <div class="rounded-xl border border-gray-100 bg-white py-16 text-center shadow-sm">
            <p class="font-bold text-gray-700">Tidak ada laporan untuk ditampilkan</p>
            <p class="mt-1 text-sm text-gray-400">Laporan baru dari masyarakat akan muncul di antrean ini.</p>
        </div>
        @endforelse
    </div>
    @if($reports->hasPages())
    <div class="mt-4">{{ $reports->links() }}</div>
    @endif
</div>
@endsection

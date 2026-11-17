<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\FloodReport;
use App\Models\FloodReportPhoto;
use App\Support\IndonesianPhoneNumber;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use RuntimeException;

class FloodReportController extends Controller
{
    private const IMPACTS = [
        'rumah_terendam',
        'jalan_tergenang',
        'fasilitas_umum',
        'warga_terisolasi',
        'kerusakan_harta_benda',
    ];

    public function create()
    {
        return view('dashboard.laporan-banjir');
    }

    public function publicCreate()
    {
        return view('lapor-banjir');
    }

    public function monitoringMap()
    {
        $reports = FloodReport::query()
            ->whereIn('status', ['pending', 'needs_clarification', 'verified', 'in_progress', 'resolved'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->latest('occurred_at')
            ->get([
                'id', 'report_number', 'title', 'village', 'occurred_at',
                'latitude', 'longitude', 'water_level_cm', 'danger_level', 'status',
            ]);

        $mapReports = $reports->map(fn (FloodReport $report): array => [
            'id' => $report->id,
            'report_number' => $report->report_number,
            'title' => $report->title,
            'village' => $report->village,
            'occurred_at' => $report->occurred_at?->toIso8601String(),
            'latitude' => (float) $report->latitude,
            'longitude' => (float) $report->longitude,
            'water_level_cm' => $report->water_level_cm,
            'danger_level' => $report->danger_level,
            'status' => $report->status,
        ])->values();

        return view('petugas.peta-monitoring', compact('reports', 'mapReports'));
    }

    public function storeStaffIncident(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:8', 'max:150'],
            'description' => ['required', 'string', 'min:20', 'max:5000'],
            'occurred_at' => ['required', 'date', 'before_or_equal:now'],
            'village' => ['required', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'water_level_m' => ['required', 'numeric', 'between:0.01,10'],
            'flow_condition' => ['required', Rule::in(['stagnant', 'slow', 'fast', 'dangerous'])],
        ]);

        $waterLevel = (int) round((float) $validated['water_level_m'] * 100);
        $dangerLevel = match (true) {
            $waterLevel <= 30 => 'low',
            $waterLevel <= 60 => 'medium',
            default => 'high',
        };

        $report = DB::transaction(function () use ($request, $validated, $waterLevel, $dangerLevel): FloodReport {
            $report = FloodReport::create([
                'report_number' => 'TEMP-'.Str::uuid(),
                'user_id' => $request->user()->id,
                'reporter_name' => $request->user()->name,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'occurred_at' => $validated['occurred_at'],
                'village' => $validated['village'],
                'address' => $validated['address'] ?? null,
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'water_level_cm' => $waterLevel,
                'flow_condition' => $validated['flow_condition'],
                'danger_level' => $dangerLevel,
                'impacts' => [],
                'status' => 'verified',
                'verified_by' => $request->user()->id,
                'verified_at' => now(),
            ]);

            $report->report_number = sprintf('LPR-%s-%06d', now()->format('ym'), $report->id);
            $report->save();

            ActivityLog::create([
                'user_id' => $request->user()->id,
                'category' => 'flood_report',
                'action' => 'recorded_by_officer',
                'subject_type' => FloodReport::class,
                'subject_id' => $report->id,
                'properties' => ['report_number' => $report->report_number],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return $report;
        });

        return redirect()
            ->route('petugas.peta-monitoring')
            ->with('status', "Kejadian {$report->report_number} berhasil dicatat dan ditampilkan di peta.");
    }

    public function store(Request $request)
    {
        $isPublic = $request->routeIs('lapor-banjir.store');
        $validated = $request->validate([
            'title' => [$isPublic ? 'nullable' : 'required', 'string', 'min:8', 'max:150'],
            'description' => ['required', 'string', 'min:20', 'max:5000'],
            'occurred_at' => ['required', 'date', 'before_or_equal:now'],
            'village' => ['required', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'water_level_cm' => [$isPublic ? 'nullable' : 'required', 'integer', 'min:0', 'max:1000'],
            'water_level_m' => [$isPublic ? 'required' : 'prohibited', 'numeric', 'between:0.01,10'],
            'flow_condition' => [$isPublic ? 'required' : 'nullable', Rule::in(['stagnant', 'slow', 'fast', 'dangerous'])],
            'reporter_name' => ['nullable', 'string', 'max:150'],
            'contact_phone' => [$isPublic ? 'required' : 'nullable', 'string', 'regex:/^\+?[0-9\s().-]{8,30}$/', 'max:30'],
            'impacts' => ['nullable', 'array'],
            'impacts.*' => ['string', Rule::in(self::IMPACTS)],
            'photo' => [$isPublic ? 'required' : 'prohibited', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'video' => [$isPublic ? 'required' : 'prohibited', 'file', 'mimetypes:video/mp4', 'mimes:mp4', 'max:51200'],
            'photos' => [$isPublic ? 'prohibited' : 'nullable', 'array', 'max:5'],
            'photos.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'agreement' => ['accepted'],
        ], [
            'title.min' => 'Judul laporan minimal 8 karakter.',
            'description.min' => 'Deskripsi kondisi banjir minimal 20 karakter.',
            'occurred_at.before_or_equal' => 'Waktu kejadian tidak boleh di masa depan.',
            'photos.max' => 'Maksimal 5 foto untuk setiap laporan.',
            'photos.*.image' => 'Setiap berkas harus berupa foto.',
            'photos.*.mimes' => 'Foto harus berformat JPG, PNG, atau WEBP.',
            'photos.*.max' => 'Ukuran setiap foto maksimal 5 MB.',
            'photo.required' => 'Foto kejadian wajib diunggah.',
            'photo.image' => 'Berkas foto harus berupa gambar yang valid.',
            'photo.mimes' => 'Foto harus berformat JPG, PNG, atau WEBP.',
            'photo.max' => 'Ukuran foto maksimal 5 MB.',
            'video.required' => 'Video kejadian wajib diunggah.',
            'video.mimetypes' => 'Video harus berformat MP4.',
            'video.mimes' => 'Video harus berformat MP4.',
            'video.max' => 'Ukuran video maksimal 50 MB.',
            'water_level_m.between' => 'Ketinggian air harus antara 0,01 sampai 10 meter.',
        ]);

        $waterLevel = $isPublic
            ? (int) round((float) $validated['water_level_m'] * 100)
            : (int) $validated['water_level_cm'];
        $dangerLevel = match (true) {
            $waterLevel <= 30 => 'low',
            $waterLevel <= 60 => 'medium',
            default => 'high',
        };

        $media = collect($request->file('photos', []))
            ->map(fn ($file) => ['file' => $file, 'type' => 'photo'])
            ->when($request->hasFile('photo'), fn ($files) => $files->push(['file' => $request->file('photo'), 'type' => 'photo']))
            ->when($request->hasFile('video'), fn ($files) => $files->push(['file' => $request->file('video'), 'type' => 'video']));

        $report = DB::transaction(function () use ($request, $validated, $waterLevel, $dangerLevel, $media, $isPublic): FloodReport {
            $report = FloodReport::create([
                'report_number' => 'TEMP-'.Str::uuid(),
                'user_id' => $request->user()?->id,
                'reporter_name' => $isPublic
                    ? (($validated['reporter_name'] ?? null) ?: $request->user()?->name)
                    : ($request->user()?->name ?? ($validated['reporter_name'] ?? null)),
                'contact_phone' => isset($validated['contact_phone'])
                    ? IndonesianPhoneNumber::normalize($validated['contact_phone'])
                    : ($request->user()?->phone ? IndonesianPhoneNumber::normalize($request->user()->phone) : null),
                'title' => ($validated['title'] ?? null) ?: 'Laporan banjir di '.$validated['village'],
                'description' => $validated['description'],
                'occurred_at' => $validated['occurred_at'],
                'village' => $validated['village'],
                'address' => $validated['address'] ?? null,
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'water_level_cm' => $waterLevel,
                'flow_condition' => $validated['flow_condition'] ?? null,
                'danger_level' => $dangerLevel,
                'impacts' => $validated['impacts'] ?? [],
                'status' => 'pending',
            ]);

            $report->report_number = sprintf(
                'LPR-%s-%06d',
                now()->format('ym'),
                $report->id
            );
            $report->save();

            foreach ($media as $item) {
                $file = $item['file'];
                $path = $file->store('flood-reports/'.$report->id, 'local');
                if ($path === false) {
                    throw new RuntimeException('Berkas media laporan gagal disimpan.');
                }

                $report->photos()->create([
                    'path' => $path,
                    'media_type' => $item['type'],
                    'original_name' => mb_substr($file->getClientOriginalName(), 0, 255),
                    'size_bytes' => $file->getSize(),
                ]);
            }

            ActivityLog::create([
                'user_id' => $request->user()?->id,
                'category' => 'flood_report',
                'action' => 'submitted',
                'subject_type' => FloodReport::class,
                'subject_id' => $report->id,
                'properties' => ['report_number' => $report->report_number],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return $report;
        });

        if ($isPublic) {
            return redirect()
                ->route('status-warga')
                ->with('submitted_reference', $report->report_number)
                ->with('submission_type', 'flood_report');
        }

        return redirect()->route('dashboard.laporan-saya')
            ->with('status', "Laporan {$report->report_number} berhasil dikirim dan menunggu verifikasi petugas.");
    }

    public function mine(Request $request)
    {
        $reports = FloodReport::query()
            ->where('user_id', $request->user()->id)
            ->when($request->filled('search'), function (Builder $query) use ($request): void {
                $search = $request->string('search')->trim()->toString();
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('report_number', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%")
                        ->orWhere('village', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn (Builder $query) => $query->where('status', $request->string('status')->toString()))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.laporan-saya', compact('reports'));
    }

    public function verificationQueue(Request $request)
    {
        $status = $request->query('status', 'pending');
        abort_unless(in_array($status, ['pending', 'all'], true), 422);

        $reports = FloodReport::query()
            ->with(['reporter', 'photos', 'activityLogs.user'])
            ->when($status === 'pending', fn (Builder $query) => $query->whereIn('status', ['pending', 'needs_clarification']))
            ->when($request->filled('search'), function (Builder $query) use ($request): void {
                $search = $request->string('search')->trim()->toString();
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('report_number', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%")
                        ->orWhere('village', 'like', "%{$search}%")
                        ->orWhere('reporter_name', 'like', "%{$search}%")
                        ->orWhereHas('reporter', fn (Builder $reporter) => $reporter->where('name', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('petugas.verifikasi-laporan', compact('reports', 'status'));
    }

    public function verify(Request $request, FloodReport $report)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['verified', 'needs_clarification', 'rejected'])],
            'verification_note' => [
                Rule::requiredIf(in_array($request->input('status'), ['needs_clarification', 'rejected'], true)),
                'nullable',
                'string',
                'max:2000',
            ],
        ], [
            'verification_note.required' => 'Catatan wajib diisi untuk klarifikasi atau penolakan.',
        ]);

        DB::transaction(function () use ($request, $report, $validated): void {
            $lockedReport = FloodReport::query()->lockForUpdate()->findOrFail($report->id);
            abort_unless(
                in_array($lockedReport->status, ['pending', 'needs_clarification'], true),
                409,
                'Laporan ini sudah ditinjau dan tidak dapat diubah kembali.'
            );

            $previousStatus = $lockedReport->status;
            $lockedReport->update([
                'status' => $validated['status'],
                'verified_by' => $request->user()->id,
                'verified_at' => now(),
                'verification_note' => $validated['verification_note'] ?? null,
            ]);

            ActivityLog::create([
                'user_id' => $request->user()->id,
                'category' => 'flood_report',
                'action' => $validated['status'],
                'subject_type' => FloodReport::class,
                'subject_id' => $lockedReport->id,
                'properties' => [
                    'report_number' => $lockedReport->report_number,
                    'from_status' => $previousStatus,
                    'to_status' => $validated['status'],
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        });

        return redirect()
            ->route('petugas.verifikasi-laporan')
            ->with('status', "Laporan {$report->report_number} berhasil diperbarui.");
    }

    public function photo(FloodReport $report, FloodReportPhoto $photo)
    {
        abort_unless($photo->flood_report_id === $report->id, 404);
        abort_unless(in_array($photo->media_type, ['photo', 'video'], true), 404);
        abort_unless(Storage::disk('local')->exists($photo->path), 404);

        return Storage::disk('local')->response($photo->path, null, [
            'Content-Disposition' => 'inline',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}

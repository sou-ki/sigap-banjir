<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\EvacuationRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class EvacuationRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        abort_unless(in_array($status, ['pending', 'accepted', 'in_progress', 'completed', 'cancelled', 'all'], true), 422);

        $requests = EvacuationRequest::query()
            ->with(['shelter', 'activityLogs.user'])
            ->when($status !== 'all', fn (Builder $query) => $query->where('status', $status))
            ->when($request->filled('search'), function (Builder $query) use ($request): void {
                $search = $request->string('search')->trim()->toString();
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('request_number', 'like', "%{$search}%")
                        ->orWhere('requester_name', 'like', "%{$search}%")
                        ->orWhere('village', 'like', "%{$search}%");
                });
            })
            ->orderByRaw("CASE priority WHEN 'urgent' THEN 0 WHEN 'high' THEN 1 WHEN 'medium' THEN 2 ELSE 3 END")
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $counts = EvacuationRequest::query()
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('petugas.permintaan-evakuasi', compact('requests', 'status', 'counts'));
    }

    public function update(Request $request, EvacuationRequest $evacuationRequest)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['accepted', 'in_progress', 'completed', 'cancelled'])],
            'public_note' => [
                Rule::requiredIf($request->input('status') === 'cancelled'),
                'nullable',
                'string',
                'max:2000',
            ],
        ], [
            'public_note.required' => 'Catatan untuk pemohon wajib diisi saat permintaan dibatalkan.',
        ]);

        DB::transaction(function () use ($request, $evacuationRequest, $validated): void {
            $lockedRequest = EvacuationRequest::query()->lockForUpdate()->findOrFail($evacuationRequest->id);
            $allowedTransitions = [
                'pending' => ['accepted', 'cancelled'],
                'accepted' => ['in_progress', 'cancelled'],
                'in_progress' => ['completed', 'cancelled'],
                'completed' => [],
                'cancelled' => [],
            ];
            abort_unless(in_array($validated['status'], $allowedTransitions[$lockedRequest->status] ?? [], true), 409, 'Perubahan status tidak diizinkan.');

            $previousStatus = $lockedRequest->status;
            $lockedRequest->update([
                'status' => $validated['status'],
                'handled_by' => $request->user()->id,
                'completed_at' => $validated['status'] === 'completed' ? now() : null,
                'public_note' => $validated['public_note'] ?? null,
            ]);

            ActivityLog::create([
                'user_id' => $request->user()->id,
                'category' => 'evacuation_request',
                'action' => $validated['status'],
                'subject_type' => EvacuationRequest::class,
                'subject_id' => $lockedRequest->id,
                'properties' => [
                    'request_number' => $lockedRequest->request_number,
                    'from_status' => $previousStatus,
                    'to_status' => $validated['status'],
                    'public_note' => $validated['public_note'] ?? null,
                ],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        });

        return redirect()
            ->route('petugas.permintaan-evakuasi', ['status' => $validated['status'] === 'accepted' ? 'accepted' : $validated['status']])
            ->with('status', "Status permintaan {$evacuationRequest->request_number} berhasil diperbarui.");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\EvacuationRequest;
use App\Models\FloodReport;
use App\Support\IndonesianPhoneNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PublicCitizenController extends Controller
{
    private const VULNERABLE_GROUPS = [
        'lansia',
        'ibu_hamil',
        'sakit',
        'anak',
        'disabilitas',
    ];

    public function evacuationForm()
    {
        return view('dashboard.permintaan-evakuasi');
    }

    public function submitEvacuationRequest(Request $request)
    {
        $validated = $request->validate([
            'requester_name' => ['required', 'string', 'min:2', 'max:150'],
            'contact_phone' => ['required', 'string', 'regex:/^\+?[0-9\s().-]{8,30}$/', 'max:30'],
            'pickup_address' => ['required', 'string', 'max:255'],
            'village' => ['required', 'string', 'max:100'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'people_count' => ['required', 'integer', 'between:1,500'],
            'emergency_condition' => ['nullable', 'string', 'max:255'],
            'vulnerable_groups' => ['nullable', 'array'],
            'vulnerable_groups.*' => ['string', Rule::in(self::VULNERABLE_GROUPS)],
            'additional_information' => ['nullable', 'string', 'max:2000'],
            'agreement' => ['accepted'],
        ], [
            'contact_phone.regex' => 'Masukkan nomor HP yang valid.',
            'people_count.between' => 'Jumlah warga harus antara 1 sampai 500 orang.',
            'agreement.accepted' => 'Persetujuan wajib dicentang sebelum mengirim.',
        ]);

        $requestModel = DB::transaction(function () use ($request, $validated): EvacuationRequest {
            $requestModel = EvacuationRequest::create([
                'request_number' => 'TEMP-'.Str::uuid(),
                'user_id' => $request->user()?->id,
                'requester_name' => $validated['requester_name'],
                'contact_phone' => IndonesianPhoneNumber::normalize($validated['contact_phone']),
                'pickup_address' => $validated['pickup_address'],
                'village' => $validated['village'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
                'people_count' => $validated['people_count'],
                'emergency_condition' => $validated['emergency_condition'] ?? null,
                'vulnerable_groups' => $validated['vulnerable_groups'] ?? [],
                'additional_information' => $validated['additional_information'] ?? null,
                'priority' => empty($validated['vulnerable_groups']) ? 'medium' : 'high',
                'status' => 'pending',
            ]);

            $requestModel->request_number = sprintf(
                'EVK-%s-%06d',
                now()->format('ym'),
                $requestModel->id
            );
            $requestModel->save();

            ActivityLog::create([
                'user_id' => $request->user()?->id,
                'category' => 'evacuation_request',
                'action' => 'submitted',
                'subject_type' => EvacuationRequest::class,
                'subject_id' => $requestModel->id,
                'properties' => ['request_number' => $requestModel->request_number],
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return $requestModel;
        });

        return redirect()
            ->route('status-warga')
            ->with('submitted_reference', $requestModel->request_number)
            ->with('submission_type', 'evacuation_request');
    }

    public function track(Request $request)
    {
        $result = null;
        $reference = $request->session()->get('submitted_reference');
        $type = $request->session()->get('submission_type');

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'type' => ['required', Rule::in(['flood_report', 'evacuation_request'])],
                'reference' => ['required', 'string', 'max:40'],
                'contact_phone' => ['required', 'string', 'regex:/^\+?[0-9\s().-]{8,30}$/', 'max:30'],
            ], [
                'contact_phone.regex' => 'Masukkan nomor HP yang valid.',
            ]);

            $reference = strtoupper(trim($validated['reference']));
            $type = $validated['type'];
            $phone = IndonesianPhoneNumber::normalize($validated['contact_phone']);

            if ($type === 'flood_report') {
                $record = FloodReport::query()
                    ->where('report_number', $reference)
                    ->where('contact_phone', $phone)
                    ->first();

                if ($record) {
                    $result = [
                        'reference' => $record->report_number,
                        'title' => $record->title,
                        'location' => $record->village,
                        'status' => $record->status,
                        'note' => $record->verification_note,
                        'updated_at' => $record->updated_at,
                    ];
                }
            } else {
                $record = EvacuationRequest::query()
                    ->where('request_number', $reference)
                    ->where('contact_phone', $phone)
                    ->first();

                if ($record) {
                    $result = [
                        'reference' => $record->request_number,
                        'title' => 'Permintaan evakuasi',
                        'location' => $record->village,
                        'status' => $record->status,
                        'note' => $record->public_note,
                        'updated_at' => $record->updated_at,
                    ];
                }
            }

            if (! $result) {
                return back()->withInput($request->only('type', 'reference'))
                    ->withErrors(['lookup' => 'Data tidak ditemukan. Periksa kembali nomor referensi dan nomor HP.']);
            }
        }

        return view('status-warga', compact('reference', 'type', 'result'));
    }
}

<?php

namespace Tests\Feature;

use App\Models\EvacuationRequest;
use App\Models\FloodReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicCitizenSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_a_flood_report_and_track_it_with_reference_and_phone(): void
    {
        Storage::fake('local');
        $this->get(route('lapor-banjir'))
            ->assertOk()
            ->assertSee(route('lapor-banjir.store'))
            ->assertSee('name="latitude"', false)
            ->assertSee('name="water_level_m"', false)
            ->assertSee('name="photo"', false)
            ->assertSee('name="video"', false)
            ->assertDontSee('name="title"', false)
            ->assertSee('name="contact_phone"', false);

        $this->post(route('lapor-banjir.store'), [
            'description' => 'Air mulai memasuki jalan dan halaman rumah warga sekitar pasar.',
            'occurred_at' => now()->subHour()->format('Y-m-d\TH:i'),
            'village' => 'Uteunkot',
            'address' => 'Jalan Pasar',
            'latitude' => '5.1801000',
            'longitude' => '97.1500000',
            'water_level_m' => 0.8,
            'flow_condition' => 'fast',
            'reporter_name' => 'Warga Tanpa Akun',
            'contact_phone' => '+62 812-3456-7890',
            'agreement' => '1',
            'photo' => UploadedFile::fake()->image('flood.jpg'),
            'video' => UploadedFile::fake()->create('flood.mp4', 100, 'video/mp4'),
        ])
            ->assertRedirect(route('status-warga'))
            ->assertSessionHas('submitted_reference');

        $report = FloodReport::with('photos')->firstOrFail();
        $this->assertGuest();
        $this->assertNull($report->user_id);
        $this->assertSame('Warga Tanpa Akun', $report->reporter_name);
        $this->assertSame('081234567890', $report->contact_phone);
        $this->assertSame('fast', $report->flow_condition);
        $this->assertSame('Laporan banjir di Uteunkot', $report->title);
        $this->assertSame(80, $report->water_level_cm);
        $this->assertSame('high', $report->danger_level);
        $this->assertSame(['photo', 'video'], $report->photos->pluck('media_type')->sort()->values()->all());
        foreach ($report->photos as $media) {
            Storage::disk('local')->assertExists($media->path);
        }

        $this->post(route('status-warga'), [
            'type' => 'flood_report',
            'reference' => $report->report_number,
            'contact_phone' => '081234567890',
        ])
            ->assertOk()
            ->assertSee($report->report_number)
            ->assertSee('Menunggu verifikasi petugas');
    }

    public function test_guest_can_submit_an_evacuation_request_and_track_it(): void
    {
        $this->get(route('permintaan-evakuasi'))
            ->assertOk()
            ->assertSee(route('permintaan-evakuasi.store'))
            ->assertSee('name="requester_name"', false)
            ->assertSee('name="latitude"', false);

        $this->post(route('permintaan-evakuasi.store'), [
            'requester_name' => 'Pemohon Evakuasi',
            'contact_phone' => '081234567890',
            'pickup_address' => 'Rumah dekat musala',
            'village' => 'Mon Geudong',
            'latitude' => '5.1856000',
            'longitude' => '97.1315000',
            'people_count' => 4,
            'emergency_condition' => 'Air mulai masuk rumah',
            'vulnerable_groups' => ['lansia', 'anak'],
            'additional_information' => 'Mohon bantuan penjemputan.',
            'agreement' => '1',
        ])
            ->assertRedirect(route('status-warga'))
            ->assertSessionHas('submitted_reference');

        $evacuation = EvacuationRequest::firstOrFail();
        $this->assertGuest();
        $this->assertNull($evacuation->user_id);
        $this->assertSame('EVK-'.now()->format('ym').'-000001', $evacuation->request_number);
        $this->assertSame('081234567890', $evacuation->contact_phone);
        $this->assertSame('high', $evacuation->priority);

        $this->post(route('status-warga'), [
            'type' => 'evacuation_request',
            'reference' => $evacuation->request_number,
            'contact_phone' => '081234567890',
        ])
            ->assertOk()
            ->assertSee($evacuation->request_number)
            ->assertSee('Menunggu verifikasi petugas');
    }

    public function test_status_lookup_requires_matching_reference_and_phone(): void
    {
        $report = $this->createFloodReport('081111111111');

        $this->from(route('status-warga'))
            ->post(route('status-warga'), [
                'type' => 'flood_report',
                'reference' => $report->report_number,
                'contact_phone' => '082222222222',
            ])
            ->assertRedirect(route('status-warga'))
            ->assertSessionHasErrors('lookup');
    }

    public function test_guest_must_provide_report_location_and_evacuation_agreement(): void
    {
        $this->from(route('lapor-banjir'))
            ->post(route('lapor-banjir.store'), [
                'description' => 'Kondisi air sudah menggenangi jalan lingkungan warga.',
                'occurred_at' => now()->subHour()->format('Y-m-d\TH:i'),
                'village' => 'Uteunkot',
                'water_level_m' => 0.35,
                'flow_condition' => 'slow',
                'contact_phone' => '081234567890',
            ])
            ->assertRedirect(route('lapor-banjir'))
            ->assertSessionHasErrors(['latitude', 'longitude', 'agreement', 'photo', 'video']);

        $this->from(route('permintaan-evakuasi'))
            ->post(route('permintaan-evakuasi.store'), [
                'requester_name' => 'Pemohon',
                'contact_phone' => '081234567890',
                'pickup_address' => 'Dekat musala',
                'village' => 'Mon Geudong',
                'latitude' => '5.18',
                'longitude' => '97.15',
                'people_count' => 2,
            ])
            ->assertRedirect(route('permintaan-evakuasi'))
            ->assertSessionHasErrors('agreement');

        $this->assertDatabaseCount('flood_reports', 0);
        $this->assertDatabaseCount('evacuation_requests', 0);
    }

    public function test_guest_must_upload_exactly_one_photo_and_one_mp4_video(): void
    {
        $data = [
            'description' => 'Kondisi air sudah menggenangi jalan lingkungan warga sekitar.',
            'occurred_at' => now()->subHour()->format('Y-m-d\TH:i'),
            'village' => 'Uteunkot',
            'latitude' => '5.18',
            'longitude' => '97.15',
            'water_level_m' => 0.5,
            'flow_condition' => 'slow',
            'contact_phone' => '081234567890',
            'agreement' => '1',
            'video' => UploadedFile::fake()->create('flood.mp4', 100, 'video/mp4'),
        ];

        $this->from(route('lapor-banjir'))
            ->post(route('lapor-banjir.store'), $data)
            ->assertRedirect(route('lapor-banjir'))
            ->assertSessionHasErrors('photo');

        $this->from(route('lapor-banjir'))
            ->post(route('lapor-banjir.store'), array_replace($data, [
                'photo' => UploadedFile::fake()->image('flood.jpg'),
                'video' => UploadedFile::fake()->create('flood.mov', 100, 'video/quicktime'),
            ]))
            ->assertRedirect(route('lapor-banjir'))
            ->assertSessionHasErrors('video');

        $this->assertDatabaseCount('flood_reports', 0);
    }

    public function test_only_bpbd_staff_can_manage_evacuation_requests(): void
    {
        $evacuation = EvacuationRequest::create([
            'request_number' => 'EVK-2611-000001',
            'requester_name' => 'Pemohon',
            'contact_phone' => '081234567890',
            'pickup_address' => 'Dekat musala',
            'village' => 'Mon Geudong',
            'latitude' => 5.18,
            'longitude' => 97.15,
            'people_count' => 2,
            'priority' => 'medium',
            'status' => 'pending',
        ]);

        $this->get(route('petugas.permintaan-evakuasi'))
            ->assertRedirect(route('masuk'));

        $officer = User::create([
            'name' => 'Petugas Uji',
            'email' => 'petugas-evakuasi@example.test',
            'password' => 'password123',
            'role' => 'petugas_bpbd',
            'is_active' => true,
        ]);

        $this->actingAs($officer)
            ->get(route('petugas.permintaan-evakuasi'))
            ->assertOk()
            ->assertSee($evacuation->request_number)
            ->assertSee($evacuation->contact_phone);

        $this->actingAs($officer)
            ->patch(route('petugas.permintaan-evakuasi.update', $evacuation), ['status' => 'accepted'])
            ->assertRedirect(route('petugas.permintaan-evakuasi', ['status' => 'accepted']));

        $this->assertSame('accepted', $evacuation->fresh()->status);
        $this->assertSame($officer->id, $evacuation->fresh()->handled_by);
    }

    private function createFloodReport(string $phone): FloodReport
    {
        return FloodReport::create([
            'report_number' => 'LPR-2611-000001',
            'reporter_name' => 'Pelapor',
            'contact_phone' => $phone,
            'title' => 'Laporan banjir wilayah',
            'description' => 'Kondisi air sudah menggenangi jalan lingkungan warga.',
            'occurred_at' => now()->subHour(),
            'village' => 'Uteunkot',
            'latitude' => 5.18,
            'longitude' => 97.15,
            'water_level_cm' => 35,
            'danger_level' => 'medium',
            'status' => 'pending',
        ]);
    }
}

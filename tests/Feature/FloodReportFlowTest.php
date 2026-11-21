<?php

namespace Tests\Feature;

use App\Models\FloodReport;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FloodReportFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_community_can_open_the_public_report_form(): void
    {
        $this->get(route('lapor-banjir'))
            ->assertOk()
            ->assertSee(route('lapor-banjir.store'))
            ->assertSee('enctype="multipart/form-data"', false)
            ->assertSee('name="latitude"', false)
            ->assertSee('name="contact_phone"', false);
    }

    public function test_community_report_is_saved_and_can_be_verified_by_a_bpbd_officer(): void
    {
        Storage::fake('local');
        $officer = $this->makeUser('petugas_bpbd');

        $this->post(route('lapor-banjir.store'), $this->reportData([
                'photo' => UploadedFile::fake()->image('flood.jpg'),
                'video' => UploadedFile::fake()->create('flood.mp4', 100, 'video/mp4'),
            ]))
            ->assertRedirect(route('status-warga'))
            ->assertSessionHas('submitted_reference');

        $report = FloodReport::with('photos')->firstOrFail();
        $this->assertNull($report->user_id);
        $this->assertSame('pending', $report->status);
        $this->assertSame('medium', $report->danger_level);
        $this->assertMatchesRegularExpression('/^LPR-\d{4}-\d{6}$/', $report->report_number);
        Storage::disk('local')->assertExists($report->photos->first()->path);

        $this->actingAs($officer)
            ->get(route('petugas.verifikasi-laporan'))
            ->assertOk()
            ->assertSee($report->report_number);

        $this->actingAs($officer)
            ->post(route('petugas.verifikasi-laporan.update', $report), [
                'status' => 'verified',
            ])
            ->assertRedirect(route('petugas.verifikasi-laporan'))
            ->assertSessionHas('status');

        $report->refresh();
        $this->assertSame('verified', $report->status);
        $this->assertSame($officer->id, $report->verified_by);
        $this->assertNotNull($report->verified_at);
    }

    public function test_community_member_can_check_their_report_status(): void
    {
        $report = FloodReport::create([
            'report_number' => 'LPR-2611-000001',
            'user_id' => null,
            'reporter_name' => 'Warga Uji',
            'contact_phone' => '081234567890',
            'title' => 'Banjir dekat pasar',
            'description' => 'Air mulai menggenangi jalan depan pasar.',
            'occurred_at' => now()->subHour(),
            'village' => 'Uteunkot',
            'latitude' => 5.18,
            'longitude' => 97.15,
            'water_level_cm' => 45,
            'danger_level' => 'medium',
            'status' => 'pending',
        ]);

        $this->post(route('status-warga'), [
            'type' => 'flood_report',
            'reference' => $report->report_number,
            'contact_phone' => '081234567890',
        ])
            ->assertOk()
            ->assertSee($report->report_number);
    }

    public function test_report_requires_valid_coordinates_and_agreement(): void
    {
        $data = $this->reportData();
        unset($data['latitude'], $data['agreement']);

        $this->from(route('lapor-banjir'))
            ->post(route('lapor-banjir.store'), $data)
            ->assertRedirect(route('lapor-banjir'))
            ->assertSessionHasErrors(['latitude', 'agreement']);

        $this->assertDatabaseCount('flood_reports', 0);
    }

    public function test_only_bpbd_officer_can_verify_or_view_report_photos(): void
    {
        Storage::fake('local');
        $reporter = $this->makeUser('masyarakat');
        $report = FloodReport::create([
            'report_number' => 'LPR-2611-000001',
            'user_id' => $reporter->id,
            'title' => 'Banjir dekat pasar',
            'description' => 'Air mulai menggenangi jalan depan pasar.',
            'occurred_at' => now()->subHour(),
            'village' => 'Uteunkot',
            'latitude' => 5.18,
            'longitude' => 97.15,
            'water_level_cm' => 45,
            'danger_level' => 'medium',
            'status' => 'pending',
        ]);
        $path = UploadedFile::fake()->image('bukti.png')->store('flood-reports/'.$report->id, 'local');
        $photo = $report->photos()->create(['path' => $path, 'original_name' => 'bukti.png']);

        $this->actingAs($reporter)
            ->get(route('petugas.laporan-foto', [$report, $photo]))
            ->assertForbidden();

        $this->actingAs($this->makeUser('petugas_bpbd'))
            ->get(route('petugas.laporan-foto', [$report, $photo]))
            ->assertOk();

        $this->actingAs($reporter)
            ->post(route('petugas.verifikasi-laporan.update', $report), ['status' => 'verified'])
            ->assertForbidden();
    }

    public function test_clarification_and_rejection_require_an_officer_note(): void
    {
        $officer = $this->makeUser('petugas_bpbd');
        $report = $this->makeReport($this->makeUser('masyarakat'));

        $this->actingAs($officer)
            ->from(route('petugas.verifikasi-laporan'))
            ->post(route('petugas.verifikasi-laporan.update', $report), [
                'status' => 'rejected',
            ])
            ->assertRedirect(route('petugas.verifikasi-laporan'))
            ->assertSessionHasErrors('verification_note');

        $this->assertSame('pending', $report->fresh()->status);
    }

    public function test_petugas_menu_badge_counts_reports_waiting_for_review(): void
    {
        $officer = $this->makeUser('petugas_bpbd');
        $this->makeReport($this->makeUser('masyarakat'));

        $clarification = $this->makeReport($this->makeUser('masyarakat'));
        $clarification->update(['status' => 'needs_clarification']);

        $verified = $this->makeReport($this->makeUser('masyarakat'));
        $verified->update(['status' => 'verified']);

        $this->actingAs($officer)
            ->get(route('petugas.verifikasi-laporan'))
            ->assertOk()
            ->assertSeeText('Verifikasi Laporan 2');
    }

    public function test_officer_can_record_a_verified_incident_for_the_monitoring_map(): void
    {
        $officer = $this->makeUser('petugas_bpbd');

        $this->actingAs($officer)
            ->post(route('petugas.peta-monitoring.store'), [
                'title' => 'Genangan di jalan utama',
                'description' => 'Air menggenangi jalan utama dan mulai menghambat kendaraan warga.',
                'occurred_at' => now()->subMinutes(30)->format('Y-m-d\TH:i'),
                'village' => 'Uteunkot',
                'address' => 'Jalan Pasar',
                'latitude' => '5.1801000',
                'longitude' => '97.1500000',
                'water_level_m' => 0.45,
                'flow_condition' => 'slow',
            ])
            ->assertRedirect(route('petugas.peta-monitoring'))
            ->assertSessionHas('status');

        $report = FloodReport::firstOrFail();
        $this->assertSame('verified', $report->status);
        $this->assertSame($officer->id, $report->verified_by);
        $this->assertSame(45, $report->water_level_cm);
        $this->assertDatabaseHas('activity_logs', [
            'subject_type' => FloodReport::class,
            'subject_id' => $report->id,
            'action' => 'recorded_by_officer',
        ]);
    }

    private function makeUser(string $role): User
    {
        return User::create([
            'name' => ucfirst($role).' Uji',
            'email' => uniqid($role.'-', true).'@example.test',
            'password' => 'password123',
            'role' => $role,
            'is_active' => true,
        ]);
    }

    private function makeReport(User $user): FloodReport
    {
        return FloodReport::create([
            'report_number' => 'LPR-'.now()->format('ym').'-'.str_pad((string) (FloodReport::count() + 1), 6, '0', STR_PAD_LEFT),
            'user_id' => $user->id,
            'title' => 'Banjir dekat pasar',
            'description' => 'Air mulai menggenangi jalan depan pasar.',
            'occurred_at' => now()->subHour(),
            'village' => 'Uteunkot',
            'latitude' => 5.18,
            'longitude' => 97.15,
            'water_level_cm' => 45,
            'danger_level' => 'medium',
            'status' => 'pending',
        ]);
    }

    private function reportData(array $overrides = []): array
    {
        return array_replace([
            'description' => 'Air menggenangi jalan dan mulai masuk ke halaman rumah warga.',
            'occurred_at' => now()->subHour()->format('Y-m-d\TH:i'),
            'village' => 'Uteunkot',
            'address' => 'Jalan Pasar',
            'latitude' => '5.1801000',
            'longitude' => '97.1500000',
            'water_level_m' => 0.45,
            'flow_condition' => 'slow',
            'reporter_name' => 'Warga Uji',
            'contact_phone' => '081234567890',
            'agreement' => '1',
        ], $overrides);
    }
}

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

    public function test_community_can_open_the_server_submitted_report_form(): void
    {
        $this->actingAs($this->makeUser('masyarakat'))
            ->get(route('dashboard.laporan-banjir'))
            ->assertOk()
            ->assertSee(route('dashboard.laporan-banjir.store'))
            ->assertSee('enctype="multipart/form-data"', false)
            ->assertSee('name="latitude"', false)
            ->assertSee('name="photos[]"', false);
    }

    public function test_community_report_is_saved_and_can_be_verified_by_a_bpbd_officer(): void
    {
        Storage::fake('local');
        $reporter = $this->makeUser('masyarakat');
        $officer = $this->makeUser('petugas_bpbd');

        $this->actingAs($reporter)
            ->post(route('dashboard.laporan-banjir.store'), $this->reportData([
                'photos' => [UploadedFile::fake()->image('flood.jpg')],
            ]))
            ->assertRedirect(route('dashboard.laporan-saya'))
            ->assertSessionHas('status');

        $report = FloodReport::with('photos')->firstOrFail();
        $this->assertSame($reporter->id, $report->user_id);
        $this->assertSame('pending', $report->status);
        $this->assertSame('medium', $report->danger_level);
        $this->assertMatchesRegularExpression('/^LPR-\d{4}-\d{6}$/', $report->report_number);
        $this->assertCount(1, $report->photos);
        Storage::disk('local')->assertExists($report->photos->first()->path);

        $this->actingAs($reporter)
            ->get(route('dashboard.laporan-saya'))
            ->assertOk()
            ->assertSee($report->report_number)
            ->assertSee('Menunggu Verifikasi');

        $this->actingAs($officer)
            ->get(route('petugas.verifikasi-laporan'))
            ->assertOk()
            ->assertSee($report->report_number)
            ->assertSee($reporter->name);

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

    public function test_community_member_can_only_see_their_own_reports(): void
    {
        $owner = $this->makeUser('masyarakat');
        $other = $this->makeUser('masyarakat');
        $ownReport = $this->makeReport($owner);
        $otherReport = $this->makeReport($other);

        $this->actingAs($owner)
            ->get(route('dashboard.laporan-saya'))
            ->assertOk()
            ->assertSee($ownReport->report_number)
            ->assertDontSee($otherReport->report_number);
    }

    public function test_report_requires_valid_coordinates_and_agreement(): void
    {
        $user = $this->makeUser('masyarakat');
        $data = $this->reportData();
        unset($data['latitude'], $data['agreement']);

        $this->actingAs($user)
            ->from(route('dashboard.laporan-banjir'))
            ->post(route('dashboard.laporan-banjir.store'), $data)
            ->assertRedirect(route('dashboard.laporan-banjir'))
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
            'title' => 'Jalan depan pasar terendam',
            'description' => 'Air menggenangi jalan dan mulai masuk ke halaman rumah warga.',
            'occurred_at' => now()->subHour()->format('Y-m-d\TH:i'),
            'village' => 'Uteunkot',
            'address' => 'Jalan Pasar',
            'latitude' => '5.1801000',
            'longitude' => '97.1500000',
            'water_level_cm' => 45,
            'impacts' => ['jalan_tergenang'],
            'agreement' => '1',
        ], $overrides);
    }
}

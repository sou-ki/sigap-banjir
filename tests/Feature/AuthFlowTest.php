<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class AuthFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_creates_and_logs_in_a_community_user(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'Warga Uji',
            'email' => 'warga-uji@example.test',
            'phone' => '081234567890',
            'password' => 'strong-password-123',
            'password_confirmation' => 'strong-password-123',
            'agree' => '1',
        ]);

        $user = User::where('email', 'warga-uji@example.test')->firstOrFail();

        $response->assertRedirect(route('dashboard.beranda'));
        $this->assertAuthenticatedAs($user);
        $this->assertSame('masyarakat', $user->role);
        $this->assertTrue($user->is_active);
        $this->assertTrue(Hash::check('strong-password-123', $user->password));
    }

    public function test_active_user_can_log_in_with_the_web_session(): void
    {
        $user = User::create([
            'name' => 'Warga Login',
            'email' => 'warga-login@example.test',
            'password' => Hash::make('strong-password-123'),
            'role' => 'masyarakat',
            'is_active' => true,
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'strong-password-123',
        ])
            ->assertRedirect(route('dashboard.beranda'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_inactive_user_cannot_log_in(): void
    {
        User::create([
            'name' => 'Warga Nonaktif',
            'email' => 'nonaktif@example.test',
            'password' => Hash::make('strong-password-123'),
            'role' => 'masyarakat',
            'is_active' => false,
        ]);

        $this->from(route('masuk'))
            ->post(route('login'), [
                'email' => 'nonaktif@example.test',
                'password' => 'strong-password-123',
            ])
            ->assertRedirect(route('masuk'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_reset_link_can_be_used_once_to_change_the_password(): void
    {
        Notification::fake();
        $user = User::create([
            'name' => 'Warga Reset',
            'email' => 'warga-reset@example.test',
            'password' => Hash::make('old-password-123'),
            'role' => 'masyarakat',
            'is_active' => true,
        ]);

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertRedirect()
            ->assertSessionHas('status');

        Notification::assertSentTo($user, ResetPassword::class);
        $notification = Notification::sent($user, ResetPassword::class)->first();

        $this->get(route('password.reset', [
            'token' => $notification->token,
            'email' => $user->email,
        ]))->assertOk();

        $this->post(route('password.update'), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ])->assertRedirect(route('masuk'));

        $this->assertTrue(Hash::check('new-password-123', $user->fresh()->password));
        $this->assertFalse(Password::broker()->tokenExists($user->fresh(), $notification->token));
    }
}

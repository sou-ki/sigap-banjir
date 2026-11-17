<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    public function test_forgot_password_form_is_available(): void
    {
        $this->get(route('lupa-sandi'))
            ->assertOk()
            ->assertSee(route('password.email'))
            ->assertSee('name="email"', false);
    }

    public function test_reset_form_is_available_from_a_reset_link(): void
    {
        $this->get(route('password.reset', [
            'token' => 'sample-token',
            'email' => 'warga@example.test',
        ]))
            ->assertOk()
            ->assertSee(route('password.update'))
            ->assertSee('sample-token')
            ->assertSee('warga@example.test');
    }

    public function test_forgot_password_request_shows_generic_confirmation(): void
    {
        Password::shouldReceive('sendResetLink')
            ->once()
            ->with(['email' => 'warga@example.test'])
            ->andReturn(Password::INVALID_USER);

        $this->post(route('password.email'), ['email' => 'warga@example.test'])
            ->assertRedirect()
            ->assertSessionHas('status');
    }

    public function test_successful_password_reset_redirects_to_login(): void
    {
        Password::shouldReceive('reset')
            ->once()
            ->andReturn(Password::PASSWORD_RESET);

        $this->post(route('password.update'), [
            'token' => 'valid-token',
            'email' => 'warga@example.test',
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ])
            ->assertRedirect(route('masuk'))
            ->assertSessionHas('status');
    }

    public function test_password_reset_requires_a_matching_confirmation_and_minimum_length(): void
    {
        $this->from(route('password.reset', ['token' => 'sample-token']))
            ->post(route('password.update'), [
                'token' => 'sample-token',
                'email' => 'warga@example.test',
                'password' => 'short',
                'password_confirmation' => 'different',
            ])
            ->assertRedirect()
            ->assertSessionHasErrors(['password']);
    }
}

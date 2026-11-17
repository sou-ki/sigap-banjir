<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    public function test_guest_is_redirected_to_the_web_login_page(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('masuk'));
    }

    public function test_user_with_another_role_cannot_open_admin_pages(): void
    {
        $user = (new User())->forceFill([
            'role' => 'masyarakat',
            'is_active' => true,
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_inactive_user_is_logged_out_of_protected_pages(): void
    {
        $user = (new User())->forceFill([
            'role' => 'admin_sistem',
            'is_active' => false,
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.dashboard'));

        $response->assertRedirect(route('masuk'));
        $this->assertGuest();
    }
}

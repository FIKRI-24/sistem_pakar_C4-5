<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthRoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        if (! extension_loaded('pdo_sqlite')) {
            $this->markTestSkipped('pdo_sqlite extension is required for in-memory auth feature tests.');
        }

        parent::setUp();
    }

    public function test_admin_can_login_and_is_redirected_to_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'password' => 'password',
        ]);

        $response = $this->post(route('login.store'), [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_guru_bk_can_login_and_is_redirected_to_guru_bk_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_GURU_BK,
            'password' => 'password',
        ]);

        $response = $this->post(route('login.store'), [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('guru-bk.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_siswa_can_login_and_is_redirected_to_siswa_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_SISWA,
            'password' => 'password',
        ]);

        $response = $this->post(route('login.store'), [
            'username' => $user->username,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('siswa.dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_access_another_role_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_SISWA,
        ]);

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_login_attempts_are_rate_limited(): void
    {
        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $this->post(route('login.store'), [
                'username' => 'unknown_user',
                'password' => 'wrong-password',
            ])->assertSessionHasErrors('username');
        }

        $this->post(route('login.store'), [
            'username' => 'unknown_user',
            'password' => 'wrong-password',
        ])->assertStatus(429);
    }

    public function test_username_is_required_for_login(): void
    {
        $this->post(route('login.store'), [
            'password' => 'password',
        ])->assertSessionHasErrors('username');
    }
}

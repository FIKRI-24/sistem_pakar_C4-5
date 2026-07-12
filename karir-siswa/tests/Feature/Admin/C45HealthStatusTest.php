<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class C45HealthStatusTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('services.c45.base_url', 'http://127.0.0.1:8001');
        Http::preventStrayRequests();
    }

    public function test_admin_can_view_a_healthy_c45_service_status(): void
    {
        Http::fake([
            'http://127.0.0.1:8001/health' => Http::response([
                'status' => 'ok',
                'service' => 'c45-service',
                'version' => '0.1.0',
                'environment' => 'testing',
            ]),
        ]);

        $this->actingAs($this->user(User::ROLE_ADMIN))
            ->get(route('admin.c45.status'))
            ->assertOk()
            ->assertSee('Status Service C4.5')
            ->assertSee('Terhubung')
            ->assertSee('c45-service');
    }

    public function test_admin_sees_a_friendly_message_when_c45_service_is_unreachable(): void
    {
        Http::fake(Http::failedConnection('Connection refused'));

        $this->actingAs($this->user(User::ROLE_ADMIN))
            ->get(route('admin.c45.status'))
            ->assertOk()
            ->assertSee('Tidak terhubung')
            ->assertSee('Pastikan service Python sedang berjalan');
    }

    public function test_non_admin_cannot_run_the_c45_health_check(): void
    {
        Http::fake();

        $this->actingAs($this->user(User::ROLE_SISWA))
            ->get(route('admin.c45.status'))
            ->assertForbidden();

        Http::assertNothingSent();
    }

    public function test_admin_dashboard_does_not_call_the_c45_service(): void
    {
        Http::fake();

        $this->actingAs($this->user(User::ROLE_ADMIN))
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Status C4.5');

        Http::assertNothingSent();
    }

    private function user(string $role): User
    {
        $user = new User([
            'name' => 'Test User',
            'email' => "{$role}@example.com",
            'password' => 'password',
            'role' => $role,
        ]);
        $user->id = 1;
        $user->exists = true;

        return $user;
    }
}

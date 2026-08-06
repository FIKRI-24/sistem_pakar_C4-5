<?php

namespace Tests\Feature\Admin;

use App\Models\DecisionTree;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class DecisionTreeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config()->set('services.c45.base_url', 'http://127.0.0.1:8001');
        Http::preventStrayRequests();
    }

    public function test_admin_can_view_decision_tree_index_when_no_active_tree(): void
    {
        $this->actingAs($this->adminUser())
            ->get(route('admin.decision-tree.index'))
            ->assertOk()
            ->assertSee('Belum Ada Model Pohon Keputusan');
    }

    public function test_admin_can_view_decision_tree_index_with_active_tree_and_rules(): void
    {
        // Create a dummy decision tree
        $admin = $this->adminUser();
        DecisionTree::create([
            'versi' => 1,
            'struktur_json' => ['type' => 'leaf', 'class' => 1, 'count' => 10],
            'akurasi' => 0.925,
            'dibuat_oleh' => $admin->id,
            'status_aktif' => true,
        ]);

        Http::fake([
            'http://127.0.0.1:8001/tree/rules' => Http::response([
                'versi' => 1,
                'akurasi' => 0.925,
                'rules' => [
                    [
                        'rule' => "IF minat = 'Investigative' THEN Rekomendasikan Karir = 'Software Engineer' (Sampel: 10, Distribusi: [Software Engineer: 10])",
                        'career_id' => 1,
                        'career_name' => 'Software Engineer',
                        'conditions' => ["minat = 'Investigative'"],
                        'count' => 10
                    ]
                ]
            ]),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.decision-tree.index'))
            ->assertOk()
            ->assertSee('Versi #1')
            ->assertSee('92,50%')
            ->assertSee('Software Engineer');
    }

    public function test_admin_can_view_decision_tree_index_when_c45_service_is_offline(): void
    {
        $admin = $this->adminUser();
        DecisionTree::create([
            'versi' => 1,
            'struktur_json' => ['type' => 'leaf', 'class' => 1, 'count' => 10],
            'akurasi' => 0.925,
            'dibuat_oleh' => $admin->id,
            'status_aktif' => true,
        ]);

        Http::fake([
            'http://127.0.0.1:8001/tree/rules' => Http::failedConnection('Connection refused'),
        ]);

        $this->actingAs($admin)
            ->get(route('admin.decision-tree.index'))
            ->assertOk()
            ->assertSee('Layanan C4.5 Python saat ini offline');
    }

    public function test_admin_can_trigger_model_training(): void
    {
        $admin = $this->adminUser();

        Http::fake([
            'http://127.0.0.1:8001/train' => Http::response([
                'status' => 'success',
                'versi' => 2,
                'akurasi' => 0.85,
            ]),
        ]);

        $this->actingAs($admin)
            ->post(route('admin.decision-tree.train'))
            ->assertRedirect(route('admin.decision-tree.index'))
            ->assertSessionHas('success', 'Latih ulang berhasil! Pohon Keputusan Versi #2 terbentuk dengan Akurasi: 85,00%.');

        Http::assertSent(fn ($request) => $request->method() === 'POST'
            && $request->url() === 'http://127.0.0.1:8001/train'
            && $request['dibuat_oleh'] === $admin->id);
    }

    public function test_non_admin_cannot_trigger_model_training(): void
    {
        $siswa = User::factory()->create(['role' => User::ROLE_SISWA]);

        $this->actingAs($siswa)
            ->post(route('admin.decision-tree.train'))
            ->assertForbidden();
    }

    private function adminUser(): User
    {
        return User::factory()->create(['role' => User::ROLE_ADMIN]);
    }
}

<?php

namespace Tests\Feature\Admin;

use App\Models\Karir;
use App\Models\Kriteria;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MasterDataCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_access_master_data(): void
    {
        $siswa = User::factory()->create(['role' => User::ROLE_SISWA]);

        foreach (['admin.siswas.index', 'admin.kriterias.index', 'admin.karirs.index'] as $route) {
            $this->actingAs($siswa)->get(route($route))->assertForbidden();
        }
    }

    public function test_admin_can_create_update_and_delete_a_student_account(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)->post(route('admin.siswas.store'), [
            'name' => 'Siswa Baru',
            'username' => 'siswa_baru',
            'email' => 'baru@example.com',
            'password' => 'password123',
            'nis' => '2026001',
            'kelas' => 'XII TKJ 1',
            'jurusan' => 'Teknik Komputer dan Jaringan',
        ])->assertRedirect(route('admin.siswas.index'));

        $siswa = Siswa::query()->where('nis', '2026001')->with('user')->firstOrFail();
        $this->assertSame(User::ROLE_SISWA, $siswa->user->role);
        $this->assertSame('siswa_baru', $siswa->user->username);
        $this->assertTrue(Hash::check('password123', $siswa->user->password));

        $this->actingAs($admin)->put(route('admin.siswas.update', $siswa), [
            'name' => 'Siswa Diperbarui',
            'username' => 'siswa_baru',
            'email' => 'baru@example.com',
            'password' => '',
            'nis' => '2026001',
            'kelas' => 'XII TKJ 2',
            'jurusan' => 'Teknik Komputer dan Jaringan',
        ])->assertRedirect(route('admin.siswas.index'));

        $this->assertDatabaseHas('users', ['id' => $siswa->user_id, 'name' => 'Siswa Diperbarui']);
        $this->assertDatabaseHas('siswas', ['id' => $siswa->id, 'kelas' => 'XII TKJ 2']);

        $this->actingAs($admin)->delete(route('admin.siswas.destroy', $siswa))
            ->assertRedirect(route('admin.siswas.index'));
        $this->assertDatabaseHas('users', ['id' => $siswa->user_id]);
        $this->assertSoftDeleted('siswas', ['id' => $siswa->id]);
    }

    public function test_admin_can_manage_kriteria(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)->post(route('admin.kriterias.store'), [
            'nama_kriteria' => 'Minat',
            'tipe_data' => Kriteria::TYPE_KATEGORIK,
            'keterangan' => 'Minat dominan.',
        ])->assertRedirect(route('admin.kriterias.index'));

        $kriteria = Kriteria::firstOrFail();
        $this->actingAs($admin)->put(route('admin.kriterias.update', $kriteria), [
            'nama_kriteria' => 'Minat Karir',
            'tipe_data' => Kriteria::TYPE_KATEGORIK,
            'keterangan' => 'Minat dominan siswa.',
        ])->assertRedirect(route('admin.kriterias.index'));
        $this->assertDatabaseHas('kriterias', ['nama_kriteria' => 'Minat Karir']);

        $this->actingAs($admin)->delete(route('admin.kriterias.destroy', $kriteria));
        $this->assertSoftDeleted('kriterias', ['id' => $kriteria->id]);
    }

    public function test_admin_can_manage_karir(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)->post(route('admin.karirs.store'), [
            'nama_karir' => 'Teknisi Komputer',
            'bidang_pekerjaan' => 'Teknologi Informasi',
            'deskripsi' => 'Merawat perangkat komputer.',
            'informasi_pendukung' => 'Sertifikasi kompetensi membantu.',
        ])->assertRedirect(route('admin.karirs.index'));

        $karir = Karir::firstOrFail();
        $this->actingAs($admin)->put(route('admin.karirs.update', $karir), [
            'nama_karir' => 'Teknisi Sistem Komputer',
            'bidang_pekerjaan' => 'Teknologi Informasi',
            'deskripsi' => 'Merawat perangkat dan sistem komputer.',
            'informasi_pendukung' => null,
        ])->assertRedirect(route('admin.karirs.index'));
        $this->assertDatabaseHas('karirs', ['nama_karir' => 'Teknisi Sistem Komputer']);

        $this->actingAs($admin)->delete(route('admin.karirs.destroy', $karir));
        $this->assertSoftDeleted('karirs', ['id' => $karir->id]);
    }

    public function test_master_data_indexes_support_search(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        Kriteria::create(['nama_kriteria' => 'Kepribadian', 'tipe_data' => 'kategorik']);
        Karir::create(['nama_karir' => 'Desainer Grafis', 'bidang_pekerjaan' => 'Kreatif']);

        $this->actingAs($admin)->get(route('admin.kriterias.index', ['q' => 'Kepribadian']))
            ->assertOk()->assertSee('Kepribadian');
        $this->actingAs($admin)->get(route('admin.karirs.index', ['q' => 'Desainer']))
            ->assertOk()->assertSee('Desainer Grafis');
    }
}

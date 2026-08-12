<?php

namespace Tests\Feature\Siswa;

use App\Models\Siswa;
use App\Models\User;
use App\Models\Tes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SiswaSelfRegisterAndBiodataGateTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_can_self_register_and_is_redirected_to_biodata(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Siswa Mandiri',
            'username' => 'siswa_mandiri',
            'nis' => '11223344',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('siswa.biodata'));
        $this->assertAuthenticated();

        $user = User::where('username', 'siswa_mandiri')->firstOrFail();
        $this->assertSame(User::ROLE_SISWA, $user->role);
        $this->assertSame('Siswa Mandiri', $user->name);

        $siswa = $user->siswa;
        $this->assertNotNull($siswa);
        $this->assertSame('11223344', $siswa->nis);
        $this->assertNull($siswa->kelas);
        $this->assertNull($siswa->jurusan);
        $this->assertNull($siswa->jenis_kelamin);
    }

    public function test_siswa_with_incomplete_biodata_is_redirected_to_biodata_page(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_SISWA]);
        $siswa = Siswa::create([
            'user_id' => $user->id,
            'nis' => '112233',
            'kelas' => null,
            'jurusan' => null,
            'jenis_kelamin' => null,
        ]);

        $response = $this->actingAs($user)->get(route('siswa.konsultasi.index'));

        $response->assertRedirect(route('siswa.biodata'));
        $response->assertSessionHas('error', 'Lengkapi biodata Anda terlebih dahulu sebelum mengerjakan tes.');
    }

    public function test_siswa_can_complete_biodata_and_then_access_konsultasi(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_SISWA, 'name' => 'Original Name']);
        $siswa = Siswa::create([
            'user_id' => $user->id,
            'nis' => '112233',
            'kelas' => null,
            'jurusan' => null,
            'jenis_kelamin' => null,
        ]);

        // Submit biodata completion
        $response = $this->actingAs($user)->post(route('siswa.biodata.update'), [
            'name' => 'Updated Name',
            'nis' => '112233',
            'kelas' => 'XII RPL 1',
            'jurusan' => 'Rekayasa Perangkat Lunak',
            'jenis_kelamin' => 'L',
        ]);

        $response->assertRedirect(route('siswa.dashboard'));
        $response->assertSessionHas('success', 'Biodata berhasil diperbarui.');

        $user->refresh();
        $siswa->refresh();

        $this->assertSame('Updated Name', $user->name);
        $this->assertSame('XII RPL 1', $siswa->kelas);
        $this->assertSame('Rekayasa Perangkat Lunak', $siswa->jurusan);
        $this->assertSame('L', $siswa->jenis_kelamin);

        // Can access consultation routes now
        $this->actingAs($user)->get(route('siswa.konsultasi.index'))
            ->assertOk();
    }

    public function test_siswa_created_by_admin_with_complete_data_does_not_get_redirected(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_SISWA, 'name' => 'Siswa Lengkap']);
        $siswa = Siswa::create([
            'user_id' => $user->id,
            'nis' => '998877',
            'kelas' => 'XII TKJ 2',
            'jurusan' => 'Teknik Komputer Jaringan',
            'jenis_kelamin' => 'P',
        ]);

        $this->actingAs($user)->get(route('siswa.konsultasi.index'))
            ->assertOk();
    }

    public function test_admin_can_manage_siswa_with_jenis_kelamin(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)->post(route('admin.siswas.store'), [
            'name' => 'Siswa Baru Admin',
            'username' => 'siswa_admin',
            'password' => 'password123',
            'nis' => '2026111',
            'kelas' => 'XII TKJ 1',
            'jurusan' => 'Teknik Komputer dan Jaringan',
            'jenis_kelamin' => 'L',
        ])->assertRedirect(route('admin.siswas.index'));

        $siswa = Siswa::query()->where('nis', '2026111')->with('user')->firstOrFail();
        $this->assertSame('L', $siswa->jenis_kelamin);
        $this->assertSame('Siswa Baru Admin', $siswa->user->name);

        // Update siswa
        $this->actingAs($admin)->put(route('admin.siswas.update', $siswa), [
            'name' => 'Siswa Baru Admin Updated',
            'username' => 'siswa_admin',
            'password' => '',
            'nis' => '2026111',
            'kelas' => 'XII TKJ 1',
            'jurusan' => 'Teknik Komputer dan Jaringan',
            'jenis_kelamin' => 'P',
        ])->assertRedirect(route('admin.siswas.index'));

        $siswa->refresh();
        $this->assertSame('P', $siswa->jenis_kelamin);
        $this->assertSame('Siswa Baru Admin Updated', $siswa->user->name);
    }
}

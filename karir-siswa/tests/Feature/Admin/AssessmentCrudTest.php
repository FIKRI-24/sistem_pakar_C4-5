<?php

namespace Tests\Feature\Admin;

use App\Models\Kriteria;
use App\Models\KriteriaOpsi;
use App\Models\PilihanJawaban;
use App\Models\Soal;
use App\Models\Tes;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssessmentCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_guru_bk_can_access_assessment_routes_but_siswa_cannot(): void
    {
        $guruBk = User::factory()->create(['role' => User::ROLE_GURU_BK, 'password' => 'password']);

        $this->post(route('login.store'), [
            'username' => $guruBk->username,
            'password' => 'password',
        ])->assertRedirect(route('guru-bk.dashboard'));

        foreach (['admin.tes.index', 'admin.soals.index', 'admin.pilihan-jawabans.index'] as $route) {
            $this->get(route($route))->assertOk();
        }

        $siswa = User::factory()->create(['role' => User::ROLE_SISWA]);
        foreach (['admin.tes.index', 'admin.soals.index', 'admin.pilihan-jawabans.index'] as $route) {
            $this->actingAs($siswa)->get(route($route))->assertForbidden();
        }
    }

    public function test_admin_can_create_update_and_delete_a_tes(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $this->actingAs($admin)->post(route('admin.tes.store'), [
            'nama_tes' => 'Tes Potensi Karir',
            'deskripsi' => 'Tes awal.',
            'durasi_menit' => 45,
            'status_aktif' => true,
        ])->assertRedirect(route('admin.tes.index'));

        $tes = Tes::firstOrFail();
        $this->actingAs($admin)->put(route('admin.tes.update', $tes), [
            'nama_tes' => 'Tes Potensi Karir Final',
            'deskripsi' => null,
            'durasi_menit' => 60,
            'status_aktif' => false,
        ])->assertRedirect(route('admin.tes.index'));
        $this->assertDatabaseHas('tes', ['nama_tes' => 'Tes Potensi Karir Final', 'status_aktif' => 0]);

        $this->actingAs($admin)->delete(route('admin.tes.destroy', $tes));
        $this->assertDatabaseMissing('tes', ['id' => $tes->id]);
    }

    public function test_admin_can_manage_soal_and_likert_pilihan_with_matching_option(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $tes = Tes::create(['nama_tes' => 'Tes Karir', 'status_aktif' => true]);
        $minat = Kriteria::create(['nama_kriteria' => 'Minat', 'tipe_data' => Kriteria::TYPE_KATEGORIK]);
        $bakat = Kriteria::create(['nama_kriteria' => 'Bakat', 'tipe_data' => Kriteria::TYPE_KATEGORIK]);
        $opsiMinat = KriteriaOpsi::create(['kriteria_id' => $minat->id, 'label' => 'Investigative', 'urutan' => 1]);
        $opsiBakat = KriteriaOpsi::create(['kriteria_id' => $bakat->id, 'label' => 'Verbal', 'urutan' => 1]);

        $this->actingAs($admin)->post(route('admin.soals.store'), [
            'tes_id' => $tes->id,
            'kriteria_id' => $minat->id,
            'pertanyaan' => 'Saya suka menyelidiki masalah.',
            'urutan' => 1,
        ])->assertRedirect(route('admin.soals.index'));

        $soal = Soal::firstOrFail();
        $this->actingAs($admin)->put(route('admin.soals.update', $soal), [
            'tes_id' => $tes->id,
            'kriteria_id' => $minat->id,
            'pertanyaan' => 'Saya suka menganalisis masalah.',
            'urutan' => 2,
        ])->assertRedirect(route('admin.soals.index'));

        $this->actingAs($admin)->post(route('admin.pilihan-jawabans.store'), [
            'soal_id' => $soal->id,
            'pilihan' => 'Sangat setuju',
            'skor' => 5,
            'kriteria_opsi_id' => $opsiMinat->id,
        ])->assertRedirect(route('admin.pilihan-jawabans.index'));

        $pilihan = PilihanJawaban::firstOrFail();
        $this->actingAs($admin)->put(route('admin.pilihan-jawabans.update', $pilihan), [
            'soal_id' => $soal->id,
            'pilihan' => 'Setuju',
            'skor' => 4,
            'kriteria_opsi_id' => $opsiMinat->id,
        ])->assertRedirect(route('admin.pilihan-jawabans.index'));
        $this->assertDatabaseHas('pilihan_jawabans', ['pilihan' => 'Setuju', 'skor' => 4]);

        $this->actingAs($admin)->post(route('admin.pilihan-jawabans.store'), [
            'soal_id' => $soal->id,
            'pilihan' => 'Opsi tidak sesuai',
            'skor' => 5,
            'kriteria_opsi_id' => $opsiBakat->id,
        ])->assertSessionHasErrors('kriteria_opsi_id');

        $this->actingAs($admin)->post(route('admin.pilihan-jawabans.store'), [
            'soal_id' => $soal->id,
            'pilihan' => 'Skor tidak valid',
            'skor' => 6,
        ])->assertSessionHasErrors('skor');

        $this->actingAs($admin)->delete(route('admin.pilihan-jawabans.destroy', $pilihan));
        $this->assertDatabaseMissing('pilihan_jawabans', ['id' => $pilihan->id]);
        $this->actingAs($admin)->delete(route('admin.soals.destroy', $soal));
        $this->assertDatabaseMissing('soals', ['id' => $soal->id]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\HasilTes;
use App\Models\Karir;
use App\Models\RekomendasiKarir;
use App\Models\Siswa;
use App\Models\Tes;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardStatsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_guru_bk_can_view_dashboard_with_real_time_career_distribution(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'username' => 'admin_dash']);
        $guruBk = User::factory()->create(['role' => 'guru_bk', 'username' => 'guru_dash']);

        $siswaUser = User::factory()->create(['role' => 'siswa', 'username' => 'siswa_dash']);
        $siswa = Siswa::create([
            'user_id' => $siswaUser->id,
            'nis' => '998877',
            'kelas' => 'XII',
            'jurusan' => 'RPL',
            'jenis_kelamin' => 'L',
        ]);

        $tes = Tes::create([
            'nama_tes' => 'Tes Minat Bakat',
            'deskripsi' => 'Tes Rekomendasi Karir C4.5',
            'status_aktif' => true,
        ]);

        $karir1 = Karir::create(['nama_karir' => 'Software Engineer', 'deskripsi' => 'Dev', 'bidang_pekerjaan' => 'IT']);
        $karir2 = Karir::create(['nama_karir' => 'Data Analyst', 'deskripsi' => 'Data', 'bidang_pekerjaan' => 'IT']);

        $hasil1 = HasilTes::create(['siswa_id' => $siswa->id, 'tes_id' => $tes->id, 'tanggal_tes' => now()]);
        $hasil2 = HasilTes::create(['siswa_id' => $siswa->id, 'tes_id' => $tes->id, 'tanggal_tes' => now()]);

        RekomendasiKarir::create([
            'hasil_tes_id' => $hasil1->id,
            'karir_id' => $karir1->id,
            'persen_kecocokan' => 88.0,
            'alasan' => 'Rule 1',
        ]);

        RekomendasiKarir::create([
            'hasil_tes_id' => $hasil2->id,
            'karir_id' => $karir1->id,
            'persen_kecocokan' => 95.0,
            'alasan' => 'Rule 2',
        ]);

        // Verify Admin dashboard renders dynamic real-time data
        $responseAdmin = $this->actingAs($admin)->get(route('admin.dashboard'));
        $responseAdmin->assertOk();
        $responseAdmin->assertSee('Distribusi Rekomendasi Karir');
        $responseAdmin->assertSee('Software Engineer');
        $responseAdmin->assertSee('2 Siswa (100%)');

        // Add a new recommendation for karir2 (Data Analyst) and verify real-time update
        $hasil3 = HasilTes::create(['siswa_id' => $siswa->id, 'tes_id' => $tes->id, 'tanggal_tes' => now()]);
        RekomendasiKarir::create([
            'hasil_tes_id' => $hasil3->id,
            'karir_id' => $karir2->id,
            'persen_kecocokan' => 90.0,
            'alasan' => 'Rule 3',
        ]);

        // Verify Guru BK dashboard instantly reflects the updated distribution (2 Software Engineer = 66.7%, 1 Data Analyst = 33.3%)
        $responseGuru = $this->actingAs($guruBk)->get(route('guru-bk.dashboard'));
        $responseGuru->assertOk();
        $responseGuru->assertSee('Software Engineer');
        $responseGuru->assertSee('2 Siswa (66.7%)');
        $responseGuru->assertSee('Data Analyst');
        $responseGuru->assertSee('1 Siswa (33.3%)');
    }
}

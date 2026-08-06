<?php

namespace Tests\Feature;

use App\Models\HasilTes;
use App\Models\Karir;
use App\Models\Kriteria;
use App\Models\RekomendasiKarir;
use App\Models\Siswa;
use App\Models\Tes;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PdfExportTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $guruBkUser;
    protected User $siswaUser1;
    protected User $siswaUser2;
    protected Siswa $siswa1;
    protected Siswa $siswa2;
    protected HasilTes $hasilTes1;
    protected HasilTes $hasilTes2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create(['role' => 'admin', 'username' => 'admin_test']);
        $this->guruBkUser = User::factory()->create(['role' => 'guru_bk', 'username' => 'gurubk_test']);

        $this->siswaUser1 = User::factory()->create(['role' => 'siswa', 'username' => 'siswa_1', 'name' => 'Siswa Satu']);
        $this->siswa1 = Siswa::create([
            'user_id' => $this->siswaUser1->id,
            'nis' => '12345',
            'kelas' => 'XII',
            'jurusan' => 'RPL',
            'jenis_kelamin' => 'L',
        ]);

        $this->siswaUser2 = User::factory()->create(['role' => 'siswa', 'username' => 'siswa_2', 'name' => 'Siswa Dua']);
        $this->siswa2 = Siswa::create([
            'user_id' => $this->siswaUser2->id,
            'nis' => '67890',
            'kelas' => 'XII',
            'jurusan' => 'TKJ',
            'jenis_kelamin' => 'P',
        ]);

        $tes = Tes::create([
            'nama_tes' => 'Tes Minat Bakat',
            'deskripsi' => 'Tes Rekomendasi Karir C4.5',
            'status_aktif' => true,
        ]);

        $kriteria = Kriteria::create([
            'nama_kriteria' => 'Minat',
            'tipe_data' => 'kategorik',
        ]);

        $karir = Karir::create([
            'nama_karir' => 'Software Engineer',
            'deskripsi' => 'Pengembang Perangkat Lunak',
            'bidang_pekerjaan' => 'Teknologi Informasi',
        ]);

        $this->hasilTes1 = HasilTes::create([
            'siswa_id' => $this->siswa1->id,
            'tes_id' => $tes->id,
            'tanggal_tes' => now(),
        ]);

        $this->hasilTes1->details()->create([
            'kriteria_id' => $kriteria->id,
            'nilai_kategorik' => 'Investigative',
        ]);

        RekomendasiKarir::create([
            'hasil_tes_id' => $this->hasilTes1->id,
            'karir_id' => $karir->id,
            'persen_kecocokan' => 92.5,
            'alasan' => 'IF Minat = Investigative THEN Software Engineer',
        ]);

        $this->hasilTes2 = HasilTes::create([
            'siswa_id' => $this->siswa2->id,
            'tes_id' => $tes->id,
            'tanggal_tes' => now(),
        ]);
    }

    public function test_siswa_can_download_own_pdf_report(): void
    {
        $response = $this->actingAs($this->siswaUser1)
            ->get(route('siswa.hasil-tes.pdf', $this->hasilTes1));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_siswa_cannot_download_other_siswa_pdf_report(): void
    {
        $response = $this->actingAs($this->siswaUser1)
            ->get(route('siswa.hasil-tes.pdf', $this->hasilTes2));

        $response->assertNotFound();
    }

    public function test_admin_and_guru_bk_can_download_any_siswa_pdf_report(): void
    {
        $responseAdmin = $this->actingAs($this->adminUser)
            ->get(route('admin.tes.hasil-tes.pdf', $this->hasilTes1));

        $responseAdmin->assertOk();
        $responseAdmin->assertHeader('content-type', 'application/pdf');

        $responseGuru = $this->actingAs($this->guruBkUser)
            ->get(route('admin.tes.hasil-tes.pdf', $this->hasilTes2));

        $responseGuru->assertOk();
        $responseGuru->assertHeader('content-type', 'application/pdf');
    }

    public function test_admin_and_guru_bk_can_download_pdf_rekap_report(): void
    {
        $responseAdmin = $this->actingAs($this->adminUser)
            ->get(route('admin.tes.rekap-hasil.pdf'));

        $responseAdmin->assertOk();
        $responseAdmin->assertHeader('content-type', 'application/pdf');

        $responseGuru = $this->actingAs($this->guruBkUser)
            ->get(route('admin.tes.rekap-hasil.pdf', ['q' => 'Siswa']));

        $responseGuru->assertOk();
        $responseGuru->assertHeader('content-type', 'application/pdf');
    }

    public function test_siswa_cannot_access_admin_pdf_routes(): void
    {
        $response = $this->actingAs($this->siswaUser1)
            ->get(route('admin.tes.rekap-hasil.pdf'));

        $response->assertForbidden();
    }
}

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

class TesLengkapTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_and_guru_bk_can_access_buat_lengkap_form_but_siswa_cannot(): void
    {
        $guruBk = User::factory()->create(['role' => User::ROLE_GURU_BK]);
        $response = $this->actingAs($guruBk)->get(route('admin.tes.buat-lengkap'));
        $response->assertOk();

        $siswa = User::factory()->create(['role' => User::ROLE_SISWA]);
        $response = $this->actingAs($siswa)->get(route('admin.tes.buat-lengkap'));
        $response->assertForbidden();
    }

    public function test_validation_rejects_empty_data_or_no_questions(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);

        $response = $this->actingAs($admin)->post(route('admin.tes.buat-lengkap.store'), [
            'nama_tes' => '',
            'status_aktif' => '1',
            'soals' => []
        ]);
        $response->assertSessionHasErrors(['nama_tes', 'soals']);
    }

    public function test_validation_requires_at_least_two_choices_for_categorical_questions(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $kriteria = Kriteria::create(['nama_kriteria' => 'Minat', 'tipe_data' => Kriteria::TYPE_KATEGORIK]);

        $response = $this->actingAs($admin)->post(route('admin.tes.buat-lengkap.store'), [
            'nama_tes' => 'Tes Baru',
            'status_aktif' => '1',
            'soals' => [
                [
                    'pertanyaan' => 'Pertanyaan 1',
                    'kriteria_id' => $kriteria->id,
                    'pilihans' => [
                        ['pilihan' => 'Ya', 'skor' => 5], // Only 1 choice
                    ]
                ]
            ]
        ]);

        $response->assertSessionHasErrors(['soals.0.pilihans']);
    }

    public function test_validation_rejects_choices_with_invalid_kriteria_option(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $kriteriaMinat = Kriteria::create(['nama_kriteria' => 'Minat', 'tipe_data' => Kriteria::TYPE_KATEGORIK]);
        $kriteriaBakat = Kriteria::create(['nama_kriteria' => 'Bakat', 'tipe_data' => Kriteria::TYPE_KATEGORIK]);
        $opsiBakat = KriteriaOpsi::create(['kriteria_id' => $kriteriaBakat->id, 'label' => 'Verbal', 'urutan' => 1]);

        $response = $this->actingAs($admin)->post(route('admin.tes.buat-lengkap.store'), [
            'nama_tes' => 'Tes Baru',
            'status_aktif' => '1',
            'soals' => [
                [
                    'pertanyaan' => 'Pertanyaan 1',
                    'kriteria_id' => $kriteriaMinat->id,
                    'pilihans' => [
                        ['pilihan' => 'Opsi A', 'skor' => 5, 'kriteria_opsi_id' => $opsiBakat->id], // Mismatched criteria option
                        ['pilihan' => 'Opsi B', 'skor' => 3, 'kriteria_opsi_id' => $opsiBakat->id]
                    ]
                ]
            ]
        ]);

        $response->assertSessionHasErrors(['soals.0.pilihans.0.kriteria_opsi_id', 'soals.0.pilihans.1.kriteria_opsi_id']);
    }

    public function test_successfully_stores_integrated_test_data_and_siswa_can_take_it(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $kriteriaMinat = Kriteria::create(['nama_kriteria' => 'Minat', 'tipe_data' => Kriteria::TYPE_KATEGORIK]);
        $opsiArtistic = KriteriaOpsi::create(['kriteria_id' => $kriteriaMinat->id, 'label' => 'Artistic', 'urutan' => 1]);
        $opsiRealistic = KriteriaOpsi::create(['kriteria_id' => $kriteriaMinat->id, 'label' => 'Realistic', 'urutan' => 2]);
        $kriteriaNilai = Kriteria::create(['nama_kriteria' => 'Nilai Akademik', 'tipe_data' => Kriteria::TYPE_NUMERIK]);

        $response = $this->actingAs($admin)->post(route('admin.tes.buat-lengkap.store'), [
            'nama_tes' => 'Tes Integrasi Lengkap',
            'deskripsi' => 'Deskripsi tes integrasi.',
            'durasi_menit' => 30,
            'status_aktif' => '1',
            'soals' => [
                [
                    'pertanyaan' => 'Pertanyaan Minat',
                    'kriteria_id' => $kriteriaMinat->id,
                    'urutan' => 1,
                    'pilihans' => [
                        ['pilihan' => 'Suka Menggambar', 'skor' => 5, 'kriteria_opsi_id' => $opsiArtistic->id],
                        ['pilihan' => 'Suka Merakit', 'skor' => 5, 'kriteria_opsi_id' => $opsiRealistic->id]
                    ]
                ],
                [
                    'pertanyaan' => 'Input Nilai Akademik Anda',
                    'kriteria_id' => $kriteriaNilai->id,
                    'urutan' => 2,
                    'pilihans' => [] // Numeric doesn't need choices
                ]
            ]
        ]);

        $response->assertRedirect(route('admin.tes.index'));

        $this->assertDatabaseHas('tes', [
            'nama_tes' => 'Tes Integrasi Lengkap',
            'durasi_menit' => 30,
            'status_aktif' => 1
        ]);

        $tes = Tes::where('nama_tes', 'Tes Integrasi Lengkap')->firstOrFail();
        $this->assertCount(2, $tes->soals);

        $soalMinat = $tes->soals()->where('kriteria_id', $kriteriaMinat->id)->firstOrFail();
        $this->assertCount(2, $soalMinat->pilihanJawabans);
        $this->assertDatabaseHas('pilihan_jawabans', [
            'soal_id' => $soalMinat->id,
            'pilihan' => 'Suka Menggambar',
            'skor' => 5.0,
            'kriteria_opsi_id' => $opsiArtistic->id
        ]);

        // Verify student can take this test
        $siswaUser = User::factory()->create(['role' => User::ROLE_SISWA]);
        $siswaUser->siswa()->create(['nis' => '12345', 'kelas' => 'XII', 'jurusan' => 'TKJ']);

        $this->actingAs($siswaUser)->get(route('siswa.konsultasi.index'))->assertOk()
            ->assertSee('Tes Integrasi Lengkap');

        $siswaResponse = $this->actingAs($siswaUser)->get(route('siswa.konsultasi.show', $tes));
        $siswaResponse->assertOk()
            ->assertSee('Pertanyaan Minat')
            ->assertSee('Input Nilai Akademik Anda');

        // Submit test
        $this->actingAs($siswaUser)->post(route('siswa.konsultasi.store', $tes), [
            'jawabans' => [
                $soalMinat->id => $soalMinat->pilihanJawabans->firstWhere('kriteria_opsi_id', $opsiArtistic->id)->id
            ],
            'nilai_numerik' => [
                $kriteriaNilai->id => 85.5
            ]
        ])->assertSessionHasNoErrors();

        $this->assertDatabaseHas('hasil_tes', [
            'siswa_id' => $siswaUser->siswa->id,
            'tes_id' => $tes->id,
        ]);
    }
}

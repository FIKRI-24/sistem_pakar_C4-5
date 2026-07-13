<?php

namespace Tests\Feature;

use App\Models\HasilTes;
use App\Models\Kriteria;
use App\Models\Siswa;
use App\Models\Tes;
use App\Models\User;
use App\Services\C45DataFormatter;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class EndToEndFase1To3Test extends TestCase
{
    use RefreshDatabase;

    public function test_fase_1_to_3_complete_flow_works_from_login_to_contract_payload(): void
    {
        $this->seed(DatabaseSeeder::class);

        // Step 1: login Admin and open the Admin dashboard.
        $this->post(route('login.store'), [
            'username' => 'admin_sistem',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));
        $this->get(route('admin.dashboard'))->assertOk();

        // Step 2: create a new student through the Admin CRUD.
        $nis = 'E2E'.now()->format('YmdHisv');
        $this->post(route('admin.siswas.store'), [
            'name' => 'Siswa Uji Otomatis',
            'username' => 'siswa_uji_otomatis',
            'email' => 'siswa_uji_otomatis@karirsiswa.test',
            'password' => 'password',
            'nis' => $nis,
            'kelas' => 'XII TKJ 1',
            'jurusan' => 'Teknik Komputer dan Jaringan',
        ])->assertRedirect(route('admin.siswas.index'));

        $newStudent = Siswa::query()->where('nis', $nis)->with('user')->firstOrFail();
        $this->assertDatabaseHas('users', [
            'id' => $newStudent->user_id,
            'name' => 'Siswa Uji Otomatis',
            'username' => 'siswa_uji_otomatis',
            'role' => User::ROLE_SISWA,
        ]);
        $this->assertDatabaseHas('siswas', [
            'id' => $newStudent->id,
            'nis' => $nis,
            'kelas' => 'XII TKJ 1',
            'jurusan' => 'Teknik Komputer dan Jaringan',
        ]);
        $this->assertTrue(Hash::check('password', $newStudent->user->password));

        // Step 3: verify the seeded master and training data remain consistent.
        $this->assertDatabaseCount('kriterias', 4);
        $this->assertDatabaseCount('karirs', 8);
        $this->assertDatabaseCount('data_trainings', 64);

        // Step 4: Guru BK can access all assessment management pages.
        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->post(route('login.store'), [
            'username' => 'guru_bk',
            'password' => 'password',
        ])->assertRedirect(route('guru-bk.dashboard'));
        $this->get(route('admin.tes.index'))->assertOk();
        $this->get(route('admin.soals.index'))->assertOk();
        $this->get(route('admin.pilihan-jawabans.index'))->assertOk();

        // Step 5: logout Guru BK, then login as the newly created student.
        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->post(route('login.store'), [
            'username' => 'siswa_uji_otomatis',
            'password' => 'password',
        ])->assertRedirect(route('siswa.dashboard'));

        // Step 6: the active seeded test, questions, and choices are visible.
        $this->get(route('siswa.konsultasi.index'))->assertOk()
            ->assertSee('Tes Potensi Karir #1');

        $tes = Tes::query()->where('nama_tes', 'Tes Potensi Karir #1')->firstOrFail();

        $consultationPage = $this->get(route('siswa.konsultasi.show', $tes));
        $consultationPage->assertOk()
            ->assertSee('Merakit komputer, memasang jaringan kabel LAN, atau merawat perangkat keras (TKJ).')
            ->assertSee('Sangat Suka')
            ->assertDontSee('Pilihan jawaban belum tersedia untuk soal ini.');

        $tes->load(['soals.kriteria', 'soals.pilihanJawabans']);
        $categoricalSoals = $tes->soals->filter(fn ($soal) => $soal->kriteria->tipe_data === Kriteria::TYPE_KATEGORIK);

        // Step 7: incomplete submission is rejected and creates no result.
        $this->post(route('siswa.konsultasi.store', $tes), [
            'jawabans' => [],
            'nilai_numerik' => [],
        ])->assertSessionHasErrors();
        $this->assertDatabaseCount('hasil_tes', 0);

        // Step 8: submit a complete, explicit scenario for the new student.
        $desiredLabels = [
            'Minat' => 'Investigative',
            'Bakat' => 'Numerik/Logika',
            'Kepribadian' => 'Compliance',
        ];
        $answers = [];
        foreach ($categoricalSoals as $soal) {
            $desiredLabel = $desiredLabels[$soal->kriteria->nama_kriteria];
            $mappedOptionLabel = $soal->pilihanJawabans->first()?->kriteriaOpsi?->label;
            if ($mappedOptionLabel === $desiredLabel) {
                $choice = $soal->pilihanJawabans->firstWhere('skor', 5.0);
            } else {
                $choice = $soal->pilihanJawabans->firstWhere('skor', 1.0);
            }
            $this->assertNotNull($choice, "Choice must exist for soal {$soal->id}.");
            $answers[$soal->id] = $choice->id;
        }

        $numericKriteriaId = Kriteria::query()->where('nama_kriteria', 'Nilai Akademik')->value('id');
        $submitResponse = $this->post(route('siswa.konsultasi.store', $tes), [
            'jawabans' => $answers,
            'nilai_numerik' => [$numericKriteriaId => 72.0],
        ]);

        // Step 9: result and exactly four criterion details are persisted.
        $hasilTes = HasilTes::query()->latest('id')->firstOrFail();
        $submitResponse->assertRedirect(route('siswa.hasil-tes.show', $hasilTes));
        $this->assertDatabaseHas('hasil_tes', [
            'id' => $hasilTes->id,
            'siswa_id' => $newStudent->id,
            'tes_id' => $tes->id,
        ]);
        $this->assertDatabaseCount('hasil_tes', 1);
        $this->assertDatabaseCount('hasil_tes_detail', 4);

        $details = $hasilTes->details()->with('kriteria')->get()->keyBy(fn ($detail) => $detail->kriteria->nama_kriteria);
        $this->assertSame('Investigative', $details['Minat']->nilai_kategorik);
        $this->assertSame('Numerik/Logika', $details['Bakat']->nilai_kategorik);
        $this->assertSame('Compliance', $details['Kepribadian']->nilai_kategorik);
        $this->assertSame(72.0, $details['Nilai Akademik']->nilai_numerik);

        // Step 10: the old demo student cannot access the new student's result.
        $this->post(route('logout'))->assertRedirect(route('login'));
        $this->post(route('login.store'), [
            'username' => 'siswa_demo',
            'password' => 'password',
        ])->assertRedirect(route('siswa.dashboard'));
        $this->get(route('siswa.hasil-tes.show', $hasilTes))->assertNotFound();

        // Step 11: both categorical labels and the numeric type follow the API contract.
        $payload = app(C45DataFormatter::class)->fromHasilTes($hasilTes->fresh());
        $this->assertSame([
            'minat' => 'Investigative',
            'bakat' => 'Numerik/Logika',
            'nilai_akademik' => 72.0,
            'kepribadian' => 'Compliance',
        ], $payload);
        $this->assertIsFloat($payload['nilai_akademik']);
        $this->assertSame(['minat', 'bakat', 'nilai_akademik', 'kepribadian'], array_keys($payload));
    }
}

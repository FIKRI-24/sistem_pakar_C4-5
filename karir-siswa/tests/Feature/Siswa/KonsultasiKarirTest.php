<?php

namespace Tests\Feature\Siswa;

use App\Models\HasilTes;
use App\Models\Kriteria;
use App\Models\KriteriaOpsi;
use App\Models\PilihanJawaban;
use App\Models\Siswa;
use App\Models\Soal;
use App\Models\Tes;
use App\Models\User;
use Database\Seeders\KriteriaFinalSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KonsultasiKarirTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(KriteriaFinalSeeder::class);
    }

    public function test_siswa_can_submit_a_complete_consultation_and_scores_are_saved(): void
    {
        [$user, $siswa] = $this->siswa('siswa_a');
        [$tes, $soals] = $this->tesDenganSoalLengkap();

        $response = $this->actingAs($user)->post(route('siswa.konsultasi.store', $tes), [
            'jawabans' => [
                $soals['Minat']->id => $soals['Minat']->pilihanJawabans->first()->id,
                $soals['Bakat']->id => $soals['Bakat']->pilihanJawabans->first()->id,
                $soals['Kepribadian']->id => $soals['Kepribadian']->pilihanJawabans->first()->id,
            ],
            'nilai_numerik' => [
                Kriteria::where('nama_kriteria', 'Nilai Akademik')->firstOrFail()->id => 87.5,
            ],
        ]);

        $hasilTes = HasilTes::firstOrFail();
        $response->assertRedirect(route('siswa.hasil-tes.show', $hasilTes));
        $this->assertDatabaseHas('hasil_tes', ['id' => $hasilTes->id, 'siswa_id' => $siswa->id, 'tes_id' => $tes->id]);
        $this->assertDatabaseCount('hasil_tes_detail', 4);
        $details = $hasilTes->details()->with('kriteria')->get()->keyBy(fn ($detail) => $detail->kriteria->nama_kriteria);
        $this->assertSame('Investigative', $details['Minat']->nilai_kategorik);
        $this->assertSame('Numerik/Logika', $details['Bakat']->nilai_kategorik);
        $this->assertSame('Compliance', $details['Kepribadian']->nilai_kategorik);
        $this->assertSame(87.5, $details['Nilai Akademik']->nilai_numerik);
    }

    public function test_category_totals_choose_the_highest_and_earliest_question_wins_ties(): void
    {
        [$user] = $this->siswa('siswa_total_score');
        [$tes, $answers, $numericKriteriaId] = $this->tesDenganMultipleSoalPerKriteria();

        $this->actingAs($user)->post(route('siswa.konsultasi.store', $tes), [
            'jawabans' => $answers,
            'nilai_numerik' => [$numericKriteriaId => 91.0],
        ])->assertRedirect();

        $hasilTes = HasilTes::firstOrFail();
        $details = $hasilTes->details()->with('kriteria')->get()->keyBy(fn ($detail) => $detail->kriteria->nama_kriteria);

        // Minat: Artistic totals 3 + 2 and beats Realistic's total 1.
        $this->assertSame('Artistic', $details['Minat']->nilai_kategorik);
        // Bakat: Verbal and Numerik/Logika both total 3; question order 4 wins.
        $this->assertSame('Verbal', $details['Bakat']->nilai_kategorik);
        // Kepribadian: Compliance totals 3 + 1 and beats Dominance's total 2.
        $this->assertSame('Compliance', $details['Kepribadian']->nilai_kategorik);
        $this->assertSame(91.0, $details['Nilai Akademik']->nilai_numerik);
    }

    public function test_submit_requires_all_categorical_answers_and_numeric_value(): void
    {
        [$user] = $this->siswa('siswa_validasi');
        [$tes, $soals] = $this->tesDenganSoalLengkap();

        $this->actingAs($user)->post(route('siswa.konsultasi.store', $tes), [
            'jawabans' => [$soals['Minat']->id => $soals['Minat']->pilihanJawabans->first()->id],
            'nilai_numerik' => [],
        ])->assertSessionHasErrors([
            "jawabans.{$soals['Bakat']->id}",
            "jawabans.{$soals['Kepribadian']->id}",
            'nilai_numerik.'.Kriteria::where('nama_kriteria', 'Nilai Akademik')->firstOrFail()->id,
        ]);
        $this->assertDatabaseCount('hasil_tes', 0);
    }

    public function test_consultation_page_renders_categorical_radio_options_and_numeric_input(): void
    {
        [$user] = $this->siswa('siswa_tampilan');
        [$tes, $soals] = $this->tesDenganSoalLengkap();

        $this->actingAs($user)->get(route('siswa.konsultasi.show', $tes))
            ->assertOk()
            ->assertSee('Sangat setuju')
            ->assertSee('name="jawabans['.$soals['Minat']->id.']"', false)
            ->assertSee('name="nilai_numerik['.$soals['Nilai Akademik']->kriteria_id.']"', false);
    }

    public function test_siswa_cannot_open_another_siswa_result_and_only_active_test_is_shown(): void
    {
        [$userA, $siswaA] = $this->siswa('siswa_a_isolasi');
        [, $siswaB] = $this->siswa('siswa_b_isolasi');
        $active = Tes::create(['nama_tes' => 'Tes Aktif', 'status_aktif' => true]);
        Tes::create(['nama_tes' => 'Tes Tidak Aktif', 'status_aktif' => false]);
        $hasilB = HasilTes::create(['siswa_id' => $siswaB->id, 'tes_id' => $active->id, 'tanggal_tes' => now()]);

        $this->actingAs($userA)->get(route('siswa.konsultasi.index'))
            ->assertOk()
            ->assertSee('Tes Aktif')
            ->assertDontSee('Tes Tidak Aktif');
        $this->actingAs($userA)->get(route('siswa.hasil-tes.show', $hasilB))->assertNotFound();
        $this->assertDatabaseHas('siswas', ['id' => $siswaA->id]);
    }

    /** @return array{0: User, 1: Siswa} */
    private function siswa(string $username): array
    {
        $user = User::factory()->create(['username' => $username, 'role' => User::ROLE_SISWA]);
        $siswa = Siswa::create([
            'user_id' => $user->id,
            'nis' => strtoupper($username),
            'kelas' => 'XII',
            'jurusan' => 'Teknik Komputer',
        ]);

        return [$user, $siswa];
    }

    /** @return array{0: Tes, 1: array<string, Soal>} */
    private function tesDenganSoalLengkap(): array
    {
        $tes = Tes::create(['nama_tes' => 'Tes Konsultasi Aktif', 'status_aktif' => true]);
        $soals = [];
        $definitions = [
            'Minat' => ['Saya senang mencari jawaban melalui riset.', 'Investigative'],
            'Bakat' => ['Saya mudah memahami pola angka dan logika.', 'Numerik/Logika'],
            'Kepribadian' => ['Saya teliti mengikuti aturan dan prosedur.', 'Compliance'],
        ];

        foreach ($definitions as $name => [$pertanyaan, $opsiLabel]) {
            $kriteria = Kriteria::where('nama_kriteria', $name)->firstOrFail();
            $soal = Soal::create([
                'tes_id' => $tes->id,
                'kriteria_id' => $kriteria->id,
                'pertanyaan' => $pertanyaan,
                'urutan' => count($soals) + 1,
            ]);
            PilihanJawaban::create([
                'soal_id' => $soal->id,
                'pilihan' => 'Sangat setuju',
                'skor' => 5,
                'kriteria_opsi_id' => KriteriaOpsi::where('kriteria_id', $kriteria->id)->where('label', $opsiLabel)->firstOrFail()->id,
            ]);
            $soals[$name] = $soal->load('pilihanJawabans');
        }

        $nilaiAkademik = Kriteria::where('nama_kriteria', 'Nilai Akademik')->firstOrFail();
        $soals['Nilai Akademik'] = Soal::create([
            'tes_id' => $tes->id,
            'kriteria_id' => $nilaiAkademik->id,
            'pertanyaan' => 'Masukkan rata-rata nilai mata pelajaran relevan.',
            'urutan' => 4,
        ]);

        return [$tes, $soals];
    }

    /**
     * @return array{0: Tes, 1: array<int, int>, 2: int}
     */
    private function tesDenganMultipleSoalPerKriteria(): array
    {
        $tes = Tes::create(['nama_tes' => 'Tes Total Skor', 'status_aktif' => true]);
        $answers = [];
        $urutan = 1;
        $definitions = [
            'Minat' => [['Realistic', 1], ['Artistic', 3], ['Artistic', 2]],
            'Bakat' => [['Verbal', 3], ['Numerik/Logika', 1], ['Numerik/Logika', 2]],
            'Kepribadian' => [['Dominance', 2], ['Compliance', 3], ['Compliance', 1]],
        ];

        foreach ($definitions as $namaKriteria => $questions) {
            $kriteria = Kriteria::where('nama_kriteria', $namaKriteria)->firstOrFail();
            foreach ($questions as [$opsiLabel, $skor]) {
                $soal = Soal::create([
                    'tes_id' => $tes->id,
                    'kriteria_id' => $kriteria->id,
                    'pertanyaan' => "Pertanyaan {$namaKriteria} {$urutan}",
                    'urutan' => $urutan,
                ]);
                $pilihan = PilihanJawaban::create([
                    'soal_id' => $soal->id,
                    'pilihan' => $opsiLabel,
                    'skor' => $skor,
                    'kriteria_opsi_id' => KriteriaOpsi::where('kriteria_id', $kriteria->id)
                        ->where('label', $opsiLabel)
                        ->firstOrFail()
                        ->id,
                ]);
                $answers[$soal->id] = $pilihan->id;
                $urutan++;
            }
        }

        $numericKriteria = Kriteria::where('nama_kriteria', 'Nilai Akademik')->firstOrFail();
        Soal::create([
            'tes_id' => $tes->id,
            'kriteria_id' => $numericKriteria->id,
            'pertanyaan' => 'Masukkan nilai akademik.',
            'urutan' => $urutan,
        ]);

        return [$tes, $answers, $numericKriteria->id];
    }

    public function test_siswa_cannot_submit_consultation_twice_for_the_same_test(): void
    {
        [$user, $siswa] = $this->siswa('siswa_double_submit');
        [$tes, $soals] = $this->tesDenganSoalLengkap();

        $payload = [
            'jawabans' => [
                $soals['Minat']->id => $soals['Minat']->pilihanJawabans->first()->id,
                $soals['Bakat']->id => $soals['Bakat']->pilihanJawabans->first()->id,
                $soals['Kepribadian']->id => $soals['Kepribadian']->pilihanJawabans->first()->id,
            ],
            'nilai_numerik' => [
                Kriteria::where('nama_kriteria', 'Nilai Akademik')->firstOrFail()->id => 80.0,
            ],
        ];

        // First submit should succeed
        $this->actingAs($user)->post(route('siswa.konsultasi.store', $tes), $payload)
            ->assertRedirect();
        
        $this->assertDatabaseCount('hasil_tes', 1);

        // Second submit should fail and redirect back with session error
        $response = $this->actingAs($user)->post(route('siswa.konsultasi.store', $tes), $payload);
        $response->assertRedirect();
        $response->assertSessionHas('error', 'Anda sudah mengerjakan kuesioner ini.');
        
        // Still 1 result
        $this->assertDatabaseCount('hasil_tes', 1);
    }
}

<?php

namespace Database\Seeders;

use App\Models\DataTraining;
use App\Models\Karir;
use App\Models\Kriteria;
use App\Services\DataTrainingWriter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DataTrainingDemoSeeder extends Seeder
{
    /**
     * Data awal representatif, bukan data riil final.
     *
     * Dataset semi-sintetis ini dipakai untuk pengembangan dan demo. Data riil
     * dari Guru BK tetap diperlukan sebelum angka akurasi digunakan di skripsi.
     */
    public const SOURCE = 'Data awal representatif, bukan data riil final';

    public function run(): void
    {
        $kriterias = Kriteria::with('opsis')->orderBy('id')->get();
        $kriteriaByName = $kriterias->keyBy('nama_kriteria');
        $karirIds = Karir::query()->pluck('id', 'nama_karir');
        $writer = app(DataTrainingWriter::class);

        $profiles = [
            ['karir' => 'Teknisi/Operator Teknik', 'minat' => ['Realistic'], 'bakat' => ['Motorik/Praktikal', 'Spasial/Visual'], 'kepribadian' => ['Compliance', 'Dominance'], 'nilai' => [68, 72, 76, 80, 74, 78, 82, 70]],
            ['karir' => 'Analis/Peneliti', 'minat' => ['Investigative'], 'bakat' => ['Numerik/Logika'], 'kepribadian' => ['Compliance', 'Steadiness'], 'nilai' => [82, 88, 91, 85, 94, 87, 90, 84]],
            ['karir' => 'Desainer Kreatif', 'minat' => ['Artistic'], 'bakat' => ['Spasial/Visual'], 'kepribadian' => ['Influence', 'Dominance'], 'nilai' => [70, 76, 82, 74, 88, 79, 84, 72]],
            ['karir' => 'Tenaga Kesehatan & Konseling', 'minat' => ['Social'], 'bakat' => ['Verbal'], 'kepribadian' => ['Steadiness', 'Influence'], 'nilai' => [78, 84, 88, 81, 90, 85, 79, 86]],
            ['karir' => 'Wirausaha/Marketing', 'minat' => ['Enterprising'], 'bakat' => ['Verbal', 'Numerik/Logika'], 'kepribadian' => ['Dominance', 'Influence'], 'nilai' => [68, 75, 80, 72, 85, 77, 82, 70]],
            ['karir' => 'Administrasi & Akuntansi', 'minat' => ['Conventional'], 'bakat' => ['Numerik/Logika'], 'kepribadian' => ['Compliance', 'Steadiness'], 'nilai' => [76, 83, 89, 80, 92, 86, 78, 84]],
            ['karir' => 'Pendidik/Guru', 'minat' => ['Social', 'Investigative'], 'bakat' => ['Verbal'], 'kepribadian' => ['Steadiness', 'Influence'], 'nilai' => [77, 83, 87, 80, 90, 85, 79, 88]],
            ['karir' => 'Agribisnis/Pertanian', 'minat' => ['Realistic'], 'bakat' => ['Motorik/Praktikal', 'Spasial/Visual'], 'kepribadian' => ['Steadiness', 'Dominance'], 'nilai' => [65, 72, 78, 69, 82, 75, 80, 71]],
        ];

        DB::transaction(function () use ($profiles, $karirIds, $kriterias, $kriteriaByName, $writer) {
            foreach (DataTraining::query()->where('sumber', self::SOURCE)->with('atributs')->get() as $existing) {
                $existing->atributs()->delete();
                $existing->delete();
            }

            foreach ($profiles as $profile) {
                for ($index = 0; $index < 8; $index++) {
                    $writer->create(self::SOURCE, $karirIds[$profile['karir']], [
                        $kriteriaByName['Minat']->id => ['nilai_kategorik' => $profile['minat'][$index % count($profile['minat'])]],
                        $kriteriaByName['Bakat']->id => ['nilai_kategorik' => $profile['bakat'][$index % count($profile['bakat'])]],
                        $kriteriaByName['Nilai Akademik']->id => ['nilai_numerik' => $profile['nilai'][$index]],
                        $kriteriaByName['Kepribadian']->id => ['nilai_kategorik' => $profile['kepribadian'][$index % count($profile['kepribadian'])]],
                    ], $kriterias);
                }
            }
        });
    }
}

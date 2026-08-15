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
            // === DPIB (Arsitektur & Konstruksi) ===
            [
                'karir' => 'Drafter Bangunan',
                'minat' => ['Realistic'],
                'bakat' => ['Spasial/Visual'],
                'kepribadian' => ['Compliance'],
                'nilai' => [70, 74, 76, 72, 78, 75, 77, 73],
            ],
            [
                'karir' => 'Desainer Bangunan',
                'minat' => ['Artistic'],
                'bakat' => ['Spasial/Visual'],
                'kepribadian' => ['Influence', 'Steadiness'],
                'nilai' => [76, 80, 82, 78, 83, 79, 81, 77],
            ],
            [
                'karir' => 'BIM Modeler',
                'minat' => ['Investigative', 'Realistic'],
                'bakat' => ['Spasial/Visual'],
                'kepribadian' => ['Compliance'],
                'nilai' => [80, 83, 85, 82, 86, 84, 85, 81],
            ],
            [
                'karir' => 'Surveyor',
                'minat' => ['Realistic'],
                'bakat' => ['Numerik/Logika'],
                'kepribadian' => ['Steadiness', 'Compliance'],
                'nilai' => [72, 75, 78, 74, 79, 76, 80, 73],
            ],
            [
                'karir' => 'Estimator/Quantity Surveyor',
                'minat' => ['Conventional'],
                'bakat' => ['Numerik/Logika'],
                'kepribadian' => ['Compliance'],
                'nilai' => [78, 82, 85, 80, 86, 83, 84, 79],
            ],
            [
                'karir' => 'Pengawas Konstruksi',
                'minat' => ['Realistic'],
                'bakat' => ['Motorik/Praktikal'],
                'kepribadian' => ['Dominance'],
                'nilai' => [73, 77, 80, 75, 82, 78, 79, 74],
            ],

            // === TKJ (Teknologi Informasi & Jaringan) ===
            [
                'karir' => 'Network Administrator',
                'minat' => ['Investigative'],
                'bakat' => ['Numerik/Logika'],
                'kepribadian' => ['Compliance'],
                'nilai' => [78, 82, 85, 80, 86, 83, 84, 79],
            ],
            [
                'karir' => 'IT Support Specialist',
                'minat' => ['Social', 'Realistic'],
                'bakat' => ['Motorik/Praktikal'],
                'kepribadian' => ['Steadiness'],
                'nilai' => [68, 72, 75, 70, 76, 73, 74, 69],
            ],
            [
                'karir' => 'Teknisi Fiber Optic',
                'minat' => ['Realistic'],
                'bakat' => ['Motorik/Praktikal'],
                'kepribadian' => ['Steadiness'],
                'nilai' => [67, 71, 74, 69, 75, 72, 73, 68],
            ],
            [
                'karir' => 'Junior System Administrator',
                'minat' => ['Investigative'],
                'bakat' => ['Numerik/Logika'],
                'kepribadian' => ['Dominance'],
                'nilai' => [80, 84, 86, 82, 88, 85, 86, 81],
            ],
            [
                'karir' => 'Teknisi CCTV & IoT',
                'minat' => ['Realistic'],
                'bakat' => ['Spasial/Visual'],
                'kepribadian' => ['Steadiness', 'Compliance'],
                'nilai' => [70, 73, 76, 72, 78, 75, 77, 71],
            ],
            [
                'karir' => 'Field Technician ISP',
                'minat' => ['Realistic'],
                'bakat' => ['Motorik/Praktikal'],
                'kepribadian' => ['Influence'],
                'nilai' => [66, 70, 73, 68, 74, 71, 72, 67],
            ],
            [
                'karir' => 'Wirausaha Jasa IT (Technopreneur)',
                'minat' => ['Enterprising'],
                'bakat' => ['Numerik/Logika', 'Verbal'],
                'kepribadian' => ['Dominance', 'Influence'],
                'nilai' => [72, 76, 80, 74, 82, 78, 81, 73],
            ],

            // === KRIYA KAYU (Kerajinan & Furnitur) ===
            [
                'karir' => 'Desainer Furnitur & Mebel Kayu',
                'minat' => ['Artistic'],
                'bakat' => ['Spasial/Visual'],
                'kepribadian' => ['Influence', 'Dominance'],
                'nilai' => [75, 79, 82, 77, 83, 80, 81, 76],
            ],
            [
                'karir' => 'Pengrajin Kriya Kayu & Ukir (Wood Artisan)',
                'minat' => ['Artistic', 'Realistic'],
                'bakat' => ['Motorik/Praktikal'],
                'kepribadian' => ['Steadiness', 'Compliance'],
                'nilai' => [70, 74, 78, 72, 80, 75, 77, 71],
            ],
            [
                'karir' => 'Operator Mesin Woodworking / CNC Kayu',
                'minat' => ['Realistic'],
                'bakat' => ['Motorik/Praktikal'],
                'kepribadian' => ['Compliance'],
                'nilai' => [69, 73, 76, 71, 78, 74, 75, 70],
            ],
            [
                'karir' => 'Finishing Specialist Kayu (Wood Finisher)',
                'minat' => ['Realistic'],
                'bakat' => ['Motorik/Praktikal'],
                'kepribadian' => ['Steadiness'],
                'nilai' => [68, 72, 75, 70, 77, 73, 74, 69],
            ],
            [
                'karir' => 'Wirausaha Kriya Kayu (Woodcraft Entrepreneur)',
                'minat' => ['Enterprising'],
                'bakat' => ['Motorik/Praktikal', 'Verbal'],
                'kepribadian' => ['Dominance', 'Influence'],
                'nilai' => [71, 75, 79, 73, 81, 77, 80, 72],
            ],
            [
                'karir' => 'Quality Control (QC) Produk Kayu & Mebel',
                'minat' => ['Conventional'],
                'bakat' => ['Numerik/Logika', 'Spasial/Visual'],
                'kepribadian' => ['Compliance'],
                'nilai' => [75, 79, 82, 77, 84, 80, 81, 76],
            ],

            // === UMUM / KEDINASAN ===
            [
                'karir' => 'Polisi',
                'minat' => ['Social'],
                'bakat' => ['Motorik/Praktikal'],
                'kepribadian' => ['Dominance', 'Steadiness'],
                'nilai' => [70, 74, 78, 72, 80, 76, 77, 71],
            ],
            [
                'karir' => 'TNI',
                'minat' => ['Realistic'],
                'bakat' => ['Motorik/Praktikal'],
                'kepribadian' => ['Dominance'],
                'nilai' => [68, 72, 76, 70, 78, 74, 75, 69],
            ],
            [
                'karir' => 'Banker',
                'minat' => ['Conventional'],
                'bakat' => ['Numerik/Logika'],
                'kepribadian' => ['Compliance', 'Steadiness'],
                'nilai' => [76, 80, 83, 78, 85, 82, 84, 77],
            ],
            [
                'karir' => 'Pebisnis',
                'minat' => ['Enterprising'],
                'bakat' => ['Verbal'],
                'kepribadian' => ['Influence', 'Dominance'],
                'nilai' => [68, 73, 78, 71, 80, 75, 79, 70],
            ],

            // === STUDI LANJUT / JURUSAN KULIAH ===
            [
                'karir' => 'Kuliah: Teknik / Informatika',
                'minat' => ['Investigative'],
                'bakat' => ['Numerik/Logika'],
                'kepribadian' => ['Compliance'],
                'nilai' => [88, 92, 95, 90, 96, 93, 94, 89],
            ],
            [
                'karir' => 'Kuliah: Ekonomi / Manajemen',
                'minat' => ['Enterprising'],
                'bakat' => ['Numerik/Logika'],
                'kepribadian' => ['Dominance'],
                'nilai' => [84, 88, 91, 86, 94, 89, 92, 85],
            ],
            [
                'karir' => 'Kuliah: Pendidikan (Keguruan)',
                'minat' => ['Social'],
                'bakat' => ['Verbal'],
                'kepribadian' => ['Steadiness', 'Influence'],
                'nilai' => [82, 86, 90, 84, 92, 88, 89, 83],
            ],
            [
                'karir' => 'Kuliah: Ilmu Hukum',
                'minat' => ['Investigative', 'Social'],
                'bakat' => ['Verbal'],
                'kepribadian' => ['Dominance', 'Compliance'],
                'nilai' => [85, 89, 93, 87, 95, 91, 92, 86],
            ],
            [
                'karir' => 'Kuliah: Desain / Arsitektur',
                'minat' => ['Artistic'],
                'bakat' => ['Spasial/Visual'],
                'kepribadian' => ['Influence'],
                'nilai' => [85, 89, 92, 87, 95, 90, 93, 86],
            ],
            [
                'karir' => 'Kuliah: Pertanian / Agroteknologi',
                'minat' => ['Investigative', 'Realistic'],
                'bakat' => ['Numerik/Logika', 'Motorik/Praktikal'],
                'kepribadian' => ['Steadiness'],
                'nilai' => [81, 85, 88, 83, 90, 87, 89, 82],
            ],
            [
                'karir' => 'Kuliah: Ilmu Komunikasi',
                'minat' => ['Artistic', 'Social'],
                'bakat' => ['Verbal'],
                'kepribadian' => ['Influence'],
                'nilai' => [83, 87, 91, 85, 93, 89, 92, 84],
            ],
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


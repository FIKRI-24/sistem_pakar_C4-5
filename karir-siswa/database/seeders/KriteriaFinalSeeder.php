<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class KriteriaFinalSeeder extends Seeder
{
    public function run(): void
    {
        $definitions = [
            [
                'nama_kriteria' => 'Minat',
                'tipe_data' => Kriteria::TYPE_KATEGORIK,
                'keterangan' => 'Minat berdasarkan enam kategori RIASEC/Holland Code.',
                'opsi' => ['Realistic', 'Investigative', 'Artistic', 'Social', 'Enterprising', 'Conventional'],
            ],
            [
                'nama_kriteria' => 'Bakat',
                'tipe_data' => Kriteria::TYPE_KATEGORIK,
                'keterangan' => 'Bakat dominan mengacu konsep Differential Aptitude Test (DAT).',
                'opsi' => ['Verbal', 'Numerik/Logika', 'Spasial/Visual', 'Motorik/Praktikal'],
            ],
            [
                'nama_kriteria' => 'Nilai Akademik',
                'tipe_data' => Kriteria::TYPE_NUMERIK,
                'keterangan' => 'Rata-rata nilai mata pelajaran relevan dalam rentang 0-100.',
                'opsi' => [],
            ],
            [
                'nama_kriteria' => 'Kepribadian',
                'tipe_data' => Kriteria::TYPE_KATEGORIK,
                'keterangan' => 'Kepribadian kerja berdasarkan kerangka DISC.',
                'opsi' => ['Dominance', 'Influence', 'Steadiness', 'Compliance'],
            ],
        ];

        foreach ($definitions as $definition) {
            $kriteria = Kriteria::withTrashed()->firstOrNew([
                'nama_kriteria' => $definition['nama_kriteria'],
            ]);
            $kriteria->fill([
                'tipe_data' => $definition['tipe_data'],
                'keterangan' => $definition['keterangan'],
            ]);
            $kriteria->save();
            $kriteria->restore();

            $kriteria->opsis()->delete();
            foreach ($definition['opsi'] as $index => $label) {
                $kriteria->opsis()->create(['label' => $label, 'urutan' => $index + 1]);
            }
        }
    }
}

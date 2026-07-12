<?php

namespace App\Services;

use App\Models\DataTraining;
use App\Models\Kriteria;
use Illuminate\Support\Collection;

class DataTrainingWriter
{
    /**
     * @param  array<int|string, array{nilai_kategorik?: mixed, nilai_numerik?: mixed}>  $atributs
     * @param  Collection<int, Kriteria>  $kriterias
     */
    public function create(?string $sumber, int $labelKarirId, array $atributs, Collection $kriterias): DataTraining
    {
        $training = DataTraining::create(['sumber' => $sumber, 'label_karir_id' => $labelKarirId]);
        $this->replaceAtributs($training, $atributs, $kriterias);

        return $training;
    }

    /**
     * @param  array<int|string, array{nilai_kategorik?: mixed, nilai_numerik?: mixed}>  $atributs
     * @param  Collection<int, Kriteria>  $kriterias
     */
    public function replaceAtributs(DataTraining $training, array $atributs, Collection $kriterias): void
    {
        $training->atributs()->delete();

        foreach ($kriterias as $kriteria) {
            $value = $atributs[$kriteria->id] ?? [];
            $training->atributs()->create([
                'kriteria_id' => $kriteria->id,
                'nilai_kategorik' => $kriteria->tipe_data === Kriteria::TYPE_KATEGORIK
                    ? $value['nilai_kategorik']
                    : null,
                'nilai_numerik' => $kriteria->tipe_data === Kriteria::TYPE_NUMERIK
                    ? (float) $value['nilai_numerik']
                    : null,
            ]);
        }
    }
}

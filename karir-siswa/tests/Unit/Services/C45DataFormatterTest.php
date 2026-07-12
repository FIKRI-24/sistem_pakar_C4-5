<?php

namespace Tests\Unit\Services;

use App\Models\DataTraining;
use App\Models\DataTrainingAtribut;
use App\Models\HasilTes;
use App\Models\HasilTesDetail;
use App\Models\Kriteria;
use App\Models\KriteriaOpsi;
use App\Services\C45DataFormatter;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Tests\TestCase;

class C45DataFormatterTest extends TestCase
{
    public function test_training_and_result_use_the_same_c45_payload_contract(): void
    {
        [$kriterias, $opsi] = $this->kriterias();
        $training = new DataTraining;
        $training->setRelation('atributs', new Collection([
            $this->trainingAtribut($kriterias['Minat'], $opsi['Minat'], 'Investigative'),
            $this->trainingAtribut($kriterias['Bakat'], $opsi['Bakat'], 'Numerik/Logika'),
            $this->trainingAtribut($kriterias['Nilai Akademik'], null, null, 88),
            $this->trainingAtribut($kriterias['Kepribadian'], $opsi['Kepribadian'], 'Compliance'),
        ]));

        $hasilTes = new HasilTes;
        $hasilTes->setRelation('details', new Collection([
            $this->hasilTesDetail($kriterias['Minat'], $opsi['Minat'], 'Investigative'),
            $this->hasilTesDetail($kriterias['Bakat'], $opsi['Bakat'], 'Numerik/Logika'),
            $this->hasilTesDetail($kriterias['Nilai Akademik'], null, null, 88),
            $this->hasilTesDetail($kriterias['Kepribadian'], $opsi['Kepribadian'], 'Compliance'),
        ]));

        $formatter = new C45DataFormatter;
        $expected = [
            'minat' => 'Investigative',
            'bakat' => 'Numerik/Logika',
            'nilai_akademik' => 88.0,
            'kepribadian' => 'Compliance',
        ];

        $this->assertSame($expected, $formatter->fromDataTraining($training));
        $this->assertSame($expected, $formatter->fromHasilTes($hasilTes));
    }

    public function test_formatter_rejects_missing_attributes(): void
    {
        $kriteria = Kriteria::make([
            'nama_kriteria' => 'Minat',
            'tipe_data' => Kriteria::TYPE_KATEGORIK,
        ]);
        $opsi = KriteriaOpsi::make(['label' => 'Investigative']);
        $kriteria->setRelation('opsis', new Collection([$opsi]));
        $atribut = $this->trainingAtribut($kriteria, $opsi, 'Investigative');
        $training = new DataTraining;
        $training->setRelation('atributs', new Collection([$atribut]));

        $this->expectException(InvalidArgumentException::class);

        (new C45DataFormatter)->fromDataTraining($training);
    }

    /** @return array{0: array<string, Kriteria>, 1: array<string, KriteriaOpsi>} */
    private function kriterias(): array
    {
        $definitions = [
            'Minat' => ['kategorik', 'Investigative'],
            'Bakat' => ['kategorik', 'Numerik/Logika'],
            'Nilai Akademik' => ['numerik', null],
            'Kepribadian' => ['kategorik', 'Compliance'],
        ];
        $kriterias = [];
        $opsi = [];

        foreach ($definitions as $name => [$type, $label]) {
            $kriteria = Kriteria::make(['nama_kriteria' => $name, 'tipe_data' => $type]);
            $option = KriteriaOpsi::make(['label' => $label]);
            $kriteria->setRelation('opsis', new Collection($label === null ? [] : [$option]));
            $kriterias[$name] = $kriteria;
            if ($label !== null) {
                $opsi[$name] = $option;
            }
        }

        return [$kriterias, $opsi];
    }

    private function trainingAtribut(Kriteria $kriteria, ?KriteriaOpsi $opsi, ?string $categorical, ?float $numeric = null): DataTrainingAtribut
    {
        $attribute = new DataTrainingAtribut([
            'nilai_kategorik' => $categorical,
            'nilai_numerik' => $numeric,
        ]);
        $attribute->setRelation('kriteria', $kriteria);

        return $attribute;
    }

    private function hasilTesDetail(Kriteria $kriteria, ?KriteriaOpsi $opsi, ?string $categorical, ?float $numeric = null): HasilTesDetail
    {
        $detail = new HasilTesDetail([
            'nilai_kategorik' => $categorical,
            'nilai_numerik' => $numeric,
        ]);
        $detail->setRelation('kriteria', $kriteria);

        return $detail;
    }
}

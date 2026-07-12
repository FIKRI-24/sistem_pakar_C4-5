<?php

namespace App\Services;

use App\Models\DataTraining;
use App\Models\HasilTes;
use App\Models\Kriteria;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class C45DataFormatter
{
    /**
     * The public C4.5 attribute names are intentionally independent from
     * database naming so both training rows and test results use one contract.
     *
     * @var array<string, string>
     */
    public const ATTRIBUTE_KEYS = [
        'Minat' => 'minat',
        'Bakat' => 'bakat',
        'Nilai Akademik' => 'nilai_akademik',
        'Kepribadian' => 'kepribadian',
    ];

    /**
     * @return array{minat: string, bakat: string, nilai_akademik: float, kepribadian: string}
     */
    public function fromDataTraining(DataTraining $training): array
    {
        $training->loadMissing('atributs.kriteria.opsis');

        return $this->format($training->atributs);
    }

    /**
     * @return array{minat: string, bakat: string, nilai_akademik: float, kepribadian: string}
     */
    public function fromHasilTes(HasilTes $hasilTes): array
    {
        $hasilTes->loadMissing('details.kriteria.opsis');

        return $this->format($hasilTes->details);
    }

    /**
     * @param  Collection<int, object>  $rows
     * @return array{minat: string, bakat: string, nilai_akademik: float, kepribadian: string}
     */
    private function format(Collection $rows): array
    {
        $payload = [];

        foreach ($rows as $row) {
            $kriteria = $row->kriteria;
            $namaKriteria = $kriteria?->nama_kriteria;
            $key = self::ATTRIBUTE_KEYS[$namaKriteria] ?? null;

            if (! $kriteria instanceof Kriteria || ! $key) {
                throw new InvalidArgumentException('C4.5 payload contains an unknown criterion.');
            }

            if ($kriteria->tipe_data === Kriteria::TYPE_NUMERIK) {
                if ($row->nilai_numerik === null) {
                    throw new InvalidArgumentException("C4.5 attribute {$key} must have a numeric value.");
                }

                $payload[$key] = (float) $row->nilai_numerik;

                continue;
            }

            if (! is_string($row->nilai_kategorik) || $row->nilai_kategorik === '') {
                throw new InvalidArgumentException("C4.5 attribute {$key} must have a categorical value.");
            }

            // Preserve the exact kriteria_opsis.label casing; C4.5 treats it as a categorical value.
            if (! $kriteria->opsis->contains(fn ($opsi): bool => $opsi->label === $row->nilai_kategorik)) {
                throw new InvalidArgumentException("C4.5 attribute {$key} is not a valid kriteria_opsis label.");
            }

            $payload[$key] = $row->nilai_kategorik;
        }

        $expectedKeys = array_values(self::ATTRIBUTE_KEYS);
        $missingKeys = array_diff($expectedKeys, array_keys($payload));
        if ($missingKeys !== []) {
            throw new InvalidArgumentException('C4.5 payload is missing: '.implode(', ', $missingKeys).'.');
        }

        /** @var array{minat: string, bakat: string, nilai_akademik: float, kepribadian: string} */
        return array_combine($expectedKeys, array_map(
            fn (string $key): mixed => $payload[$key],
            $expectedKeys
        ));
    }
}

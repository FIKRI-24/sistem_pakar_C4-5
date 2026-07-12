<?php

namespace App\Http\Requests\Admin;

use App\Models\Kriteria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTesLengkapRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()?->role, ['admin', 'guru_bk'], true);
    }

    public function rules(): array
    {
        return [
            'nama_tes' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'durasi_menit' => ['nullable', 'integer', 'min:1'],
            'status_aktif' => ['required', 'boolean'],
            'soals' => ['required', 'array', 'min:1'],
            'soals.*.pertanyaan' => ['required', 'string'],
            'soals.*.kriteria_id' => ['required', Rule::exists('kriterias', 'id')],
            'soals.*.urutan' => ['nullable', 'integer', 'min:1'],
            'soals.*.pilihans' => ['nullable', 'array'],
            'soals.*.pilihans.*.pilihan' => ['required_with:soals.*.pilihans', 'string', 'max:150'],
            'soals.*.pilihans.*.skor' => ['required_with:soals.*.pilihans', 'numeric', 'between:1,5'],
            'soals.*.pilihans.*.kriteria_opsi_id' => ['nullable', Rule::exists('kriteria_opsis', 'id')],
        ];
    }

    public function after(): array
    {
        return [
            function ($validator) {
                $soals = $this->input('soals', []);
                if (! is_array($soals) || count($soals) === 0) {
                    return;
                }

                $kriterias = Kriteria::with('opsis')->get()->keyBy('id');

                foreach ($soals as $index => $soal) {
                    $kriteriaId = $soal['kriteria_id'] ?? null;
                    if (! $kriteriaId) {
                        continue;
                    }

                    $kriteria = $kriterias->get($kriteriaId);
                    if (! $kriteria) {
                        continue;
                    }

                    if ($kriteria->tipe_data === Kriteria::TYPE_NUMERIK) {
                        // Numeric criteria shouldn't have choices
                        continue;
                    }

                    $pilihans = $soal['pilihans'] ?? [];
                    if (! is_array($pilihans) || count($pilihans) < 2) {
                        $validator->errors()->add("soals.{$index}.pilihans", 'Setiap soal kategorik harus memiliki minimal 2 pilihan jawaban.');
                        continue;
                    }

                    foreach ($pilihans as $pIndex => $pilihan) {
                        $opsiId = $pilihan['kriteria_opsi_id'] ?? null;
                        if (! $opsiId) {
                            $validator->errors()->add("soals.{$index}.pilihans.{$pIndex}.kriteria_opsi_id", 'Opsi kriteria wajib dipilih untuk pilihan jawaban ini.');
                            continue;
                        }

                        $opsi = $kriteria->opsis->firstWhere('id', (int) $opsiId);
                        if (! $opsi) {
                            $validator->errors()->add("soals.{$index}.pilihans.{$pIndex}.kriteria_opsi_id", 'Opsi kategori harus berasal dari kriteria soal yang dipilih.');
                        }
                    }
                }
            }
        ];
    }
}

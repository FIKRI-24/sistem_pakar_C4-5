<?php

namespace App\Http\Requests\Siswa;

use App\Models\Kriteria;
use App\Models\Tes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class SubmitKonsultasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isRole('siswa') === true;
    }

    public function rules(): array
    {
        return [
            'jawabans' => ['nullable', 'array'],
            'nilai_numerik' => ['nullable', 'array'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator) {
            /** @var Tes|null $tes */
            $tes = $this->route('tes');
            if (! $tes || ! $tes->status_aktif) {
                $validator->errors()->add('tes', 'Tes ini tidak aktif.');

                return;
            }

            $tes->load(['soals.kriteria', 'soals.pilihanJawabans.kriteriaOpsi']);
            $numericKriterias = [];
            foreach ($tes->soals as $soal) {
                if ($soal->kriteria->tipe_data === Kriteria::TYPE_NUMERIK) {
                    $numericKriterias[$soal->kriteria_id] = $soal->kriteria;

                    continue;
                }

                $pilihanId = $this->input("jawabans.{$soal->id}");
                $pilihan = $soal->pilihanJawabans->firstWhere('id', (int) $pilihanId);
                if (! $pilihan) {
                    $validator->errors()->add("jawabans.{$soal->id}", 'Setiap pertanyaan wajib dijawab.');
                } elseif (! $pilihan->kriteria_opsi_id) {
                    $validator->errors()->add("jawabans.{$soal->id}", 'Pilihan jawaban ini belum dipetakan ke opsi kriteria oleh Admin.');
                }
            }

            foreach ($numericKriterias as $kriteria) {
                $nilai = $this->input("nilai_numerik.{$kriteria->id}");
                if (! is_numeric($nilai) || $nilai < 0 || $nilai > 100) {
                    $validator->errors()->add("nilai_numerik.{$kriteria->id}", "Nilai {$kriteria->nama_kriteria} wajib diisi antara 0-100.");
                }
            }
        }];
    }
}

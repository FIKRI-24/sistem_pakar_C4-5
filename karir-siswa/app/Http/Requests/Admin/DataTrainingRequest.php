<?php

namespace App\Http\Requests\Admin;

use App\Models\Kriteria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class DataTrainingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isRole('admin') === true;
    }

    public function rules(): array
    {
        return [
            'sumber' => ['nullable', 'string', 'max:100'],
            'label_karir_id' => ['required', 'exists:karirs,id'],
            'atributs' => ['required', 'array'],
        ];
    }

    public function after(): array
    {
        return [function (Validator $validator) {
            $atributs = $this->input('atributs', []);
            foreach (Kriteria::with('opsis')->orderBy('id')->get() as $kriteria) {
                $value = $atributs[$kriteria->id] ?? [];
                if ($kriteria->tipe_data === Kriteria::TYPE_KATEGORIK) {
                    $label = $value['nilai_kategorik'] ?? null;
                    if (! is_string($label) || $label === '') {
                        $validator->errors()->add("atributs.{$kriteria->id}.nilai_kategorik", "Nilai {$kriteria->nama_kriteria} wajib dipilih.");
                    } elseif (! $kriteria->opsis->contains('label', $label)) {
                        $validator->errors()->add("atributs.{$kriteria->id}.nilai_kategorik", "Nilai {$kriteria->nama_kriteria} tidak valid.");
                    }
                } else {
                    $nilai = $value['nilai_numerik'] ?? null;
                    if (! is_numeric($nilai) || $nilai < 0 || $nilai > 100) {
                        $validator->errors()->add("atributs.{$kriteria->id}.nilai_numerik", "Nilai {$kriteria->nama_kriteria} harus berada pada rentang 0-100.");
                    }
                }
            }
        }];
    }
}

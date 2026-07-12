<?php

namespace App\Http\Requests\Admin;

use App\Models\KriteriaOpsi;
use App\Models\Soal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PilihanJawabanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()?->role, ['admin', 'guru_bk'], true);
    }

    public function rules(): array
    {
        return [
            'soal_id' => ['required', Rule::exists('soals', 'id')],
            'pilihan' => ['required', 'string', 'max:150'],
            'skor' => ['required', 'numeric', 'between:1,5'],
            'kriteria_opsi_id' => ['nullable', Rule::exists('kriteria_opsis', 'id')],
        ];
    }

    public function after(): array
    {
        return [function ($validator) {
            if (! $this->filled('kriteria_opsi_id') || ! $this->filled('soal_id')) {
                return;
            }

            $soal = Soal::find($this->integer('soal_id'));
            $opsi = KriteriaOpsi::find($this->integer('kriteria_opsi_id'));

            if (! $soal || ! $opsi || $soal->kriteria_id !== $opsi->kriteria_id) {
                $validator->errors()->add('kriteria_opsi_id', 'Opsi kategori harus berasal dari kriteria soal yang dipilih.');
            }
        }];
    }
}

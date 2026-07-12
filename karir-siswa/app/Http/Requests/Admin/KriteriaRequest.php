<?php

namespace App\Http\Requests\Admin;

use App\Models\Kriteria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KriteriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isRole('admin') === true;
    }

    public function rules(): array
    {
        return [
            'nama_kriteria' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kriterias')->ignore($this->route('kriteria')),
            ],
            'tipe_data' => ['required', Rule::in(Kriteria::TYPES)],
            'keterangan' => ['nullable', 'string'],
        ];
    }
}

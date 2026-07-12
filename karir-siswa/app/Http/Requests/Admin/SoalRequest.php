<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SoalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return in_array($this->user()?->role, ['admin', 'guru_bk'], true);
    }

    public function rules(): array
    {
        return [
            'tes_id' => ['required', Rule::exists('tes', 'id')],
            'kriteria_id' => ['required', Rule::exists('kriterias', 'id')],
            'pertanyaan' => ['required', 'string'],
            'urutan' => ['nullable', 'integer', 'min:1'],
        ];
    }
}

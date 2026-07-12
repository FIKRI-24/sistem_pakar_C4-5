<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KarirRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isRole('admin') === true;
    }

    public function rules(): array
    {
        return [
            'nama_karir' => [
                'required',
                'string',
                'max:255',
                Rule::unique('karirs')->ignore($this->route('karir')),
            ],
            'deskripsi' => ['nullable', 'string'],
            'bidang_pekerjaan' => ['nullable', 'string', 'max:255'],
            'informasi_pendukung' => ['nullable', 'string'],
        ];
    }
}

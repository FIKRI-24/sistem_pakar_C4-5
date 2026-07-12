<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TesRequest extends FormRequest
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
        ];
    }
}

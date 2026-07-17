<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isRole('admin') === true;
    }

    public function rules(): array
    {
        $siswa = $this->route('siswa');
        $userId = $siswa?->user_id;
        $passwordRules = $siswa
            ? ['nullable', 'string', 'min:8']
            : ['required', 'string', 'min:8'];

        return [
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'alpha_dash', 'max:50', Rule::unique('users')->ignore($userId)],
            'email' => ['nullable', 'email', 'max:100', Rule::unique('users')->ignore($userId)],
            'password' => $passwordRules,
            'nis' => ['required', 'string', 'max:20', Rule::unique('siswas')->ignore($siswa)],
            'kelas' => ['required', 'string', 'max:20'],
            'jurusan' => ['required', 'string', 'max:50'],
            'jenis_kelamin' => ['nullable', 'string', Rule::in(['L', 'P'])],
        ];
    }
}

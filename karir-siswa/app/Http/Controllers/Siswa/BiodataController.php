<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BiodataController extends Controller
{
    public function edit(Request $request): View
    {
        $siswa = $request->user()->siswa;
        return view('siswa.biodata', compact('siswa'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        $siswa = $user->siswa;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'nis' => ['required', 'string', 'max:20', Rule::unique('siswas', 'nis')->ignore($siswa->id)],
            'kelas' => ['required', 'string', 'max:20'],
            'jurusan' => ['required', 'string', 'max:50'],
            'jenis_kelamin' => ['required', 'string', Rule::in(['L', 'P'])],
        ]);

        DB::transaction(function () use ($user, $siswa, $validated) {
            $user->update([
                'name' => $validated['name'],
            ]);

            $siswa->update([
                'nis' => $validated['nis'],
                'kelas' => $validated['kelas'],
                'jurusan' => $validated['jurusan'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
            ]);
        });

        return redirect()->route('siswa.dashboard')->with('success', 'Biodata berhasil diperbarui.');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBiodataIsComplete
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->isRole(\App\Models\User::ROLE_SISWA)) {
            $siswa = $user->siswa;

            if (
                !$siswa ||
                is_null($user->name) || trim($user->name) === '' ||
                is_null($siswa->nis) || trim($siswa->nis) === '' ||
                is_null($siswa->kelas) || trim($siswa->kelas) === '' ||
                is_null($siswa->jurusan) || trim($siswa->jurusan) === '' ||
                is_null($siswa->jenis_kelamin) || trim($siswa->jenis_kelamin) === ''
            ) {
                return redirect()->route('siswa.biodata')
                    ->with('error', 'Lengkapi biodata Anda terlebih dahulu sebelum mengerjakan tes.');
            }
        }

        return $next($request);
    }
}

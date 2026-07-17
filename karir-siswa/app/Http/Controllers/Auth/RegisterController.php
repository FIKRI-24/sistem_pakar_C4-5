<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'alpha_dash', 'max:50', 'unique:users,username'],
            'nis' => ['required', 'string', 'max:20', 'unique:siswas,nis'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->string('name'),
                'username' => $request->string('username'),
                'password' => $request->string('password'),
                'role' => User::ROLE_SISWA,
            ]);

            $user->siswa()->create([
                'nis' => $request->string('nis'),
                'kelas' => null,
                'jurusan' => null,
                'jenis_kelamin' => null,
            ]);

            return $user;
        });

        Auth::login($user);

        return redirect()->route('siswa.biodata')->with('warning', 'Lengkapi biodata Anda terlebih dahulu sebelum mengerjakan tes.');
    }
}

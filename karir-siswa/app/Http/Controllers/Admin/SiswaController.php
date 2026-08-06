<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SiswaRequest;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SiswaController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('q'));
        $siswas = Siswa::query()
            ->with('user')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nis', 'like', "%{$search}%")
                        ->orWhere('kelas', 'like', "%{$search}%")
                        ->orWhere('jurusan', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($user) => $user
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.siswas.index', compact('siswas', 'search'));
    }

    public function create(): View
    {
        return view('admin.siswas.form', ['siswa' => new Siswa]);
    }

    public function store(SiswaRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->string('name')->value(),
                'username' => $request->string('username')->value(),
                'email' => $request->filled('email') ? $request->string('email')->value() : null,
                'password' => $request->string('password')->value(),
                'role' => User::ROLE_SISWA,
            ]);
            $user->siswa()->create($request->safe()->only(['nis', 'kelas', 'jurusan', 'jenis_kelamin']));
        });

        return to_route('admin.siswas.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function edit(Siswa $siswa): View
    {
        $siswa->load('user');

        return view('admin.siswas.form', compact('siswa'));
    }

    public function update(SiswaRequest $request, Siswa $siswa): RedirectResponse
    {
        DB::transaction(function () use ($request, $siswa) {
            $userData = [
                'name' => $request->string('name')->value(),
                'username' => $request->string('username')->value(),
                'email' => $request->filled('email') ? $request->string('email')->value() : null,
            ];
            if ($request->filled('password')) {
                $userData['password'] = $request->string('password')->value();
            }
            $siswa->user->update($userData);
            $siswa->update($request->safe()->only(['nis', 'kelas', 'jurusan', 'jenis_kelamin']));
        });

        return to_route('admin.siswas.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa): RedirectResponse
    {
        $siswa->delete();

        return to_route('admin.siswas.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}

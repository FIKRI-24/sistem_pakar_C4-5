<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KarirRequest;
use App\Models\Karir;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KarirController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('q'));
        $karirs = Karir::query()
            ->when($search !== '', fn ($query) => $query
                ->where('nama_karir', 'like', "%{$search}%")
                ->orWhere('bidang_pekerjaan', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%"))
            ->orderBy('nama_karir')
            ->paginate(10)
            ->withQueryString();

        return view('admin.karirs.index', compact('karirs', 'search'));
    }

    public function create(): View
    {
        return view('admin.karirs.form', ['karir' => new Karir]);
    }

    public function store(KarirRequest $request): RedirectResponse
    {
        Karir::create($request->validated());

        return to_route('admin.karirs.index')->with('success', 'Karir berhasil ditambahkan.');
    }

    public function edit(Karir $karir): View
    {
        return view('admin.karirs.form', compact('karir'));
    }

    public function update(KarirRequest $request, Karir $karir): RedirectResponse
    {
        $karir->update($request->validated());

        return to_route('admin.karirs.index')->with('success', 'Karir berhasil diperbarui.');
    }

    public function destroy(Karir $karir): RedirectResponse
    {
        $karir->delete();

        return to_route('admin.karirs.index')->with('success', 'Karir berhasil dihapus.');
    }
}

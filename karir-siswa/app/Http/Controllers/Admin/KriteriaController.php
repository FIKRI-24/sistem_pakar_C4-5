<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\KriteriaRequest;
use App\Models\Kriteria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KriteriaController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('q'));
        $kriterias = Kriteria::query()
            ->when($search !== '', fn ($query) => $query
                ->where('nama_kriteria', 'like', "%{$search}%")
                ->orWhere('keterangan', 'like', "%{$search}%"))
            ->orderBy('nama_kriteria')
            ->paginate(10)
            ->withQueryString();

        return view('admin.kriterias.index', compact('kriterias', 'search'));
    }

    public function create(): View
    {
        return view('admin.kriterias.form', ['kriteria' => new Kriteria]);
    }

    public function store(KriteriaRequest $request): RedirectResponse
    {
        Kriteria::create($request->validated());

        return to_route('admin.kriterias.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(Kriteria $kriteria): View
    {
        return view('admin.kriterias.form', compact('kriteria'));
    }

    public function update(KriteriaRequest $request, Kriteria $kriteria): RedirectResponse
    {
        $kriteria->update($request->validated());

        return to_route('admin.kriterias.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Kriteria $kriteria): RedirectResponse
    {
        $kriteria->delete();

        return to_route('admin.kriterias.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}

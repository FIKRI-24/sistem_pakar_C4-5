<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SoalRequest;
use App\Models\Kriteria;
use App\Models\Soal;
use App\Models\Tes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SoalController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('q'));
        $tesId = $request->integer('tes_id') ?: null;
        $soals = Soal::query()
            ->with(['tes', 'kriteria'])
            ->when($tesId, fn ($query) => $query->where('tes_id', $tesId))
            ->when($search !== '', fn ($query) => $query->where('pertanyaan', 'like', "%{$search}%"))
            ->orderBy('tes_id')
            ->orderBy('urutan')
            ->paginate(10)
            ->withQueryString();

        return view('admin.soals.index', [
            'soals' => $soals,
            'tests' => Tes::orderBy('nama_tes')->get(),
            'search' => $search,
            'tesId' => $tesId,
        ]);
    }

    public function create(): View
    {
        return view('admin.soals.form', $this->formData(new Soal));
    }

    public function store(SoalRequest $request): RedirectResponse
    {
        Soal::create($request->validated());

        return to_route('admin.soals.index')->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function edit(Soal $soal): View
    {
        return view('admin.soals.form', $this->formData($soal));
    }

    public function update(SoalRequest $request, Soal $soal): RedirectResponse
    {
        $soal->update($request->validated());

        return to_route('admin.soals.index')->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroy(Soal $soal): RedirectResponse
    {
        $soal->delete();

        return to_route('admin.soals.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function formData(Soal $soal): array
    {
        return [
            'soal' => $soal,
            'tests' => Tes::orderBy('nama_tes')->get(),
            'kriterias' => Kriteria::orderBy('nama_kriteria')->get(),
        ];
    }
}

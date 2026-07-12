<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PilihanJawabanRequest;
use App\Models\KriteriaOpsi;
use App\Models\PilihanJawaban;
use App\Models\Soal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PilihanJawabanController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('q'));
        $pilihanJawabans = PilihanJawaban::query()
            ->with(['soal.tes', 'soal.kriteria', 'kriteriaOpsi'])
            ->when($search !== '', fn ($query) => $query
                ->where('pilihan', 'like', "%{$search}%")
                ->orWhereHas('soal', fn ($soal) => $soal->where('pertanyaan', 'like', "%{$search}%")))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pilihan-jawabans.index', compact('pilihanJawabans', 'search'));
    }

    public function create(): View
    {
        return view('admin.pilihan-jawabans.form', $this->formData(new PilihanJawaban));
    }

    public function store(PilihanJawabanRequest $request): RedirectResponse
    {
        PilihanJawaban::create($request->validated());

        return to_route('admin.pilihan-jawabans.index')->with('success', 'Pilihan jawaban berhasil ditambahkan.');
    }

    public function edit(PilihanJawaban $pilihanJawaban): View
    {
        return view('admin.pilihan-jawabans.form', $this->formData($pilihanJawaban));
    }

    public function update(PilihanJawabanRequest $request, PilihanJawaban $pilihanJawaban): RedirectResponse
    {
        $pilihanJawaban->update($request->validated());

        return to_route('admin.pilihan-jawabans.index')->with('success', 'Pilihan jawaban berhasil diperbarui.');
    }

    public function destroy(PilihanJawaban $pilihanJawaban): RedirectResponse
    {
        $pilihanJawaban->delete();

        return to_route('admin.pilihan-jawabans.index')->with('success', 'Pilihan jawaban berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function formData(PilihanJawaban $pilihanJawaban): array
    {
        return [
            'pilihanJawaban' => $pilihanJawaban,
            'soals' => Soal::with(['tes', 'kriteria'])->orderBy('tes_id')->orderBy('urutan')->get(),
            'opsiKriteria' => KriteriaOpsi::with('kriteria')->orderBy('kriteria_id')->orderBy('urutan')->get(),
        ];
    }
}

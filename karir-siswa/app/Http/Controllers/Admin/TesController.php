<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TesRequest;
use App\Models\Tes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TesController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('q'));
        $tes = Tes::query()
            ->when($search !== '', fn ($query) => $query
                ->where('nama_tes', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%"))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.tes.index', compact('tes', 'search'));
    }

    public function create(): View
    {
        return view('admin.tes.form', ['tes' => new Tes]);
    }

    public function store(TesRequest $request): RedirectResponse
    {
        Tes::create($request->validated());

        return to_route('admin.tes.index')->with('success', 'Tes berhasil ditambahkan.');
    }

    public function edit(Tes $te): View
    {
        return view('admin.tes.form', ['tes' => $te]);
    }

    public function update(TesRequest $request, Tes $te): RedirectResponse
    {
        $te->update($request->validated());

        return to_route('admin.tes.index')->with('success', 'Tes berhasil diperbarui.');
    }

    public function destroy(Tes $te): RedirectResponse
    {
        $te->delete();

        return to_route('admin.tes.index')->with('success', 'Tes berhasil dihapus.');
    }

    public function hasilTes(Request $request): View
    {
        $search = trim((string) $request->string('q'));
        $hasilTes = \App\Models\HasilTes::with(['siswa.user', 'tes', 'rekomendasis.karir'])
            ->when($search !== '', function ($query) use ($search) {
                $query->whereHas('siswa.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('tes', function ($q) use ($search) {
                    $q->where('nama_tes', 'like', "%{$search}%");
                });
            })
            ->latest('tanggal_tes')
            ->paginate(10)
            ->withQueryString();

        return view('admin.tes.hasil_tes', compact('hasilTes', 'search'));
    }

    public function rekomendasiKarir(Request $request): View
    {
        $search = trim((string) $request->string('q'));
        $rekomendasis = \App\Models\RekomendasiKarir::with(['hasilTes.siswa.user', 'karir'])
            ->when($search !== '', function ($query) use ($search) {
                $query->whereHas('hasilTes.siswa.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('karir', function ($q) use ($search) {
                    $q->where('nama_karir', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.tes.rekomendasi_karir', compact('rekomendasis', 'search'));
    }

    public function showHasilTes(\App\Models\HasilTes $hasilTes): View
    {
        $hasilTes->load(['tes', 'siswa.user', 'details.kriteria', 'rekomendasis.karir']);
        return view('admin.tes.show_hasil', compact('hasilTes'));
    }
}

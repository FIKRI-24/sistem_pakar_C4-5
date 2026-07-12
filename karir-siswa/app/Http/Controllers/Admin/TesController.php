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
}

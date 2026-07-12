<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTesLengkapRequest;
use App\Models\Kriteria;
use App\Models\Tes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TesLengkapController extends Controller
{
    public function create(): View
    {
        $kriterias = Kriteria::with([
            'opsis' => fn ($query) => $query->orderBy('urutan')->orderBy('id')
        ])->orderBy('nama_kriteria')->get();

        return view('admin.tes.buat_lengkap', compact('kriterias'));
    }

    public function store(StoreTesLengkapRequest $request): RedirectResponse
    {
        DB::transaction(function () use ($request) {
            $tes = Tes::create([
                'nama_tes' => $request->input('nama_tes'),
                'deskripsi' => $request->input('deskripsi'),
                'durasi_menit' => $request->input('durasi_menit'),
                'status_aktif' => $request->boolean('status_aktif'),
            ]);

            $soalsData = $request->input('soals', []);
            $kriteriaIds = collect($soalsData)->pluck('kriteria_id')->unique()->all();
            $kriterias = Kriteria::findMany($kriteriaIds)->keyBy('id');

            foreach ($soalsData as $soalData) {
                $soal = $tes->soals()->create([
                    'kriteria_id' => $soalData['kriteria_id'],
                    'pertanyaan' => $soalData['pertanyaan'],
                    'urutan' => $soalData['urutan'] ?? null,
                ]);

                $kriteria = $kriterias->get($soalData['kriteria_id']);

                if ($kriteria && $kriteria->tipe_data === Kriteria::TYPE_KATEGORIK) {
                    $pilihansData = $soalData['pilihans'] ?? [];
                    foreach ($pilihansData as $pilihanData) {
                        $soal->pilihanJawabans()->create([
                            'pilihan' => $pilihanData['pilihan'],
                            'skor' => (float) $pilihanData['skor'],
                            'kriteria_opsi_id' => $pilihanData['kriteria_opsi_id'] ?? null,
                        ]);
                    }
                }
            }
        });

        return to_route('admin.tes.index')->with('success', 'Tes lengkap beserta soal dan pilihan jawaban berhasil dibuat.');
    }
}

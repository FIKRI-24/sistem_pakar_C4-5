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

        // Ambil data bank soal unik dari database (anti-duplikat)
        $bankSoals = \App\Models\Soal::with(['kriteria', 'pilihanJawabans.kriteriaOpsi'])
            ->get()
            ->unique(function ($soal) {
                return trim(strtolower($soal->pertanyaan));
            })
            ->map(function ($soal) {
                // Tentukan tag jurusan/kategori
                $tag = 'Umum';
                if ($soal->kriteria->nama_kriteria === 'Nilai Akademik') {
                    $tag = 'Akademik';
                } elseif ($soal->kriteria->nama_kriteria === 'Bakat') {
                    $tag = 'Bakat';
                } elseif ($soal->kriteria->nama_kriteria === 'Kepribadian') {
                    $tag = 'Kepribadian';
                } else {
                    if (str_contains($soal->pertanyaan, '(TKJ)')) {
                        $tag = 'TKJ';
                    } elseif (str_contains($soal->pertanyaan, '(ATPH)')) {
                        $tag = 'ATPH';
                    } elseif (str_contains($soal->pertanyaan, '(AKL')) {
                        $tag = 'AKL';
                    }
                }

                $firstChoice = $soal->pilihanJawabans->first();
                $opsiLabel = $firstChoice && $firstChoice->kriteriaOpsi ? $firstChoice->kriteriaOpsi->label : null;

                return [
                    'kriteriaName' => $soal->kriteria->nama_kriteria,
                    'opsiLabel' => $opsiLabel,
                    'pertanyaan' => trim($soal->pertanyaan),
                    'tag' => $tag
                ];
            })->values();

        return view('admin.tes.buat_lengkap', compact('kriterias', 'bankSoals'));
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

            // --- PENGAMAN OTOMATIS: Suntik Nilai Akademik jika Guru BK lupa ---
            $hasAcademic = false;
            foreach ($soalsData as $soal) {
                $k = $kriterias->get($soal['kriteria_id']);
                if ($k && $k->nama_kriteria === 'Nilai Akademik') {
                    $hasAcademic = true;
                    break;
                }
            }

            if (!$hasAcademic) {
                $academicKriteria = Kriteria::where('nama_kriteria', 'Nilai Akademik')->first();
                if ($academicKriteria) {
                    $stdAcademicQuestions = [
                        'Berapa nilai rata-rata mata pelajaran Produktif Kejuruan (TKJ / AKL / ATPH) Anda semester lalu?',
                        'Berapa nilai rata-rata mata pelajaran Eksakta (Matematika, IPA, Kimia) Anda semester lalu?',
                        'Berapa nilai rata-rata mata pelajaran Umum (Bahasa Indonesia, Bahasa Inggris, PKN) Anda semester lalu?'
                    ];
                    foreach ($stdAcademicQuestions as $pertanyaan) {
                        $soalsData[] = [
                            'kriteria_id' => $academicKriteria->id,
                            'pertanyaan' => $pertanyaan,
                            'urutan' => null,
                            'pilihans' => []
                        ];
                    }
                    $kriterias[$academicKriteria->id] = $academicKriteria;
                }
            }
            // -----------------------------------------------------------------

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

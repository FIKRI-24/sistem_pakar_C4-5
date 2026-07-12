<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\Siswa\SubmitKonsultasiRequest;
use App\Models\HasilTes;
use App\Models\Kriteria;
use App\Models\Siswa;
use App\Models\Tes;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class KonsultasiController extends Controller
{
    public function index(): View
    {
        $siswa = $this->siswa(auth()->id());
        $tests = Tes::query()
            ->where('status_aktif', true)
            ->orderBy('nama_tes')
            ->get();

        $takenTestIds = HasilTes::where('siswa_id', $siswa->id)->pluck('tes_id')->all();

        return view('siswa.konsultasi.index', compact('tests', 'takenTestIds'));
    }

    public function show(Tes $tes): View|RedirectResponse
    {
        $siswa = $this->siswa(auth()->id());

        $alreadyTaken = HasilTes::where('siswa_id', $siswa->id)->where('tes_id', $tes->id)->exists();
        if ($alreadyTaken) {
            return to_route('siswa.konsultasi.index')->with('error', 'Anda sudah mengerjakan kuesioner ini.');
        }

        $tes->load([
            'soals' => fn ($query) => $query
                ->with(['kriteria.opsis', 'pilihanJawabans.kriteriaOpsi'])
                ->orderBy('urutan')
                ->orderBy('id'),
        ]);

        return view('siswa.konsultasi.show', compact('tes'));
    }

    public function store(SubmitKonsultasiRequest $request, Tes $tes): RedirectResponse
    {
        $siswa = $this->siswa($request->user()->id);

        $alreadyTaken = HasilTes::where('siswa_id', $siswa->id)->where('tes_id', $tes->id)->exists();
        if ($alreadyTaken) {
            return back()->with('error', 'Anda sudah mengerjakan kuesioner ini.');
        }

        $tes->load([
            'soals' => fn ($query) => $query
                ->with(['kriteria.opsis', 'pilihanJawabans.kriteriaOpsi'])
                ->orderBy('urutan')
                ->orderBy('id'),
        ]);

        $hasilTes = DB::transaction(function () use ($request, $tes, $siswa) {
            $hasilTes = HasilTes::create([
                'siswa_id' => $siswa->id,
                'tes_id' => $tes->id,
                'tanggal_tes' => now(),
            ]);
            $scores = [];
            $numericKriterias = [];

            foreach ($tes->soals as $soal) {
                $kriteria = $soal->kriteria;
                if ($kriteria->tipe_data === Kriteria::TYPE_NUMERIK) {
                    $numericKriterias[$kriteria->id] = $kriteria;

                    continue;
                }

                foreach ($kriteria->opsis as $opsi) {
                    $scores[$kriteria->id][$opsi->id] ??= [
                        'total' => 0.0,
                        'first_question_order' => null,
                        'opsi' => $opsi,
                    ];
                }
                $pilihan = $soal->pilihanJawabans->firstWhere('id', (int) $request->input("jawabans.{$soal->id}"));
                $score = &$scores[$kriteria->id][$pilihan->kriteria_opsi_id];
                $score['total'] += (float) $pilihan->skor;
                $score['first_question_order'] ??= $soal->urutan ?? $soal->id;
                unset($score);
            }

            foreach ($scores as $kriteriaId => $optionScores) {
                // Use total score. On a tie, the category answered on the earliest question wins.
                usort($optionScores, function (array $left, array $right): int {
                    $totalComparison = $right['total'] <=> $left['total'];
                    if ($totalComparison !== 0) {
                        return $totalComparison;
                    }

                    $leftOrder = $left['first_question_order'] ?? PHP_INT_MAX;
                    $rightOrder = $right['first_question_order'] ?? PHP_INT_MAX;

                    return $leftOrder <=> $rightOrder
                        ?: ($left['opsi']->urutan ?? PHP_INT_MAX) <=> ($right['opsi']->urutan ?? PHP_INT_MAX);
                });
                $hasilTes->details()->create([
                    'kriteria_id' => $kriteriaId,
                    'nilai_kategorik' => $optionScores[0]['opsi']->label,
                ]);
            }

            foreach ($numericKriterias as $kriteria) {
                $hasilTes->details()->create([
                    'kriteria_id' => $kriteria->id,
                    'nilai_numerik' => (float) $request->input("nilai_numerik.{$kriteria->id}"),
                ]);
            }

            return $hasilTes;
        });

        return to_route('siswa.hasil-tes.show', $hasilTes)->with('success', 'Kuesioner berhasil disimpan.');
    }

    private function siswa(int $userId): Siswa
    {
        return Siswa::query()->where('user_id', $userId)->firstOrFail();
    }
}

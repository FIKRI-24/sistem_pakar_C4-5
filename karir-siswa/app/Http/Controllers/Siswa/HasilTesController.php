<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\HasilTes;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HasilTesController extends Controller
{
    public function index(Request $request): View
    {
        $siswa = $this->siswa($request->user()->id);
        $hasilTes = HasilTes::query()
            ->where('siswa_id', $siswa->id)
            ->with('tes')
            ->latest('tanggal_tes')
            ->paginate(10);

        return view('siswa.hasil-tes.index', compact('hasilTes'));
    }

    public function show(Request $request, HasilTes $hasilTes): View
    {
        $siswa = $this->siswa($request->user()->id);
        abort_unless($hasilTes->siswa_id === $siswa->id, 404);
        $hasilTes->load([
            'tes',
            'details.kriteria',
            'jawabans.soal.kriteria',
            'jawabans.pilihanJawaban.kriteriaOpsi',
            'rekomendasis.karir'
        ]);

        return view('siswa.hasil-tes.show', compact('hasilTes'));
    }

    public function exportPdf(Request $request, HasilTes $hasilTes)
    {
        $siswa = $this->siswa($request->user()->id);
        abort_unless($hasilTes->siswa_id === $siswa->id, 404);
        $hasilTes->load([
            'tes',
            'siswa.user',
            'details.kriteria',
            'jawabans.soal.kriteria',
            'jawabans.pilihanJawaban.kriteriaOpsi',
            'rekomendasis.karir'
        ]);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.laporan_siswa', compact('hasilTes'));
        
        $filename = 'Laporan_Hasil_Tes_' . str_replace(' ', '_', $hasilTes->siswa->user->name ?? 'Siswa') . '.pdf';
        return $pdf->download($filename);
    }

    private function siswa(int $userId): Siswa
    {
        return Siswa::query()->where('user_id', $userId)->firstOrFail();
    }
}

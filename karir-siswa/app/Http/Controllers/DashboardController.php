<?php

namespace App\Http\Controllers;

use App\Models\HasilTes;
use App\Models\HasilTesDetail;
use App\Models\RekomendasiKarir;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function redirect(Request $request): RedirectResponse
    {
        return redirect()->route($request->user()->dashboardRouteName());
    }

    public function admin(): View
    {
        $stats = $this->getDashboardStats();
        return view('dashboards.role', array_merge([
            'title' => 'Dashboard',
            'roleLabel' => 'Admin',
            'description' => 'Kelola data master, pengguna, dan proses pembangunan pohon keputusan.',
            'items' => [
                'Manajemen data siswa, kriteria, dan alternatif karir.',
                'Import data training untuk mesin C4.5.',
                'Rebuild decision tree saat data training diperbarui.',
            ],
            'links' => [
                ['label' => 'Kelola Siswa', 'route' => 'admin.siswas.index'],
                ['label' => 'Kelola Kriteria', 'route' => 'admin.kriterias.index'],
                ['label' => 'Kelola Karir', 'route' => 'admin.karirs.index'],
                ['label' => 'Kelola Tes', 'route' => 'admin.tes.index'],
                ['label' => 'Kelola Data Training', 'route' => 'admin.data-trainings.index'],
                ['label' => 'Status C4.5', 'route' => 'admin.c45.status'],
            ],
        ], $stats));
    }

    public function guruBk(): View
    {
        $stats = $this->getDashboardStats();
        return view('dashboards.role', array_merge([
            'title' => 'Dashboard',
            'roleLabel' => 'Guru BK',
            'description' => 'Pantau hasil konsultasi siswa dan siapkan rekap rekomendasi karir.',
            'items' => [
                'Melihat rekap hasil konsultasi siswa.',
                'Memfilter laporan berdasarkan kelas, jurusan, dan tanggal.',
                'Mengunduh laporan rekomendasi saat modul laporan tersedia.',
            ],
            'links' => [
                ['label' => 'Kelola Tes', 'route' => 'admin.tes.index'],
            ],
        ], $stats));
    }

    public function siswa(): View
    {
        return view('dashboards.role', [
            'title' => 'Dashboard Siswa',
            'roleLabel' => 'Siswa',
            'description' => 'Akses konsultasi karir dan lihat hasil rekomendasi pribadi.',
            'items' => [
                'Mengisi kuesioner konsultasi karir.',
                'Melihat rekomendasi karir berdasarkan hasil tes.',
                'Data hanya dapat diakses oleh siswa pemilik akun.',
            ],
            'links' => [
                ['label' => 'Konsultasi Karir', 'route' => 'siswa.konsultasi.index'],
                ['label' => 'Riwayat Hasil Tes', 'route' => 'siswa.hasil-tes.index'],
            ],
        ]);
    }

    private function getDashboardStats(): array
    {
        $totalSiswa = 0;
        $tesDilakukan = 0;
        $hasilTesCount = 0;
        $rekomendasiCount = 0;

        $minatCount = 0;
        $bakatCount = 0;
        $kepribadianCount = 0;
        $kecocokanCount = 0;

        $tesTerbaru = [];
        $distribusiKarir = [];

        try {
            $totalSiswa = Siswa::count();
            $tesDilakukan = HasilTes::count();
            $hasilTesCount = HasilTes::count();
            $rekomendasiCount = RekomendasiKarir::distinct('hasil_tes_id')->count();

            // Count for Pie Chart: Tes per Kategori
            $minatCount = HasilTesDetail::whereHas('kriteria', fn($q) => $q->where('nama_kriteria', 'Minat'))->count();
            $bakatCount = HasilTesDetail::whereHas('kriteria', fn($q) => $q->where('nama_kriteria', 'Bakat'))->count();
            $kepribadianCount = HasilTesDetail::whereHas('kriteria', fn($q) => $q->where('nama_kriteria', 'Kepribadian'))->count();
            $kecocokanCount = RekomendasiKarir::count();

            // Latest Tests Table
            $tesTerbaru = HasilTes::with(['siswa.user', 'tes'])
                ->latest('tanggal_tes')
                ->take(5)
                ->get()
                ->map(function ($hasil) {
                    return [
                        'nama_siswa' => $hasil->siswa->user->name ?? 'Siswa',
                        'jenis_tes' => $hasil->tes->nama_tes ?? 'Tes',
                        'tanggal' => $hasil->tanggal_tes->format('d/m/Y'),
                        'status' => 'Selesai'
                    ];
                })->all();

            // Real-time Career Recommendation Distribution
            $rawDistribusi = RekomendasiKarir::query()
                ->selectRaw('karir_id, COUNT(*) as total')
                ->groupBy('karir_id')
                ->with('karir')
                ->get();

            $totalRekomendasiReal = $rawDistribusi->sum('total');

            if ($totalRekomendasiReal > 0) {
                $distribusiKarir = $rawDistribusi->map(function ($item) use ($totalRekomendasiReal) {
                    $namaKarir = $item->karir->nama_karir ?? ('Karir #' . $item->karir_id);
                    $percentage = round(($item->total / $totalRekomendasiReal) * 100, 1);
                    return [
                        'nama_karir' => $namaKarir,
                        'total' => (int) $item->total,
                        'persen' => $percentage,
                    ];
                })->sortByDesc('total')->values()->all();
            }
        } catch (\Throwable $e) {
            // Silently catch database errors
        }

        return [
            'totalSiswa' => $totalSiswa,
            'tesDilakukan' => $tesDilakukan,
            'hasilTesCount' => $hasilTesCount,
            'rekomendasiCount' => $rekomendasiCount,
            'minatCount' => $minatCount,
            'bakatCount' => $bakatCount,
            'kepribadianCount' => $kepribadianCount,
            'kecocokanCount' => $kecocokanCount,
            'tesTerbaru' => $tesTerbaru,
            'distribusiKarir' => $distribusiKarir,
        ];
    }
}

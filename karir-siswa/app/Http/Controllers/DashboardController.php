<?php

namespace App\Http\Controllers;

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
        return view('dashboards.role', [
            'title' => 'Dashboard Admin',
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
        ]);
    }

    public function guruBk(): View
    {
        return view('dashboards.role', [
            'title' => 'Dashboard Guru BK',
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
        ]);
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
}

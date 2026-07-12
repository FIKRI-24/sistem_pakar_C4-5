<?php

namespace Database\Seeders;

use App\Models\Karir;
use Illuminate\Database\Seeder;

class KarirFinalSeeder extends Seeder
{
    public function run(): void
    {
        $karirs = [
            ['nama_karir' => 'Teknisi/Operator Teknik', 'bidang_pekerjaan' => 'Teknik', 'deskripsi' => 'Mengoperasikan, merawat, dan memperbaiki peralatan atau sistem teknis.', 'informasi_pendukung' => 'Cocok untuk minat Realistic dan bakat Motorik/Praktikal.'],
            ['nama_karir' => 'Analis/Peneliti', 'bidang_pekerjaan' => 'Sains dan Analisis', 'deskripsi' => 'Menganalisis data, masalah, atau fenomena untuk menghasilkan temuan dan solusi.', 'informasi_pendukung' => 'Cocok untuk minat Investigative dan bakat Numerik/Logika.'],
            ['nama_karir' => 'Desainer Kreatif', 'bidang_pekerjaan' => 'Industri Kreatif', 'deskripsi' => 'Merancang karya visual, produk, atau pengalaman kreatif.', 'informasi_pendukung' => 'Cocok untuk minat Artistic dan bakat Spasial/Visual.'],
            ['nama_karir' => 'Tenaga Kesehatan & Konseling', 'bidang_pekerjaan' => 'Layanan Kesehatan', 'deskripsi' => 'Memberi layanan kesehatan, pendampingan, atau konseling kepada masyarakat.', 'informasi_pendukung' => 'Cocok untuk minat Social dan kepribadian Steadiness.'],
            ['nama_karir' => 'Wirausaha/Marketing', 'bidang_pekerjaan' => 'Bisnis', 'deskripsi' => 'Membangun usaha, menawarkan produk, dan mengembangkan pasar.', 'informasi_pendukung' => 'Cocok untuk minat Enterprising dan kepribadian Dominance atau Influence.'],
            ['nama_karir' => 'Administrasi & Akuntansi', 'bidang_pekerjaan' => 'Administrasi dan Keuangan', 'deskripsi' => 'Mengelola dokumen, transaksi, pencatatan, dan tata kelola administrasi.', 'informasi_pendukung' => 'Cocok untuk minat Conventional dan kepribadian Compliance.'],
            ['nama_karir' => 'Pendidik/Guru', 'bidang_pekerjaan' => 'Pendidikan', 'deskripsi' => 'Merancang serta menyampaikan pembelajaran dan pendampingan perkembangan peserta didik.', 'informasi_pendukung' => 'Cocok untuk minat Social atau Investigative dengan bakat Verbal.'],
            ['nama_karir' => 'Agribisnis/Pertanian', 'bidang_pekerjaan' => 'Agribisnis', 'deskripsi' => 'Mengelola produksi, teknologi, dan usaha berbasis pertanian.', 'informasi_pendukung' => 'Cocok untuk minat Realistic dan bakat Motorik/Praktikal.'],
        ];

        foreach ($karirs as $attributes) {
            $karir = Karir::withTrashed()->firstOrNew(['nama_karir' => $attributes['nama_karir']]);
            $karir->fill($attributes);
            $karir->save();
            $karir->restore();
        }

        Karir::query()->whereNotIn('nama_karir', array_column($karirs, 'nama_karir'))->delete();
    }
}

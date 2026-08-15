<?php

namespace Database\Seeders;

use App\Models\DataTraining;
use App\Models\DataTrainingAtribut;
use App\Models\Karir;
use Illuminate\Database\Seeder;

class KarirFinalSeeder extends Seeder
{
    public function run(): void
    {
        $karirs = [
            // === DPIB (Arsitektur & Konstruksi) ===
            [
                'nama_karir' => 'Drafter Bangunan',
                'bidang_pekerjaan' => 'DPIB (Arsitektur & Konstruksi)',
                'deskripsi' => 'Membuat dan mengembangkan gambar kerja teknik bangunan 2D/3D (CAD) secara presisi berdasarkan arahan arsitek atau insinyur.',
                'informasi_pendukung' => 'Cocok untuk minat Realistic dengan bakat Spasial/Visual dan ketelitian Compliance yang tinggi.',
            ],
            [
                'nama_karir' => 'Desainer Bangunan',
                'bidang_pekerjaan' => 'DPIB (Arsitektur & Konstruksi)',
                'deskripsi' => 'Merancang konsep tata letak, estetika arsitektur, dan visualisasi interior/eksterior bangunan.',
                'informasi_pendukung' => 'Cocok untuk minat Artistic dengan bakat Spasial/Visual dan kepribadian Influence.',
            ],
            [
                'nama_karir' => 'BIM Modeler',
                'bidang_pekerjaan' => 'DPIB (Arsitektur & Konstruksi)',
                'deskripsi' => 'Menyusun model informasi bangunan digital 3D terintegrasi (Building Information Modeling) mencakup struktur, arsitektur, dan utilitas.',
                'informasi_pendukung' => 'Cocok untuk minat Investigative/Realistic dengan bakat Spasial/Visual dan kepribadian Compliance.',
            ],
            [
                'nama_karir' => 'Surveyor',
                'bidang_pekerjaan' => 'DPIB (Arsitektur & Konstruksi)',
                'deskripsi' => 'Melakukan pengukuran topografi, elevasi tanah, dan pemetaan lahan proyek menggunakan alat ukur theodolite/total station.',
                'informasi_pendukung' => 'Cocok untuk minat Realistic dengan bakat Numerik/Logika dan kepribadian Steadiness.',
            ],
            [
                'nama_karir' => 'Estimator/Quantity Surveyor',
                'bidang_pekerjaan' => 'DPIB (Arsitektur & Konstruksi)',
                'deskripsi' => 'Menghitung volume pekerjaan, kebutuhan material, dan menyusun Rencana Anggaran Biaya (RAB) proyek konstruksi.',
                'informasi_pendukung' => 'Cocok untuk minat Conventional dengan bakat Numerik/Logika dan kepribadian Compliance.',
            ],
            [
                'nama_karir' => 'Pengawas Konstruksi',
                'bidang_pekerjaan' => 'DPIB (Arsitektur & Konstruksi)',
                'deskripsi' => 'Mengawasi jalannya pekerjaan konstruksi di lapangan agar sesuai dengan gambar kerja, spesifikasi mutu, dan jadwal proyek.',
                'informasi_pendukung' => 'Cocok untuk minat Realistic dengan bakat Motorik/Praktikal dan kepribadian Dominance.',
            ],

            // === TKJ (Teknologi Informasi & Jaringan) ===
            [
                'nama_karir' => 'Network Administrator',
                'bidang_pekerjaan' => 'TKJ (Teknologi Informasi & Jaringan)',
                'deskripsi' => 'Merancang, mengonfigurasi, dan memelihara infrastruktur jaringan komputer (router, switch, firewall, VPN) serta keamanan data.',
                'informasi_pendukung' => 'Cocok untuk minat Investigative dengan bakat Numerik/Logika dan kepribadian Compliance.',
            ],
            [
                'nama_karir' => 'IT Support Specialist',
                'bidang_pekerjaan' => 'TKJ (Teknologi Informasi & Jaringan)',
                'deskripsi' => 'Memberikan layanan bantuan teknis, perbaikan hardware/software komputer, dan pemecahan masalah operasional IT pengguna.',
                'informasi_pendukung' => 'Cocok untuk minat Social/Realistic dengan bakat Motorik/Praktikal dan kepribadian Steadiness.',
            ],
            [
                'nama_karir' => 'Teknisi Fiber Optic',
                'bidang_pekerjaan' => 'TKJ (Teknologi Informasi & Jaringan)',
                'deskripsi' => 'Melakukan instalasi penarikan kabel fiber optic, penyambungan core (splicing), dan pengujian redaman jalur dengan OTDR.',
                'informasi_pendukung' => 'Cocok untuk minat Realistic dengan bakat Motorik/Praktikal dan kepribadian Steadiness.',
            ],
            [
                'nama_karir' => 'Junior System Administrator',
                'bidang_pekerjaan' => 'TKJ (Teknologi Informasi & Jaringan)',
                'deskripsi' => 'Mengelola sistem operasi server (Linux/Windows Server), layanan direktori, backup data berkala, dan monitoring ketersediaan server.',
                'informasi_pendukung' => 'Cocok untuk minat Investigative dengan bakat Numerik/Logika dan kepribadian Dominance/Compliance.',
            ],
            [
                'nama_karir' => 'Teknisi CCTV & IoT',
                'bidang_pekerjaan' => 'TKJ (Teknologi Informasi & Jaringan)',
                'deskripsi' => 'Memasang, mengonfigurasi perangkat kamera keamanan berbasis IP (CCTV), sensor pintar, dan perangkat IoT terhubung jaringan.',
                'informasi_pendukung' => 'Cocok untuk minat Realistic dengan bakat Spasial/Visual dan kepribadian Compliance.',
            ],
            [
                'nama_karir' => 'Field Technician ISP',
                'bidang_pekerjaan' => 'TKJ (Teknologi Informasi & Jaringan)',
                'deskripsi' => 'Melakukan instalasi modem/ONT, setting router pelanggan internet, penarikan kabel drop core ke rumah/kantor pelanggan.',
                'informasi_pendukung' => 'Cocok untuk minat Realistic/Social dengan bakat Motorik/Praktikal dan kepribadian Influence.',
            ],
            [
                'nama_karir' => 'Wirausaha Jasa IT (Technopreneur)',
                'bidang_pekerjaan' => 'TKJ (Teknologi Informasi & Jaringan)',
                'deskripsi' => 'Membangun usaha mandiri penyedia jasa instalasi jaringan, servis komputer, pengadaan perangkat IT, dan solusi teknologi.',
                'informasi_pendukung' => 'Cocok untuk minat Enterprising dengan bakat Verbal/Numerik dan kepribadian Dominance atau Influence.',
            ],

            // === KRIYA KAYU (Kerajinan & Furnitur) ===
            [
                'nama_karir' => 'Desainer Furnitur & Mebel Kayu',
                'bidang_pekerjaan' => 'Kriya Kayu (Kerajinan & Furnitur)',
                'deskripsi' => 'Merancang sketsa, konsep estetika, dan model produk furnitur kayu/rotan fungsional bernilai jual tinggi.',
                'informasi_pendukung' => 'Cocok untuk minat Artistic dengan bakat Spasial/Visual dan kepribadian Influence atau Dominance.',
            ],
            [
                'nama_karir' => 'Pengrajin Kriya Kayu & Ukir (Wood Artisan)',
                'bidang_pekerjaan' => 'Kriya Kayu (Kerajinan & Furnitur)',
                'deskripsi' => 'Membuat karya seni kriya kayu, ornamen ukiran tradisional/modern, souvenir, dan hiasan interior berbahan kayu.',
                'informasi_pendukung' => 'Cocok untuk minat Artistic/Realistic dengan bakat Motorik/Praktikal dan kepribadian Steadiness.',
            ],
            [
                'nama_karir' => 'Operator Mesin Woodworking / CNC Kayu',
                'bidang_pekerjaan' => 'Kriya Kayu (Kerajinan & Furnitur)',
                'deskripsi' => 'Mengoperasikan mesin perkayuan presisi (mesin serut, bubut kayu, router CNC) untuk pemotongan dan pembentukan komponen mebel.',
                'informasi_pendukung' => 'Cocok untuk minat Realistic dengan bakat Motorik/Praktikal dan kepribadian Compliance.',
            ],
            [
                'nama_karir' => 'Finishing Specialist Kayu (Wood Finisher)',
                'bidang_pekerjaan' => 'Kriya Kayu (Kerajinan & Furnitur)',
                'deskripsi' => 'Melakukan proses pengamplasan halus, pewarnaan serat kayu, pelapisan melamin, pernis, dan coating akhir produk kayu.',
                'informasi_pendukung' => 'Cocok untuk minat Realistic dengan bakat Motorik/Praktikal dan kepribadian Steadiness.',
            ],
            [
                'nama_karir' => 'Wirausaha Kriya Kayu (Woodcraft Entrepreneur)',
                'bidang_pekerjaan' => 'Kriya Kayu (Kerajinan & Furnitur)',
                'deskripsi' => 'Mendirikan dan mengelola bengkel produksi kriya kayu, mebel custom, serta memasarkan produk kerajinan kayu.',
                'informasi_pendukung' => 'Cocok untuk minat Enterprising dengan bakat Motorik/Verbal dan kepribadian Dominance atau Influence.',
            ],
            [
                'nama_karir' => 'Quality Control (QC) Produk Kayu & Mebel',
                'bidang_pekerjaan' => 'Kriya Kayu (Kerajinan & Furnitur)',
                'deskripsi' => 'Melakukan inspeksi mutu kadar air kayu, kekuatan sambungan konstruksi kayu, dan kelayakan finishing sebelum pengiriman produk.',
                'informasi_pendukung' => 'Cocok untuk minat Conventional dengan bakat Numerik/Spasial dan kepribadian Compliance.',
            ],

            // === UMUM / KEDINASAN ===
            [
                'nama_karir' => 'Polisi',
                'bidang_pekerjaan' => 'Kedinasan & Layanan Publik',
                'deskripsi' => 'Menjaga keamanan dan ketertiban masyarakat, menegakkan hukum, serta memberikan perlindungan, pengayoman, dan pelayanan publik.',
                'informasi_pendukung' => 'Cocok untuk minat Social/Realistic dengan bakat Motorik/Praktikal dan kepribadian Dominance/Steadiness.',
            ],
            [
                'nama_karir' => 'TNI',
                'bidang_pekerjaan' => 'Pertahanan & Kedinasan',
                'deskripsi' => 'Menjalankan operasi militer untuk mempertahankan kedaulatan negara, keutuhan wilayah, dan keselamatan segenap bangsa.',
                'informasi_pendukung' => 'Cocok untuk minat Realistic dengan bakat Motorik/Praktikal dan kepribadian Dominance.',
            ],
            [
                'nama_karir' => 'Banker',
                'bidang_pekerjaan' => 'Perbankan & Keuangan',
                'deskripsi' => 'Melayani transaksi keuangan nasabah, verifikasi dokumen kredit/simpanan, pembukuan keuangan, dan administrasi perbankan.',
                'informasi_pendukung' => 'Cocok untuk minat Conventional dengan bakat Numerik/Logika dan kepribadian Compliance.',
            ],
            [
                'nama_karir' => 'Pebisnis',
                'bidang_pekerjaan' => 'Bisnis & Wirausaha',
                'deskripsi' => 'Mengembangkan usaha perdagangan/jasa mandiri, mengelola modal usaha, strategi pemasaran, dan manajemen penjualan barang/jasa.',
                'informasi_pendukung' => 'Cocok untuk minat Enterprising dengan bakat Verbal dan kepribadian Influence atau Dominance.',
            ],

            // === STUDI LANJUT / JURUSAN KULIAH ===
            [
                'nama_karir' => 'Kuliah: Teknik / Informatika',
                'bidang_pekerjaan' => 'Pendidikan Tinggi / Studi Lanjut',
                'deskripsi' => 'Melanjutkan pendidikan tinggi pada program studi Teknik Informatika, Ilmu Komputer, Sistem Informasi, atau Teknik Elektro/Sipil.',
                'informasi_pendukung' => 'Direkomendasikan untuk siswa dengan nilai akademik tinggi (>85), minat Investigative kuat, dan bakat Numerik/Logika.',
            ],
            [
                'nama_karir' => 'Kuliah: Ekonomi / Manajemen',
                'bidang_pekerjaan' => 'Pendidikan Tinggi / Studi Lanjut',
                'deskripsi' => 'Melanjutkan pendidikan tinggi pada program studi Manajemen, Akuntansi, Ekonomi Pembangunan, atau Bisnis Digital.',
                'informasi_pendukung' => 'Direkomendasikan untuk siswa dengan nilai akademik tinggi (>82), minat Enterprising/Conventional, dan bakat Numerik/Verbal.',
            ],
            [
                'nama_karir' => 'Kuliah: Pendidikan (Keguruan)',
                'bidang_pekerjaan' => 'Pendidikan Tinggi / Studi Lanjut',
                'deskripsi' => 'Melanjutkan studi ke FKIP/universitas pendidikan untuk menjadi tenaga pendidik/guru profesional di bidang kejuruan atau mata pelajaran umum.',
                'informasi_pendukung' => 'Direkomendasikan untuk siswa dengan nilai akademik tinggi (>80), minat Social kuat, dan bakat Verbal.',
            ],
            [
                'nama_karir' => 'Kuliah: Ilmu Hukum',
                'bidang_pekerjaan' => 'Pendidikan Tinggi / Studi Lanjut',
                'deskripsi' => 'Melanjutkan pendidikan tinggi ke Fakultas Hukum untuk mendalami sistem perundang-undangan, advokasi, regulasi bisnis, dan peradilan.',
                'informasi_pendukung' => 'Direkomendasikan untuk siswa dengan nilai akademik tinggi (>84), minat Investigative/Social, dan bakat Verbal.',
            ],
            [
                'nama_karir' => 'Kuliah: Desain / Arsitektur',
                'bidang_pekerjaan' => 'Pendidikan Tinggi / Studi Lanjut',
                'deskripsi' => 'Melanjutkan pendidikan tinggi pada jurusan Arsitektur, Desain Komunikasi Visual (DKV), Desain Interior, atau Perencanaan Wilayah Kota.',
                'informasi_pendukung' => 'Direkomendasikan untuk siswa dengan nilai akademik tinggi (>84), minat Artistic kuat, dan bakat Spasial/Visual.',
            ],
            [
                'nama_karir' => 'Kuliah: Pertanian / Agroteknologi',
                'bidang_pekerjaan' => 'Pendidikan Tinggi / Studi Lanjut',
                'deskripsi' => 'Melanjutkan pendidikan tinggi di bidang Agribisnis, Agroteknologi, Ilmu Tanah, Teknologi Pangan, atau Peternakan.',
                'informasi_pendukung' => 'Direkomendasikan untuk siswa dengan nilai akademik tinggi (>80), minat Investigative/Realistic, dan bakat Numerik/Motorik.',
            ],
            [
                'nama_karir' => 'Kuliah: Ilmu Komunikasi',
                'bidang_pekerjaan' => 'Pendidikan Tinggi / Studi Lanjut',
                'deskripsi' => 'Melanjutkan pendidikan tinggi pada program studi Ilmu Komunikasi, Hubungan Masyarakat (PR), Jurnalistik, atau Penyiaran Media.',
                'informasi_pendukung' => 'Direkomendasikan untuk siswa dengan nilai akademik tinggi (>82), minat Artistic/Social, dan bakat Verbal.',
            ],
        ];

        foreach ($karirs as $attributes) {
            $karir = Karir::withTrashed()->firstOrNew(['nama_karir' => $attributes['nama_karir']]);
            $karir->fill($attributes);
            $karir->save();
            $karir->restore();
        }

        Karir::query()->whereNotIn('nama_karir', array_column($karirs, 'nama_karir'))->delete();

        $deletedCareerIds = Karir::onlyTrashed()->pluck('id');
        if ($deletedCareerIds->isNotEmpty()) {
            $orphanTrainingIds = DataTraining::whereIn('label_karir_id', $deletedCareerIds)->pluck('id');
            DataTrainingAtribut::whereIn('data_training_id', $orphanTrainingIds)->delete();
            DataTraining::whereIn('id', $orphanTrainingIds)->delete();
        }
    }
}


<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\PilihanJawaban;
use App\Models\Soal;
use App\Models\Tes;
use Illuminate\Database\Seeder;

class KuesionerDemoSeeder extends Seeder
{
    /**
     * Menyediakan satu kuesioner demo yang dapat langsung diuji manual.
     *
     * Pilihan kategorik mengikuti opsi final kriteria. Skor 5 diberikan pada
     * opsi yang dipilih agar kategori pilihan menjadi hasil dominan untuk soal
     * tersebut; Nilai Akademik tetap diisi melalui input angka 0-100.
     */
    public function run(): void
    {
        $tes = Tes::updateOrCreate(
            ['nama_tes' => 'Tes Asesmen Potensi Karir Siswa SMK (TKJ, DPIB, Kriya Kayu)'],
            [
                'deskripsi' => 'Instrumen asesmen bimbingan karir terpadu mencakup Minat (RIASEC), Bakat (DAT), Kepribadian (DISC), dan Nilai Akademik untuk penentuan arah karir & studi lanjut.',
                'durasi_menit' => 30,
                'status_aktif' => true,
            ]
        );

        // Pastikan hanya tes utama ini yang berstatus aktif di web
        Tes::query()->where('id', '!=', $tes->id)->update(['status_aktif' => false]);

        $kriterias = Kriteria::with('opsis')->get()->keyBy('nama_kriteria');
        $definitions = [
            // ==========================================
            // === 1. KRITERIA MINAT (RIASEC: 24 Soal) ===
            // ==========================================
            
            // --- Realistic (Praktik Alat, Mesin, Lapangan) ---
            ['urutan' => 1, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Merakit dan menginstalasi perangkat keras komputer atau memasang kabel jaringan LAN (TKJ).'],
            ['urutan' => 2, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Mengoperasikan alat ukur tanah (theodolite/waterpass) dan peralatan survei lapangan konstruksi (DPIB).'],
            ['urutan' => 3, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Memotong, merangkai, dan membentuk komponen mebel atau kerajinan kayu di bengkel kerja (Kriya Kayu).'],
            ['urutan' => 4, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Memperbaiki peralatan mekanik/elektronik, mesin perkakas, atau perangkat instalasi fisik secara praktis.'],

            // --- Investigative (Analisis, Troubleshooting, Riset) ---
            ['urutan' => 5, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Mendiagnosis kerusakan sistem jaringan komputer dan melakukan troubleshooting konfigurasi IT (TKJ).'],
            ['urutan' => 6, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Menganalisis perhitungan kekuatan struktur bangunan dan detail pemodelan digital 3D/BIM (DPIB).'],
            ['urutan' => 7, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Menguji daya tahan material kayu, kekuatan sambungan konstruksi, dan setting parameter mesin CNC (Kriya Kayu).'],
            ['urutan' => 8, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Membaca artikel ilmiah, meneliti data teknis, dan memecahkan teka-teki logika yang membutuhkan analisis mendalam.'],

            // --- Artistic (Desain, Estetika, Seni Visual) ---
            ['urutan' => 9, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Mendesain tampilan visual antarmuka pengguna (UI/UX) web atau materi media promosi kreatif (TKJ).'],
            ['urutan' => 10, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Merancang konsep estetika arsitektur, gambar fasad bangunan, dan visualisasi tata ruang interior 3D (DPIB).'],
            ['urutan' => 11, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Membuat sketsa motif ukiran seni, perabot furnitur kayu bernilai estetis, atau produk cinderamata artistik (Kriya Kayu).'],
            ['urutan' => 12, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Mengekspresikan gagasan dan ide kreatif melalui karya seni rupa, desain grafis, ilustrasi, atau fotografi.'],

            // --- Social (Pelayanan, Pendampingan, Edukasi) ---
            ['urutan' => 13, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Membimbing dan mengajari teman sekelas dalam memahami materi pelajaran atau penggunaan perangkat praktik kejuruan.'],
            ['urutan' => 14, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Berpartisipasi aktif dalam kegiatan organisasi sekolah (OSIS/Pramuka) atau membantu guru bimbingan konseling.'],
            ['urutan' => 15, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Menjalin kerja sama tim yang rukun, mendengarkan saran teman, dan membantu menyelesaikan persoalan kelompok.'],
            ['urutan' => 16, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Melakukan bakti sosial, peduli pada sesama, dan memberikan pelayanan bantuan sukarela kepada masyarakat.'],

            // --- Enterprising (Wirausaha, Bisnis, Kepemimpinan) ---
            ['urutan' => 17, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Menawarkan dan menjual jasa instalasi IT, servis komputer, atau pengadaan perangkat teknologi (TKJ).'],
            ['urutan' => 18, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Mempromosikan jasa pembuatan gambar kerja arsitektur, desain rumah, atau estimasi RAB proyek (DPIB).'],
            ['urutan' => 19, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Memasarkan produk mebel custom, kerajinan souvenir kayu, dan menegosiasikan harga jual dengan pelanggan (Kriya Kayu).'],
            ['urutan' => 20, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Memimpin kelompok kerja, berani menangkap peluang bisnis baru, dan memotivasi tim mencapai target penjualan.'],

            // --- Conventional (Arsip, Data Teratur, Prosedural) ---
            ['urutan' => 21, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Mencatat nomor inventaris server, pengkabelan, dan mendokumentasikan log pemeliharaan perangkat IT (TKJ).'],
            ['urutan' => 22, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Mengarsipkan berkas spesifikasi teknis bangunan, dokumen tender, dan tabel Rencana Anggaran Biaya/RAB (DPIB).'],
            ['urutan' => 23, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Mengontrol kartu stok bahan baku kayu, memeriksa catatan mutu QC produk, dan pembukuan pesanan mebel (Kriya Kayu).'],
            ['urutan' => 24, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Menyusun jadwal kegiatan secara tertib, mencatat pembukuan keuangan/kas, dan merapikan dokumen sesuai SOP.'],

            // ==========================================
            // === 2. KRITERIA BAKAT (DAT: 16 Soal) ======
            // ==========================================

            // --- Verbal ---
            ['urutan' => 25, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya mampu memahami maksud dari instruksi kerja tertulis dan artikel teknis yang panjang dengan cepat.'],
            ['urutan' => 26, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya merasa mudah menyusun laporan praktik, proposal kegiatan, atau tugas tertulis dengan bahasa yang terstruktur.'],
            ['urutan' => 27, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya merasa percaya diri saat berbicara di depan umum, mempresentasikan hasil karya, atau berdiskusi.'],
            ['urutan' => 28, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya mudah menangkap arti istilah baru dan mampu menjelaskan konsep yang rumit dengan bahasa yang mudah dipahami.'],

            // --- Numerik/Logika ---
            ['urutan' => 29, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya mampu menyelesaikan perhitungan matematika atau kalkulasi angka secara cepat dan teliti.'],
            ['urutan' => 30, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya dapat dengan mudah membaca, menganalisis, dan menarik kesimpulan dari grafik data atau tabel angka.'],
            ['urutan' => 31, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya terbiasa memecahkan masalah dengan langkah-langkah logika yang berurutan, runut, dan sistematis.'],
            ['urutan' => 32, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya peka terhadap kesalahan hitungan, ketidakkonsistenan data, atau pola hubungan angka dalam pekerjaan.'],

            // --- Spasial/Visual ---
            ['urutan' => 33, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya mampu membayangkan bentuk bangun 3 dimensi di dalam pikiran secara jelas dari berbagai sudut pandang.'],
            ['urutan' => 34, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya pandai menggambar sketsa tata letak ruangan, peta arah/topologi, denah kerja, atau bentuk geometri presisi.'],
            ['urutan' => 35, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya mudah mendeteksi ketidaksejajaran visual, ketimpangan proporsi/warna, atau kesalahan tata letak visual.'],
            ['urutan' => 36, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya mudah membaca dan memahami gambar kerja teknik potongan (cross-section) serta proyeksi isometri.'],

            // --- Motorik/Praktikal ---
            ['urutan' => 37, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya sangat terampil menggunakan tangan untuk memotong, merakit komponen kecil, atau memahat/mengukir secara presisi.'],
            ['urutan' => 38, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya memiliki koordinasi mata-tangan yang baik dan refleks yang sigap saat mengoperasikan alat/mesin praktik.'],
            ['urutan' => 39, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya memiliki ketahanan fisik yang baik untuk bekerja berdiri lama atau beraktivitas praktik di workshop/lapangan.'],
            ['urutan' => 40, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya terbiasa memegang dan menggunakan berbagai alat perkakas bengkel kerja secara aman, cekatan, dan terampil.'],

            // ==========================================
            // === 3. KRITERIA KEPRIBADIAN (DISC: 8 Soal) ===
            // ==========================================

            // --- Dominance ---
            ['urutan' => 41, 'kriteria' => 'Kepribadian', 'opsi' => 'Dominance', 'pertanyaan' => 'Saya berani mengambil keputusan cepat, bersikap tegas dalam memimpin, dan fokus pada target hasil maksimal.'],
            ['urutan' => 42, 'kriteria' => 'Kepribadian', 'opsi' => 'Dominance', 'pertanyaan' => 'Saya termotivasi oleh tantangan sulit, menyukai kompetisi positif, dan siap mengambil risiko demi pencapaian target.'],

            // --- Influence ---
            ['urutan' => 43, 'kriteria' => 'Kepribadian', 'opsi' => 'Influence', 'pertanyaan' => 'Saya senang menghidupkan suasana kelompok, ramah bergaul dengan orang baru, dan bersikap optimis.'],
            ['urutan' => 44, 'kriteria' => 'Kepribadian', 'opsi' => 'Influence', 'pertanyaan' => 'Saya pandai membujuk orang lain secara positif, menularkan semangat antusiasme, dan membangun komunikasi yang cair.'],

            // --- Steadiness ---
            ['urutan' => 45, 'kriteria' => 'Kepribadian', 'opsi' => 'Steadiness', 'pertanyaan' => 'Saya adalah pendengar yang sabar, dapat diandalkan oleh teman, dan menyukai suasana kerja sama yang rukun tanpa konflik.'],
            ['urutan' => 46, 'kriteria' => 'Kepribadian', 'opsi' => 'Steadiness', 'pertanyaan' => 'Saya lebih menyukai ritme kerja yang stabil, teratur, konsisten, dan tidak menyukai perubahan jadwal mendadak.'],

            // --- Compliance ---
            ['urutan' => 47, 'kriteria' => 'Kepribadian', 'opsi' => 'Compliance', 'pertanyaan' => 'Saya selalu mengecek detail tugas berulang kali untuk memastikan tidak ada kesalahan ejaan, angka, atau ukuran cacat.'],
            ['urutan' => 48, 'kriteria' => 'Kepribadian', 'opsi' => 'Compliance', 'pertanyaan' => 'Saya merasa nyaman mengikuti aturan standar operasional prosedur (SOP) secara disiplin, rapi, dan taat azas.'],

            // ==========================================
            // === 4. NILAI AKADEMIK (Numerik: 2 Soal) ===
            // ==========================================
            ['urutan' => 49, 'kriteria' => 'Nilai Akademik', 'opsi' => null, 'pertanyaan' => 'Berapa nilai rata-rata mata pelajaran Produktif Kejuruan (TKJ / DPIB / Kriya Kayu) Anda pada semester terakhir? (0-100)'],
            ['urutan' => 50, 'kriteria' => 'Nilai Akademik', 'opsi' => null, 'pertanyaan' => 'Berapa nilai rata-rata mata pelajaran Umum & Eksakta (Matematika, B. Indonesia, B. Inggris, Fisika/IPA) Anda pada semester terakhir? (0-100)'],
        ];

        // Hapus soal di luar nomor urut 1-50 (jika ada sisa lama)
        $tes->soals()->where('urutan', '>', count($definitions))->delete();

        foreach ($definitions as $definition) {
            $kriteria = $kriterias->get($definition['kriteria']);
            $soal = Soal::updateOrCreate(
                ['tes_id' => $tes->id, 'urutan' => $definition['urutan']],
                [
                    'kriteria_id' => $kriteria->id,
                    'pertanyaan' => $definition['pertanyaan'],
                ]
            );

            if ($kriteria->tipe_data === Kriteria::TYPE_NUMERIK) {
                // Hapus pilihan jika sebelumnya ada (agar bersih)
                $soal->pilihanJawabans()->delete();
                continue;
            }

            $choiceTexts = [];
            if ($definition['kriteria'] === 'Minat') {
                $choiceTexts = [
                    5 => 'Sangat Suka',
                    4 => 'Suka',
                    3 => 'Biasa Saja',
                    2 => 'Kurang Suka',
                    1 => 'Tidak Suka',
                ];
            } elseif ($definition['kriteria'] === 'Bakat') {
                $choiceTexts = [
                    5 => 'Sangat Mampu',
                    4 => 'Mampu',
                    3 => 'Cukup Mampu',
                    2 => 'Kurang Mampu',
                    1 => 'Tidak Mampu',
                ];
            } elseif ($definition['kriteria'] === 'Kepribadian') {
                $choiceTexts = [
                    5 => 'Sangat Setuju',
                    4 => 'Setuju',
                    3 => 'Netral',
                    2 => 'Kurang Setuju',
                    1 => 'Tidak Setuju',
                ];
            }

            $opsi = null;
            if (isset($definition['opsi']) && $definition['opsi']) {
                $opsi = $kriteria->opsis->firstWhere('label', $definition['opsi']);
            }

            foreach ($choiceTexts as $skor => $pilihanText) {
                PilihanJawaban::updateOrCreate(
                    [
                        'soal_id' => $soal->id,
                        'pilihan' => $pilihanText,
                    ],
                    [
                        'skor' => $skor,
                        'kriteria_opsi_id' => $opsi ? $opsi->id : null,
                    ]
                );
            }

            // Bersihkan pilihan jawaban lain yang tidak sesuai skor 1-5
            $soal->pilihanJawabans()->whereNotIn('pilihan', array_values($choiceTexts))->delete();
        }
    }
}

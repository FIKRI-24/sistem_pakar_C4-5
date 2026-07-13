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
            ['nama_tes' => 'Tes Potensi Karir #1'],
            [
                'deskripsi' => 'Kuesioner uji coba manual — Minat, Bakat, Nilai Akademik, Kepribadian',
                'durasi_menit' => 30,
                'status_aktif' => true,
            ]
        );

        $kriterias = Kriteria::with('opsis')->get()->keyBy('nama_kriteria');
        $definitions = [
            // === MINAT (RIASEC) ===
            // Realistic
            ['urutan' => 1, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Merakit komputer, memasang jaringan kabel LAN, atau merawat perangkat keras (TKJ).'],
            ['urutan' => 2, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Menanam tanaman pangan/hidroponik, mengolah tanah, atau merawat hewan ternak (ATPH).'],
            ['urutan' => 3, 'kriteria' => 'Minat', 'opsi' => 'Realistic', 'pertanyaan' => 'Memperbaiki peralatan rumah tangga, menggunakan alat perkakas kayu/besi secara praktis.'],

            // Investigative
            ['urutan' => 4, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Mendiagnosis kerusakan sistem jaringan (troubleshooting) atau memprogram aplikasi komputer (TKJ).'],
            ['urutan' => 5, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Menganalisis jenis penyakit tanaman, meneliti kecocokan pupuk kimia/organik di lahan (ATPH).'],
            ['urutan' => 6, 'kriteria' => 'Minat', 'opsi' => 'Investigative', 'pertanyaan' => 'Membaca artikel ilmiah, memecahkan teka-teki logika matematika, atau menyelidiki akar masalah.'],

            // Artistic
            ['urutan' => 7, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Mendesain tata letak antarmuka (UI) web atau merancang poster promosi digital (TKJ).'],
            ['urutan' => 8, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Merancang materi promosi produk kreatif, mendesain logo usaha, atau membuat konten video pemasaran (AKL/Bisnis).'],
            ['urutan' => 9, 'kriteria' => 'Minat', 'opsi' => 'Artistic', 'pertanyaan' => 'Mengekspresikan ide dengan melukis, menulis puisi/cerita, atau memainkan alat musik.'],

            // Social
            ['urutan' => 10, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Membimbing dan mengajarkan teman tentang penggunaan aplikasi atau instalasi perangkat lunak (TKJ).'],
            ['urutan' => 11, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Aktif menjadi pengurus kelas, OSIS, atau membantu guru bimbingan konseling di sekolah.'],
            ['urutan' => 12, 'kriteria' => 'Minat', 'opsi' => 'Social', 'pertanyaan' => 'Melakukan bakti sosial, merawat orang sakit, atau memberikan saran kepada teman yang curhat.'],

            // Enterprising
            ['urutan' => 13, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Menjual jasa instalasi jaringan/rakit komputer atau memimpin tim proyek IT sekolah (TKJ).'],
            ['urutan' => 14, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Memasarkan produk tanaman hidroponik, menegosiasikan harga jual hasil tani sekolah (ATPH).'],
            ['urutan' => 15, 'kriteria' => 'Minat', 'opsi' => 'Enterprising', 'pertanyaan' => 'Mengkoordinasi acara kelompok, membujuk orang lain untuk membeli produk, atau memimpin organisasi.'],

            // Conventional
            ['urutan' => 16, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Menginventarisir dan mencatat nomor aset server, kabel, atau komputer secara teratur (TKJ).'],
            ['urutan' => 17, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Mencatat uang kas kelas, mengelola pembukuan keuangan, atau mengarsipkan kwitansi belanja (AKL).'],
            ['urutan' => 18, 'kriteria' => 'Minat', 'opsi' => 'Conventional', 'pertanyaan' => 'Menyusun jadwal kegiatan mingguan secara rapi atau merapikan arsip dokumen sesuai abjad.'],

            // === BAKAT (DAT) ===
            // Verbal
            ['urutan' => 19, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya dapat memahami dengan cepat maksud dari artikel bacaan yang panjang dan kompleks.'],
            ['urutan' => 20, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya merasa mudah menulis laporan kegiatan dengan kalimat yang rapi dan mudah dimengerti.'],
            ['urutan' => 21, 'kriteria' => 'Bakat', 'opsi' => 'Verbal', 'pertanyaan' => 'Saya merasa percaya diri saat berpidato, membawakan presentasi tugas, atau berdebat.'],

            // Numerik/Logika
            ['urutan' => 22, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya mampu menyelesaikan soal perhitungan matematika atau angka secara cepat tanpa alat bantu.'],
            ['urutan' => 23, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya dengan mudah dapat menarik kesimpulan dari grafik data, tabel keuangan, atau statistik.'],
            ['urutan' => 24, 'kriteria' => 'Bakat', 'opsi' => 'Numerik/Logika', 'pertanyaan' => 'Saya terbiasa menggunakan logika runut dan sistematis dalam memecahkan masalah.'],

            // Spasial/Visual
            ['urutan' => 25, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya dapat membayangkan bentuk benda tiga dimensi secara jelas di kepala dari berbagai sudut.'],
            ['urutan' => 26, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya pandai menggambar sketsa tata letak ruangan, peta arah, atau desain pola tertentu.'],
            ['urutan' => 27, 'kriteria' => 'Bakat', 'opsi' => 'Spasial/Visual', 'pertanyaan' => 'Saya mudah mendeteksi ketidaksejajaran visual, ketimpangan warna, atau kesalahan tata letak.'],

            // Motorik/Praktikal
            ['urutan' => 28, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya sangat terampil menggunakan tangan untuk memotong, merakit, atau mengupas benda secara presisi.'],
            ['urutan' => 29, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya memiliki kelincahan fisik dan refleks yang baik saat melakukan kegiatan olahraga/praktik fisik.'],
            ['urutan' => 30, 'kriteria' => 'Bakat', 'opsi' => 'Motorik/Praktikal', 'pertanyaan' => 'Saya kuat bekerja berdiri lama atau beraktivitas fisik di lapangan dalam jangka waktu panjang.'],

            // === KEPRIBADIAN (DISC) ===
            // Dominance
            ['urutan' => 31, 'kriteria' => 'Kepribadian', 'opsi' => 'Dominance', 'pertanyaan' => 'Saya berani mengemukakan ide secara frontal di kelompok, suka memimpin, dan fokus pada target cepat.'],
            ['urutan' => 32, 'kriteria' => 'Kepribadian', 'opsi' => 'Dominance', 'pertanyaan' => 'Saya termotivasi oleh tantangan, menyukai kompetisi, dan siap mengambil risiko untuk menang.'],

            // Influence
            ['urutan' => 33, 'kriteria' => 'Kepribadian', 'opsi' => 'Influence', 'pertanyaan' => 'Saya senang menghidupkan suasana obrolan kelompok, bercanda, dan berteman dengan siapa saja.'],
            ['urutan' => 34, 'kriteria' => 'Kepribadian', 'opsi' => 'Influence', 'pertanyaan' => 'Saya pandai membujuk teman untuk menyetujui pendapat saya dan menularkan antusiasme positif.'],

            // Steadiness
            ['urutan' => 35, 'kriteria' => 'Kepribadian', 'opsi' => 'Steadiness', 'pertanyaan' => 'Saya adalah pendengar curhat yang baik, bersikap sabar, dan menyukai kerja sama tim yang rukun.'],
            ['urutan' => 36, 'kriteria' => 'Kepribadian', 'opsi' => 'Steadiness', 'pertanyaan' => 'Saya lebih menyukai ritme belajar yang teratur, damai tanpa konflik, dan tidak suka kejutan mendadak.'],

            // Compliance
            ['urutan' => 37, 'kriteria' => 'Kepribadian', 'opsi' => 'Compliance', 'pertanyaan' => 'Saya selalu mengecek detail tugas berulang kali untuk memastikan tidak ada kesalahan ejaan/angka.'],
            ['urutan' => 38, 'kriteria' => 'Kepribadian', 'opsi' => 'Compliance', 'pertanyaan' => 'Saya merasa nyaman mengikuti aturan sekolah secara ketat dan bertindak sesuai standar operasi kerja.'],

            // === NILAI AKADEMIK (Numerik) ===
            ['urutan' => 39, 'kriteria' => 'Nilai Akademik', 'opsi' => null, 'pertanyaan' => 'Berapa nilai rata-rata mata pelajaran Produktif Kejuruan (TKJ / AKL / ATPH) Anda semester lalu?'],
            ['urutan' => 40, 'kriteria' => 'Nilai Akademik', 'opsi' => null, 'pertanyaan' => 'Berapa nilai rata-rata mata pelajaran Eksakta (Matematika, IPA, Kimia) Anda semester lalu?'],
            ['urutan' => 41, 'kriteria' => 'Nilai Akademik', 'opsi' => null, 'pertanyaan' => 'Berapa nilai rata-rata mata pelajaran Umum (Bahasa Indonesia, Bahasa Inggris, PKN) Anda semester lalu?'],
        ];

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

            // Bersihkan pilihan jawaban lain yang tidak sesuai skor 1-5 (jika ada sisa sampah lama)
            $soal->pilihanJawabans()->whereNotIn('pilihan', array_values($choiceTexts))->delete();
        }
    }
}

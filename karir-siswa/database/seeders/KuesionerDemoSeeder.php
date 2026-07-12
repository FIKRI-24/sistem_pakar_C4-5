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
            ['urutan' => 1, 'kriteria' => 'Minat', 'pertanyaan' => 'Saya lebih tertarik pada kegiatan yang melibatkan...'],
            ['urutan' => 2, 'kriteria' => 'Minat', 'pertanyaan' => 'Jika ada waktu luang, saya paling suka melakukan...'],
            ['urutan' => 3, 'kriteria' => 'Bakat', 'pertanyaan' => 'Saya merasa paling mudah/unggul dalam hal...'],
            ['urutan' => 4, 'kriteria' => 'Bakat', 'pertanyaan' => 'Ketika mengerjakan tugas sekolah, saya paling nyaman dengan...'],
            ['urutan' => 5, 'kriteria' => 'Kepribadian', 'pertanyaan' => 'Dalam kelompok, saya cenderung bersikap...'],
            ['urutan' => 6, 'kriteria' => 'Kepribadian', 'pertanyaan' => 'Saat menghadapi masalah, cara saya bereaksi adalah...'],
            ['urutan' => 7, 'kriteria' => 'Nilai Akademik', 'pertanyaan' => 'Berapa rata-rata nilai akademik Anda semester terakhir?'],
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
                continue;
            }

            foreach ($kriteria->opsis as $opsi) {
                PilihanJawaban::updateOrCreate(
                    ['soal_id' => $soal->id, 'pilihan' => $opsi->label],
                    ['skor' => 5, 'kriteria_opsi_id' => $opsi->id]
                );
            }
        }
    }
}

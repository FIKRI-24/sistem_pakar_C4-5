# Fase 3 - Konsultasi Karir

## Status

Selesai pada 11 Juli 2026.

## Implementasi

- Siswa dapat membuka seluruh tes yang `status_aktif = true` melalui halaman Konsultasi Karir.
- Soal dikelompokkan berdasarkan Minat, Bakat, Nilai Akademik, dan Kepribadian.
- Semua pertanyaan kategorik wajib dijawab sebelum hasil disimpan.
- Nilai Akademik memakai input langsung 0-100, satu nilai untuk setiap kriteria pada satu pengisian tes.
- Hasil disimpan ke `hasil_tes`; nilai final setiap kriteria disimpan ke `hasil_tes_detail`.
- Siswa hanya dapat melihat riwayat dan detail hasil miliknya sendiri.

## Aturan perhitungan

- Untuk Minat, Bakat, dan Kepribadian, Admin memetakan setiap pilihan jawaban ke `kriteria_opsi` yang sesuai.
- Sistem menjumlahkan skor seluruh jawaban yang dipetakan ke setiap opsi kategori.
- Opsi dengan total skor tertinggi menjadi `nilai_kategorik`.
- Jika dua atau lebih kategori memiliki total skor tertinggi yang sama, sistem memilih kategori dari jawaban pada soal dengan `urutan` paling kecil/awal. Jika urutan tersebut juga sama, urutan master opsi menjadi fallback deterministik.
- Batasan yang diketahui: tie-break ini memilih kategori berdasarkan jawaban paling awal, bukan berdasarkan urutan master atau jawaban terakhir.
- Nilai Akademik disimpan langsung sebagai `nilai_numerik`; asumsi yang dipakai adalah siswa memasukkan rata-rata nilai mata pelajaran relevan yang telah diverifikasi bersama Guru BK. Integrasi nilai akademik sekolah dapat ditambahkan kemudian tanpa mengubah struktur hasil.

Format payload atribut untuk integrasi C4.5 dikunci di `docs/API_CONTRACT_C45.md`.

## Batas fase

Hasil konsultasi belum memanggil service C4.5 atau menulis `rekomendasi_karirs`. Integrasi klasifikasi tetap menunggu Fase 4 sesuai instruksi proyek.

## Verifikasi

- Test end-to-end mencakup login siswa, pengisian lengkap, submit, dan penyimpanan empat detail hasil.
- Test validasi memastikan jawaban kategorik dan Nilai Akademik tidak boleh kosong.
- Test data isolation memastikan Siswa A menerima HTTP 404 saat mencoba membuka hasil Siswa B.

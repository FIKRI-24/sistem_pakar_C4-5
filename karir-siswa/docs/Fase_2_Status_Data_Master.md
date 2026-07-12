# Fase 2 - Modul Data Master

## Status

Selesai pada 11 Juli 2026 berdasarkan skema final di `DATABASE_DESIGN.md`.

## Implementasi

- Skema master menggunakan satu tabel `users` dengan `username` unik dan profil `siswas` satu-ke-satu.
- Soft delete aktif pada Siswa, Kriteria, dan Karir untuk menjaga histori audit.
- Seeder final membuat empat kriteria: Minat (RIASEC), Bakat (DAT), Nilai Akademik numerik 0-100, dan Kepribadian (DISC).
- Seeder final membuat 14 opsi kategorik: enam Minat, empat Bakat, dan empat Kepribadian.
- Seeder final membuat delapan alternatif karir yang menjadi kelas target C4.5.
- Admin mengelola seluruh data master: Siswa, Kriteria, Karir, dan Data Training.
- Tes, Soal, dan Pilihan Jawaban dapat dikelola oleh Admin maupun Guru BK sesuai FR-03.
- Semua listing mendukung pencarian, pagination, serta pembatasan role sesuai pembagian akses tersebut.
- Pilihan Jawaban dibatasi ke skor Likert 1-5; opsi kategori wajib sesuai kriteria soal.
- Data Training memakai format EAV melalui `data_trainings` dan `data_training_atributs`, sehingga tetap fleksibel bila jumlah kriteria berubah.
- Import CSV, XLS, dan XLSX tersedia. Header wajib adalah `label_karir,minat,bakat,nilai_akademik,kepribadian`; `sumber` bersifat opsional.
- Import berjalan transaksional: satu baris tidak valid membatalkan seluruh file agar dataset tidak tersimpan sebagian.

## Data demo

`DataTrainingDemoSeeder` membuat 64 baris semi-sintetis—delapan baris untuk setiap label karir—dengan kombinasi atribut yang dirancang berdasarkan logika domain. Sumber data diberi penanda **"Data awal representatif, bukan data riil final"**.

Dataset ini cukup untuk pengembangan dan demonstrasi C4.5, tetapi bukan dasar klaim akurasi skripsi final. Data historis riil dari Guru BK tetap perlu dikumpulkan sebelum sidang akhir.

## Verifikasi

- Migration skema final diterapkan pada MySQL.
- Seeder menghasilkan 4 kriteria, 14 opsi, 8 karir, 64 data training, dan 256 atribut training.
- Test CRUD Tes/Soal/Pilihan Jawaban, CRUD Data Training, import CSV/XLSX, validasi, otorisasi Admin/Guru BK, serta rollback import tersedia.
- Setelah Bagian A, seluruh suite Laravel lulus: 26 test dan 131 assertion.

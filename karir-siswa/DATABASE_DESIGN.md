# DATABASE_DESIGN.md
## Sistem Pakar Penentuan Karir Siswa — Skema Database FINAL (v1.0)

> Status: **FINAL** — skema kriteria telah diputuskan (client menyerahkan keputusan sepenuhnya kepada developer, mengikuti kerangka akademis yang teruji: RIASEC, DAT, DISC). Dokumen ini menggantikan draft sebelumnya dan siap dijadikan dasar migration.
>
> Scope proyek terkini (dikonfirmasi client): **Fase 0 – Fase 4** (bukan hanya 40% untuk seminar proposal).

---

## 0. Keputusan Arsitektur yang Dikunci

- **Auth:** single table `users` dengan kolom `role` (enum: `admin`, `guru_bk`, `siswa`) — bukan multi-guard terpisah. Alasan: satu tabel lebih sederhana untuk relasi FK (mis. `created_by`), lebih cepat dirawat, cukup untuk 3 role dengan hak akses jelas.
- **Password:** selalu di-hash (bcrypt bawaan Laravel), sekalipun proposal asli menyiratkan plain text di struktur tabelnya.
- **Session:** `SESSION_DRIVER=database` (perlu tabel `sessions` — jalankan `php artisan session:table` jika belum ada).
- **Soft delete:** dipakai di tabel data master (siswa, karir, kriteria) agar data histori tidak hilang permanen saat dihapus — penting karena data ini dipakai untuk audit skripsi.

---

## 0.1 Skema Kriteria FINAL (Keputusan Developer, disetujui client)

Karena client menyerahkan keputusan teknis sepenuhnya, skema berikut dipilih berdasarkan kerangka akademis yang sudah teruji dan bisa dikutip di Bab II skripsi — bukan kategori buatan sendiri tanpa dasar teori.

| Kriteria | Tipe | Kategori/Skala | Dasar Teori |
|---|---|---|---|
| Minat | Kategorik | Realistic, Investigative, Artistic, Social, Enterprising, Conventional (RIASEC) | Teori Holland Code — standar de-facto dalam bimbingan karir |
| Bakat | Kategorik | Verbal, Numerik/Logika, Spasial/Visual, Motorik/Praktikal | Mengacu konsep Differential Aptitude Test (DAT) |
| Nilai Akademik | **Numerik** (0-100) | Rata-rata nilai mapel relevan, TIDAK dikategorikan | Sengaja dibiarkan numerik agar C4.5 mendemonstrasikan kemampuan mencari threshold split pada atribut kontinu |
| Kepribadian | Kategorik | Dominance, Influence, Steadiness, Compliance (DISC) | Kerangka kepribadian kerja, dipilih berbeda dari RIASEC agar tidak redundan dengan Minat |

**Skala skor jawaban kuesioner:** Likert 1-5 per pertanyaan, dijumlah/dirata-rata per kriteria untuk menentukan kategori/nilai akhir kriteria tersebut.

**Daftar Alternatif Karir (8 kelas target, mewakili tiap tipe RIASEC):**
1. Teknisi/Operator Teknik (Realistic)
2. Analis/Peneliti (Investigative)
3. Desainer Kreatif (Artistic)
4. Tenaga Kesehatan & Konseling (Social)
5. Wirausaha/Marketing (Enterprising)
6. Administrasi & Akuntansi (Conventional)
7. Pendidik/Guru (Social/Investigative)
8. Agribisnis/Pertanian (Realistic — relevan dengan konteks daerah agraris; sesuaikan bila jurusan riil SMKN 1 Hiliran Gumanti berbeda)

**Data Training:** karena data riil belum terkumpul saat pengembangan dimulai, dataset awal (60-100 baris) dibangun semi-sintetis mengikuti logika domain yang masuk akal (bukan random), didokumentasikan secara eksplisit sebagai "data awal representatif" di README. **Rekomendasi:** sebelum sidang akhir (bukan sidang proposal), dorong pengumpulan data riil dari Guru BK agar angka akurasi di Bab IV kredibel — data sintetis cukup untuk tahap pengembangan & seminar proposal, tapi sebaiknya tidak jadi dasar klaim akurasi final.



### `users`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED, PK, auto | |
| name | VARCHAR(100) | |
| username | VARCHAR(50), UNIQUE | |
| email | VARCHAR(100), UNIQUE, nullable | |
| password | VARCHAR(255) | hashed |
| role | ENUM('admin','guru_bk','siswa') | |
| remember_token | VARCHAR(100), nullable | bawaan Laravel |
| created_at, updated_at | TIMESTAMP | |

### `siswas` (profil tambahan, relasi 1-1 ke `users`)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED, PK | |
| user_id | BIGINT UNSIGNED, FK → users.id | |
| nis | VARCHAR(20), UNIQUE | proposal: VARCHAR(2) — **typo di proposal asli, dikoreksi jadi 20** |
| kelas | VARCHAR(20) | |
| jurusan | VARCHAR(50) | |
| deleted_at | TIMESTAMP, nullable | soft delete |
| created_at, updated_at | TIMESTAMP | |

> Catatan: `guru_bks` dan `admins` di proposal digabung ke `users` + role, tidak perlu tabel terpisah kecuali ada field tambahan spesifik guru BK (mis. NIP) — **[KONFIRMASI CLIENT]** apakah Guru BK butuh field tambahan seperti NIP/no. HP?

---

## 2. Tabel Master Kriteria & Karir

### `kriterias`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED, PK | |
| nama_kriteria | VARCHAR(100) | mis. "Minat", "Bakat", "Nilai Akademik", "Kepribadian" |
| tipe_data | ENUM('kategorik','numerik') | menentukan cara C4.5 memproses atribut ini |
| keterangan | TEXT, nullable | |
| deleted_at | TIMESTAMP, nullable | |

### `kriteria_opsis` (nilai/kategori untuk kriteria bertipe kategorik)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED, PK | |
| kriteria_id | BIGINT UNSIGNED, FK → kriterias.id | |
| label | VARCHAR(100) | |
| urutan | INT, nullable | untuk sorting tampilan |

**Isi seeder final:**
- Kriteria "Minat" → Realistic, Investigative, Artistic, Social, Enterprising, Conventional
- Kriteria "Bakat" → Verbal, Numerik/Logika, Spasial/Visual, Motorik/Praktikal
- Kriteria "Kepribadian" → Dominance, Influence, Steadiness, Compliance
- Kriteria "Nilai Akademik" → tidak punya baris di `kriteria_opsis` (numerik, tanpa kategori)

### `karirs`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED, PK | |
| nama_karir | VARCHAR(100) | label kelas target C4.5 |
| deskripsi | TEXT | |
| bidang_pekerjaan | VARCHAR(100) | |
| informasi_pendukung | TEXT, nullable | |
| deleted_at | TIMESTAMP, nullable | |

> **Seeder final (8 karir):** Teknisi/Operator Teknik, Analis/Peneliti, Desainer Kreatif, Tenaga Kesehatan & Konseling, Wirausaha/Marketing, Administrasi & Akuntansi, Pendidik/Guru, Agribisnis/Pertanian. Lihat rasional pemilihan di bagian 0.1.

---

## 3. Tabel Tes / Kuesioner

### `tes`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED, PK | |
| nama_tes | VARCHAR(100) | |
| deskripsi | TEXT, nullable | |
| durasi_menit | INT, nullable | |
| status_aktif | BOOLEAN, default true | menentukan tes mana yang bisa diakses siswa |
| created_at, updated_at | TIMESTAMP | |

### `soals`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED, PK | |
| tes_id | BIGINT UNSIGNED, FK → tes.id | |
| kriteria_id | BIGINT UNSIGNED, FK → kriterias.id | soal ini mengukur kriteria yang mana |
| pertanyaan | TEXT | |
| urutan | INT, nullable | |

### `pilihan_jawabans`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED, PK | |
| soal_id | BIGINT UNSIGNED, FK → soals.id | |
| pilihan | VARCHAR(150) | |
| skor | DOUBLE | bobot nilai pilihan ini |
| kriteria_opsi_id | BIGINT UNSIGNED, FK → kriteria_opsis.id, nullable | jika pilihan ini merepresentasikan kategori kriteria tertentu |

---

## 4. Tabel Hasil Tes & Rekomendasi

### `hasil_tes`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED, PK | |
| siswa_id | BIGINT UNSIGNED, FK → siswas.id | |
| tes_id | BIGINT UNSIGNED, FK → tes.id | |
| tanggal_tes | DATETIME | |
| catatan | TEXT, nullable | |
| created_at, updated_at | TIMESTAMP | |

### `hasil_tes_detail` (skor per kriteria — dibutuhkan sebagai input C4.5)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED, PK | |
| hasil_tes_id | BIGINT UNSIGNED, FK → hasil_tes.id | |
| kriteria_id | BIGINT UNSIGNED, FK → kriterias.id | |
| nilai_kategorik | VARCHAR(100), nullable | diisi jika kriteria bertipe kategorik |
| nilai_numerik | DOUBLE, nullable | diisi jika kriteria bertipe numerik |

> Tabel ini yang jadi jembatan: hasil kuesioner siswa → diformat jadi payload atribut → dikirim ke service Python `/classify`.

### `rekomendasi_karirs`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED, PK | |
| hasil_tes_id | BIGINT UNSIGNED, FK → hasil_tes.id | |
| karir_id | BIGINT UNSIGNED, FK → karirs.id | |
| persen_kecocokan | DOUBLE | confidence dari service Python |
| alasan | TEXT | rule IF-THEN dalam bahasa yang bisa dibaca siswa |
| created_at | TIMESTAMP | |

---

## 5. Tabel untuk Mesin C4.5 (dipakai bersama Laravel & Python)

### `data_trainings`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED, PK | |
| sumber | VARCHAR(100), nullable | mis. "wawancara 2024", "dokumentasi lama" |
| label_karir_id | BIGINT UNSIGNED, FK → karirs.id | kelas target |
| created_at | TIMESTAMP | |

### `data_training_atributs` (format long/EAV — fleksibel mengikuti jumlah kriteria final)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED, PK | |
| data_training_id | BIGINT UNSIGNED, FK → data_trainings.id | |
| kriteria_id | BIGINT UNSIGNED, FK → kriterias.id | |
| nilai_kategorik | VARCHAR(100), nullable | |
| nilai_numerik | DOUBLE, nullable | |

> Kenapa format long (EAV) bukan wide (satu kolom per kriteria)? Karena jumlah & jenis kriteria masih **[KONFIRMASI CLIENT]** dan berpotensi berubah. Format ini fleksibel tanpa perlu migration ulang kalau kriteria bertambah. Service Python akan melakukan pivot ke bentuk tabel (baris=data, kolom=atribut) saat training — ini standar untuk data mining.

### `decision_trees`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | BIGINT UNSIGNED, PK | |
| versi | INT, auto-increment manual | untuk histori training |
| struktur_json | JSON / LONGTEXT | hasil pohon keputusan dari service Python |
| akurasi | DOUBLE, nullable | hasil uji akurasi (untuk Bab IV skripsi) |
| dibuat_oleh | BIGINT UNSIGNED, FK → users.id | admin yang memicu training |
| status_aktif | BOOLEAN, default true | tree mana yang dipakai untuk klasifikasi saat ini |
| created_at | TIMESTAMP | |

---

## 6. Ringkasan Relasi (ERD Tekstual)

```
users (1) ── (1) siswas
kriterias (1) ── (N) kriteria_opsis
kriterias (1) ── (N) soals
tes (1) ── (N) soals
soals (1) ── (N) pilihan_jawabans
siswas (1) ── (N) hasil_tes
tes (1) ── (N) hasil_tes
hasil_tes (1) ── (N) hasil_tes_detail ── (N:1) kriterias
hasil_tes (1) ── (N) rekomendasi_karirs ── (N:1) karirs
karirs (1) ── (N) data_trainings
data_trainings (1) ── (N) data_training_atributs ── (N:1) kriterias
decision_trees (dibuat oleh) ── (N:1) users
```

---

## 7. Checklist Status (Semua Terkunci)

- [x] Daftar final kriteria + tipe data — RIASEC (Minat), DAT (Bakat), numerik (Nilai Akademik), DISC (Kepribadian)
- [x] Daftar final opsi/kategori per kriteria — lihat bagian 0.1
- [x] Daftar final alternatif karir (8) — lihat bagian 0.1
- [ ] Guru BK butuh field tambahan (NIP, dll)? — belum krusial, boleh ditambah menyusul via migration kecil jika diperlukan
- [x] Skala skor pilihan jawaban — Likert 1-5
- [ ] Data training riil — belum tersedia, memakai dataset awal semi-sintetis (lihat bagian 0.1); pengumpulan data riil disarankan sebelum sidang akhir

**Status:** skema siap dipakai untuk migration. Sisa Fase 2 (Tes, Soal, Pilihan Jawaban, Data Training + seeder) dan Fase 3 (Kuesioner Siswa) dapat langsung dilanjutkan tanpa asumsi tambahan.

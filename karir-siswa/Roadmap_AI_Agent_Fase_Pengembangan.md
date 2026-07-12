# Roadmap Eksekusi untuk AI Agent (Claude Code)

> **Status implementasi per 11 Juli 2026:** Fase 0 dan Fase 1 selesai serta teruji. Fase 2 sedang berjalan; CRUD Siswa, Kriteria, dan Alternatif Karir sudah selesai, sedangkan Data Training, Tes, Soal, dan Pilihan Jawaban menunggu finalisasi skala kriteria. Lihat folder `docs/` untuk laporan verifikasi.
## Sistem Pakar Penentuan Karir Siswa — Laravel + MySQL + Mesin C4.5 (Python)

> **Update:** Client meminta perhitungan algoritma C4.5 dikerjakan di **Python**, bukan PHP. Arsitektur disesuaikan menjadi **hybrid**: Laravel tetap menjadi aplikasi web utama (auth, CRUD, UI, laporan), sementara seluruh proses training decision tree & klasifikasi C4.5 dipisah menjadi **service Python** yang dipanggil oleh Laravel lewat HTTP API internal. Lihat Fase 4 (direvisi) untuk detail.

> Gunakan file ini sebagai instruksi bertahap ke AI coding agent Anda. Kerjakan **satu fase penuh**, minta agent menjalankan tes/verifikasi, baru lanjut ke fase berikutnya. Jangan lompat fase — mesin C4.5 (Fase 4) bergantung pada struktur data Fase 1–2.

### Mengapa hybrid, bukan full-Python atau full-PHP?
- Proposal & struktur database di proposal disusun berbasis Laravel/PHP/MySQL — mengubah seluruh aplikasi ke Python (mis. Django/Flask penuh) berarti menulis ulang semua modul CRUD yang sudah dirancang di proposal, dan berisiko tidak sesuai lagi dengan Bab III yang sudah disetujui dosen pembimbing.
- Memisahkan mesin C4.5 ke service Python kecil (FastAPI/Flask) memenuhi permintaan client tanpa membongkar arsitektur yang sudah direstui, dan memudahkan mahasiswa menjelaskan "modul algoritma" secara terpisah saat sidang.
- **Penting:** gunakan implementasi C4.5 **buatan sendiri** (native Python, bukan `sklearn.tree.DecisionTreeClassifier`) karena scikit-learn hanya mengimplementasikan CART (Gini/entropy tanpa gain ratio, tanpa native categorical split) — bukan C4.5 sesungguhnya. Jika dosen penguji menanyakan detail entropy/gain ratio/split information sesuai judul skripsi, implementasi sklearn CART akan sulit dipertanggungjawabkan sebagai "algoritma C4.5". Konfirmasi pendekatan ini ke client/dosen pembimbing sebelum mulai coding.

---

## Fase 0 — Setup Proyek & Fondasi
**Tujuan:** Dua proyek siap jalan berdampingan — aplikasi web Laravel dan service Python C4.5 — dan bisa saling terhubung.

**A. Proyek Laravel (aplikasi utama)**
- Inisialisasi project Laravel (versi LTS terbaru yang stabil).
- Setup `.env`, koneksi database MySQL (`karir_siswa`), konfigurasi XAMPP lokal.
- Install dependency dasar: Laravel Breeze/UI (starting point auth, disesuaikan role-nya), DomPDF/Snappy (export laporan PDF), Guzzle HTTP client (untuk memanggil service Python).
- Setup folder `app/Services/C45Client/` — bukan berisi algoritma, tapi **klien HTTP** yang memanggil service Python.

**B. Proyek Python (service algoritma C4.5)**
- Buat folder terpisah, mis. `c45-service/`, sebagai proyek Python mandiri (virtualenv sendiri).
- Install FastAPI (direkomendasikan, karena otomatis punya dokumentasi API di `/docs`) + Uvicorn sebagai server, atau Flask bila client/dosen lebih familiar dengannya.
- Install driver database (`mysql-connector-python` atau `PyMySQL` + SQLAlchemy) agar service Python bisa membaca tabel `data_trainings` langsung dari MySQL yang sama dengan Laravel — hindari duplikasi data antar dua bahasa.
- Endpoint awal: `GET /health` untuk cek service hidup.

- Inisialisasi Git repo (boleh 1 repo dengan 2 folder `web/` dan `c45-service/`, atau 2 repo terpisah) + `.gitignore` sesuai masing-masing stack.

**Selesai jika:** `php artisan serve` berjalan dan halaman welcome tampil, koneksi DB berhasil (`php artisan migrate`); service Python berjalan (`uvicorn main:app --reload`) dan `GET /health` mengembalikan status OK; Laravel berhasil memanggil `/health` Python via Guzzle dan menampilkan hasilnya (uji koneksi awal).

---

## Fase 1 — Autentikasi & Manajemen Role
**Tujuan:** 3 role bisa login dengan hak akses terpisah (FR-01).

1. Buat migration + model: `admins`, `guru_bks`, `siswas` (lihat struktur Bagian 7.1 PRD) — gunakan Laravel multi-guard atau single `users` table dengan kolom `role` (pilih salah satu pendekatan, dokumentasikan alasannya).
2. Implementasi login per role dengan middleware pembatas akses (`role:admin`, `role:guru_bk`, `role:siswa`).
3. Hash password dengan bcrypt (jangan simpan plain text meski proposal aslinya tidak menyebut hashing — ini standar keamanan wajib).
4. Buat halaman error login + redirect otomatis ke dashboard sesuai role.
5. (Opsional sesuai kesepakatan) Fitur registrasi mandiri untuk siswa.

**Selesai jika:** Admin/Guru BK/Siswa dummy bisa login dan diarahkan ke dashboard masing-masing; mencoba akses halaman role lain menghasilkan 403.

---

## Fase 2 — Modul Data Master (CRUD)
**Tujuan:** Semua data pendukung bisa dikelola Admin (FR-02).

1. CRUD **Siswa** (nis, nama, kelas, jurusan, akun).
2. CRUD **Kriteria** (nama_kriteria, tipe_data kategorik/numerik, keterangan) — tabel baru, lihat Bagian 7.2 PRD.
3. CRUD **Karir/Alternatif Karir** (nama_karir, deskripsi, bidang_pekerjaan, info_pendukung).
4. CRUD **Data Training** (baris riwayat kasus: atribut sesuai kriteria + label karir), termasuk fitur **import CSV/Excel** agar tidak input manual satu per satu.
5. CRUD **Tes**, **Soal** (terhubung ke kriteria), dan **Pilihan Jawaban** (dengan skor/bobot).
6. Tambahkan pencarian & filter pada semua listing (DataTables atau pagination Laravel bawaan cukup).

**Selesai jika:** Admin dapat menambah minimal 1 set data kriteria, 3–5 alternatif karir, dan ≥ 20 baris data training dummy tanpa error.

**Catatan penting untuk agent:** sebelum menulis kode Fase 2 poin 4, konfirmasi ke user/client struktur kolom `data_trainings` final (berapa kriteria, skala nilainya apa) — jangan asumsikan sendiri karena ini menentukan akurasi model.

---

## Fase 3 — Modul Konsultasi Karir (Siswa)
**Tujuan:** Siswa bisa mengisi kuesioner dan datanya tersimpan (FR-03, FR-04).

1. Halaman "Konsultasi Karir": tampilkan soal-soal dari tes yang aktif, dikelompokkan per kriteria.
2. Validasi seluruh pertanyaan wajib dijawab sebelum submit.
3. Hitung skor per kriteria dari jawaban siswa, simpan ke `hasil_tes`.
4. Pastikan satu siswa hanya bisa melihat/mengelola datanya sendiri (data isolation — cek `id_siswa` di setiap query).

**Selesai jika:** Siswa dummy bisa mengisi kuesioner penuh, dan skor tersimpan benar di database (cek manual via tinker/DB viewer).

---

## Fase 4 — Mesin Algoritma C4.5 (Inti Sistem Pakar) — di Python
**Tujuan:** Implementasi algoritma sesuai spesifikasi Bagian 6 PRD, sebagai **service Python** independen yang diakses Laravel via REST API.

### 4A. Bangun modul algoritma murni Python (`c45-service/c45/`)
1. `entropy.py` — fungsi hitung Entropy(S) dari distribusi kelas.
2. `gain.py` — fungsi hitung Information Gain per atribut; untuk atribut numerik, cari threshold split terbaik (uji beberapa titik potong, ambil yang gain-nya maksimum).
3. `gain_ratio.py` — fungsi Split Information & Gain Ratio (ciri khas C4.5 dibanding ID3, wajib ada agar sesuai judul skripsi).
4. `tree_builder.py` — fungsi rekursif pembentukan tree, berhenti jika: leaf murni, atribut habis, atau jumlah sampel di bawah `min_samples_leaf` (pruning sederhana).
5. `classifier.py` — fungsi menelusuri tree (dict/JSON) untuk mengklasifikasi 1 data baru → label karir + confidence (% proporsi kelas mayoritas di leaf node yang dituju).
6. `rule_extractor.py` — ekstraksi seluruh jalur root→leaf menjadi rule IF-THEN dalam bentuk teks/JSON, untuk ditampilkan sebagai "alasan rekomendasi".
7. **Tulis unit test (pytest)** dengan dataset contoh kecil yang sudah diketahui hasil manualnya (mis. dataset klasik "bermain tenis/cuaca") untuk membuktikan entropy/gain/gain-ratio dihitung benar — ini krusial untuk pertanggungjawaban akademis di sidang (dosen bisa minta bukti perhitungan).
8. Gunakan **library Python murni** (tidak wajib pandas/numpy, tapi boleh dipakai untuk mempermudah manipulasi data) — hindari `sklearn.tree` sebagai pengganti C4.5 (lihat catatan di bagian atas dokumen ini).

### 4B. Bangun REST API di atas modul algoritma (FastAPI)
1. `POST /train` — ambil data dari tabel `data_trainings` (via SQLAlchemy/koneksi MySQL), jalankan `tree_builder`, simpan hasil tree (JSON) ke tabel `decision_tree_json` (tabel yang sama, diakses dua bahasa — Python menulis, Laravel membaca untuk ditampilkan).
2. `POST /classify` — terima payload atribut 1 siswa (JSON), kembalikan `{label_karir, confidence, rule_path}`.
3. `GET /tree/latest` — kembalikan struktur tree JSON terbaru (untuk kebutuhan visualisasi di Laravel).
4. `GET /tree/rules` — kembalikan seluruh rules IF-THEN hasil ekstraksi (untuk lampiran skripsi).
5. Tambahkan validasi payload (Pydantic models) dan penanganan error yang jelas (mis. jika tree belum pernah di-training, `/classify` mengembalikan error informatif).
6. Amankan komunikasi internal: batasi akses service Python hanya dari jaringan lokal/Laravel (mis. cek header API key sederhana antar layanan), karena service ini tidak untuk diakses publik.

### 4C. Hubungkan dari sisi Laravel
1. Buat `App\Services\C45Client` — wrapper Guzzle yang memanggil endpoint `/train`, `/classify`, `/tree/latest`, `/tree/rules`.
2. Endpoint/tombol Admin "Rebuild Decision Tree" di Laravel → memanggil `POST /train` ke service Python → tampilkan status sukses/gagal.
3. Setelah siswa submit kuesioner (Fase 3), Laravel memanggil `POST /classify` → simpan hasil ke tabel `rekomendasi_karirs`.
4. Tangani skenario service Python mati/timeout dengan pesan error yang ramah ke user (jangan sampai submit kuesioner siswa gagal total karena service down — pertimbangkan retry atau antrian/job Laravel).

**Selesai jika:** Unit test pytest lulus dengan dataset contoh yang hasil manualnya sudah diketahui; endpoint `/train` dan `/classify` bisa dites langsung lewat `/docs` (Swagger UI bawaan FastAPI) menghasilkan output masuk akal; dari sisi Laravel, tombol "Rebuild Tree" dan alur klasifikasi otomatis setelah kuesioner berjalan end-to-end memanggil service Python dengan benar.

---

## Fase 5 — Hasil Rekomendasi & Laporan
**Tujuan:** Menyambungkan hasil tes siswa ke mesin C4.5, menampilkan hasil ke UI, dan membuat laporan (FR-05, FR-06).

1. Setelah siswa submit kuesioner (Fase 3), Laravel memanggil `C45Client::classify()` (yang meneruskan ke service Python `POST /classify`) → simpan hasil ke `rekomendasi_karirs` (id_karir, persen_kecocokan, alasan/rule).
2. Halaman "Hasil Rekomendasi Karir" untuk siswa: tampilkan nama karir, %, dan alasan dalam bahasa yang mudah dipahami (bukan JSON mentah).
3. Halaman rekap untuk Guru BK: tabel seluruh siswa + filter kelas/jurusan/tanggal.
4. Fitur export PDF (gunakan DomPDF/Snappy) untuk laporan per siswa dan rekap keseluruhan.
5. Dashboard ringkasan (Admin & Guru BK): total siswa, total tes selesai, distribusi karir (bisa pakai chart sederhana, mis. Chart.js).
6. (Opsional, untuk lampiran skripsi) Halaman visualisasi pohon keputusan berbasis JSON tree yang tersimpan.

**Selesai jika:** Alur end-to-end berjalan: siswa isi kuesioner → hasil rekomendasi otomatis muncul → Guru BK melihat rekap → laporan PDF bisa diunduh.

---

## Fase 6 — Pengujian & Penyempurnaan
**Tujuan:** Sistem siap untuk pengujian akademis (Bagian 9 PRD).

1. Siapkan skenario **Black Box Testing** per fitur (tabel: skenario, input, expected output, hasil) — bisa langsung dipakai di Bab IV skripsi.
2. Jalankan **uji akurasi model**: split data training/testing (mis. 80/20), hitung confusion matrix + akurasi.
3. Perbaiki bug/UX minor berdasarkan hasil testing internal.
4. Siapkan draf kuesioner **Alpha Testing** (untuk dosen/ahli) dan **Beta Testing** (untuk Guru BK & siswa asli) sesuai skala Likert di proposal — ini dijalankan oleh peneliti (client Anda), bukan oleh agent, tapi sistem harus siap dipakai untuk uji tersebut.
5. Tulis dokumentasi instalasi (README) dan user manual singkat.

**Selesai jika:** Seluruh fitur di Bagian 4 PRD lulus Black Box Testing tanpa bug blocking, dan client memiliki angka akurasi model untuk dilaporkan.

---

## Urutan Prioritas Jika Waktu Terbatas (MVP untuk kejar deadline sidang)
1. Fase 0–1 (setup + login) — wajib.
2. Fase 2 (khususnya CRUD siswa, karir, data training) — wajib.
3. Fase 4 (mesin C4.5) — **ini adalah objek penelitian utama skripsi, jangan disederhanakan/di-skip** meski waktu mepet.
4. Fase 3 & 5 (kuesioner + hasil) — wajib untuk demo end-to-end.
5. Fase 6 — minimal Black Box Testing wajib ada untuk Bab IV skripsi; Alpha/Beta testing dijalankan belakangan oleh client.

## Hal yang Harus Dikonfirmasi ke Client Sebelum Mulai Coding
- Skema final kriteria & skala penilaian (lihat catatan Fase 2 poin 4 dan Bagian 6.2 PRD).
- Sumber data training riil (berapa banyak, dari mana — wawancara/dokumentasi lama?).
- Apakah siswa self-register atau akun dibuatkan Admin.
- Target platform hosting (lokal untuk sidang saja, atau perlu online? — perlu diingat: dengan arsitektur hybrid ini, hosting harus bisa menjalankan **dua service** — PHP/Laravel dan Python/FastAPI — sekaligus. Untuk sidang lokal, cukup jalankan keduanya bersamaan di laptop mahasiswa dengan XAMPP untuk Laravel + `uvicorn` untuk Python).
- Apakah dosen pembimbing/penguji sudah setuju dengan pendekatan hybrid PHP+Python ini, atau lebih memilih semuanya dijelaskan dalam satu bahasa saja di laporan skripsi (arsitektur hybrid tetap bisa dijelaskan sebagai "microservice" di Bab III, tapi pastikan ini dikomunikasikan dulu).

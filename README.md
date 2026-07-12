# Sistem Pakar Rekomendasi Karir Siswa (Laravel + C4.5 FastAPI)

Sistem Pakar ini dirancang untuk mendeteksi kecocokan karir masa depan siswa berdasarkan kriteria Minat (RIASEC), Bakat (DAT), Nilai Akademik, dan Kepribadian (DISC) menggunakan algoritme klasifikasi C4.5.

> [!NOTE]
> **Status Proyek**: Baru sampai **Fase 3** (Siap untuk Seminar).
> Fitur yang telah selesai diuji:
> 1. CRUD Master Data (Siswa, Kriteria, Opsi Kriteria, Karir).
> 2. CRUD Data Latih/Training (Import Excel/CSV dan input manual).
> 3. Modul Kuesioner Satu Halaman Dinamis (Admin dapat menentukan jumlah soal secara instan, serta menginput soal & pilihan jawaban sekaligus).
> 4. Pengisian Kuesioner Siswa (Pencegahan retake/pengisian berulang, riwayat pengerjaan, dan rekap detail profil).

---

## 📁 Struktur Repositori

1.  **/karir-siswa** (Aplikasi Web Laravel):
    *   Mengelola antarmuka Admin, Guru BK, dan Siswa.
    *   CRUD Kriteria, Karir, Soal Terintegrasi, dan Hasil Tes.
2.  **/c45-service** (FastAPI Python Service):
    *   Engine C4.5 untuk pemrosesan latih data dan komputasi pohon keputusan (Decision Tree).

---

## 🚀 Cara Menjalankan Aplikasi

### 1. Aplikasi Laravel (karir-siswa)
```bash
cd karir-siswa
composer install
npm install
cp .env.example .env
php artisan key:generate

# Konfigurasi Database di file .env Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
# Jalankan migrasi dan seeder awal
php artisan migrate --seed
php artisan db:seed --class=KriteriaFinalSeeder

# Jalankan server
php artisan serve
```

### 2. Python Service (c45-service)
```bash
cd c45-service
pip install -r requirements.txt
uvicorn main:app --reload --port 8000
```

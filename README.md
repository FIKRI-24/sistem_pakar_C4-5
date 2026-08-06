# Sistem Pakar Rekomendasi Karir Siswa (Laravel + C4.5 FastAPI)

Sistem Pakar ini dirancang untuk mendeteksi kecocokan karir masa depan siswa berdasarkan kriteria Minat (RIASEC), Bakat (DAT), Nilai Akademik, dan Kepribadian (DISC) menggunakan algoritme klasifikasi C4.5.

> [!NOTE]
> **Status Proyek**: **Fase 5 - Rekomendasi & Laporan Selesai** (Tahap Pengujian & Finalisasi Sistem).
> Fitur yang telah selesai diuji:
> 1. CRUD Master Data (Siswa, Kriteria, Opsi Kriteria, Karir).
> 2. CRUD Data Latih/Training (Import Excel/CSV dan input manual).
> 3. Modul Kuesioner Dinamis Siswa & Rekap Profil.
> 4. Mesin C4.5 FastAPI Engine (Entropy, Gain Ratio, Tree Builder, Classifier, Rule Extractor).
> 5. Rekomendasi Karir Otomatis & Export Laporan PDF (Siswa & Guru BK).

---

## 📁 Struktur Repositori

1.  **/karir-siswa** (Aplikasi Web Laravel):
    *   Mengelola antarmuka Admin, Guru BK, dan Siswa.
    *   CRUD Kriteria, Karir, Soal Terintegrasi, dan Hasil Tes.
2.  **/c45-service** (FastAPI Python Service):
    *   Engine C4.5 untuk pemrosesan latih data dan komputasi pohon keputusan (Decision Tree).

---

## 🚀 Cara Menjalankan Aplikasi

### 🔥 Cara Cepat (Jalankan Laravel & Engine Python Sekaligus dalam 1 Perintah)
Cukup masuk ke folder `karir-siswa` dan jalankan:
```bash
cd karir-siswa
npm run dev:all
```
*(Atau menggunakan Composer: `composer run dev:all`)*

---

### 🛠️ Cara Manual (Server Terpisah)

#### 1. Aplikasi Laravel (karir-siswa)
```bash
cd karir-siswa
php artisan serve
```

#### 2. Python Service (c45-service)
```bash
cd c45-service
.\.venv\Scripts\python.exe -m uvicorn app.main:app --reload --port 8001
```

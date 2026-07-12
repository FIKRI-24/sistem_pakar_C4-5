# Sistem Pakar Karir Siswa

Aplikasi skripsi penentuan rekomendasi karir siswa dengan arsitektur hybrid:

- Laravel 12 menangani autentikasi, role, data master, UI, dan laporan.
- FastAPI di folder `../c45-service` menangani algoritma C4.5 melalui REST API internal.
- MySQL menjadi basis data bersama kedua service pada fase algoritma.
- DomPDF sudah tersedia sebagai fondasi export laporan pada fase berikutnya.

## Status pengembangan

- Fase 0: fondasi Laravel dan FastAPI selesai, termasuk health check end-to-end.
- Fase 1: autentikasi dan pembatasan tiga role selesai serta teruji.
- Fase 2: data master final, Tes, Soal, Pilihan Jawaban, Data Training, dan import CSV/Excel selesai.
- Fase 3: konsultasi karir siswa dan penyimpanan hasil per kriteria selesai.
- Fase 4: mesin C4.5 belum dimulai.

Rincian terdapat di `docs/Fase_0_Fondasi_Hybrid.md`, `docs/Fase_1_Auth_Role.md`, `docs/Fase_2_Status_Data_Master.md`, dan `docs/Fase_3_Konsultasi_Karir.md`.

## Persyaratan

- PHP 8.2 atau lebih baru dengan `pdo_mysql`, `pdo_sqlite`, dan `sqlite3`.
- Composer.
- MySQL/MariaDB.
- Node.js dan npm bila aset Vite akan dikembangkan.
- Python 3.11 atau lebih baru.
- Git; repository diinisialisasi pada folder induk yang memuat Laravel dan FastAPI.

## Menjalankan Laravel

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
```

Atur koneksi MySQL di `.env`, contohnya:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_pakar
DB_USERNAME=root
DB_PASSWORD=
```

Kemudian jalankan:

```powershell
php artisan migrate --seed
php artisan serve
```

## Menjalankan service C4.5

Dari folder proyek utama:

```powershell
Set-Location ..\c45-service
python -m venv .venv
.\.venv\Scripts\Activate.ps1
python -m pip install -e ".[dev]"
Copy-Item .env.example .env
python -m app
```

Service tersedia di `http://127.0.0.1:8001`, endpoint health di `/health`, dan dokumentasi OpenAPI di `/docs`.

Laravel menggunakan konfigurasi berikut:

```dotenv
C45_SERVICE_URL=http://127.0.0.1:8001
C45_SERVICE_TIMEOUT=5
C45_SERVICE_CONNECT_TIMEOUT=2
```

Setelah login sebagai Admin, buka `/admin/c45/status` untuk menguji koneksi Laravel ke service Python.

## Akun demo

Semua akun menggunakan password `password`.

| Role | Username |
|---|---|
| Admin | `admin_sistem` |
| Guru BK | `guru_bk` |
| Siswa | `siswa_demo` |

## Pengujian

Laravel:

```powershell
php artisan test
vendor\bin\pint --test
```

FastAPI:

```powershell
Set-Location ..\c45-service
.\.venv\Scripts\python.exe -m pytest
```

## Keputusan data penting

Pendekatan autentikasi menggunakan satu tabel `users` dengan kolom `role`. Detail profil siswa disimpan pada tabel `siswas` yang berelasi satu-ke-satu dengan akun pengguna.

Skema final menggunakan Minat (RIASEC), Bakat (DAT), Nilai Akademik numerik 0-100, dan Kepribadian (DISC). Dataset 64 baris yang disediakan adalah data awal representatif untuk pengembangan, bukan data riil final untuk klaim akurasi skripsi.

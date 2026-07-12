# Fase 1 - Autentikasi dan Role

Implementasi Fase 1 memakai satu tabel `users` dengan kolom `role`.

## Alasan Pendekatan

Pendekatan single-table dipilih karena tiga role memakai mekanisme login yang sama dan perbedaan hak aksesnya masih dapat ditangani dengan middleware. Ini lebih sederhana untuk proyek skripsi, lebih mudah diuji, dan tetap cukup aman selama semua route diproteksi dengan middleware `auth` dan `role`.

## Role

- `admin`
- `guru_bk`
- `siswa`

## Akun Demo

Semua akun memakai password `password`.

| Role | Username | Password |
|---|---|---|
| Admin | `admin_sistem` | `password` |
| Guru BK | `guru_bk` | `password` |
| Siswa | `siswa_demo` | `password` |

## Verifikasi

- Login memakai username dan password, lalu mengarah ke dashboard sesuai role.
- Username kosong atau salah menampilkan pesan validasi yang ramah.
- Akses route role lain akan menghasilkan HTTP 403.
- Password disimpan dalam bentuk hash melalui Laravel.
- Login dibatasi lima percobaan per menit menggunakan middleware throttle.
- Registrasi mandiri tidak diaktifkan; akun siswa dibuat oleh Admin melalui modul Data Siswa.
- Ekstensi `pdo_sqlite` dan `sqlite3` pada PHP CLI sudah aktif.
- Seluruh test suite Laravel berjalan tanpa tes yang dilewati.

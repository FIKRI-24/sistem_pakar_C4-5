# C4.5 Service

Service FastAPI untuk mesin rekomendasi karier aplikasi Karir Siswa. Fondasi ini
hanya menyediakan pemeriksaan kesehatan service; endpoint algoritme C4.5 akan
ditambahkan pada fase pengembangan berikutnya.

## Persyaratan

- Python 3.11 atau lebih baru

## Instalasi

Jalankan perintah berikut dari folder `c45-service`:

```powershell
python -m venv .venv
.\.venv\Scripts\Activate.ps1
python -m pip install --upgrade pip
python -m pip install -e ".[dev]"
Copy-Item .env.example .env
```

Untuk Linux atau macOS, aktifkan virtual environment dengan
`source .venv/bin/activate` dan salin environment menggunakan
`cp .env.example .env`.

## Menjalankan service

```powershell
python -m app
```

Secara default service tersedia di `http://127.0.0.1:8001`. Nilai host, port,
environment, versi, dan log level dapat diubah melalui file `.env` dengan acuan
`.env.example`.

Untuk pengembangan dengan auto-reload:

```powershell
python -m uvicorn app.main:app --host 127.0.0.1 --port 8001 --reload
```

## Kontrak health check

```http
GET /health
```

Respons sukses (`200 OK`):

```json
{
  "status": "ok",
  "service": "c45-service",
  "version": "0.1.0",
  "environment": "development"
}
```

Endpoint ini tidak memerlukan API key. Dokumentasi OpenAPI tersedia di `/docs`
dan schema mentahnya tersedia di `/openapi.json`.

## Pengujian

```powershell
python -m pytest
```

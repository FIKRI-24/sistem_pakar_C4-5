# Kontrak API C4.5

Dokumen ini adalah kontrak resmi pertukaran atribut antara aplikasi Laravel dan
service Python `c45-service`. Kontrak berlaku untuk data training dan data hasil
tes siswa.

## Payload atribut

Payload harus memiliki tepat empat key berikut dalam bentuk lowercase
`snake_case`:

```json
{
  "minat": "Investigative",
  "bakat": "Numerik/Logika",
  "nilai_akademik": 87.5,
  "kepribadian": "Compliance"
}
```

| Key | Tipe | Sumber Laravel |
|---|---|---|
| `minat` | string | Kriteria Minat |
| `bakat` | string | Kriteria Bakat |
| `nilai_akademik` | number/float | Kriteria Nilai Akademik |
| `kepribadian` | string | Kriteria Kepribadian |

## Aturan nilai

- Key harus persis: `minat`, `bakat`, `nilai_akademik`, `kepribadian`.
- Nilai kategorik harus persis sama dengan `kriteria_opsis.label`, termasuk
  kapitalisasi dan tanda baca. Laravel tidak boleh mengubahnya menjadi lowercase
  atau mengganti ejaan.
- `nilai_akademik` selalu dikirim sebagai JSON number/float, bukan string.
- Keempat atribut wajib ada; payload yang tidak lengkap harus ditolak.
- Payload atribut tidak membawa `label_karir`; label tersebut hanya digunakan
  sebagai target saat proses training.

## Transformasi Laravel

`App\Services\C45DataFormatter` adalah satu-satunya helper canonical untuk
mengubah `data_training_atributs` dan `hasil_tes_detail` menjadi payload ini.
Helper tersebut mempertahankan label kategorik apa adanya dan mengubah nilai
numerik menjadi `float`.

## Rencana penggunaan endpoint

Kontrak ini akan digunakan oleh endpoint berikut pada Fase 4:

- `POST /train`: mengirim baris training beserta label karir.
- `POST /classify`: mengirim payload atribut siswa.
- `GET /tree/latest`: mengambil pohon keputusan aktif.
- `GET /tree/rules`: mengambil aturan hasil ekstraksi pohon.

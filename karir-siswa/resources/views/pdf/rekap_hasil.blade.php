<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Hasil Konsultasi Rekomendasi Karir Siswa</title>
    <style>
        @page {
            margin: 20px 25px;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10.5pt;
            line-height: 1.4;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        
        /* Kop Surat Resmi Kemendikbud */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
        }
        .kop-logo {
            width: 65px;
            text-align: center;
            vertical-align: middle;
        }
        .kop-logo img {
            width: 60px;
            height: auto;
        }
        .kop-text {
            text-align: center;
            vertical-align: middle;
            padding-right: 15px;
        }
        .kop-text .instansi-1 {
            font-size: 11pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #0f172a;
        }
        .kop-text .instansi-2 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #0f172a;
        }
        .kop-text .sekolah {
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
            color: #0f766e;
            margin: 2px 0;
        }
        .kop-text .alamat {
            font-size: 8.5pt;
            font-family: Arial, sans-serif;
            color: #475569;
            line-height: 1.2;
        }
        .garis-kop-1 {
            border-top: 2.5px solid #0f172a;
            margin-top: 4px;
        }
        .garis-kop-2 {
            border-top: 1px solid #0f172a;
            margin-top: 2px;
            margin-bottom: 14px;
        }

        /* Title Dokumen */
        .doc-header {
            text-align: center;
            margin-bottom: 14px;
        }
        .doc-title {
            font-size: 12.5pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            color: #0f172a;
            letter-spacing: 0.5px;
        }
        .doc-subtitle {
            font-size: 9pt;
            font-family: Arial, sans-serif;
            color: #475569;
            margin-top: 3px;
            font-weight: bold;
        }

        /* Table */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #cbd5e1;
            margin-top: 8px;
        }
        table.data-table th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-family: Arial, sans-serif;
            font-size: 8.5pt;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #cbd5e1;
            padding: 6px 6px;
            text-align: left;
        }
        table.data-table td {
            border: 1px solid #cbd5e1;
            padding: 5px 6px;
            font-size: 9pt;
            vertical-align: middle;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .badge-career {
            font-weight: bold;
            color: #0f766e;
        }

        /* Signatures */
        .signature-table {
            width: 100%;
            margin-top: 24px;
            page-break-inside: avoid;
        }
        .signature-table td {
            width: 50%;
            vertical-align: top;
            text-align: center;
            font-size: 9.5pt;
        }
        .signature-space {
            height: 50px;
        }
    </style>
</head>
<body>

    @php
        $logoPath = public_path('images/logo-smkn1.jpg');
        $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : null;
    @endphp

    <!-- KOP SURAT RESMI KEMENDIKBUD -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                @if($logoData)
                    <img src="data:image/jpeg;base64,{{ $logoData }}" alt="Logo Sekolah">
                @endif
            </td>
            <td class="kop-text">
                <div class="instansi-1">Pemerintah Provinsi Sumatera Barat</div>
                <div class="instansi-2">Dinas Pendidikan — Cabang Dinas Wilayah V</div>
                <div class="sekolah">SMK NEGERI 1 HILIRAN GUMANTI</div>
                <div class="alamat">Jl. Raya Talang Babungo, Kec. Hiliran Gumanti, Kab. Solok, Sumatera Barat · Kode Pos: 27372</div>
            </td>
        </tr>
    </table>
    <div class="garis-kop-1"></div>
    <div class="garis-kop-2"></div>

    <!-- TITLE DOKUMEN -->
    <div class="doc-header">
        <div class="doc-title">REKAPITULASI HASIL REKOMENDASI KARIR SISWA</div>
        <div class="doc-subtitle">Sistem Pakar Berbasis Algoritma C4.5 · Total Data: {{ count($hasilTes) }} Siswa · Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }} WIB</div>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%; text-align: center;">No</th>
                <th style="width: 10%;">NIS</th>
                <th style="width: 22%;">Nama Siswa</th>
                <th style="width: 13%;">Kelas / Jurusan</th>
                <th style="width: 10%;">Jenis Kelamin</th>
                <th style="width: 14%;">Tanggal Tes</th>
                <th style="width: 19%;">Rekomendasi Karir (C4.5)</th>
                <th style="width: 8%; text-align: center;">Kecocokan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasilTes as $index => $item)
                @php
                    $rekomendasi = $item->rekomendasis->first();
                @endphp
                <tr>
                    <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                    <td>{{ $item->siswa->nis ?? '-' }}</td>
                    <td><strong>{{ $item->siswa->user->name ?? '-' }}</strong></td>
                    <td>{{ $item->siswa->kelas ?? '-' }} / {{ $item->siswa->jurusan ?? '-' }}</td>
                    <td>{{ ($item->siswa->jenis_kelamin ?? '') === 'L' ? 'Laki-laki' : (($item->siswa->jenis_kelamin ?? '') === 'P' ? 'Perempuan' : '-') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal_tes)->translatedFormat('d/m/Y H:i') }}</td>
                    <td>
                        @if($rekomendasi && $rekomendasi->karir)
                            <span class="badge-career">{{ $rekomendasi->karir->nama_karir }}</span>
                        @else
                            <span style="color: #94a3b8;">Belum Ada</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @if($rekomendasi)
                            <strong>{{ number_format($rekomendasi->persen_kecocokan, 1) }}%</strong>
                        @else
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #64748b; padding: 15px;">
                        Belum ada data hasil tes siswa.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Kepala Sekolah SMKN 1 Hiliran Gumanti</strong>
                <div class="signature-space"></div>
                <strong><u>________________________</u></strong><br>
                NIP. ........................................
            </td>
            <td>
                Hiliran Gumanti, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
                <strong>Guru Bimbingan Konseling (BK)</strong>
                <div class="signature-space"></div>
                <strong><u>________________________</u></strong><br>
                NIP. ........................................
            </td>
        </tr>
    </table>

</body>
</html>


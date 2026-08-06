<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Hasil Konsultasi Rekomendasi Karir Siswa</title>
    <style>
        @page {
            margin: 20px 30px;
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
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
            width: 70px;
            text-align: center;
            vertical-align: middle;
        }
        .kop-logo img {
            width: 65px;
            height: auto;
        }
        .kop-text {
            text-align: center;
            vertical-align: middle;
            padding-right: 20px;
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
            font-size: 9pt;
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
            margin-bottom: 16px;
        }

        /* Title Dokumen */
        .doc-header {
            text-align: center;
            margin-bottom: 16px;
        }
        .doc-title {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            text-decoration: underline;
            color: #0f172a;
            letter-spacing: 0.5px;
        }
        .doc-subtitle {
            font-size: 9.5pt;
            font-family: Arial, sans-serif;
            color: #475569;
            margin-top: 3px;
            font-weight: bold;
        }

        /* Section Styling */
        .section-header {
            font-size: 10.5pt;
            font-weight: bold;
            font-family: Arial, sans-serif;
            color: #ffffff;
            background-color: #0f766e;
            padding: 5px 10px;
            margin-top: 14px;
            margin-bottom: 8px;
            border-radius: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        table.info-table td {
            padding: 4px 6px;
            vertical-align: top;
            font-size: 10.5pt;
        }
        table.info-table td.label {
            width: 22%;
            font-weight: bold;
            color: #334155;
        }
        table.info-table td.colon {
            width: 2%;
            font-weight: bold;
        }
        
        table.data-table {
            border: 1px solid #cbd5e1;
            margin-top: 4px;
        }
        table.data-table th {
            background-color: #f1f5f9;
            color: #0f172a;
            font-family: Arial, sans-serif;
            font-size: 9.5pt;
            font-weight: bold;
            text-transform: uppercase;
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
        }
        table.data-table td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            font-size: 10pt;
            vertical-align: middle;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Recommendation Box */
        .rec-box {
            background-color: #f0fdf4;
            border: 1.5px solid #a7f3d0;
            border-radius: 6px;
            padding: 12px 16px;
            margin-top: 6px;
            margin-bottom: 10px;
        }
        .rec-title {
            font-size: 13.5pt;
            font-weight: bold;
            color: #0f766e;
            margin-bottom: 8px;
        }
        .badge-kecocokan {
            float: right;
            background-color: #0d9488;
            color: #ffffff;
            font-family: Arial, sans-serif;
            font-size: 10pt;
            font-weight: bold;
            padding: 4px 12px;
            border-radius: 12px;
        }
        .rule-box {
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            border-left: 3px solid #0f766e;
            padding: 6px 10px;
            font-family: 'Courier New', Courier, monospace;
            font-size: 9pt;
            font-weight: bold;
            color: #0f766e;
            margin: 6px 0;
            border-radius: 4px;
        }
        .catatan-bk {
            font-size: 9.5pt;
            color: #334155;
            line-height: 1.4;
            margin-top: 8px;
            padding-top: 6px;
            border-top: 1px dashed #cbd5e1;
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
            font-size: 10pt;
        }
        .signature-space {
            height: 55px;
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
        <div class="doc-title">LAPORAN HASIL REKOMENDASI KARIR SISWA</div>
        <div class="doc-subtitle">Sistem Pakar Penentuan Karir Berbasis Algoritma C4.5 · No. Dokumen: BK/C45/{{ date('Y') }}/{{ str_pad($hasilTes->id, 5, '0', STR_PAD_LEFT) }}</div>
    </div>

    <!-- I. BIODATA SISWA -->
    <div class="section-header">I. BIODATA SISWA</div>
    <table class="info-table">
        <tr>
            <td class="label">Nama Siswa</td>
            <td class="colon">:</td>
            <td><strong>{{ $hasilTes->siswa->user->name ?? '-' }}</strong></td>
            <td class="label">NIS / NISN</td>
            <td class="colon">:</td>
            <td>{{ $hasilTes->siswa->nis ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Kelas & Jurusan</td>
            <td class="colon">:</td>
            <td>{{ $hasilTes->siswa->kelas ?? '-' }} — {{ $hasilTes->siswa->jurusan ?? '-' }}</td>
            <td class="label">Jenis Kelamin</td>
            <td class="colon">:</td>
            <td>{{ ($hasilTes->siswa->jenis_kelamin ?? '') === 'L' ? 'Laki-laki' : (($hasilTes->siswa->jenis_kelamin ?? '') === 'P' ? 'Perempuan' : '-') }}</td>
        </tr>
        <tr>
            <td class="label">Instrumen Tes</td>
            <td class="colon">:</td>
            <td>{{ $hasilTes->tes->nama_tes ?? 'Kuesioner Minat & Bakat Karir' }}</td>
            <td class="label">Tanggal Pengisian</td>
            <td class="colon">:</td>
            <td>{{ \Carbon\Carbon::parse($hasilTes->tanggal_tes)->translatedFormat('d F Y — H:i') }} WIB</td>
        </tr>
    </table>

    <!-- II. PROFIL KRITERIA -->
    <div class="section-header">II. RINGKASAN PROFIL KRITERIA SISWA</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 6%; text-align: center;">No</th>
                <th style="width: 38%;">Kriteria Penilaian</th>
                <th style="width: 24%;">Tipe Kriteria</th>
                <th style="width: 32%;">Kategori / Nilai Hasil Kuesioner</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasilTes->details as $index => $detail)
                <tr>
                    <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                    <td><strong>{{ $detail->kriteria->nama_kriteria ?? '-' }}</strong></td>
                    <td>{{ ucfirst($detail->kriteria->tipe_data ?? 'Kategorik') }}</td>
                    <td>
                        @if(($detail->kriteria->tipe_data ?? '') === 'numerik')
                            <strong style="color: #0f172a;">{{ number_format($detail->nilai_numerik, 2, ',', '.') }}</strong> (Skala 0 - 100)
                        @else
                            <strong style="color: #0f766e;">{{ $detail->nilai_kategorik ?? '-' }}</strong>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada detail kriteria.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- III. HASIL REKOMENDASI C4.5 -->
    <div class="section-header">III. HASIL REKOMENDASI KARIR (SISTEM PAKAR C4.5)</div>
    @php
        $rekomendasi = $hasilTes->rekomendasis->first();
    @endphp

    @if($rekomendasi)
        <div class="rec-box">
            <div class="rec-title">
                <span class="badge-kecocokan">Tingkat Kecocokan: {{ number_format($rekomendasi->persen_kecocokan, 1, ',', '.') }}%</span>
                Rekomendasi Karir Utama: {{ $rekomendasi->karir->nama_karir ?? 'Belum Terklasifikasi' }}
            </div>
            
            @if($rekomendasi->karir && $rekomendasi->karir->deskripsi)
                <p style="margin: 6px 0 8px; font-size: 11pt; color: #334155;"><strong>Deskripsi Profil Karir:</strong> {{ $rekomendasi->karir->deskripsi }}</p>
            @endif

            <p style="margin-top: 10px; margin-bottom: 4px; font-size: 10.5pt; font-weight: bold; color: #0f172a;">Jalur Keputusan Matched (C4.5 Decision Rule):</p>
            <div class="rule-box" style="font-size: 10.5pt; padding: 8px 12px;">
                {{ $rekomendasi->alasan ?? 'Berdasarkan klasifikasi pohon keputusan C4.5' }}
            </div>

            <div class="catatan-bk" style="font-size: 10.5pt; line-height: 1.5; margin-top: 10px; padding-top: 8px;">
                <strong style="font-size: 10.5pt; color: #0f172a;">Catatan & Rekomendasi Pembinaan Guru Bimbingan Konseling (BK):</strong><br>
                Berdasarkan kombinasi skor kecenderungan minat, bakat, kepribadian, serta nilai akademik di atas, siswa sangat potensial dikembangkan pada karir <strong>{{ $rekomendasi->karir->nama_karir }}</strong>. Disarankan untuk memprioritaskan penempatan magang PKL dan bimbingan sertifikasi keahlian di bidang tersebut.
            </div>
        </div>
    @else
        <div style="background-color: #fef2f2; border: 1px solid #fecaca; padding: 10px; border-radius: 4px; color: #991b1b; text-align: center; font-size: 10pt;">
            Rekomendasi karir belum tersedia atau mesin C4.5 belum dilatih.
        </div>
    @endif

    <!-- IV. RIWAYAT JAWABAN PER BUTIR SOAL -->
    @if($hasilTes->jawabans->isNotEmpty())
        <div class="section-header">IV. DOKUMENTASI RIWAYAT JAWABAN BUTIR KUESIONER</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 6%; text-align: center;">No</th>
                    <th style="width: 44%;">Pertanyaan Kuesioner</th>
                    <th style="width: 25%;">Kriteria & Indikator</th>
                    <th style="width: 25%;">Pilihan / Jawaban Siswa</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hasilTes->jawabans as $index => $jwb)
                    <tr>
                        <td style="text-align: center; font-weight: bold;">#{{ $index + 1 }}</td>
                        <td>{{ $jwb->soal->pertanyaan ?? '-' }}</td>
                        <td>
                            <strong>{{ $jwb->soal->kriteria->nama_kriteria ?? '-' }}</strong>
                            @if($jwb->pilihanJawaban && $jwb->pilihanJawaban->kriteriaOpsi)
                                <br><span style="color: #0f766e; font-size: 8.5pt; font-weight: bold;">({{ $jwb->pilihanJawaban->kriteriaOpsi->label }})</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $jwb->jawaban_teks ?? '-' }}</strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- V. LEMBAR PENGESAHAN -->
    <table class="signature-table">
        <tr>
            <td>
                Mengetahui,<br>
                <strong>Orang Tua / Wali Siswa</strong>
                <div class="signature-space"></div>
                <strong>( ________________________ )</strong>
            </td>
            <td>
                Hiliran Gumanti, {{ \Carbon\Carbon::parse($hasilTes->tanggal_tes)->translatedFormat('d F Y') }}<br>
                <strong>Guru Bimbingan Konseling (BK)</strong>
                <div class="signature-space"></div>
                <strong><u>________________________</u></strong><br>
                NIP. ........................................
            </td>
        </tr>
    </table>

</body>
</html>

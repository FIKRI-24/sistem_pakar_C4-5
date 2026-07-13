@extends('layouts.app', ['title' => 'Detail Hasil Tes Siswa'])

@section('content')
    <section class="panel" style="max-width:850px; margin:auto;">
        <div class="panel-body">
            <div class="toolbar" style="margin-bottom:28px;">
                <div>
                    <p class="role-badge">Detail Hasil Tes</p>
                    <h1>{{ $hasilTes->tes->nama_tes }}</h1>
                    <p class="muted" style="margin-top:6px;">Dikerjakan oleh <strong>{{ $hasilTes->siswa->user->name ?? 'Siswa' }}</strong> pada {{ $hasilTes->tanggal_tes->format('d-m-Y H:i') }}</p>
                </div>
                <div>
                    <a class="button secondary" href="{{ route('admin.tes.hasil-tes') }}">Kembali</a>
                </div>
            </div>

            <!-- Informasi Siswa -->
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:10px; padding:16px 20px; margin-bottom:24px; display:flex; flex-wrap:wrap; gap:24px;">
                <div>
                    <span style="font-size:0.75rem; text-transform:uppercase; font-weight:700; color:#64748b; display:block;">Nama Siswa</span>
                    <strong style="font-size:1.05rem; color:#0f172a;">{{ $hasilTes->siswa->user->name ?? 'Siswa' }}</strong>
                </div>
                <div>
                    <span style="font-size:0.75rem; text-transform:uppercase; font-weight:700; color:#64748b; display:block;">NIS</span>
                    <strong style="font-size:1.05rem; color:#0f172a;">{{ $hasilTes->siswa->nis ?? '-' }}</strong>
                </div>
                <div>
                    <span style="font-size:0.75rem; text-transform:uppercase; font-weight:700; color:#64748b; display:block;">Kelas & Jurusan</span>
                    <strong style="font-size:1.05rem; color:#0f172a;">{{ $hasilTes->siswa->kelas ?? '-' }} - {{ $hasilTes->siswa->jurusan ?? '-' }}</strong>
                </div>
            </div>

            <!-- Ringkasan Nilai Kriteria -->
            <h2 style="font-size:1.2rem; font-weight:750; color:#1e293b; margin: 0 0 14px;">Ringkasan Nilai Kuesioner</h2>
            <div class="table-wrap" style="margin-bottom:28px;">
                <table>
                    <thead>
                        <tr>
                            <th>Kriteria Penilaian</th>
                            <th>Nilai Akhir (Kategorik / Rata-rata)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hasilTes->details as $detail)
                            <tr>
                                <td><strong>{{ $detail->kriteria->nama_kriteria }}</strong></td>
                                <td>
                                    @if($detail->nilai_kategorik)
                                        <span style="background:#e2f0fd; color:#0369a1; padding:4px 10px; border-radius:12px; font-weight:700; font-size:0.875rem;">{{ $detail->nilai_kategorik }}</span>
                                    @else
                                        <strong style="color:#0f172a;">{{ number_format($detail->nilai_numerik, 2, ',', '.') }}</strong>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Rekomendasi Karir (C4.5) -->
            <h2 style="font-size:1.2rem; font-weight:750; color:#1e293b; margin: 0 0 14px;">Hasil Klasifikasi & Rekomendasi Karir</h2>
            @if($hasilTes->rekomendasis->isNotEmpty())
                <div style="display:flex; flex-direction:column; gap:16px;">
                    @foreach($hasilTes->rekomendasis as $rekomendasi)
                        <div style="border:1px solid #cbd5e1; border-radius:12px; padding:20px; background:#f0fdfa; border-left:4px solid #0d9488;">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:12px; margin-bottom:10px;">
                                <strong style="font-size:1.2rem; color:#0f766e;">{{ $rekomendasi->karir->nama_karir }}</strong>
                                <span style="background:#0d9488; color:#ffffff; padding:4px 10px; border-radius:12px; font-weight:800; font-size:0.85rem;">Persen Kecocokan: {{ number_format($rekomendasi->persen_kecocokan, 2, ',', '.') }}%</span>
                            </div>
                            <p style="margin:0; line-height:1.6; color:#334155; font-size:0.95rem;">{{ $rekomendasi->alasan }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="border:1px solid #cbd5e1; border-radius:12px; padding:20px; background:#f8fafc; text-align:center;">
                    <p class="muted" style="margin:0;">Klasifikasi pohon keputusan C4.5 belum dijalankan untuk tes ini.</p>
                </div>
            @endif
        </div>
    </section>
@endsection

@extends('layouts.app', ['title' => 'Detail Hasil Tes Siswa'])

@section('content')
    <style>
        .btn-3d {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 0.875rem;
            text-decoration: none;
            cursor: pointer;
            border: none;
            outline: none;
            transition: all 0.15s ease-in-out;
            user-select: none;
            line-height: 1.2;
        }
        .btn-3d:active {
            transform: translateY(3px) !important;
        }

        .btn-3d-blue {
            background: linear-gradient(180deg, #38bdf8 0%, #0284c7 100%);
            color: #ffffff !important;
            box-shadow: 0 4px 0 #0369a1, 0 6px 14px rgba(2, 132, 199, 0.35);
            border-top: 1px solid rgba(255, 255, 255, 0.35);
        }
        .btn-3d-blue:hover {
            background: linear-gradient(180deg, #7dd3fc 0%, #0369a1 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 0 #0369a1, 0 10px 18px rgba(2, 132, 199, 0.45);
        }

        .btn-3d-secondary {
            background: linear-gradient(180deg, #ffffff 0%, #e2e8f0 100%);
            color: #475569 !important;
            box-shadow: 0 3.5px 0 #cbd5e1, 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #cbd5e1;
        }
        .btn-3d-secondary:hover {
            background: linear-gradient(180deg, #ffffff 0%, #cbd5e1 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #94a3b8;
            color: #0f172a !important;
        }
    </style>

    <div style="max-width: 860px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px;">
        <!-- Back button -->
        <div>
            <a href="{{ route('admin.tes.rekomendasi-karir') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #64748b; font-size: 0.875rem; font-weight: 700; text-decoration: none; transition: color 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali ke Rekomendasi Karir
            </a>
        </div>

        <!-- Main Card Container -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden;">
            <!-- Header Section -->
            <div style="padding: 28px 32px; border-bottom: 1px solid #f1f5f9; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: #f0fdf4; border: 1px solid #ccfbf1; color: #0f766e; font-size: 0.75rem; font-weight: 800; padding: 2px 10px; border-radius: 20px; text-transform: uppercase; margin-bottom: 8px;">
                        Detail Rekomendasi Siswa
                    </div>
                    <h1 style="margin: 0 0 4px; font-size: 1.5rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
                        {{ $hasilTes->tes->nama_tes }}
                    </h1>
                    <p style="margin: 0; font-size: 0.9rem; color: #64748b; font-weight: 600;">
                        Dikerjakan oleh <strong style="color: #0f172a;">{{ $hasilTes->siswa->user->name ?? 'Siswa' }}</strong> pada {{ $hasilTes->tanggal_tes->format('d-m-Y H:i') }}
                    </p>
                </div>

                <div style="display: flex; gap: 10px;">
                    <!-- 3D PDF Download Button -->
                    <a href="{{ route('admin.tes.hasil-tes.pdf', $hasilTes) }}" target="_blank" class="btn-3d btn-3d-blue">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        <span>Unduh PDF Laporan</span>
                    </a>
                </div>
            </div>

            <div style="padding: 32px; display: flex; flex-direction: column; gap: 28px;">
                <!-- Profile Siswa Card -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px 24px; box-shadow: 0 2px 10px rgba(0,0,0,0.02); display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                    <div>
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: #64748b; display: block; margin-bottom: 4px;">Nama Siswa</span>
                        <strong style="font-size: 1.05rem; color: #0f172a; font-weight: 800;">{{ $hasilTes->siswa->user->name ?? 'Siswa' }}</strong>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: #64748b; display: block; margin-bottom: 4px;">NIS</span>
                        <span style="font-family: monospace; font-size: 0.95rem; font-weight: 800; color: #0f172a; background: #f1f5f9; padding: 3px 8px; border-radius: 6px; border: 1px solid #e2e8f0; display: inline-block;">
                            {{ $hasilTes->siswa->nis ?? '-' }}
                        </span>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; text-transform: uppercase; font-weight: 800; color: #64748b; display: block; margin-bottom: 4px;">Kelas & Jurusan</span>
                        <strong style="font-size: 1.05rem; color: #0f766e; font-weight: 800;">{{ $hasilTes->siswa->kelas ?? '-' }} - {{ $hasilTes->siswa->jurusan ?? '-' }}</strong>
                    </div>
                </div>

                <!-- Ringkasan Nilai Kriteria -->
                <div>
                    <h2 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0 0 14px; display: flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0f766e" stroke-width="2.5"><rect x="3" y="5" width="6" height="6" rx="1"/><path d="M13 6h8"/><path d="M13 12h8"/><rect x="3" y="11" width="6" height="6" rx="1"/></svg>
                        <span>Ringkasan Nilai Kuesioner</span>
                    </h2>
                    <div style="border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden;">
                        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                            <thead>
                                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                    <th style="padding: 12px 20px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 50%;">Kriteria Penilaian</th>
                                    <th style="padding: 12px 20px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 50%;">Nilai Akhir (Kategorik / Numerik)</th>
                                </tr>
                            </thead>
                            <tbody style="background: #ffffff;">
                                @foreach($hasilTes->details as $detail)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="padding: 14px 20px; vertical-align: middle;">
                                            <strong style="color: #0f172a; font-weight: 800;">{{ $detail->kriteria->nama_kriteria }}</strong>
                                        </td>
                                        <td style="padding: 14px 20px; vertical-align: middle;">
                                            @if($detail->nilai_kategorik)
                                                <span style="background: #e0f2fe; border: 1px solid #bae6fd; color: #0369a1; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 0.825rem; display: inline-block;">
                                                    {{ $detail->nilai_kategorik }}
                                                </span>
                                            @else
                                                <strong style="color: #0f172a; font-size: 0.95rem;">{{ number_format($detail->nilai_numerik, 2, ',', '.') }}</strong>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Hasil Klasifikasi & Rekomendasi Karir (C4.5) -->
                <div>
                    <h2 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0 0 14px; display: flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0f766e" stroke-width="2.5"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                        <span>Hasil Klasifikasi & Rekomendasi Karir C4.5</span>
                    </h2>
                    @if($hasilTes->rekomendasis->isNotEmpty())
                        <div style="display: flex; flex-direction: column; gap: 16px;">
                            @foreach($hasilTes->rekomendasis as $rekomendasi)
                                <div style="border: none; border-radius: 16px; padding: 24px 28px; background: #edf7f5; box-shadow: 0 4px 16px rgba(13, 148, 136, 0.08);">
                                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 14px;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div style="width: 38px; height: 38px; border-radius: 10px; background: #0d9488; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; box-shadow: 0 3px 8px rgba(13, 148, 136, 0.25);">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                            </div>
                                            <div>
                                                <strong style="font-size: 1.3rem; font-weight: 800; color: #0f766e; display: block;">{{ $rekomendasi->karir->nama_karir }}</strong>
                                                <span style="font-size: 0.85rem; color: #475569; font-weight: 600;">{{ $rekomendasi->karir->deskripsi ?: 'Bidang keahlian yang direkomendasikan.' }}</span>
                                            </div>
                                        </div>
                                        <span style="background: #0d9488; color: #ffffff; padding: 6px 18px; border-radius: 20px; font-weight: 800; font-size: 0.9rem; box-shadow: 0 3px 10px rgba(13, 148, 136, 0.3);">
                                            Tingkat Kecocokan: {{ number_format($rekomendasi->persen_kecocokan, 2, ',', '.') }}%
                                        </span>
                                    </div>

                                    <!-- Aturan Keputusan C4.5 Matched Rule Card -->
                                    <div style="background: #ffffff; border: 1px solid #ccfbf1; border-radius: 12px; padding: 18px 20px; margin-top: 14px;">
                                        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                            <span style="background: #0f766e; color: #ffffff; font-size: 0.725rem; font-weight: 800; padding: 2px 8px; border-radius: 6px; text-transform: uppercase;">Aturan Keputusan Matched C4.5</span>
                                        </div>
                                        <div style="font-family: monospace; font-size: 0.9rem; font-weight: 700; color: #0f766e; background: #f0fdf4; padding: 10px 14px; border-radius: 8px; border: 1px solid #a7f3d0; margin-bottom: 12px; word-break: break-word;">
                                            {{ $rekomendasi->alasan }}
                                        </div>

                                        <!-- Analisis Pembinaan untuk Guru BK -->
                                        <div style="border-top: 1px dashed #cbd5e1; padding-top: 12px; font-size: 0.875rem; color: #334155; line-height: 1.6;">
                                            <strong style="color: #0f172a; font-weight: 800; display: block; margin-bottom: 4px;">💡 Analisis & Catatan Rekomendasi untuk Guru BK:</strong>
                                            <p style="margin: 0;">
                                                Berdasarkan hasil traverse Pohon Keputusan C4.5 dari data training historis alumni, kombinasi variabel kecenderungan siswa 
                                                terbukti paling optimal mendukung kesuksesan siswa pada karir <strong>{{ $rekomendasi->karir->nama_karir }}</strong>. Guru BK disarankan untuk mengarahkan siswa mengikuti program magang PKL atau pelatihan sertifikasi pendukung di bidang ini.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="border: none; border-radius: 14px; padding: 24px; background: #f8fafc; text-align: center; color: #64748b;">
                            <p style="margin: 0; font-weight: 700; font-size: 0.95rem;">Klasifikasi pohon keputusan C4.5 belum dijalankan untuk tes ini.</p>
                        </div>
                    @endif
                </div>

                <!-- Riwayat Jawaban Butir Kuesioner Siswa -->
                @if($hasilTes->jawabans->isNotEmpty())
                    <div>
                        <h2 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0 0 14px; display: flex; align-items: center; gap: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0f766e" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                            <span>Riwayat Jawaban Kuesioner Siswa (Per Butir Soal)</span>
                        </h2>
                        <div style="border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; background: #ffffff;">
                            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem;">
                                <thead>
                                    <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                        <th style="padding: 12px 16px; font-weight: 800; color: #475569; font-size: 0.75rem; text-transform: uppercase; width: 8%;">No</th>
                                        <th style="padding: 12px 16px; font-weight: 800; color: #475569; font-size: 0.75rem; text-transform: uppercase; width: 45%;">Pertanyaan Kuesioner</th>
                                        <th style="padding: 12px 16px; font-weight: 800; color: #475569; font-size: 0.75rem; text-transform: uppercase; width: 25%;">Kriteria & Opsi Terpilih</th>
                                        <th style="padding: 12px 16px; font-weight: 800; color: #475569; font-size: 0.75rem; text-transform: uppercase; width: 22%;">Pilihan / Nilai Siswa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($hasilTes->jawabans as $index => $jwb)
                                        <tr style="border-bottom: 1px solid #f1f5f9;">
                                            <td style="padding: 12px 16px; font-weight: 800; color: #0f766e; text-align: center;">
                                                #{{ $index + 1 }}
                                            </td>
                                            <td style="padding: 12px 16px; color: #0f172a; font-weight: 600; line-height: 1.5;">
                                                {{ $jwb->soal->pertanyaan ?? '-' }}
                                            </td>
                                            <td style="padding: 12px 16px;">
                                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                                    <span style="font-weight: 800; color: #334155; font-size: 0.8rem;">
                                                        {{ $jwb->soal->kriteria->nama_kriteria ?? '-' }}
                                                    </span>
                                                    @if($jwb->pilihanJawaban && $jwb->pilihanJawaban->kriteriaOpsi)
                                                        <span style="background: #f0fdf4; border: 1px solid #ccfbf1; color: #0f766e; font-size: 0.75rem; font-weight: 800; padding: 2px 8px; border-radius: 12px; display: inline-block;">
                                                            {{ $jwb->pilihanJawaban->kriteriaOpsi->label }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td style="padding: 12px 16px;">
                                                <strong style="color: #0f172a; font-weight: 700;">{{ $jwb->jawaban_teks ?? '-' }}</strong>
                                                @if($jwb->skor !== null && $jwb->pilihanJawaban)
                                                    <span style="font-size: 0.75rem; color: #64748b; font-weight: 600; display: block;">(Skor: {{ $jwb->skor }})</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        </div>
    </div>
@endsection

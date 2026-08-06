@extends('layouts.app', ['title' => 'Konsultasi Karir'])

@section('content')
    <style>
        .btn-3d {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 0.9rem;
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

        .btn-3d-emerald {
            background: linear-gradient(180deg, #34d399 0%, #059669 100%);
            color: #ffffff !important;
            box-shadow: 0 4px 0 #047857, 0 6px 14px rgba(5, 150, 105, 0.35);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
        }
        .btn-3d-emerald:hover {
            background: linear-gradient(180deg, #6ee7b7 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 0 #047857, 0 10px 18px rgba(5, 150, 105, 0.45);
        }

        .btn-3d-secondary {
            background: linear-gradient(180deg, #ffffff 0%, #e2e8f0 100%);
            color: #475569 !important;
            box-shadow: 0 3.5px 0 #cbd5e1, 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #cbd5e1;
            padding: 10px 20px;
        }
        .btn-3d-secondary:hover {
            background: linear-gradient(180deg, #ffffff 0%, #cbd5e1 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #94a3b8;
            color: #0f172a !important;
        }

        .radio-card {
            display: flex;
            align-items: center;
            cursor: pointer;
            color: #334155;
            font-size: 0.925rem;
            font-weight: 600;
            margin: 0;
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: #ffffff;
            transition: all 0.2s ease;
            user-select: none;
        }
        .radio-card:hover {
            border-color: #0d9488;
            background: #f0fdf4;
        }
        .radio-card input[type="radio"]:checked + span {
            color: #0f766e;
            font-weight: 800;
        }
        .radio-card input[type="radio"] {
            accent-color: #0d9488;
            width: 18px;
            height: 18px;
            margin-right: 12px;
            cursor: pointer;
        }

        .form-numeric-input {
            width: 100%;
            min-height: 44px;
            padding: 10px 14px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 800;
            color: #0f172a;
            background: #ffffff;
            outline: none;
            box-sizing: border-box;
            transition: all 0.2s;
        }
        .form-numeric-input:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
        }
    </style>

    <div style="max-width: 860px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px;">
        <!-- Back button & Breadcrumb -->
        <div>
            <a href="{{ route('siswa.konsultasi.index') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #64748b; font-size: 0.875rem; font-weight: 700; text-decoration: none; transition: color 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali ke Daftar Kuesioner
            </a>
        </div>

        <!-- Main Card Container -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden;">
            <!-- Header Banner -->
            <div style="padding: 28px 32px; border-bottom: 1px solid #f1f5f9; background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%); color: #ffffff;">
                <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255, 255, 255, 0.18); backdrop-filter: blur(4px); color: #ccfbf1; font-size: 0.75rem; font-weight: 800; padding: 3px 12px; border-radius: 20px; text-transform: uppercase; margin-bottom: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    Lembar Kuesioner Siswa
                </div>
                <h1 style="margin: 0 0 6px; font-size: 1.65rem; font-weight: 800; color: #ffffff; letter-spacing: -0.02em;">
                    {{ $tes->nama_tes }}
                </h1>
                <p style="margin: 0; font-size: 0.95rem; color: #ccfbf1; opacity: 0.95;">
                    {{ $tes->deskripsi ?: 'Silakan jawab kuesioner ini sesuai petunjuk pengerjaan.' }}
                    @if($tes->durasi_menit)
                        · <strong style="color: #ffffff;">Estimasi: {{ $tes->durasi_menit }} Menit</strong>
                    @endif
                </p>
            </div>

            <div style="padding: 32px; display: flex; flex-direction: column; gap: 28px;">
                <!-- Instructions Card -->
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px 26px; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                    <div style="display: flex; align-items: flex-start; gap: 14px; margin-bottom: 14px;">
                        <div style="background-color: #e0f2fe; color: #0369a1; width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-weight: 800;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        </div>
                        <div>
                            <h3 style="margin: 0 0 4px; font-size: 1.05rem; font-weight: 800; color: #0f172a;">Petunjuk Pengerjaan & Tujuan Kuesioner</h3>
                            <p style="margin: 0; font-size: 0.875rem; color: #475569; line-height: 1.5;">
                                Kuesioner ini bertujuan untuk mengukur minat, bakat, kepribadian, serta nilai akademik Anda. Hasil kuesioner akan dianalisis menggunakan metode sistem pakar pohon keputusan C4.5.
                            </p>
                        </div>
                    </div>
                    <div style="border-top: 1px solid #e2e8f0; padding-top: 14px; margin-top: 14px;">
                        <h4 style="margin: 0 0 8px; font-size: 0.8rem; font-weight: 800; color: #0f766e; text-transform: uppercase; letter-spacing: 0.05em;">Panduan Pengisian:</h4>
                        <ul style="margin: 0; padding-left: 20px; font-size: 0.85rem; color: #475569; line-height: 1.6; display: flex; flex-direction: column; gap: 6px;">
                            <li><strong>Jawab Jujur:</strong> Pilih opsi jawaban yang paling sesuai dengan kondisi diri Anda. Tidak ada jawaban salah.</li>
                            <li><strong>Nilai Akademik:</strong> Masukkan nilai rata-rata mata pelajaran relevan (misal: <code style="background: #e2e8f0; padding: 2px 6px; border-radius: 4px; font-weight: 700; color: #0f172a;">85.50</code>). Gunakan titik (.) jika desimal.</li>
                            <li><strong>Sekali Pengisian:</strong> Kuesioner hanya dapat dikirimkan <strong>satu kali</strong> per sesi tes aktif.</li>
                        </ul>
                    </div>
                </div>

                <!-- Form Section -->
                <form method="POST" action="{{ route('siswa.konsultasi.store', $tes) }}" style="display: flex; flex-direction: column; gap: 28px;">
                    @csrf
                    
                    @foreach($tes->soals->groupBy('kriteria_id') as $soals)
                        @php($kriteria = $soals->first()->kriteria)
                        
                        <div style="border: 1px solid #e2e8f0; border-radius: 14px; padding: 24px; background: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.02);">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 2px solid #f1f5f9;">
                                <div style="width: 32px; height: 32px; border-radius: 8px; background: #f0fdf4; border: 1px solid #ccfbf1; color: #0f766e; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.85rem;">
                                    {{ $loop->iteration }}
                                </div>
                                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #0f766e;">
                                    Kriteria: {{ $kriteria->nama_kriteria }}
                                </h3>
                            </div>
                            
                            @if($kriteria->tipe_data === \App\Models\Kriteria::TYPE_NUMERIK)
                                @foreach($soals as $soal)
                                    <p style="margin: 0 0 12px; font-weight: 700; color: #1e293b; font-size: 0.95rem; line-height: 1.5;">{{ $soal->pertanyaan }}</p>
                                @endforeach
                                
                                <div style="max-width: 320px; margin-top: 14px;">
                                    <label for="nilai_{{ $kriteria->id }}" style="display: block; font-weight: 700; color: #475569; font-size: 0.875rem; margin-bottom: 6px;">
                                        Input Nilai (Skala 0 - 100) <span style="color:#ef4444;">*</span>
                                    </label>
                                    <input id="nilai_{{ $kriteria->id }}" name="nilai_numerik[{{ $kriteria->id }}]" class="form-numeric-input" type="number" min="0" max="100" step="0.01" value="{{ old("nilai_numerik.{$kriteria->id}") }}" required placeholder="Contoh: 85.50">
                                    @error("nilai_numerik.{$kriteria->id}")
                                        <div style="color:#ef4444; font-size:0.8rem; font-weight:600; margin-top:4px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            @else
                                @foreach($soals as $soal)
                                    <div style="margin-bottom: 20px; padding-bottom: 18px; {{ !$loop->last ? 'border-bottom: 1px dashed #e2e8f0;' : '' }}">
                                        <p style="font-weight: 700; margin: 0 0 14px; color: #1e293b; font-size: 0.95rem; line-height: 1.5;">
                                            {{ $soal->pertanyaan }}
                                        </p>
                                        
                                        <div style="display: flex; flex-direction: column; gap: 10px;">
                                            @forelse($soal->pilihanJawabans as $pilihan)
                                                <label class="radio-card">
                                                    <input type="radio" name="jawabans[{{ $soal->id }}]" value="{{ $pilihan->id }}" @checked((string) old("jawabans.{$soal->id}") === (string) $pilihan->id) required>
                                                    <span>{{ $pilihan->pilihan }}</span>
                                                </label>
                                            @empty
                                                <div style="color:#ef4444; font-size:0.85rem; font-weight:600; padding:10px; background:#fef2f2; border-radius:8px;">Pilihan jawaban belum tersedia untuk soal ini.</div>
                                            @endforelse
                                        </div>
                                        @error("jawabans.{$soal->id}")
                                            <div style="color:#ef4444; font-size:0.8rem; font-weight:600; margin-top:6px;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                    
                    <!-- 3D Action Submit Buttons -->
                    <div style="display: flex; gap: 12px; margin-top: 8px; padding-top: 24px; border-top: 1px solid #f1f5f9;">
                        <button class="btn-3d btn-3d-emerald" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            <span>Kirim Jawaban Kuesioner</span>
                        </button>
                        <a class="btn-3d btn-3d-secondary" href="{{ route('siswa.konsultasi.index') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

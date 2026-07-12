@extends('layouts.app', ['title' => 'Konsultasi Karir'])

@section('content')
    <div class="toolbar">
        <div>
            <p class="role-badge">Konsultasi Karir</p>
            <h1>Mengisi Kuesioner</h1>
            <p class="muted">Jawab seluruh pertanyaan dengan jujur untuk hasil analisis yang akurat.</p>
        </div>
        <a class="button secondary" href="{{ route('siswa.konsultasi.index') }}">Kembali ke Daftar</a>
    </div>

    <section class="panel">
        <div class="panel-body" style="padding:28px 32px;">
            <h2 style="margin-top:0; font-size:1.4rem; font-weight:750; color:#0f766e; border-bottom:1px solid #e2e8f0; padding-bottom:12px; margin-bottom:20px;">
                {{ $tes->nama_tes }}
            </h2>
            <p class="muted" style="margin-bottom:24px; font-size:0.95rem;">
                {{ $tes->deskripsi ?: 'Silakan jawab kuesioner ini sesuai instruksi.' }}
                @if($tes->durasi_menit)
                    · <strong style="color:#0f766e;">Estimasi waktu: {{ $tes->durasi_menit }} menit</strong>
                @endif
            </p>

            <form method="POST" action="{{ route('siswa.konsultasi.store', $tes) }}">
                @csrf
                
                @foreach($tes->soals->groupBy('kriteria_id') as $soals)
                    @php($kriteria = $soals->first()->kriteria)
                    
                    <fieldset style="border:1px solid #e2e8f0; border-radius:10px; margin:0 0 24px; padding:20px 24px; background:#fafafa;">
                        <legend style="font-weight:750; padding:0 10px; color:#0f766e; font-size:1rem;">
                            Kriteria: {{ $kriteria->nama_kriteria }}
                        </legend>
                        
                        @if($kriteria->tipe_data === \App\Models\Kriteria::TYPE_NUMERIK)
                            @foreach($soals as $soal)
                                <p style="margin:0 0 10px; font-weight:600; color:#334155; font-size:0.95rem;">{{ $soal->pertanyaan }}</p>
                            @endforeach
                            
                            <div class="field" style="max-width:260px; margin-bottom:0; margin-top:12px;">
                                <label for="nilai_{{ $kriteria->id }}" style="font-weight:600; color:#475569;">Input Nilai (Skala 0-100) *</label>
                                <input id="nilai_{{ $kriteria->id }}" name="nilai_numerik[{{ $kriteria->id }}]" type="number" min="0" max="100" step="0.01" value="{{ old("nilai_numerik.{$kriteria->id}") }}" required style="width:100%;">
                                @error("nilai_numerik.{$kriteria->id}")
                                    <div class="error" style="color:#ef4444; font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
                                @enderror
                            </div>
                        @else
                            @foreach($soals as $soal)
                                <div style="margin:0 0 20px; border-bottom: 1px dashed #e2e8f0; padding-bottom:16px; margin-bottom:16px;">
                                    <p style="font-weight:600; margin:0 0 12px; color:#334155; font-size:0.95rem;">
                                        {{ $soal->pertanyaan }}
                                    </p>
                                    
                                    <div style="display:flex; flex-direction:column; gap:8px;">
                                        @forelse($soal->pilihanJawabans as $pilihan)
                                            <label style="display:flex; align-items:center; cursor:pointer; color:#475569; font-size:0.9rem; margin:0; padding:6px 10px; border:1px solid #e2e8f0; border-radius:6px; background:#ffffff;">
                                                <input type="radio" name="jawabans[{{ $soal->id }}]" value="{{ $pilihan->id }}" @checked((string) old("jawabans.{$soal->id}") === (string) $pilihan->id) required style="margin-right:10px;">
                                                {{ $pilihan->pilihan }}
                                            </label>
                                        @empty
                                            <p class="error" style="color:#ef4444; font-size:0.85rem;">Pilihan jawaban belum tersedia untuk soal ini.</p>
                                        @endforelse
                                    </div>
                                    @error("jawabans.{$soal->id}")
                                        <div class="error" style="color:#ef4444; font-size:0.8rem; margin-top:4px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endforeach
                        @endif
                    </fieldset>
                @endforeach
                
                <div style="display:flex; gap:12px; margin-top:28px;">
                    <a class="button secondary" href="{{ route('siswa.konsultasi.index') }}">Batal</a>
                    <button class="button" type="submit" style="background-color:#0f766e; font-weight:700;">
                        Kirim Jawaban Kuesioner
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection

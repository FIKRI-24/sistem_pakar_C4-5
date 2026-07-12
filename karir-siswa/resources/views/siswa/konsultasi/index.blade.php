@extends('layouts.app', ['title' => 'Konsultasi Karir'])

@section('content')
    <div class="toolbar">
        <div>
            <p class="role-badge">Konsultasi Karir</p>
            <h1>Daftar Kuesioner</h1>
            <p class="muted">Silakan pilih kuesioner aktif di bawah ini untuk Anda kerjakan.</p>
        </div>
        <div style="display:flex; gap:10px;">
            <a class="button secondary" href="{{ route('siswa.dashboard') }}">Dashboard</a>
            <a class="button secondary" href="{{ route('siswa.hasil-tes.index') }}">Riwayat Hasil</a>
        </div>
    </div>

    @if (session('error'))
        <div class="notice" style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; border-radius:8px; padding:16px 20px; margin-bottom:24px;">
            {{ session('error') }}
        </div>
    @endif

    <div style="display:flex; flex-direction:column; gap:20px;">
        @forelse($tests as $tes)
            @php($sudahDikerjakan = in_array($tes->id, $takenTestIds, true))
            
            <section class="panel">
                <div class="panel-body" style="padding:24px 28px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:20px;">
                    <div style="flex:1; min-width:300px;">
                        <div style="display:flex; align-items:center; gap:10px; margin-bottom:8px; flex-wrap:wrap;">
                            <h2 style="margin:0; font-size:1.25rem; font-weight:750; color:#1e293b;">{{ $tes->nama_tes }}</h2>
                            @if($sudahDikerjakan)
                                <span style="background:#dcfce7; color:#166534; font-size:0.75rem; font-weight:700; padding:3px 10px; border-radius:9999px;">
                                    Selesai Dikerjakan
                                </span>
                            @else
                                <span style="background:#e0f2fe; color:#0369a1; font-size:0.75rem; font-weight:700; padding:3px 10px; border-radius:9999px;">
                                    Belum Dikerjakan
                                </span>
                            @endif
                        </div>
                        <p class="muted" style="margin:0 0 8px;">{{ $tes->deskripsi ?: 'Tidak ada deskripsi kuesioner.' }}</p>
                        <div style="display:flex; align-items:center; gap:6px; font-size:0.85rem; color:#64748b;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>{{ $tes->durasi_menit ? 'Estimasi '.$tes->durasi_menit.' menit' : 'Durasi tidak ditentukan' }}</span>
                        </div>
                    </div>
                    
                    <div>
                        @if($sudahDikerjakan)
                            <a class="button secondary" href="{{ route('siswa.hasil-tes.index') }}" style="font-weight:700;">
                                Lihat Riwayat Hasil
                            </a>
                        @else
                            <a class="button" href="{{ route('siswa.konsultasi.show', $tes) }}" style="background-color:#0f766e; font-weight:700;">
                                Mulai Mengerjakan
                            </a>
                        @endif
                    </div>
                </div>
            </section>
        @empty
            <section class="panel">
                <div class="panel-body" style="padding:40px; text-align:center;">
                    <p class="muted" style="margin:0;">Belum ada kuesioner aktif yang dapat dikerjakan saat ini.</p>
                </div>
            </section>
        @endforelse
    </div>
@endsection

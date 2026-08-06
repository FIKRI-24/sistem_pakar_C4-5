@extends('layouts.app', ['title' => 'Konsultasi Karir'])

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
        }
        .btn-3d-secondary:hover {
            background: linear-gradient(180deg, #ffffff 0%, #cbd5e1 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #94a3b8;
            color: #0f172a !important;
        }
    </style>

    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Header Banner -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px 28px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 6px; background: #f0fdf4; border: 1px solid #ccfbf1; color: #0f766e; font-size: 0.75rem; font-weight: 800; padding: 2px 10px; border-radius: 20px; text-transform: uppercase; margin-bottom: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    Bimbingan & Konsultasi Karir
                </div>
                <h1 style="margin: 0 0 4px; font-size: 1.65rem; font-weight: 800; letter-spacing: -0.03em; color: #0f172a;">Daftar Kuesioner Konsultasi</h1>
                <p style="margin: 0; font-size: 0.95rem; color: #64748b;">Silakan pilih kuesioner aktif di bawah ini untuk Anda kerjakan.</p>
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <a href="{{ route('siswa.dashboard') }}" class="btn-3d btn-3d-secondary">
                    <span>Dashboard Siswa</span>
                </a>
                <a href="{{ route('siswa.hasil-tes.index') }}" class="btn-3d btn-3d-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    <span>Riwayat Hasil Tes</span>
                </a>
            </div>
        </div>

        @if (session('error'))
            <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 14px 18px; border-radius: 12px; font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; gap: 10px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- List of Active Tests -->
        <div style="display: flex; flex-direction: column; gap: 16px;">
            @forelse($tests as $tes)
                @php($sudahDikerjakan = in_array($tes->id, $takenTestIds, true))
                
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px 28px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; transition: border-color 0.2s;">
                    <div style="flex: 1; min-width: 280px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px; flex-wrap: wrap;">
                            <div style="width: 38px; height: 38px; border-radius: 10px; background: {{ $sudahDikerjakan ? '#f0fdf4' : '#eff6ff' }}; color: {{ $sudahDikerjakan ? '#059669' : '#2563eb' }}; display: flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
                            </div>
                            <div>
                                <h2 style="margin: 0; font-size: 1.2rem; font-weight: 800; color: #0f172a;">{{ $tes->nama_tes }}</h2>
                            </div>
                            @if($sudahDikerjakan)
                                <span style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    Selesai Dikerjakan
                                </span>
                            @else
                                <span style="background: #f0fdf4; border: 1px solid #ccfbf1; color: #0f766e; font-size: 0.75rem; font-weight: 800; padding: 3px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 4px;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #0f766e;"></span>
                                    Belum Dikerjakan
                                </span>
                            @endif
                        </div>
                        
                        <p style="margin: 0 0 10px; color: #64748b; font-size: 0.9rem; line-height: 1.5;">
                            {{ $tes->deskripsi ?: 'Tidak ada deskripsi kuesioner.' }}
                        </p>

                        <div style="display: flex; align-items: center; gap: 6px; font-size: 0.825rem; color: #64748b; font-weight: 600;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            <span>{{ $tes->durasi_menit ? 'Estimasi '.$tes->durasi_menit.' menit pengerjaan' : 'Durasi fleksibel' }}</span>
                        </div>
                    </div>
                    
                    <div>
                        @if($sudahDikerjakan)
                            <a href="{{ route('siswa.hasil-tes.index') }}" class="btn-3d btn-3d-secondary">
                                <span>Lihat Riwayat Hasil</span>
                            </a>
                        @else
                            <a href="{{ route('siswa.konsultasi.show', $tes) }}" class="btn-3d btn-3d-emerald">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                <span>Mulai Mengerjakan</span>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 48px 24px; text-align: center; color: #64748b; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/></svg>
                        <span style="font-size: 1rem; font-weight: 700; color: #334155;">Belum ada kuesioner aktif yang dapat dikerjakan saat ini.</span>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

@extends('layouts.app', ['title' => 'Rekomendasi Karir'])

@section('content')
    <style>
        .btn-3d {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 0.825rem;
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

        .btn-3d-cyan {
            background: linear-gradient(180deg, #22d3ee 0%, #0891b2 100%);
            color: #ffffff !important;
            box-shadow: 0 3px 0 #0e7490, 0 4px 10px rgba(8, 145, 178, 0.3);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
        }
        .btn-3d-cyan:hover {
            background: linear-gradient(180deg, #67e8f9 0%, #0e7490 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #0e7490, 0 8px 14px rgba(8, 145, 178, 0.4);
        }

        .btn-3d-secondary {
            background: linear-gradient(180deg, #ffffff 0%, #e2e8f0 100%);
            color: #475569 !important;
            box-shadow: 0 3.5px 0 #cbd5e1, 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #cbd5e1;
            padding: 6px 12px;
            font-size: 0.775rem;
        }
        .btn-3d-secondary:hover {
            background: linear-gradient(180deg, #ffffff 0%, #cbd5e1 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #94a3b8;
            color: #0f172a !important;
        }

        .rekomendasi-table tr:hover {
            background-color: #f8fafc !important;
        }
    </style>

    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Header Banner -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px 28px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 6px; background: #f0fdf4; border: 1px solid #ccfbf1; color: #0f766e; font-size: 0.75rem; font-weight: 800; padding: 2px 10px; border-radius: 20px; text-transform: uppercase; margin-bottom: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                    C4.5 Career Recommendation
                </div>
                <h1 style="margin: 0 0 4px; font-size: 1.65rem; font-weight: 800; letter-spacing: -0.03em; color: #0f172a;">Rekomendasi Karir Siswa</h1>
                <p style="margin: 0; font-size: 0.95rem; color: #64748b;">Hasil rekomendasi pilihan karir/jurusan siswa berdasarkan aturan inferensi pohon keputusan C4.5.</p>
            </div>
        </div>

        <!-- Card Container -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden; display: flex; flex-direction: column;">
            <!-- Filter Toolbar -->
            <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; background: #f8fafc; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <form method="GET" action="{{ route('admin.tes.rekomendasi-karir') }}" style="display: flex; gap: 10px; width: 100%; max-width: 440px; align-items: center; position: relative;">
                    <div style="position: relative; flex: 1;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama siswa atau karir..." style="width: 100%; border: 1px solid #cbd5e1; border-radius: 10px; padding: 10px 14px 10px 40px; font-size: 0.875rem; font-weight: 600; color: #0f172a; outline: none; box-sizing: border-box; background: #ffffff; transition: border-color 0.2s;">
                    </div>
                    
                    <!-- 3D Cari Button -->
                    <button type="submit" class="btn-3d btn-3d-cyan">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <span>Cari</span>
                    </button>

                    @if($search)
                        <a href="{{ route('admin.tes.rekomendasi-karir') }}" style="color: #64748b; font-size: 0.85rem; font-weight: 700; text-decoration: none; padding: 6px 10px; background: #e2e8f0; border-radius: 8px; transition: all 0.2s;">Reset</a>
                    @endif
                </form>

                <div style="font-size: 0.85rem; font-weight: 700; color: #64748b; background: #ffffff; padding: 6px 14px; border-radius: 20px; border: 1px solid #e2e8f0;">
                    Total: <strong style="color: #0f172a;">{{ $rekomendasis->total() }} Rekomendasi</strong>
                </div>
            </div>

            <!-- Table View -->
            <div style="overflow-x: auto; width: 100%;">
                <table class="rekomendasi-table" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; min-width: 820px;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 22%;">Nama Siswa</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 16%;">Kelas & Jurusan</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 22%;">Rekomendasi Karir</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 15%;">Kecocokan</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 15%;">Alasan Rekomendasi</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 10%; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="background: #ffffff;">
                        @forelse($rekomendasis as $rek)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                                <!-- Siswa -->
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); color: #ffffff; font-weight: 800; font-size: 0.85rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(15, 118, 110, 0.25);">
                                            {{ strtoupper(substr($rek->hasilTes->siswa->user->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong style="font-size: 0.95rem; font-weight: 800; color: #0f172a; display: block; margin-bottom: 2px;">{{ $rek->hasilTes->siswa->user->name ?? 'Siswa' }}</strong>
                                            <span style="font-size: 0.8rem; font-weight: 600; color: #64748b;">
                                                NIS: {{ $rek->hasilTes->siswa->nis ?? '-' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Kelas & Jurusan -->
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <span style="font-weight: 700; color: #1e293b; background: #f8fafc; border: 1px solid #e2e8f0; padding: 4px 10px; border-radius: 8px; font-size: 0.825rem; display: inline-block;">
                                        {{ $rek->hasilTes->siswa->kelas ?? '-' }} - {{ $rek->hasilTes->siswa->jurusan ?? '-' }}
                                    </span>
                                </td>

                                <!-- Rekomendasi Karir -->
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0f766e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                        <strong style="font-size: 0.95rem; font-weight: 800; color: #0f766e;">{{ $rek->karir->nama_karir }}</strong>
                                    </div>
                                </td>

                                <!-- Kecocokan -->
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <span style="background: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 0.825rem; display: inline-flex; align-items: center; gap: 4px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                        {{ number_format($rek->persen_kecocokan, 2, ',', '.') }}%
                                    </span>
                                </td>

                                <!-- Alasan Rekomendasi -->
                                <td style="padding: 16px 24px; vertical-align: middle; max-width: 320px; font-size: 0.85rem; color: #475569; font-weight: 600; line-height: 1.5;">
                                    {{ $rek->alasan }}
                                </td>

                                <!-- 3D Action Button -->
                                <td style="padding: 16px 24px; vertical-align: middle; text-align: right;">
                                    @if($rek->hasilTes)
                                        <a href="{{ route('admin.tes.hasil-tes.show', $rek->hasilTes) }}" class="btn-3d btn-3d-secondary" title="Lihat Detail Rekomendasi">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/></svg>
                                            <span>Detail</span>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 40px 24px; text-align: center; color: #64748b; font-style: italic;">
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                                        <span style="font-size: 0.95rem; font-weight: 700; color: #475569;">Belum ada data rekomendasi karir yang tercatat.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($rekomendasis->hasPages())
                <div style="padding: 18px 24px; border-top: 1px solid #f1f5f9; background: #f8fafc; display: flex; justify-content: center;">
                    {{ $rekomendasis->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

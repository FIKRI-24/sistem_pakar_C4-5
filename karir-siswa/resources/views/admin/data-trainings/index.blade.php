@extends('layouts.app', ['title' => 'Data Training'])

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

        .btn-3d-blue {
            background: linear-gradient(180deg, #38bdf8 0%, #0284c7 100%);
            color: #ffffff !important;
            box-shadow: 0 3.5px 0 #0369a1, 0 5px 12px rgba(2, 132, 199, 0.35);
            border-top: 1px solid rgba(255, 255, 255, 0.35);
            padding: 6px 12px;
            font-size: 0.775rem;
        }
        .btn-3d-blue:hover {
            background: linear-gradient(180deg, #7dd3fc 0%, #0369a1 100%);
            transform: translateY(-2px);
            box-shadow: 0 5.5px 0 #0369a1, 0 9px 16px rgba(2, 132, 199, 0.45);
        }

        .btn-3d-danger {
            background: linear-gradient(180deg, #fb7185 0%, #e11d48 100%);
            color: #ffffff !important;
            box-shadow: 0 3.5px 0 #be123c, 0 5px 12px rgba(225, 29, 72, 0.35);
            border-top: 1px solid rgba(255, 255, 255, 0.35);
            padding: 6px 12px;
            font-size: 0.775rem;
        }
        .btn-3d-danger:hover {
            background: linear-gradient(180deg, #fda4af 0%, #be123c 100%);
            transform: translateY(-2px);
            box-shadow: 0 5.5px 0 #be123c, 0 9px 16px rgba(225, 29, 72, 0.45);
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
            padding: 8px 16px;
            font-size: 0.825rem;
        }
        .btn-3d-secondary:hover {
            background: linear-gradient(180deg, #ffffff 0%, #cbd5e1 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #94a3b8;
            color: #0f172a !important;
        }

        .data-training-pagination svg {
            display: block;
            width: 20px;
            height: 20px;
        }

        .training-table tr:hover {
            background-color: #f8fafc !important;
        }

        @media (max-width: 640px) {
            .header-banner {
                padding: 16px !important;
                flex-direction: column !important;
                align-items: stretch !important;
            }
            .header-banner .btn-3d {
                width: 100% !important;
                box-sizing: border-box;
            }
            .filter-toolbar {
                padding: 14px 16px !important;
            }
            .filter-form {
                max-width: 100% !important;
                flex-wrap: wrap !important;
            }
        }
    </style>

    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Header Banner -->
        <div class="header-banner" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px 28px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 6px; background: #f0fdf4; border: 1px solid #ccfbf1; color: #0f766e; font-size: 0.75rem; font-weight: 800; padding: 2px 10px; border-radius: 20px; text-transform: uppercase; margin-bottom: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 21 19V5"/><path d="M3 12A9 3 0 0 0 21 12"/></svg>
                    Dataset Pembentukan Model
                </div>
                <h1 style="margin: 0 0 4px; font-size: 1.65rem; font-weight: 800; letter-spacing: -0.03em; color: #0f172a;">Data Training C4.5</h1>
                <p style="margin: 0; font-size: 0.95rem; color: #64748b;">Kelola riwayat data latih yang digunakan oleh mesin Python untuk membentuk Pohon Keputusan C4.5.</p>
            </div>
            
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <!-- 3D Import CSV / Excel Button -->
                <a href="{{ route('admin.data-trainings.import.form') }}" class="btn-3d btn-3d-cyan" style="padding: 10px 18px; font-size: 0.875rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                    <span>Import Excel / CSV</span>
                </a>

                <!-- 3D Tambah Manual Button -->
                <a href="{{ route('admin.data-trainings.create') }}" class="btn-3d btn-3d-emerald" style="padding: 10px 18px; font-size: 0.875rem;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    <span>Tambah Data Manual</span>
                </a>
            </div>
        </div>

        @if (session('success'))
            <div style="background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; padding: 14px 18px; border-radius: 12px; font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; gap: 10px; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.15);">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Card Container -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden; display: flex; flex-direction: column;">
            <!-- Filter Toolbar -->
            <div class="filter-toolbar" style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; background: #f8fafc; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <form method="GET" action="" class="filter-form" style="display: flex; gap: 10px; width: 100%; max-width: 440px; align-items: center; position: relative; flex-wrap: wrap;">
                    <div style="position: relative; flex: 1; min-width: 180px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input name="q" value="{{ $search }}" placeholder="Cari sumber atau label karir..." style="width: 100%; border: 1px solid #cbd5e1; border-radius: 10px; padding: 10px 14px 10px 40px; font-size: 0.875rem; font-weight: 600; color: #0f172a; outline: none; box-sizing: border-box; background: #ffffff; transition: border-color 0.2s;">
                    </div>
                    
                    <!-- 3D Cari Button -->
                    <button type="submit" class="btn-3d btn-3d-cyan" style="white-space: nowrap;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <span>Cari</span>
                    </button>

                    @if($search)
                        <a href="{{ route('admin.data-trainings.index') }}" style="color: #64748b; font-size: 0.85rem; font-weight: 700; text-decoration: none; padding: 6px 10px; background: #e2e8f0; border-radius: 8px; transition: all 0.2s; white-space: nowrap;">Reset</a>
                    @endif
                </form>

                <div style="font-size: 0.85rem; font-weight: 700; color: #64748b; background: #ffffff; padding: 6px 14px; border-radius: 20px; border: 1px solid #e2e8f0;">
                    Total: <strong style="color: #0f172a;">{{ $dataTrainings->total() }} Data Latih</strong>
                </div>
            </div>

            <!-- Table View -->
            <div style="overflow-x: auto; width: 100%;">
                <table class="training-table" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; min-width: 820px;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 22%;">Klasifikasi Karir</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 48%;">Nilai Atribut Pelatihan</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 15%;">Sumber Data</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 15%; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="background: #ffffff;">
                        @forelse ($dataTrainings as $training)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                                <!-- Klasifikasi Karir -->
                                <td style="padding: 16px 24px; vertical-align: top;">
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <div style="width: 32px; height: 32px; border-radius: 8px; background: #f0fdf4; border: 1px solid #ccfbf1; color: #0f766e; display: flex; align-items: center; justify-content: center; font-weight: 800; flex-shrink: 0;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                                        </div>
                                        <strong style="font-size: 0.95rem; font-weight: 800; color: #0f766e;">
                                            {{ $training->labelKarir->nama_karir }}
                                        </strong>
                                    </div>
                                </td>

                                <!-- Nilai Atribut Pelatihan -->
                                <td style="padding: 16px 24px; vertical-align: top;">
                                    <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                                        @foreach($training->atributs as $atribut)
                                            <div style="background: #f8fafc; border: 1px solid #e2e8f0; padding: 4px 10px; border-radius: 8px; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 6px;">
                                                <span style="color: #64748b; font-weight: 700;">{{ $atribut->kriteria->nama_kriteria }}:</span>
                                                <strong style="color: #0f172a; font-weight: 800;">{{ $atribut->nilai_kategorik ?? $atribut->nilai_numerik }}</strong>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>

                                <!-- Sumber Data -->
                                <td style="padding: 16px 24px; vertical-align: middle; color: #475569; font-weight: 700; font-size: 0.85rem;">
                                    <span style="background: #f1f5f9; padding: 3px 8px; border-radius: 6px; border: 1px solid #cbd5e1; display: inline-block;">
                                        {{ $training->sumber ?: '-' }}
                                    </span>
                                </td>

                                <!-- 3D Action Buttons -->
                                <td style="padding: 16px 24px; vertical-align: middle; text-align: right;">
                                    <div style="display: inline-flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                        <!-- 3D Ubah Button -->
                                        <a href="{{ route('admin.data-trainings.edit', $training) }}" class="btn-3d btn-3d-blue" title="Ubah Data Training">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                            <span>Ubah</span>
                                        </a>

                                        <!-- 3D Hapus Button -->
                                        <form method="POST" action="{{ route('admin.data-trainings.destroy', $training) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data training ini?')" style="margin: 0; display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-3d btn-3d-danger" title="Hapus Data Training">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding: 40px 24px; text-align: center; color: #64748b; font-style: italic;">
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                                        <span style="font-size: 0.95rem; font-weight: 700; color: #475569;">Belum ada data training.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($dataTrainings->hasPages())
                <div style="padding: 18px 24px; border-top: 1px solid #f1f5f9; background: #f8fafc; display: flex; justify-content: center;" class="data-training-pagination">
                    {{ $dataTrainings->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

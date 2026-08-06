@extends('layouts.app', ['title' => 'Data Tes'])

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

        /* 3D Emerald (Tambah) */
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
        .btn-3d-emerald:active {
            box-shadow: 0 1px 0 #047857, 0 2px 4px rgba(5, 150, 105, 0.3);
        }

        /* 3D Primary Blue / Edit (Ubah) */
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
        .btn-3d-blue:active {
            box-shadow: 0 1px 0 #0369a1, 0 2px 4px rgba(2, 132, 199, 0.3);
        }

        /* 3D Crimson / Delete (Hapus) */
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
        .btn-3d-danger:active {
            box-shadow: 0 1px 0 #be123c, 0 2px 4px rgba(225, 29, 72, 0.3);
        }

        /* 3D Cyan (Cari) */
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
        .btn-3d-cyan:active {
            box-shadow: 0 1px 0 #0e7490;
        }

        .tes-table tr:hover {
            background-color: #f8fafc !important;
        }
    </style>

    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Header Banner -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px 28px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 6px; background: #f0fdf4; border: 1px solid #ccfbf1; color: #0f766e; font-size: 0.75rem; font-weight: 800; padding: 2px 10px; border-radius: 20px; text-transform: uppercase; margin-bottom: 8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Assessment Questionnaire
                </div>
                <h1 style="margin: 0 0 4px; font-size: 1.65rem; font-weight: 800; letter-spacing: -0.03em; color: #0f172a;">Data Kuesioner Tes</h1>
                <p style="margin: 0; font-size: 0.95rem; color: #64748b;">Kelola instrumen tes minat, bakat, kepribadian, dan nilai akademik siswa.</p>
            </div>
            
            <!-- 3D Tambah Tes Button -->
            <a href="{{ route('admin.tes.buat-lengkap') }}" class="btn-3d btn-3d-emerald" style="padding: 10px 20px; font-size: 0.9rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span>Buat Kuesioner Tes Lengkap</span>
            </a>
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
            <div style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; background: #f8fafc; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <form method="GET" action="" style="display: flex; gap: 10px; width: 100%; max-width: 440px; align-items: center; position: relative;">
                    <div style="position: relative; flex: 1;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input name="q" value="{{ $search }}" placeholder="Cari nama atau deskripsi tes..." style="width: 100%; border: 1px solid #cbd5e1; border-radius: 10px; padding: 10px 14px 10px 40px; font-size: 0.875rem; font-weight: 600; color: #0f172a; outline: none; box-sizing: border-box; background: #ffffff; transition: border-color 0.2s;">
                    </div>
                    
                    <!-- 3D Cari Button -->
                    <button type="submit" class="btn-3d btn-3d-cyan">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <span>Cari</span>
                    </button>

                    @if($search)
                        <a href="{{ route('admin.tes.index') }}" style="color: #64748b; font-size: 0.85rem; font-weight: 700; text-decoration: none; padding: 6px 10px; background: #e2e8f0; border-radius: 8px; transition: all 0.2s;">Reset</a>
                    @endif
                </form>

                <div style="font-size: 0.85rem; font-weight: 700; color: #64748b; background: #ffffff; padding: 6px 14px; border-radius: 20px; border: 1px solid #e2e8f0;">
                    Total: <strong style="color: #0f172a;">{{ $tes->total() }} Kuesioner</strong>
                </div>
            </div>

            <!-- Table View -->
            <div style="overflow-x: auto; width: 100%;">
                <table class="tes-table" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; min-width: 650px;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 48%;">Nama Kuesioner</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 20%;">Durasi</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 15%;">Status</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 17%; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="background: #ffffff;">
                        @forelse ($tes as $te)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                                <!-- Nama Kuesioner & Deskripsi -->
                                <td style="padding: 16px 24px; vertical-align: top;">
                                    <div style="display: flex; align-items: flex-start; gap: 12px;">
                                        <!-- Test Document Icon -->
                                        <div style="width: 38px; height: 38px; border-radius: 10px; background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(15, 118, 110, 0.25); margin-top: 2px;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                        </div>
                                        <div>
                                            <strong style="font-size: 0.95rem; font-weight: 800; color: #0f172a; display: block; margin-bottom: 4px;">{{ $te->nama_tes }}</strong>
                                            <span style="font-size: 0.85rem; color: #475569; line-height: 1.5; display: block;">{{ \Illuminate\Support\Str::limit($te->deskripsi, 120) ?: 'Tidak ada deskripsi.' }}</span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Durasi -->
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <div style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700; color: #334155; background: #f8fafc; border: 1px solid #e2e8f0; padding: 4px 12px; border-radius: 20px; font-size: 0.825rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#0f766e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        <span>{{ $te->durasi_menit ? $te->durasi_menit.' menit' : '-' }}</span>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    @if ($te->status_aktif)
                                        <span style="background-color: #ecfdf5; border: 1px solid #a7f3d0; color: #047857; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 0.775rem; display: inline-flex; align-items: center; gap: 6px;">
                                            <span style="width: 6px; height: 6px; border-radius: 50%; background-color: #10b981; display: inline-block;"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span style="background-color: #f1f5f9; border: 1px solid #cbd5e1; color: #64748b; padding: 4px 12px; border-radius: 20px; font-weight: 800; font-size: 0.775rem; display: inline-flex; align-items: center; gap: 6px;">
                                            <span style="width: 6px; height: 6px; border-radius: 50%; background-color: #94a3b8; display: inline-block;"></span>
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>

                                <!-- 3D Action Buttons -->
                                <td style="padding: 16px 24px; vertical-align: middle; text-align: right;">
                                    <div style="display: inline-flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                        <!-- 3D Edit / Ubah Button -->
                                        <a href="{{ route('admin.tes.edit', $te) }}" class="btn-3d btn-3d-blue" title="Ubah Tes">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                            <span>Ubah</span>
                                        </a>

                                        <!-- 3D Delete / Hapus Button -->
                                        <form method="POST" action="{{ route('admin.tes.destroy', $te) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kuesioner ini? Tindakan ini akan menghapusnya secara aman (Soft Delete) dari daftar aktif.')" style="margin: 0; display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-3d btn-3d-danger" title="Hapus Tes">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
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
                                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        <span style="font-size: 0.95rem; font-weight: 700; color: #475569;">Belum ada data kuesioner tes.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($tes->hasPages())
                <div style="padding: 18px 24px; border-top: 1px solid #f1f5f9; background: #f8fafc; display: flex; justify-content: center;">
                    {{ $tes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

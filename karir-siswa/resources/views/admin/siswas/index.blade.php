@extends('layouts.app', ['title' => 'Data Siswa'])

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

        /* 3D Emerald (Tambah / Simpan) */
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

        .siswa-table tr:hover {
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Master Data
                </div>
                <h1 style="margin: 0 0 4px; font-size: 1.65rem; font-weight: 800; letter-spacing: -0.03em; color: #0f172a;">Kelola Data Siswa</h1>
                <p style="margin: 0; font-size: 0.95rem; color: #64748b;">Kelola daftar siswa terdaftar yang berhak mengikuti kuesioner minat dan bakat C4.5.</p>
            </div>
            
            <!-- 3D Tambah Siswa Button -->
            <a href="{{ route('admin.siswas.create') }}" class="btn-3d btn-3d-emerald" style="padding: 10px 20px; font-size: 0.9rem;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                <span>Tambah Siswa Baru</span>
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
            <div class="filter-toolbar" style="padding: 18px 24px; border-bottom: 1px solid #f1f5f9; background: #f8fafc; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <form method="GET" action="" class="filter-form" style="display: flex; gap: 10px; width: 100%; max-width: 460px; align-items: center; position: relative; flex-wrap: wrap;">
                    <div style="position: relative; flex: 1; min-width: 180px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input name="q" value="{{ $search }}" placeholder="Cari nama, NIS, kelas, atau jurusan..." style="width: 100%; border: 1px solid #cbd5e1; border-radius: 10px; padding: 10px 14px 10px 40px; font-size: 0.875rem; font-weight: 600; color: #0f172a; outline: none; box-sizing: border-box; background: #ffffff; transition: border-color 0.2s;">
                    </div>
                    
                    <!-- 3D Cari Button -->
                    <button type="submit" class="btn-3d btn-3d-cyan" style="white-space: nowrap;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                        <span>Cari</span>
                    </button>

                    @if($search)
                        <a href="{{ route('admin.siswas.index') }}" style="color: #64748b; font-size: 0.85rem; font-weight: 700; text-decoration: none; padding: 6px 10px; background: #e2e8f0; border-radius: 8px; transition: all 0.2s; white-space: nowrap;">Reset</a>
                    @endif
                </form>

                <div style="font-size: 0.85rem; font-weight: 700; color: #64748b; background: #ffffff; padding: 6px 14px; border-radius: 20px; border: 1px solid #e2e8f0;">
                    Total: <strong style="color: #0f172a;">{{ $siswas->total() }} Siswa</strong>
                </div>
            </div>

            <!-- Table View -->
            <div style="overflow-x: auto; width: 100%;">
                <table class="siswa-table" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; min-width: 720px;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 15%;">NIS</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 35%;">Nama / Akun Siswa</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 15%;">Kelas</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 18%;">Jurusan</th>
                            <th style="padding: 14px 24px; font-weight: 800; color: #475569; font-size: 0.775rem; text-transform: uppercase; letter-spacing: 0.05em; width: 17%; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="background: #ffffff;">
                        @forelse ($siswas as $siswa)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                                <!-- NIS -->
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <span style="font-family: monospace; font-size: 0.875rem; font-weight: 800; color: #0f172a; background: #f1f5f9; padding: 4px 10px; border-radius: 6px; border: 1px solid #e2e8f0; display: inline-block;">
                                        {{ $siswa->nis }}
                                    </span>
                                </td>

                                <!-- Nama & Profile Info -->
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <!-- Avatar Initial Badge -->
                                        <div style="width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); color: #ffffff; font-weight: 800; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(15, 118, 110, 0.25);">
                                            {{ strtoupper(substr($siswa->user->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong style="font-size: 0.95rem; font-weight: 800; color: #0f172a; display: block; margin-bottom: 2px;">{{ $siswa->user->name }}</strong>
                                            <span style="font-size: 0.8rem; font-weight: 600; color: #64748b; display: flex; align-items: center; gap: 6px;">
                                                <span>@<span>{{ $siswa->user->username }}</span></span>
                                                @if($siswa->user->email)
                                                    <span style="color: #cbd5e1;">•</span>
                                                    <span>{{ $siswa->user->email }}</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Kelas -->
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <span style="font-weight: 700; color: #1e293b; background: #f8fafc; border: 1px solid #e2e8f0; padding: 4px 10px; border-radius: 8px; font-size: 0.85rem; display: inline-block;">
                                        {{ $siswa->kelas }}
                                    </span>
                                </td>

                                <!-- Jurusan -->
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <span style="font-weight: 700; color: #0f766e; background: #f0fdf4; border: 1px solid #ccfbf1; padding: 4px 10px; border-radius: 8px; font-size: 0.85rem; display: inline-block;">
                                        {{ $siswa->jurusan }}
                                    </span>
                                </td>

                                <!-- 3D Action Buttons -->
                                <td style="padding: 16px 24px; vertical-align: middle; text-align: right;">
                                    <div style="display: inline-flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                        <!-- 3D Edit / Ubah Button -->
                                        <a href="{{ route('admin.siswas.edit', $siswa) }}" class="btn-3d btn-3d-blue" title="Ubah Data Siswa">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                            <span>Ubah</span>
                                        </a>

                                        <!-- 3D Delete / Hapus Button -->
                                        <form method="POST" action="{{ route('admin.siswas.destroy', $siswa) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')" style="margin: 0; display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-3d btn-3d-danger" title="Hapus Siswa">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                                <span>Hapus</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 40px 24px; text-align: center; color: #64748b; font-style: italic;">
                                    <div style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="18" x2="22" y1="11" y2="15"/><line x1="22" x2="18" y1="11" y2="15"/></svg>
                                        <span style="font-size: 0.95rem; font-weight: 700; color: #475569;">Belum ada data siswa.</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($siswas->hasPages())
                <div style="padding: 18px 24px; border-top: 1px solid #f1f5f9; background: #f8fafc; display: flex; justify-content: center;">
                    {{ $siswas->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

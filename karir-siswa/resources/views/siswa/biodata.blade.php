@extends('layouts.app', ['title' => 'Biodata Saya'])

@section('content')
    <style>
        .btn-3d {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 22px;
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

        .form-input {
            width: 100%;
            min-height: 44px;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #0f172a;
            background: #ffffff;
            outline: none;
            box-sizing: border-box;
            transition: all 0.2s;
        }
        .form-input:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
        }
    </style>

    <div style="max-width: 760px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px;">
        <!-- Back button & Breadcrumb -->
        <div>
            <a href="{{ route('siswa.dashboard') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #64748b; font-size: 0.875rem; font-weight: 700; text-decoration: none; transition: color 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali ke Dashboard Siswa
            </a>
        </div>

        @php($user = auth()->user())

        <!-- Profile Header Banner -->
        <div style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 100%); border-radius: 16px; padding: 24px 28px; color: #ffffff; box-shadow: 0 4px 20px rgba(15, 118, 110, 0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 56px; height: 56px; border-radius: 50%; background: #ffffff; color: #0f766e; font-size: 1.4rem; font-weight: 900; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.15); flex-shrink: 0;">
                    {{ strtoupper(substr($user->name ?? 'S', 0, 1)) }}
                </div>
                <div>
                    <div style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px); color: #ffffff; font-size: 0.75rem; font-weight: 800; padding: 2px 10px; border-radius: 20px; text-transform: uppercase; margin-bottom: 4px;">
                        Profil Siswa
                    </div>
                    <h2 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #ffffff;">{{ $user->name }}</h2>
                    <span style="font-size: 0.85rem; color: #ccfbf1; font-weight: 600;">@<span>{{ $user->username }}</span></span>
                </div>
            </div>
            <div>
                @if($siswa && $siswa->kelas && $siswa->jurusan)
                    <span style="background: rgba(255, 255, 255, 0.2); color: #ffffff; border: 1px solid rgba(255, 255, 255, 0.3); padding: 6px 14px; border-radius: 20px; font-weight: 800; font-size: 0.825rem; display: inline-flex; align-items: center; gap: 6px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                        Biodata Lengkap
                    </span>
                @else
                    <span style="background: #fffbeb; color: #b45309; border: 1px solid #fef3c7; padding: 6px 14px; border-radius: 20px; font-weight: 800; font-size: 0.825rem;">
                        Perlu Dilengkapi
                    </span>
                @endif
            </div>
        </div>

        <!-- Form Card Container -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); overflow: hidden;">
            <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                <h1 style="margin: 0; font-size: 1.35rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
                    Formulir Biodata Diri Siswa
                </h1>
                <p style="margin: 4px 0 0; font-size: 0.875rem; color: #64748b;">Pastikan NIS, kelas, dan jurusan diisi dengan benar untuk keperluan rekap kuesioner BK.</p>
            </div>

            <div style="padding: 32px;">
                @if (session('error'))
                    <div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; border-radius:12px; padding:14px 18px; margin-bottom:20px; font-size: 0.9rem; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @if (session('warning'))
                    <div style="background:#fffbeb; border:1px solid #fef3c7; color:#92400e; border-radius:12px; padding:14px 18px; margin-bottom:20px; font-size: 0.9rem; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        <span>{{ session('warning') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('siswa.biodata.update') }}" style="display: flex; flex-direction: column; gap: 22px;">
                    @csrf

                    <!-- Section 1: Informasi Pribadi -->
                    <div>
                        <h3 style="margin: 0 0 14px; font-size: 0.95rem; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0f766e" stroke-width="2.5"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            Informasi Pribadi
                        </h3>

                        <!-- Nama Lengkap -->
                        <div style="margin-bottom: 18px;">
                            <label for="name" style="display: block; font-size: 0.875rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Nama Lengkap Siswa <span style="color:#ef4444;">*</span></label>
                            <input id="name" name="name" class="form-input" value="{{ old('name', $user->name) }}" required placeholder="Contoh: Muhammad Fikri">
                            @error('name')<div style="color:#ef4444; font-size:0.8rem; font-weight:600; margin-top:4px;">{{ $message }}</div>@enderror
                        </div>

                        <!-- NIS & Jenis Kelamin Grid -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px;">
                            <div>
                                <label for="nis" style="display: block; font-size: 0.875rem; font-weight: 700; color: #334155; margin-bottom: 6px;">NIS (Nomor Induk Siswa) <span style="color:#ef4444;">*</span></label>
                                <input id="nis" name="nis" class="form-input" value="{{ old('nis', $siswa->nis) }}" required placeholder="Contoh: 12345678">
                                @error('nis')<div style="color:#ef4444; font-size:0.8rem; font-weight:600; margin-top:4px;">{{ $message }}</div>@enderror
                            </div>

                            <div>
                                <label for="jenis_kelamin" style="display: block; font-size: 0.875rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Jenis Kelamin <span style="color:#ef4444;">*</span></label>
                                <select id="jenis_kelamin" name="jenis_kelamin" class="form-input" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')<div style="color:#ef4444; font-size:0.8rem; font-weight:600; margin-top:4px;">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- Separator -->
                    <div style="border-top: 1px dashed #e2e8f0; margin: 4px 0;"></div>

                    <!-- Section 2: Informasi Akademik Sekolah -->
                    <div>
                        <h3 style="margin: 0 0 14px; font-size: 0.95rem; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.05em; display: flex; align-items: center; gap: 8px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#0f766e" stroke-width="2.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                            Informasi Akademik Sekolah
                        </h3>

                        <!-- Kelas & Jurusan Grid -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px;">
                            <div>
                                <label for="kelas" style="display: block; font-size: 0.875rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Kelas Saat Ini <span style="color:#ef4444;">*</span></label>
                                <input id="kelas" name="kelas" class="form-input" value="{{ old('kelas', $siswa->kelas) }}" required placeholder="Contoh: XII TKJ 1">
                                @error('kelas')<div style="color:#ef4444; font-size:0.8rem; font-weight:600; margin-top:4px;">{{ $message }}</div>@enderror
                            </div>

                            <div>
                                <label for="jurusan" style="display: block; font-size: 0.875rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Jurusan / Program Keahlian <span style="color:#ef4444;">*</span></label>
                                <input id="jurusan" name="jurusan" class="form-input" value="{{ old('jurusan', $siswa->jurusan) }}" required placeholder="Contoh: Teknik Komputer dan Jaringan">
                                @error('jurusan')<div style="color:#ef4444; font-size:0.8rem; font-weight:600; margin-top:4px;">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <!-- 3D Action Buttons -->
                    <div style="display: flex; gap: 12px; margin-top: 10px; padding-top: 22px; border-top: 1px solid #f1f5f9;">
                        <button class="btn-3d btn-3d-emerald" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            <span>Simpan Biodata</span>
                        </button>
                        <a class="btn-3d btn-3d-secondary" href="{{ route('siswa.dashboard') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

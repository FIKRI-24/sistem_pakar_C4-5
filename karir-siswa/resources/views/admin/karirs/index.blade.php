@extends('layouts.app', ['title' => 'Data Karir'])

@section('content')
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 style="margin: 0 0 4px; font-size: 1.6rem; font-weight: 800; letter-spacing: -0.025em; color: #0f172a;">Data Alternatif Karir</h1>
                <p style="margin: 0; font-size: 0.95rem; color: #64748b;">Kelola daftar klasifikasi alternatif karir/jurusan siswa untuk rekomendasi keputusan C4.5.</p>
            </div>
            <a href="{{ route('admin.karirs.create') }}" style="background-color: #0f766e; color: #ffffff; padding: 10px 18px; border-radius: 8px; font-weight: 700; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px -1px rgba(15, 118, 110, 0.15); transition: all 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Karir
            </a>
        </div>

        @if (session('success'))
            <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Card Container -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden; display: flex; flex-direction: column;">
            <!-- Filter Toolbar -->
            <div style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; background: #f8fafc; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                <form method="GET" action="" style="display: flex; gap: 8px; width: 100%; max-width: 420px; align-items: center; position: relative;">
                    <div style="position: relative; flex: 1;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input name="q" value="{{ $search }}" placeholder="Cari nama karir atau bidang..." style="width: 100%; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px 8px 36px; font-size: 0.875rem; min-height: 38px; outline: none; box-sizing: border-box;">
                    </div>
                    <button type="submit" style="background-color: #0ea5e9; color: #ffffff; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; min-height: 38px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s;">
                        Cari
                    </button>
                    @if($search)
                        <a href="{{ route('admin.karirs.index') }}" style="color: #64748b; font-size: 0.85rem; font-weight: 600; text-decoration: none; padding-left: 4px;">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Table View -->
            <div style="overflow-x: auto; width: 100%;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; min-width: 700px;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; width: 30%;">Nama Karir</th>
                            <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; width: 20%;">Bidang Pekerjaan</th>
                            <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; width: 35%;">Deskripsi</th>
                            <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; width: 15%; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="background: #ffffff;">
                        @forelse ($karirs as $karir)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                                <td style="padding: 16px 20px; vertical-align: middle;">
                                    <strong style="font-size: 0.95rem; font-weight: 800; color: #0f766e;">
                                        {{ $karir->nama_karir }}
                                    </strong>
                                </td>
                                <td style="padding: 16px 20px; vertical-align: middle; color: #334155; font-weight: 600;">
                                    {{ $karir->bidang_pekerjaan ?: '-' }}
                                </td>
                                <td style="padding: 16px 20px; vertical-align: middle; color: #475569; line-height: 1.5;">
                                    {{ \Illuminate\Support\Str::limit($karir->deskripsi, 100) ?: '-' }}
                                </td>
                                <td style="padding: 16px 20px; vertical-align: middle; text-align: right;">
                                    <div style="display: inline-flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                        <a href="{{ route('admin.karirs.edit', $karir) }}" style="background-color: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 0.8rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                            Ubah
                                        </a>
                                        <form method="POST" action="{{ route('admin.karirs.destroy', $karir) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alternatif karir ini?')" style="margin: 0; display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background-color: #fee2e2; border: 1px solid #fecaca; color: #991b1b; padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 4px; cursor: pointer; transition: all 0.2s; border: 1px solid #fecaca;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding: 32px 20px; text-align: center; color: #64748b; font-style: italic;">
                                    Belum ada data alternatif karir.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($karirs->hasPages())
                <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9; background: #f8fafc; display: flex; justify-content: center;">
                    {{ $karirs->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

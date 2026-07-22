@extends('layouts.app', ['title' => 'Data Pertanyaan'])

@section('content')
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 style="margin: 0 0 4px; font-size: 1.6rem; font-weight: 800; letter-spacing: -0.025em; color: #0f172a;">Data Butir Pertanyaan</h1>
                <p style="margin: 0; font-size: 0.95rem; color: #64748b;">Kelola daftar pertanyaan kuesioner psikotes minat, bakat, kepribadian, dan akademik.</p>
            </div>
            <a href="{{ route('admin.soals.create') }}" style="background-color: #0f766e; color: #ffffff; padding: 10px 18px; border-radius: 8px; font-weight: 700; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px -1px rgba(15, 118, 110, 0.15); transition: all 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Pertanyaan
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
                <form method="GET" action="" style="display: flex; gap: 10px; width: 100%; max-width: 680px; align-items: center; flex-wrap: wrap;">
                    <div style="min-width: 180px;">
                        <select name="tes_id" style="width: 100%; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px; font-size: 0.875rem; min-height: 38px; outline: none; background-color: #ffffff; box-sizing: border-box; cursor: pointer;">
                            <option value="">Semua kuesioner tes</option>
                            @foreach($tests as $te)
                                <option value="{{ $te->id }}" @selected($tesId === $te->id)>{{ $te->nama_tes }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="position: relative; flex: 1; min-width: 200px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input name="q" value="{{ $search }}" placeholder="Cari isi pertanyaan..." style="width: 100%; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px 8px 36px; font-size: 0.875rem; min-height: 38px; outline: none; box-sizing: border-box;">
                    </div>
                    <button type="submit" style="background-color: #0ea5e9; color: #ffffff; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; min-height: 38px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s;">
                        Filter
                    </button>
                    @if($search || $tesId)
                        <a href="{{ route('admin.soals.index') }}" style="color: #64748b; font-size: 0.85rem; font-weight: 600; text-decoration: none; padding-left: 4px;">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Table View -->
            <div style="overflow-x: auto; width: 100%;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; min-width: 800px;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; width: 8%; text-align: center;">No.</th>
                            <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; width: 27%;">Tes / Kriteria</th>
                            <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; width: 50%;">Pertanyaan</th>
                            <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; width: 15%; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="background: #ffffff;">
                        @forelse ($soals as $soal)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                                <td style="padding: 16px 20px; vertical-align: middle; text-align: center; font-weight: bold; color: #64748b; font-size: 0.85rem;">
                                    {{ $soal->urutan ?: '-' }}
                                </td>
                                <td style="padding: 16px 20px; vertical-align: top;">
                                    <strong style="font-size: 0.9rem; font-weight: 700; color: #0f172a; display: block; margin-bottom: 6px;">{{ $soal->tes->nama_tes }}</strong>
                                    
                                    @php
                                        $kName = $soal->kriteria->nama_kriteria;
                                        $badgeBg = '#f1f5f9';
                                        $badgeColor = '#475569';
                                        if ($kName === 'Minat') {
                                            $badgeBg = '#e0f2fe';
                                            $badgeColor = '#0369a1';
                                        } elseif ($kName === 'Bakat') {
                                            $badgeBg = '#dcfce7';
                                            $badgeColor = '#15803d';
                                        } elseif ($kName === 'Kepribadian') {
                                            $badgeBg = '#fef3c7';
                                            $badgeColor = '#b45309';
                                        } elseif ($kName === 'Nilai Akademik') {
                                            $badgeBg = '#f3e8ff';
                                            $badgeColor = '#6b21a8';
                                        }
                                    @endphp
                                    <span style="background-color: {{ $badgeBg }}; color: {{ $badgeColor }}; padding: 3px 8px; border-radius: 12px; font-weight: 750; font-size: 0.7rem; display: inline-block;">
                                        {{ $kName }}
                                    </span>
                                </td>
                                <td style="padding: 16px 20px; vertical-align: top; color: #334155; line-height: 1.6; font-weight: 600;">
                                    {{ $soal->pertanyaan }}
                                </td>
                                <td style="padding: 16px 20px; vertical-align: middle; text-align: right;">
                                    <div style="display: inline-flex; gap: 8px; justify-content: flex-end; align-items: center;">
                                        <a href="{{ route('admin.soals.edit', $soal) }}" style="background-color: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 0.8rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                            Ubah
                                        </a>
                                        <form method="POST" action="{{ route('admin.soals.destroy', $soal) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')" style="margin: 0; display: inline-block;">
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
                                    Belum ada data butir pertanyaan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($soals->hasPages())
                <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9; background: #f8fafc; display: flex; justify-content: center;">
                    {{ $soals->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

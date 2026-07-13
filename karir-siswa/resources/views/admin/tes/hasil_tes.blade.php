@extends('layouts.app', ['title' => 'Hasil Tes Siswa'])

@section('content')
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 style="margin: 0 0 4px; font-size: 1.6rem; font-weight: 800; letter-spacing: -0.025em; color: #0f172a;">Hasil Tes Siswa</h1>
                <p style="margin: 0; font-size: 0.95rem; color: #64748b;">Pantau hasil pengerjaan kuesioner bimbingan konseling dan rekap konsultasi siswa.</p>
            </div>
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
                <form method="GET" action="{{ route('admin.tes.hasil-tes') }}" style="display: flex; gap: 8px; width: 100%; max-width: 420px; align-items: center; position: relative;">
                    <div style="position: relative; flex: 1;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input name="q" value="{{ $search }}" placeholder="Cari nama siswa..." style="width: 100%; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 12px 8px 36px; font-size: 0.875rem; min-height: 38px; outline: none; box-sizing: border-box;">
                    </div>
                    <button type="submit" style="background-color: #0ea5e9; color: #ffffff; border: none; padding: 8px 16px; border-radius: 8px; font-weight: 700; font-size: 0.85rem; cursor: pointer; min-height: 38px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s;">
                        Cari
                    </button>
                    @if($search)
                        <a href="{{ route('admin.tes.hasil-tes') }}" style="color: #64748b; font-size: 0.85rem; font-weight: 600; text-decoration: none; padding-left: 4px;">Reset</a>
                    @endif
                </form>
            </div>

            <!-- Table View -->
            <div style="overflow-x: auto; width: 100%;">
                <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; min-width: 800px;">
                    <thead>
                        <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                            <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; width: 25%;">Nama Siswa</th>
                            <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; width: 15%;">NIS</th>
                            <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; width: 20%;">Kelas & Jurusan</th>
                            <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; width: 20%;">Nama Tes</th>
                            <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; width: 10%;">Tanggal Tes</th>
                            <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; width: 10%; text-align: right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="background: #ffffff;">
                        @forelse ($hasilTes as $hasil)
                            <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.15s;">
                                <td style="padding: 16px 20px; vertical-align: top;">
                                    <strong style="font-size: 0.95rem; font-weight: 750; color: #0f172a; display: block; margin-bottom: 2px;">{{ $hasil->siswa->user->name ?? 'Siswa' }}</strong>
                                    <span style="font-size: 0.8rem; color: #64748b; display: block;">
                                        {{ $hasil->siswa->user->username ?? '-' }}
                                    </span>
                                </td>
                                <td style="padding: 16px 20px; vertical-align: middle; font-family: monospace; font-size: 0.85rem; font-weight: bold; color: #0f172a;">
                                    {{ $hasil->siswa->nis ?? '-' }}
                                </td>
                                <td style="padding: 16px 20px; vertical-align: middle; color: #334155;">
                                    <strong>{{ $hasil->siswa->kelas ?? '-' }}</strong> - <span style="font-size: 0.85rem;">{{ $hasil->siswa->jurusan ?? '-' }}</span>
                                </td>
                                <td style="padding: 16px 20px; vertical-align: middle; color: #0f172a; font-weight: 700;">
                                    {{ $hasil->tes->nama_tes ?? '-' }}
                                </td>
                                <td style="padding: 16px 20px; vertical-align: middle; color: #475569;">
                                    <div style="display: inline-flex; align-items: center; gap: 6px; font-size: 0.85rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/></svg>
                                        {{ $hasil->tanggal_tes->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td style="padding: 16px 20px; vertical-align: middle; text-align: right;">
                                    <a href="{{ route('admin.tes.hasil-tes.show', $hasil) }}" style="background-color: #f1f5f9; border: 1px solid #cbd5e1; color: #334155; padding: 6px 12px; border-radius: 6px; font-weight: 700; font-size: 0.8rem; text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: all 0.2s; white-space: nowrap;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/></svg>
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 32px 20px; text-align: center; color: #64748b; font-style: italic;">
                                    Belum ada hasil tes yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($hasilTes->hasPages())
                <div style="padding: 16px 20px; border-top: 1px solid #f1f5f9; background: #f8fafc; display: flex; justify-content: center;">
                    {{ $hasilTes->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection

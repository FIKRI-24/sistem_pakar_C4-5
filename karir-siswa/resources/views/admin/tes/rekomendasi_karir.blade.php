@extends('layouts.app', ['title' => 'Rekomendasi Karir'])

@section('content')
    <section class="panel">
        <div class="panel-body">
            <div class="toolbar">
                <div>
                    <p class="role-badge">Rekomendasi</p>
                    <h1>Rekomendasi Karir Siswa</h1>
                </div>
                <div>
                    <form method="GET" action="{{ route('admin.tes.rekomendasi-karir') }}" style="display:flex; gap:8px;">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama siswa atau karir..." style="padding:0 12px; border:1px solid #cbd5e1; border-radius:8px; min-height:40px;">
                        <button type="submit" class="button">Cari</button>
                        @if($search)
                            <a href="{{ route('admin.tes.rekomendasi-karir') }}" class="button secondary">Reset</a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Kelas & Jurusan</th>
                            <th>Rekomendasi Karir</th>
                            <th>Kecocokan</th>
                            <th>Alasan Rekomendasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekomendasis as $rek)
                            <tr>
                                <td><strong>{{ $rek->hasilTes->siswa->user->name ?? 'Siswa' }}</strong></td>
                                <td>{{ $rek->hasilTes->siswa->kelas ?? '-' }} - {{ $rek->hasilTes->siswa->jurusan ?? '-' }}</td>
                                <td><span style="color:#0f766e; font-weight:700;">{{ $rek->karir->nama_karir }}</span></td>
                                <td><strong>{{ number_format($rek->persen_kecocokan, 2, ',', '.') }}%</strong></td>
                                <td style="max-width:320px; font-size:0.875rem; color:#64748b;">{{ $rek->alasan }}</td>
                                <td>
                                    <a class="button secondary" href="{{ route('admin.tes.hasil-tes.show', $rek->hasilTes) }}">Lihat Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="muted" style="text-align:center;">Belum ada data rekomendasi karir yang tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div style="margin-top:20px">
                {{ $rekomendasis->links() }}
            </div>
        </div>
    </section>
@endsection

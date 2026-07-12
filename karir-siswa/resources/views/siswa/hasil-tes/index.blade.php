@extends('layouts.app', ['title' => 'Riwayat Hasil Tes'])

@section('content')
    <section class="panel"><div class="panel-body"><div class="toolbar"><div><p class="role-badge">Siswa</p><h1>Riwayat Hasil Tes</h1></div><div style="display:flex; gap:10px;"><a class="button secondary" href="{{ route('siswa.dashboard') }}">Dashboard</a><a class="button" href="{{ route('siswa.konsultasi.index') }}">Isi Kuesioner</a></div></div>
        @if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
        <div class="table-wrap"><table><thead><tr><th>Tes</th><th>Tanggal</th><th>Aksi</th></tr></thead><tbody>@forelse($hasilTes as $hasil)<tr><td>{{ $hasil->tes->nama_tes }}</td><td>{{ $hasil->tanggal_tes->format('d-m-Y H:i') }}</td><td><a class="button secondary" href="{{ route('siswa.hasil-tes.show', $hasil) }}">Lihat</a></td></tr>@empty<tr><td colspan="3" class="muted">Belum ada hasil tes.</td></tr>@endforelse</tbody></table></div><div style="margin-top:20px">{{ $hasilTes->links() }}</div>
    </div></section>
@endsection

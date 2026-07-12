@extends('layouts.app', ['title' => 'Data Soal'])

@section('content')
    <section class="panel"><div class="panel-body"><div class="toolbar"><div><p class="role-badge">Fase 2</p><h1>Data Soal</h1></div><a class="button" href="{{ route('admin.soals.create') }}">Tambah Soal</a></div>
        @if (session('success')) <div class="notice">{{ session('success') }}</div> @endif
        <form class="toolbar" method="GET"><select name="tes_id"><option value="">Semua tes</option>@foreach($tests as $te)<option value="{{ $te->id }}" @selected($tesId === $te->id)>{{ $te->nama_tes }}</option>@endforeach</select><input name="q" value="{{ $search }}" placeholder="Cari pertanyaan" style="min-height:42px;min-width:240px;padding:0 12px;"><button class="button secondary">Filter</button></form>
        <div class="table-wrap"><table><thead><tr><th>Urut</th><th>Tes/Kriteria</th><th>Pertanyaan</th><th>Aksi</th></tr></thead><tbody>@forelse($soals as $soal)<tr><td>{{ $soal->urutan ?: '-' }}</td><td>{{ $soal->tes->nama_tes }}<br><span class="muted">{{ $soal->kriteria->nama_kriteria }}</span></td><td>{{ $soal->pertanyaan }}</td><td><div class="inline-actions"><a class="button secondary" href="{{ route('admin.soals.edit', $soal) }}">Ubah</a><form method="POST" action="{{ route('admin.soals.destroy', $soal) }}" onsubmit="return confirm('Hapus soal ini?')">@csrf @method('DELETE')<button class="button danger">Hapus</button></form></div></td></tr>@empty<tr><td colspan="4" class="muted">Belum ada soal.</td></tr>@endforelse</tbody></table></div><div style="margin-top:20px">{{ $soals->links() }}</div>
    </div></section>
@endsection

@extends('layouts.app', ['title' => 'Data Kriteria'])

@section('content')
    <section class="panel"><div class="panel-body">
        <div class="toolbar"><div><p class="role-badge">Fase 2</p><h1>Data Kriteria</h1></div><a class="button" href="{{ route('admin.kriterias.create') }}">Tambah Kriteria</a></div>
        @if (session('success')) <div class="notice">{{ session('success') }}</div> @endif
        <form class="toolbar" method="GET"><input name="q" value="{{ $search }}" placeholder="Cari kriteria" style="min-height:42px;min-width:280px;padding:0 12px;"><button class="button secondary">Cari</button></form>
        <div class="table-wrap"><table><thead><tr><th>Nama</th><th>Tipe Data</th><th>Keterangan</th><th>Aksi</th></tr></thead><tbody>
        @forelse($kriterias as $kriteria)
            <tr><td>{{ $kriteria->nama_kriteria }}</td><td>{{ ucfirst($kriteria->tipe_data) }}</td><td>{{ $kriteria->keterangan ?: '-' }}</td><td><div class="inline-actions"><a class="button secondary" href="{{ route('admin.kriterias.edit', $kriteria) }}">Ubah</a><form method="POST" action="{{ route('admin.kriterias.destroy', $kriteria) }}" onsubmit="return confirm('Hapus kriteria ini?')">@csrf @method('DELETE')<button class="button danger">Hapus</button></form></div></td></tr>
        @empty <tr><td colspan="4" class="muted">Belum ada data kriteria.</td></tr> @endforelse
        </tbody></table></div><div style="margin-top:20px">{{ $kriterias->links() }}</div>
    </div></section>
@endsection

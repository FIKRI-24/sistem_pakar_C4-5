@extends('layouts.app', ['title' => 'Data Karir'])

@section('content')
    <section class="panel"><div class="panel-body">
        <div class="toolbar"><div><p class="role-badge">Fase 2</p><h1>Data Alternatif Karir</h1></div><a class="button" href="{{ route('admin.karirs.create') }}">Tambah Karir</a></div>
        @if (session('success')) <div class="notice">{{ session('success') }}</div> @endif
        <form class="toolbar" method="GET"><input name="q" value="{{ $search }}" placeholder="Cari karir atau bidang" style="min-height:42px;min-width:280px;padding:0 12px;"><button class="button secondary">Cari</button></form>
        <div class="table-wrap"><table><thead><tr><th>Nama</th><th>Bidang</th><th>Deskripsi</th><th>Aksi</th></tr></thead><tbody>
        @forelse($karirs as $karir)
            <tr><td>{{ $karir->nama_karir }}</td><td>{{ $karir->bidang_pekerjaan ?: '-' }}</td><td>{{ \Illuminate\Support\Str::limit($karir->deskripsi, 100) ?: '-' }}</td><td><div class="inline-actions"><a class="button secondary" href="{{ route('admin.karirs.edit', $karir) }}">Ubah</a><form method="POST" action="{{ route('admin.karirs.destroy', $karir) }}" onsubmit="return confirm('Hapus karir ini?')">@csrf @method('DELETE')<button class="button danger">Hapus</button></form></div></td></tr>
        @empty <tr><td colspan="4" class="muted">Belum ada data karir.</td></tr> @endforelse
        </tbody></table></div><div style="margin-top:20px">{{ $karirs->links() }}</div>
    </div></section>
@endsection

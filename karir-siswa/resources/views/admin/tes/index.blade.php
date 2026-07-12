@extends('layouts.app', ['title' => 'Data Tes'])

@section('content')
    <section class="panel"><div class="panel-body">
        <div class="toolbar"><div><p class="role-badge">Fase 2</p><h1>Data Tes</h1></div><a class="button" href="{{ route('admin.tes.buat-lengkap') }}">Tambah Tes</a></div>
        @if (session('success')) <div class="notice">{{ session('success') }}</div> @endif
        <form class="toolbar" method="GET"><input name="q" value="{{ $search }}" placeholder="Cari nama atau deskripsi tes" style="min-height:42px;min-width:280px;padding:0 12px;"><button class="button secondary">Cari</button></form>
        <div class="table-wrap"><table><thead><tr><th>Nama</th><th>Durasi</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
        @forelse ($tes as $te)
            <tr><td>{{ $te->nama_tes }}<br><span class="muted">{{ \Illuminate\Support\Str::limit($te->deskripsi, 80) }}</span></td><td>{{ $te->durasi_menit ? $te->durasi_menit.' menit' : '-' }}</td><td>{{ $te->status_aktif ? 'Aktif' : 'Tidak aktif' }}</td><td><div class="inline-actions"><a class="button secondary" href="{{ route('admin.tes.edit', $te) }}">Ubah</a><form method="POST" action="{{ route('admin.tes.destroy', $te) }}" onsubmit="return confirm('Hapus tes ini?')">@csrf @method('DELETE')<button class="button danger">Hapus</button></form></div></td></tr>
        @empty <tr><td colspan="4" class="muted">Belum ada data tes.</td></tr> @endforelse
        </tbody></table></div><div style="margin-top:20px">{{ $tes->links() }}</div>
    </div></section>
@endsection

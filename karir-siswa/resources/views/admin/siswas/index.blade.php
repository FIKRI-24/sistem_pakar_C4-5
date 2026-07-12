@extends('layouts.app', ['title' => 'Data Siswa'])

@section('content')
    <section class="panel"><div class="panel-body">
        <div class="toolbar">
            <div><p class="role-badge">Fase 2</p><h1>Data Siswa</h1></div>
            <a class="button" href="{{ route('admin.siswas.create') }}">Tambah Siswa</a>
        </div>
        @if (session('success')) <div class="notice">{{ session('success') }}</div> @endif
        <form class="toolbar" method="GET">
            <input name="q" value="{{ $search }}" placeholder="Cari nama, NIS, kelas, atau jurusan" style="min-height:42px;min-width:280px;padding:0 12px;">
            <button class="button secondary" type="submit">Cari</button>
        </form>
        <div class="table-wrap"><table>
            <thead><tr><th>NIS</th><th>Nama/Akun</th><th>Kelas</th><th>Jurusan</th><th>Aksi</th></tr></thead>
            <tbody>
            @forelse ($siswas as $siswa)
                <tr><td>{{ $siswa->nis }}</td><td>{{ $siswa->user->name }}<br><span class="muted">{{ $siswa->user->username }}{{ $siswa->user->email ? ' · '.$siswa->user->email : '' }}</span></td><td>{{ $siswa->kelas }}</td><td>{{ $siswa->jurusan }}</td>
                    <td><div class="inline-actions"><a class="button secondary" href="{{ route('admin.siswas.edit', $siswa) }}">Ubah</a>
                        <form method="POST" action="{{ route('admin.siswas.destroy', $siswa) }}" onsubmit="return confirm('Hapus siswa ini?')">@csrf @method('DELETE')<button class="button danger" type="submit">Hapus</button></form></div></td></tr>
            @empty
                <tr><td colspan="5" class="muted">Belum ada data siswa.</td></tr>
            @endforelse
            </tbody>
        </table></div>
        <div style="margin-top:20px">{{ $siswas->links() }}</div>
    </div></section>
@endsection

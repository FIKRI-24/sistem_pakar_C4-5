@extends('layouts.app', ['title' => 'Pilihan Jawaban'])

@section('content')
    <style>
        /* Pagination Laravel uses Tailwind classes, while this layout uses local CSS. */
        .pilihan-jawaban-pagination svg {
            display: block;
            width: 20px;
            height: 20px;
        }
    </style>

    <section class="panel"><div class="panel-body"><div class="toolbar"><div><p class="role-badge">Fase 2</p><h1>Pilihan Jawaban</h1></div><a class="button" href="{{ route('admin.pilihan-jawabans.create') }}">Tambah Pilihan</a></div>
        @if (session('success')) <div class="notice">{{ session('success') }}</div> @endif
        <form class="toolbar" method="GET"><input name="q" value="{{ $search }}" placeholder="Cari pilihan atau pertanyaan" style="min-height:42px;min-width:280px;padding:0 12px;"><button class="button secondary">Cari</button></form>
        <div class="table-wrap"><table><thead><tr><th>Pertanyaan</th><th>Pilihan</th><th>Skor</th><th>Opsi Kriteria</th><th>Aksi</th></tr></thead><tbody>@forelse($pilihanJawabans as $jawaban)<tr><td>{{ \Illuminate\Support\Str::limit($jawaban->soal->pertanyaan, 65) }}<br><span class="muted">{{ $jawaban->soal->kriteria->nama_kriteria }}</span></td><td>{{ $jawaban->pilihan }}</td><td>{{ $jawaban->skor }}</td><td>{{ $jawaban->kriteriaOpsi?->label ?: '-' }}</td><td><div class="inline-actions"><a class="button secondary" href="{{ route('admin.pilihan-jawabans.edit', $jawaban) }}">Ubah</a><form method="POST" action="{{ route('admin.pilihan-jawabans.destroy', $jawaban) }}" onsubmit="return confirm('Hapus pilihan ini?')">@csrf @method('DELETE')<button class="button danger">Hapus</button></form></div></td></tr>@empty<tr><td colspan="5" class="muted">Belum ada pilihan jawaban.</td></tr>@endforelse</tbody></table></div><div class="pilihan-jawaban-pagination" style="margin-top:20px">{{ $pilihanJawabans->links() }}</div>
    </div></section>
@endsection

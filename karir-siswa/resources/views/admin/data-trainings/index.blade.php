@extends('layouts.app', ['title' => 'Data Training'])

@section('content')
    <style>
        /* Pagination Laravel uses Tailwind classes, while this layout uses local CSS. */
        .data-training-pagination svg {
            display: block;
            width: 20px;
            height: 20px;
        }
    </style>

    <section class="panel"><div class="panel-body"><div class="toolbar"><div><p class="role-badge">Fase 2</p><h1>Data Training C4.5</h1></div><div class="inline-actions"><a class="button secondary" href="{{ route('admin.data-trainings.import.form') }}">Import CSV/Excel</a><a class="button" href="{{ route('admin.data-trainings.create') }}">Tambah Data</a></div></div>
        @if (session('success')) <div class="notice">{{ session('success') }}</div> @endif
        <form class="toolbar" method="GET"><input name="q" value="{{ $search }}" placeholder="Cari sumber atau karir" style="min-height:42px;min-width:280px;padding:0 12px;"><button class="button secondary">Cari</button></form>
        <div class="table-wrap"><table><thead><tr><th>Karir</th><th>Atribut</th><th>Sumber</th><th>Aksi</th></tr></thead><tbody>@forelse($dataTrainings as $training)<tr><td>{{ $training->labelKarir->nama_karir }}</td><td>@foreach($training->atributs as $atribut)<div><span class="muted">{{ $atribut->kriteria->nama_kriteria }}:</span> {{ $atribut->nilai_kategorik ?? $atribut->nilai_numerik }}</div>@endforeach</td><td>{{ $training->sumber ?: '-' }}</td><td><div class="inline-actions"><a class="button secondary" href="{{ route('admin.data-trainings.edit', $training) }}">Ubah</a><form method="POST" action="{{ route('admin.data-trainings.destroy', $training) }}" onsubmit="return confirm('Hapus data training ini?')">@csrf @method('DELETE')<button class="button danger">Hapus</button></form></div></td></tr>@empty<tr><td colspan="4" class="muted">Belum ada data training.</td></tr>@endforelse</tbody></table></div><div class="data-training-pagination" style="margin-top:20px">{{ $dataTrainings->links() }}</div>
    </div></section>
@endsection

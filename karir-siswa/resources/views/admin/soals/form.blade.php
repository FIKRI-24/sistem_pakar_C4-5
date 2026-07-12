@extends('layouts.app', ['title' => $soal->exists ? 'Ubah Soal' : 'Tambah Soal'])

@section('content')
    <section class="panel" style="max-width:760px;margin:auto"><div class="panel-body"><p class="role-badge">Data Soal</p><h1>{{ $soal->exists ? 'Ubah Soal' : 'Tambah Soal' }}</h1>
        <form method="POST" action="{{ $soal->exists ? route('admin.soals.update', $soal) : route('admin.soals.store') }}">@csrf @if($soal->exists) @method('PUT') @endif
            <div class="field"><label for="tes_id">Tes</label><select id="tes_id" name="tes_id" required><option value="">Pilih tes</option>@foreach($tests as $te)<option value="{{ $te->id }}" @selected((string) old('tes_id', $soal->tes_id) === (string) $te->id)>{{ $te->nama_tes }}</option>@endforeach</select>@error('tes_id')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="kriteria_id">Kriteria</label><select id="kriteria_id" name="kriteria_id" required><option value="">Pilih kriteria</option>@foreach($kriterias as $kriteria)<option value="{{ $kriteria->id }}" @selected((string) old('kriteria_id', $soal->kriteria_id) === (string) $kriteria->id)>{{ $kriteria->nama_kriteria }}</option>@endforeach</select>@error('kriteria_id')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="urutan">Urutan</label><input id="urutan" name="urutan" type="number" min="1" value="{{ old('urutan', $soal->urutan) }}">@error('urutan')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="pertanyaan">Pertanyaan</label><textarea id="pertanyaan" name="pertanyaan" required>{{ old('pertanyaan', $soal->pertanyaan) }}</textarea>@error('pertanyaan')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="inline-actions"><button class="button">Simpan</button><a class="button secondary" href="{{ route('admin.soals.index') }}">Batal</a></div>
        </form>
    </div></section>
@endsection

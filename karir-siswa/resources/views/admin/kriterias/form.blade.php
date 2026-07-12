@extends('layouts.app', ['title' => $kriteria->exists ? 'Ubah Kriteria' : 'Tambah Kriteria'])

@section('content')
    <section class="panel" style="max-width:760px;margin:auto"><div class="panel-body">
        <p class="role-badge">Data Kriteria</p><h1>{{ $kriteria->exists ? 'Ubah Kriteria' : 'Tambah Kriteria' }}</h1>
        <form method="POST" action="{{ $kriteria->exists ? route('admin.kriterias.update', $kriteria) : route('admin.kriterias.store') }}">@csrf @if($kriteria->exists) @method('PUT') @endif
            <div class="field"><label for="nama_kriteria">Nama kriteria</label><input id="nama_kriteria" name="nama_kriteria" value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" required>@error('nama_kriteria')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="tipe_data">Tipe data</label><select id="tipe_data" name="tipe_data" required>@foreach(\App\Models\Kriteria::TYPES as $type)<option value="{{ $type }}" @selected(old('tipe_data', $kriteria->tipe_data) === $type)>{{ ucfirst($type) }}</option>@endforeach</select>@error('tipe_data')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="keterangan">Keterangan</label><textarea id="keterangan" name="keterangan">{{ old('keterangan', $kriteria->keterangan) }}</textarea>@error('keterangan')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="inline-actions"><button class="button">Simpan</button><a class="button secondary" href="{{ route('admin.kriterias.index') }}">Batal</a></div>
        </form>
    </div></section>
@endsection

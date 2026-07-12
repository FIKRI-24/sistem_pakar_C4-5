@extends('layouts.app', ['title' => $karir->exists ? 'Ubah Karir' : 'Tambah Karir'])

@section('content')
    <section class="panel" style="max-width:760px;margin:auto"><div class="panel-body">
        <p class="role-badge">Alternatif Karir</p><h1>{{ $karir->exists ? 'Ubah Karir' : 'Tambah Karir' }}</h1>
        <form method="POST" action="{{ $karir->exists ? route('admin.karirs.update', $karir) : route('admin.karirs.store') }}">@csrf @if($karir->exists) @method('PUT') @endif
            <div class="field"><label for="nama_karir">Nama karir</label><input id="nama_karir" name="nama_karir" value="{{ old('nama_karir', $karir->nama_karir) }}" required>@error('nama_karir')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="bidang_pekerjaan">Bidang pekerjaan</label><input id="bidang_pekerjaan" name="bidang_pekerjaan" value="{{ old('bidang_pekerjaan', $karir->bidang_pekerjaan) }}">@error('bidang_pekerjaan')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="deskripsi">Deskripsi</label><textarea id="deskripsi" name="deskripsi">{{ old('deskripsi', $karir->deskripsi) }}</textarea>@error('deskripsi')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="informasi_pendukung">Informasi pendukung</label><textarea id="informasi_pendukung" name="informasi_pendukung">{{ old('informasi_pendukung', $karir->informasi_pendukung) }}</textarea>@error('informasi_pendukung')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="inline-actions"><button class="button">Simpan</button><a class="button secondary" href="{{ route('admin.karirs.index') }}">Batal</a></div>
        </form>
    </div></section>
@endsection

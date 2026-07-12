@extends('layouts.app', ['title' => $tes->exists ? 'Ubah Tes' : 'Tambah Tes'])

@section('content')
    <section class="panel" style="max-width:760px;margin:auto"><div class="panel-body"><p class="role-badge">Data Tes</p><h1>{{ $tes->exists ? 'Ubah Tes' : 'Tambah Tes' }}</h1>
        <form method="POST" action="{{ $tes->exists ? route('admin.tes.update', $tes) : route('admin.tes.store') }}">@csrf @if($tes->exists) @method('PUT') @endif
            <div class="field"><label for="nama_tes">Nama tes</label><input id="nama_tes" name="nama_tes" value="{{ old('nama_tes', $tes->nama_tes) }}" required>@error('nama_tes')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="deskripsi">Deskripsi</label><textarea id="deskripsi" name="deskripsi">{{ old('deskripsi', $tes->deskripsi) }}</textarea>@error('deskripsi')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="durasi_menit">Durasi (menit)</label><input id="durasi_menit" name="durasi_menit" type="number" min="1" value="{{ old('durasi_menit', $tes->durasi_menit) }}">@error('durasi_menit')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="status_aktif">Status</label><select id="status_aktif" name="status_aktif"><option value="1" @selected((string) old('status_aktif', (int) $tes->status_aktif) === '1')>Aktif</option><option value="0" @selected((string) old('status_aktif', (int) $tes->status_aktif) === '0')>Tidak aktif</option></select>@error('status_aktif')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="inline-actions"><button class="button">Simpan</button><a class="button secondary" href="{{ route('admin.tes.index') }}">Batal</a></div>
        </form>
    </div></section>
@endsection

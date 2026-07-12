@extends('layouts.app', ['title' => $siswa->exists ? 'Ubah Siswa' : 'Tambah Siswa'])

@section('content')
    <section class="panel" style="max-width:760px;margin:auto"><div class="panel-body">
        <p class="role-badge">Data Siswa</p><h1>{{ $siswa->exists ? 'Ubah Siswa' : 'Tambah Siswa' }}</h1>
        <form method="POST" action="{{ $siswa->exists ? route('admin.siswas.update', $siswa) : route('admin.siswas.store') }}">
            @csrf @if($siswa->exists) @method('PUT') @endif
            @php($user = $siswa->user)
            <div class="field"><label for="name">Nama</label><input id="name" name="name" value="{{ old('name', $user?->name) }}" required>@error('name')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="username">Username</label><input id="username" name="username" value="{{ old('username', $user?->username) }}" required>@error('username')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="nis">NIS</label><input id="nis" name="nis" value="{{ old('nis', $siswa->nis) }}" required>@error('nis')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="kelas">Kelas</label><input id="kelas" name="kelas" value="{{ old('kelas', $siswa->kelas) }}" required>@error('kelas')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="jurusan">Jurusan</label><input id="jurusan" name="jurusan" value="{{ old('jurusan', $siswa->jurusan) }}" required>@error('jurusan')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="email">Email akun (opsional)</label><input id="email" name="email" type="email" value="{{ old('email', $user?->email) }}">@error('email')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="password">Password {{ $siswa->exists ? '(kosongkan jika tidak diubah)' : '' }}</label><input id="password" name="password" type="password" {{ $siswa->exists ? '' : 'required' }}>@error('password')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="inline-actions"><button class="button" type="submit">Simpan</button><a class="button secondary" href="{{ route('admin.siswas.index') }}">Batal</a></div>
        </form>
    </div></section>
@endsection

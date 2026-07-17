@extends('layouts.app', ['title' => 'Biodata Saya'])

@section('content')
    <section class="panel" style="max-width:760px;margin:auto">
        <div class="panel-body">
            <p class="role-badge">Biodata Siswa</p>
            <h1>Lengkapi Biodata Anda</h1>
            <p class="muted" style="margin-bottom: 24px;">Silakan lengkapi data diri Anda sebelum mulai mengerjakan kuesioner minat dan bakat.</p>

            @if (session('error'))
                <div class="notice" style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; border-radius:8px; padding:16px 20px; margin-bottom:24px;">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="notice" style="background:#fffbeb; border:1px solid #fef3c7; color:#92400e; border-radius:8px; padding:16px 20px; margin-bottom:24px;">
                    {{ session('warning') }}
                </div>
            @endif

            <form method="POST" action="{{ route('siswa.biodata.update') }}">
                @csrf
                @php($user = auth()->user())

                <div class="field">
                    <label for="name">Nama Lengkap</label>
                    <input id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label for="nis">NIS (Nomor Induk Siswa)</label>
                    <input id="nis" name="nis" value="{{ old('nis', $siswa->nis) }}" required>
                    @error('nis')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label for="kelas">Kelas</label>
                    <input id="kelas" name="kelas" value="{{ old('kelas', $siswa->kelas) }}" required placeholder="Contoh: XII TKJ 1">
                    @error('kelas')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label for="jurusan">Jurusan</label>
                    <input id="jurusan" name="jurusan" value="{{ old('jurusan', $siswa->jurusan) }}" required placeholder="Contoh: Teknik Komputer dan Jaringan">
                    @error('jurusan')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="field">
                    <label for="jenis_kelamin">Jenis Kelamin</label>
                    <select id="jenis_kelamin" name="jenis_kelamin" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="L" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="inline-actions" style="margin-top: 24px;">
                    <button class="button" type="submit">Simpan Biodata</button>
                    <a class="button secondary" href="{{ route('siswa.dashboard') }}">Batal</a>
                </div>
            </form>
        </div>
    </section>
@endsection

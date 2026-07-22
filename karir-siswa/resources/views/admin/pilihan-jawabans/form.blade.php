@extends('layouts.app', ['title' => $pilihanJawaban->exists ? 'Ubah Pilihan Jawaban' : 'Tambah Pilihan Jawaban'])

@section('content')
    <section class="panel" style="max-width:760px;margin:auto"><div class="panel-body"><p class="role-badge">Pilihan Jawaban</p><h1>{{ $pilihanJawaban->exists ? 'Ubah Pilihan Jawaban' : 'Tambah Pilihan Jawaban' }}</h1>
        <p class="muted">Skor wajib memakai skala Likert 1-5. Opsi kategori hanya dipilih jika sesuai dengan kriteria pertanyaan.</p>
        <form method="POST" action="{{ $pilihanJawaban->exists ? route('admin.pilihan-jawabans.update', $pilihanJawaban) : route('admin.pilihan-jawabans.store') }}">@csrf @if($pilihanJawaban->exists) @method('PUT') @endif
            <div class="field"><label for="soal_id">Pertanyaan</label><select id="soal_id" name="soal_id" required><option value="">Pilih pertanyaan</option>@foreach($soals as $soal)<option value="{{ $soal->id }}" @selected((string) old('soal_id', $pilihanJawaban->soal_id) === (string) $soal->id)>{{ $soal->tes->nama_tes }} — {{ $soal->kriteria->nama_kriteria }} — {{ \Illuminate\Support\Str::limit($soal->pertanyaan, 55) }}</option>@endforeach</select>@error('soal_id')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="pilihan">Teks pilihan</label><input id="pilihan" name="pilihan" value="{{ old('pilihan', $pilihanJawaban->pilihan) }}" required>@error('pilihan')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="skor">Skor Likert</label><select id="skor" name="skor" required>@for($score = 1; $score <= 5; $score++)<option value="{{ $score }}" @selected((string) old('skor', $pilihanJawaban->skor) === (string) $score)>{{ $score }}</option>@endfor</select>@error('skor')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="kriteria_opsi_id">Opsi kategori (opsional)</label><select id="kriteria_opsi_id" name="kriteria_opsi_id"><option value="">Tidak ada</option>@foreach($opsiKriteria as $opsi)<option value="{{ $opsi->id }}" @selected((string) old('kriteria_opsi_id', $pilihanJawaban->kriteria_opsi_id) === (string) $opsi->id)>{{ $opsi->kriteria->nama_kriteria }} — {{ $opsi->label }}</option>@endforeach</select>@error('kriteria_opsi_id')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="inline-actions"><button class="button">Simpan</button><a class="button secondary" href="{{ route('admin.pilihan-jawabans.index') }}">Batal</a></div>
        </form>
    </div></section>
@endsection

@extends('layouts.app', ['title' => $dataTraining->exists ? 'Ubah Data Training' : 'Tambah Data Training'])

@section('content')
    <section class="panel" style="max-width:760px;margin:auto"><div class="panel-body"><p class="role-badge">Data Training</p><h1>{{ $dataTraining->exists ? 'Ubah Data Training' : 'Tambah Data Training' }}</h1>
        <form method="POST" action="{{ $dataTraining->exists ? route('admin.data-trainings.update', $dataTraining) : route('admin.data-trainings.store') }}">@csrf @if($dataTraining->exists) @method('PUT') @endif
            <div class="field"><label for="label_karir_id">Label karir</label><select id="label_karir_id" name="label_karir_id" required><option value="">Pilih karir</option>@foreach($karirs as $karir)<option value="{{ $karir->id }}" @selected((string) old('label_karir_id', $dataTraining->label_karir_id) === (string) $karir->id)>{{ $karir->nama_karir }}</option>@endforeach</select>@error('label_karir_id')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="field"><label for="sumber">Sumber</label><input id="sumber" name="sumber" value="{{ old('sumber', $dataTraining->sumber) }}" placeholder="Contoh: wawancara 2024">@error('sumber')<div class="error">{{ $message }}</div>@enderror</div>
            @php($existing = $dataTraining->atributs->keyBy('kriteria_id'))
            @foreach($kriterias as $kriteria)
                <div class="field"><label for="atribut_{{ $kriteria->id }}">{{ $kriteria->nama_kriteria }}</label>
                    @if($kriteria->tipe_data === \App\Models\Kriteria::TYPE_KATEGORIK)
                        <select id="atribut_{{ $kriteria->id }}" name="atributs[{{ $kriteria->id }}][nilai_kategorik]" required><option value="">Pilih nilai</option>@foreach($kriteria->opsis as $opsi)<option value="{{ $opsi->label }}" @selected(old("atributs.{$kriteria->id}.nilai_kategorik", $existing->get($kriteria->id)?->nilai_kategorik) === $opsi->label)>{{ $opsi->label }}</option>@endforeach</select>
                        @error("atributs.{$kriteria->id}.nilai_kategorik")<div class="error">{{ $message }}</div>@enderror
                    @else
                        <input id="atribut_{{ $kriteria->id }}" type="number" name="atributs[{{ $kriteria->id }}][nilai_numerik]" min="0" max="100" step="0.01" value="{{ old("atributs.{$kriteria->id}.nilai_numerik", $existing->get($kriteria->id)?->nilai_numerik) }}" required>
                        @error("atributs.{$kriteria->id}.nilai_numerik")<div class="error">{{ $message }}</div>@enderror
                    @endif
                </div>
            @endforeach
            <div class="inline-actions"><button class="button">Simpan</button><a class="button secondary" href="{{ route('admin.data-trainings.index') }}">Batal</a></div>
        </form>
    </div></section>
@endsection

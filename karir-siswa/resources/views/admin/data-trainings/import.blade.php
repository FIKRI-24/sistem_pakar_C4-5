@extends('layouts.app', ['title' => 'Import Data Training'])

@section('content')
    <section class="panel" style="max-width:760px;margin:auto"><div class="panel-body"><p class="role-badge">Data Training</p><h1>Import CSV atau Excel</h1>
        <p class="muted">Kolom wajib: <code>label_karir,minat,bakat,nilai_akademik,kepribadian</code>. Kolom <code>sumber</code> opsional. Nilai kategori harus persis mengikuti opsi final.</p>
        <p class="muted">Contoh header: <code>sumber,label_karir,minat,bakat,nilai_akademik,kepribadian</code></p>
        <p class="muted">Contoh data: <code>Data awal representatif,Analis/Peneliti,Investigative,Numerik/Logika,88,Compliance</code></p>
        <form method="POST" enctype="multipart/form-data" action="{{ route('admin.data-trainings.import') }}">@csrf
            <div class="field"><label for="file">File CSV/XLS/XLSX (maks. 5 MB)</label><input id="file" name="file" type="file" accept=".csv,.txt,.xls,.xlsx" required>@error('file')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="inline-actions"><button class="button">Import</button><a class="button secondary" href="{{ route('admin.data-trainings.index') }}">Batal</a></div>
        </form>
    </div></section>
@endsection

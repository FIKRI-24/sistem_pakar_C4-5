@extends('layouts.app', ['title' => 'Hasil Tes'])

@section('content')
    <section class="panel" style="max-width:800px;margin:auto"><div class="panel-body"><p class="role-badge">Hasil Tes</p><h1>{{ $hasilTes->tes->nama_tes }}</h1><p class="muted">Dikerjakan pada {{ $hasilTes->tanggal_tes->format('d-m-Y H:i') }}</p>
        @if(session('success'))<div class="notice">{{ session('success') }}</div>@endif
        <h2>Ringkasan Nilai</h2><div class="table-wrap"><table><thead><tr><th>Kriteria</th><th>Nilai</th></tr></thead><tbody>@foreach($hasilTes->details as $detail)<tr><td>{{ $detail->kriteria->nama_kriteria }}</td><td>{{ $detail->nilai_kategorik ?? number_format($detail->nilai_numerik, 2, ',', '.') }}</td></tr>@endforeach</tbody></table></div>
        @if($hasilTes->rekomendasis->isNotEmpty())<h2>Rekomendasi Karir</h2>@foreach($hasilTes->rekomendasis as $rekomendasi)<p><strong>{{ $rekomendasi->karir->nama_karir }}</strong> ({{ number_format($rekomendasi->persen_kecocokan, 2, ',', '.') }}%)<br>{{ $rekomendasi->alasan }}</p>@endforeach@else<p class="muted" style="margin-top:24px">Rekomendasi C4.5 akan muncul setelah Fase 4 diaktifkan.</p>@endif
        <a class="button secondary" href="{{ route('siswa.hasil-tes.index') }}">Kembali</a>
    </div></section>
@endsection

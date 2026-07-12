@extends('layouts.app', ['title' => 'Status Service C4.5'])

@section('content')
    <section class="panel" style="max-width: 760px; margin: 0 auto;">
        <div class="panel-body">
            <p class="role-badge" style="{{ $isHealthy ? '' : 'color: #991b1b; background: #fee2e2;' }}">
                {{ $isHealthy ? 'Terhubung' : 'Tidak terhubung' }}
            </p>
            <h1 style="margin: 16px 0 8px; font-size: clamp(2rem, 4vw, 2.6rem); line-height: 1.05;">
                Status Service C4.5
            </h1>
            <p class="muted" style="margin: 0 0 24px;">{{ $message }}</p>

            <dl style="display: grid; grid-template-columns: minmax(130px, 0.35fr) 1fr; gap: 10px 18px; margin: 0 0 28px;">
                <dt class="muted">Endpoint</dt>
                <dd style="margin: 0; overflow-wrap: anywhere;"><code>{{ $endpoint }}</code></dd>

                <dt class="muted">Waktu respons</dt>
                <dd style="margin: 0;">{{ number_format($responseTimeMs, 1, ',', '.') }} ms</dd>

                <dt class="muted">Diperiksa pada</dt>
                <dd style="margin: 0;">{{ $checkedAt->format('d-m-Y H:i:s') }}</dd>

                @if ($service)
                    <dt class="muted">Service</dt>
                    <dd style="margin: 0;">{{ $service }}</dd>
                @endif

                @if ($version)
                    <dt class="muted">Versi</dt>
                    <dd style="margin: 0;">{{ $version }}</dd>
                @endif

                @if ($environment)
                    <dt class="muted">Environment</dt>
                    <dd style="margin: 0;">{{ $environment }}</dd>
                @endif
            </dl>

            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                <a class="button" href="{{ route('admin.c45.status') }}">Periksa Lagi</a>
                <a class="button secondary" href="{{ route('admin.dashboard') }}">Kembali ke Dashboard</a>
            </div>
        </div>
    </section>
@endsection

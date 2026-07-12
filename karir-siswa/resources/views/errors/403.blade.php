@extends('layouts.app', ['title' => 'Akses Ditolak'])

@section('content')
    <section class="panel" style="max-width: 640px; margin: 0 auto;">
        <div class="panel-body">
            <p class="role-badge">403</p>
            <h1 style="margin: 16px 0 8px; font-size: 2rem; line-height: 1.15;">Akses Ditolak</h1>
            <p class="muted" style="margin: 0 0 24px;">Akun Anda tidak memiliki hak akses untuk membuka halaman ini.</p>
            @auth
                <a class="button" href="{{ route('dashboard') }}">Kembali ke Dashboard</a>
            @else
                <a class="button" href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </section>
@endsection

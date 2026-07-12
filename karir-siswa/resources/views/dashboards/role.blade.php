@extends('layouts.app', ['title' => $title])

@section('content')
    <div style="display: flex; flex-direction: column; gap: 28px;">
        <section class="panel" style="background: linear-gradient(135deg, #0d9488, #0f766e); border: none; box-shadow: 0 10px 25px -5px rgba(15, 118, 110, 0.25);">
            <div class="panel-body" style="padding: 32px 36px; color: #ffffff;">
                <p class="role-badge" style="margin-bottom: 12px; background: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.25); color: #ffffff;">
                    {{ $roleLabel }}
                </p>
                <h1 style="margin: 0 0 10px; font-size: 1.9rem; font-weight: 800; letter-spacing: -0.025em; color: #ffffff;">{{ $title }}</h1>
                <p style="max-width: 720px; margin: 0 0 24px; font-size: 1.05rem; line-height: 1.6; color: #ccfbf1;">{{ $description }}</p>

                <div style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 10px; padding: 18px 22px; max-width: 720px;">
                    <h4 style="margin: 0 0 10px; color: #ffffff; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Panduan / Fitur Utama:</h4>
                    <ul class="clean" style="margin: 0; padding-left: 20px; font-size: 0.95rem; color: #f0fdfa;">
                        @foreach ($items as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>

        @if ($links)
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 750; color: #1e293b; margin: 0 0 16px; letter-spacing: -0.025em;">Menu Akses Cepat</h2>
                <div class="dashboard-grid">
                    @foreach ($links as $link)
                        <a class="dashboard-card" href="{{ route($link['route']) }}">
                            <div class="card-icon">
                                @if(str_contains($link['route'], 'siswa'))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                @elseif(str_contains($link['route'], 'kriteria'))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="6" height="6" rx="1"/><path d="m3 17 2 2 4-4"/><path d="M13 6h8"/><path d="M13 12h8"/><path d="M13 18h8"/><rect x="3" y="11" width="6" height="6" rx="1"/></svg>
                                @elseif(str_contains($link['route'], 'karir'))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
                                @elseif(str_contains($link['route'], 'tes') || str_contains($link['route'], 'konsultasi'))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
                                @elseif(str_contains($link['route'], 'soal'))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                                @elseif(str_contains($link['route'], 'pilihan-jawaban'))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 11 3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                                @elseif(str_contains($link['route'], 'training'))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 21 19V5"/><path d="M3 12A9 3 0 0 0 21 12"/></svg>
                                @elseif(str_contains($link['route'], 'c45'))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" x2="21" y1="14" y2="3"/></svg>
                                @endif
                            </div>
                            <div class="card-details">
                                <h3>{{ $link['label'] }}</h3>
                                <p>Akses modul {{ strtolower($link['label']) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection

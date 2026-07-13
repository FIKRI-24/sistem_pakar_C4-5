@extends('layouts.app', ['title' => $title])

@php
    $showStatsDashboard = auth()->user()->isRole(\App\Models\User::ROLE_ADMIN) || auth()->user()->isRole(\App\Models\User::ROLE_GURU_BK);
    if ($showStatsDashboard) {
        $totalPie = ($minatCount ?? 0) + ($bakatCount ?? 0) + ($kepribadianCount ?? 0) + ($kecocokanCount ?? 0);
        $totalPie = $totalPie > 0 ? $totalPie : 1;
        $minatPct = round((($minatCount ?? 30) / $totalPie) * 100);
        $bakatPct = round((($bakatCount ?? 20) / $totalPie) * 100);
        $kepribadianPct = round((($kepribadianCount ?? 18) / $totalPie) * 100);
        $kecocokanPct = 100 - $minatPct - $bakatPct - $kepribadianPct;
        if ($kecocokanPct < 0) $kecocokanPct = 0;
    }
@endphp

@section('content')
    @if ($showStatsDashboard)
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Welcome Section -->
            <div style="margin-bottom: 8px;">
                <h1 style="margin: 0 0 6px; font-size: 1.6rem; font-weight: 800; letter-spacing: -0.025em; color: #0f172a;">Selamat datang, {{ $roleLabel }}</h1>
                <p style="margin: 0; font-size: 0.95rem; color: #64748b;">Berikut adalah ringkasan data bimbingan dan konseling.</p>
            </div>

            <!-- KPI Cards Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
                <!-- Total Siswa -->
                <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:20px; display:flex; align-items:center; gap:16px; box-shadow:0 1px 3px rgba(0,0,0,0.02);">
                    <div style="width:48px; height:48px; border-radius:10px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; color:#475569; flex-shrink:0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div>
                        <span style="font-size:0.8rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.025em; display:block;">Total Siswa</span>
                        <strong style="font-size:1.6rem; font-weight:800; color:#0f172a; display:block; line-height:1.2; margin:2px 0;">{{ $totalSiswa }}</strong>
                        <span style="font-size:0.75rem; color:#94a3b8;">Siswa terdaftar</span>
                    </div>
                </div>

                <!-- Tes Dilakukan -->
                <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:20px; display:flex; align-items:center; gap:16px; box-shadow:0 1px 3px rgba(0,0,0,0.02);">
                    <div style="width:48px; height:48px; border-radius:10px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; color:#475569; flex-shrink:0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
                    </div>
                    <div>
                        <span style="font-size:0.8rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.025em; display:block;">Tes Dilakukan</span>
                        <strong style="font-size:1.6rem; font-weight:800; color:#0f172a; display:block; line-height:1.2; margin:2px 0;">{{ $tesDilakukan }}</strong>
                        <span style="font-size:0.75rem; color:#94a3b8;">Tes selesai</span>
                    </div>
                </div>

                <!-- Hasil Tes -->
                <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:20px; display:flex; align-items:center; gap:16px; box-shadow:0 1px 3px rgba(0,0,0,0.02);">
                    <div style="width:48px; height:48px; border-radius:10px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; color:#475569; flex-shrink:0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
                    </div>
                    <div>
                        <span style="font-size:0.8rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.025em; display:block;">Hasil Tes</span>
                        <strong style="font-size:1.6rem; font-weight:800; color:#0f172a; display:block; line-height:1.2; margin:2px 0;">{{ $hasilTesCount }}</strong>
                        <span style="font-size:0.75rem; color:#94a3b8;">Hasil tersedia</span>
                    </div>
                </div>

                <!-- Rekomendasi -->
                <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:20px; display:flex; align-items:center; gap:16px; box-shadow:0 1px 3px rgba(0,0,0,0.02);">
                    <div style="width:48px; height:48px; border-radius:10px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; color:#475569; flex-shrink:0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <div>
                        <span style="font-size:0.8rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.025em; display:block;">Rekomendasi</span>
                        <strong style="font-size:1.6rem; font-weight:800; color:#0f172a; display:block; line-height:1.2; margin:2px 0;">{{ $rekomendasiCount }}</strong>
                        <span style="font-size:0.75rem; color:#94a3b8;">Sudah diberikan</span>
                    </div>
                </div>
            </div>

            <!-- Dashboard Analytics Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 20px; align-items: stretch;">
                <!-- Tes per Kategori -->
                <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.02); display:flex; flex-direction:column;">
                    <h3 style="margin: 0 0 24px; font-size: 1.1rem; font-weight: 800; color: #1e293b;">Tes per Kategori</h3>
                    <div style="display:flex; align-items:center; justify-content:center; gap:36px; flex-wrap:wrap; flex:1;">
                        <!-- Pie Donut Chart -->
                        <div style="position: relative; width: 170px; height: 170px; border-radius: 50%; background: conic-gradient(#0f766e 0% {{ $minatPct }}%, #0ea5e9 {{ $minatPct }}% {{ $minatPct + $bakatPct }}%, #f59e0b {{ $minatPct + $bakatPct }}% {{ $minatPct + $bakatPct + $kepribadianPct }}%, #8b5cf6 {{ $minatPct + $bakatPct + $kepribadianPct }}% 100%); display: flex; align-items: center; justify-content: center; flex-shrink:0;">
                            <div style="width: 110px; height: 110px; border-radius: 50%; background: #ffffff; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);">
                                <span style="font-size: 0.65rem; color: #64748b; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Total Tes</span>
                                <strong style="font-size: 1.35rem; color: #0f172a; font-weight: 850;">{{ ($minatCount ?? 0) + ($bakatCount ?? 0) + ($kepribadianCount ?? 0) + ($kecocokanCount ?? 0) }}</strong>
                            </div>
                        </div>

                        <!-- Legend -->
                        <div style="display:flex; flex-direction:column; gap:10px; min-width:140px;">
                            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="width:10px; height:10px; border-radius:50%; background:#0f766e; display:inline-block;"></span>
                                    <span style="font-size:0.875rem; font-weight:600; color:#475569;">Minat</span>
                                </div>
                                <strong style="font-size:0.875rem; color:#1e293b;">{{ $minatCount }} ({{ $minatPct }}%)</strong>
                            </div>
                            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="width:10px; height:10px; border-radius:50%; background:#0ea5e9; display:inline-block;"></span>
                                    <span style="font-size:0.875rem; font-weight:600; color:#475569;">Bakat</span>
                                </div>
                                <strong style="font-size:0.875rem; color:#1e293b;">{{ $bakatCount }} ({{ $bakatPct }}%)</strong>
                            </div>
                            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="width:10px; height:10px; border-radius:50%; background:#f59e0b; display:inline-block;"></span>
                                    <span style="font-size:0.875rem; font-weight:600; color:#475569;">Kepribadian</span>
                                </div>
                                <strong style="font-size:0.875rem; color:#1e293b;">{{ $kepribadianCount }} ({{ $kepribadianPct }}%)</strong>
                            </div>
                            <div style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
                                <div style="display:flex; align-items:center; gap:8px;">
                                    <span style="width:10px; height:10px; border-radius:50%; background:#8b5cf6; display:inline-block;"></span>
                                    <span style="font-size:0.875rem; font-weight:600; color:#475569;">Kecocokan</span>
                                </div>
                                <strong style="font-size:0.875rem; color:#1e293b;">{{ $kecocokanCount }} ({{ $kecocokanPct }}%)</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tes Terbaru -->
                <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.02); display:flex; flex-direction:column; justify-content:space-between;">
                    <div>
                        <h3 style="margin: 0 0 16px; font-size: 1.1rem; font-weight: 800; color: #1e293b;">Tes Terbaru</h3>
                        <div class="table-wrap" style="border:none; margin:0;">
                            <table style="width:100%;">
                                <thead>
                                    <tr>
                                        <th style="padding:10px 8px; background:none; border-bottom:1px solid #f1f5f9; text-transform:none; font-weight:700; color:#64748b; font-size:0.85rem;">Nama Siswa</th>
                                        <th style="padding:10px 8px; background:none; border-bottom:1px solid #f1f5f9; text-transform:none; font-weight:700; color:#64748b; font-size:0.85rem;">Jenis Tes</th>
                                        <th style="padding:10px 8px; background:none; border-bottom:1px solid #f1f5f9; text-transform:none; font-weight:700; color:#64748b; font-size:0.85rem;">Tanggal</th>
                                        <th style="padding:10px 8px; background:none; border-bottom:1px solid #f1f5f9; text-transform:none; font-weight:700; color:#64748b; font-size:0.85rem; text-align:right;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tesTerbaru as $test)
                                        <tr style="hover:none;">
                                            <td style="padding:12px 8px; border-bottom:1px solid #f1f5f9; font-weight:600; color:#1e293b; font-size:0.85rem;">{{ $test['nama_siswa'] }}</td>
                                            <td style="padding:12px 8px; border-bottom:1px solid #f1f5f9; color:#475569; font-size:0.85rem;">{{ $test['jenis_tes'] }}</td>
                                            <td style="padding:12px 8px; border-bottom:1px solid #f1f5f9; color:#64748b; font-size:0.85rem;">{{ $test['tanggal'] }}</td>
                                            <td style="padding:12px 8px; border-bottom:1px solid #f1f5f9; text-align:right; font-size:0.85rem;">
                                                <span style="background:#f0fdf4; color:#166534; padding:3px 8px; border-radius:6px; font-weight:700; font-size:0.75rem; text-transform:uppercase;">{{ $test['status'] }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pengumuman Section -->
            <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:24px; box-shadow:0 1px 3px rgba(0,0,0,0.02);">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                    <h3 style="margin: 0; font-size: 1.1rem; font-weight: 800; color: #1e293b;">Pengumuman</h3>
                    <a href="#" onclick="event.preventDefault();" style="font-size:0.85rem; font-weight:700; color:#0f766e; text-decoration:none;">Lihat semua</a>
                </div>
                <div style="border-top:1px solid #f1f5f9; padding-top:16px;">
                    <ul style="margin:0; padding-left:18px; color:#475569; font-size:0.9rem; line-height:1.6;">
                        <li style="margin-bottom:8px;">
                            <strong>Jadwal Tes Minat dan Bakat</strong><br>
                            <span style="color:#64748b; font-size:0.85rem;">Tes akan dilaksanakan pada tanggal 10 - 12 Mei 2024.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @else
        <!-- Siswa Dashboard View -->
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
    @endif
@endsection

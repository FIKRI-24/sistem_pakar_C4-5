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
            <!-- Welcome Hero Card -->
            <div style="background: linear-gradient(135deg, #0f766e 0%, #115e59 50%, #042f2e 100%); border-radius: 16px; padding: 28px 32px; color: #ffffff; box-shadow: 0 10px 25px -5px rgba(15, 118, 110, 0.25), 0 8px 10px -6px rgba(15, 118, 110, 0.1); position: relative; overflow: hidden;">
                <!-- Decorative background elements -->
                <div style="position: absolute; right: -20px; top: -20px; width: 180px; height: 180px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; pointer-events: none;"></div>
                <div style="position: absolute; right: 100px; bottom: -40px; width: 140px; height: 140px; background: rgba(20, 184, 166, 0.15); border-radius: 50%; pointer-events: none;"></div>
                
                <div style="position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px); padding: 4px 12px; border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.25); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #ccfbf1; margin-bottom: 10px;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #34d399; box-shadow: 0 0 8px #34d399;"></span>
                            {{ $roleLabel }} Panel
                        </div>
                        <h1 style="margin: 0 0 6px; font-size: 1.75rem; font-weight: 800; letter-spacing: -0.03em; color: #ffffff;">Selamat Datang Kembali, {{ auth()->user()->name }}! 👋</h1>
                        <p style="margin: 0; font-size: 0.95rem; color: #99f6e4; max-width: 600px; line-height: 1.5;">Berikut adalah ikhtisar real-time bimbingan konseling dan performa rekomendasi C4.5.</p>
                    </div>

                    @if(auth()->user()->isRole(\App\Models\User::ROLE_ADMIN))
                        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                            <a href="{{ route('admin.decision-tree.index') }}" style="background: rgba(255, 255, 255, 0.15); hover:background: rgba(255, 255, 255, 0.25); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.3); color: #ffffff; padding: 10px 18px; border-radius: 10px; font-weight: 700; font-size: 0.875rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="6" y1="3" x2="6" y2="15"/><circle cx="18" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><path d="M18 9a9 9 0 0 1-9 9"/></svg>
                                Pohon C4.5
                            </a>
                            <a href="{{ route('admin.data-trainings.index') }}" style="background: #ffffff; color: #0f766e; padding: 10px 18px; border-radius: 10px; font-weight: 800; font-size: 0.875rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); transition: all 0.2s;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 21 19V5"/><path d="M3 12A9 3 0 0 0 21 12"/></svg>
                                Data Training
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Vibrant KPI Cards Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 20px;">
                <!-- Total Siswa -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; display: flex; align-items: center; gap: 18px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); transition: transform 0.2s, box-shadow 0.2s;">
                    <div style="width: 52px; height: 52px; border-radius: 12px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); display: flex; align-items: center; justify-content: center; color: #ffffff; flex-shrink: 0; box-shadow: 0 6px 16px rgba(59, 130, 246, 0.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; display: block;">Total Siswa</span>
                        <strong style="font-size: 1.75rem; font-weight: 800; color: #0f172a; display: block; line-height: 1.2; margin: 3px 0;">{{ $totalSiswa }}</strong>
                        <span style="font-size: 0.75rem; font-weight: 600; color: #2563eb; background: #eff6ff; padding: 2px 8px; border-radius: 6px; display: inline-block;">Siswa Terdaftar</span>
                    </div>
                </div>

                <!-- Tes Dilakukan -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; display: flex; align-items: center; gap: 18px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); transition: transform 0.2s, box-shadow 0.2s;">
                    <div style="width: 52px; height: 52px; border-radius: 12px; background: linear-gradient(135deg, #10b981 0%, #047857 100%); display: flex; align-items: center; justify-content: center; color: #ffffff; flex-shrink: 0; box-shadow: 0 6px 16px rgba(16, 185, 129, 0.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect width="8" height="4" x="8" y="2" rx="1" ry="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="m9 14 2 2 4-4"/></svg>
                    </div>
                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; display: block;">Tes Selesai</span>
                        <strong style="font-size: 1.75rem; font-weight: 800; color: #0f172a; display: block; line-height: 1.2; margin: 3px 0;">{{ $tesDilakukan }}</strong>
                        <span style="font-size: 0.75rem; font-weight: 600; color: #059669; background: #ecfdf5; padding: 2px 8px; border-radius: 6px; display: inline-block;">Kuesioner Diisi</span>
                    </div>
                </div>

                <!-- Hasil Tes -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; display: flex; align-items: center; gap: 18px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); transition: transform 0.2s, box-shadow 0.2s;">
                    <div style="width: 52px; height: 52px; border-radius: 12px; background: linear-gradient(135deg, #f59e0b 0%, #b45309 100%); display: flex; align-items: center; justify-content: center; color: #ffffff; flex-shrink: 0; box-shadow: 0 6px 16px rgba(245, 158, 11, 0.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
                    </div>
                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; display: block;">Hasil Tes</span>
                        <strong style="font-size: 1.75rem; font-weight: 800; color: #0f172a; display: block; line-height: 1.2; margin: 3px 0;">{{ $hasilTesCount }}</strong>
                        <span style="font-size: 0.75rem; font-weight: 600; color: #d97706; background: #fffbeb; padding: 2px 8px; border-radius: 6px; display: inline-block;">Profil Terhitung</span>
                    </div>
                </div>

                <!-- Rekomendasi Karir -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px; display: flex; align-items: center; gap: 18px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); transition: transform 0.2s, box-shadow 0.2s;">
                    <div style="width: 52px; height: 52px; border-radius: 12px; background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%); display: flex; align-items: center; justify-content: center; color: #ffffff; flex-shrink: 0; box-shadow: 0 6px 16px rgba(139, 92, 246, 0.3);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <div>
                        <span style="font-size: 0.78rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; display: block;">Rekomendasi C4.5</span>
                        <strong style="font-size: 1.75rem; font-weight: 800; color: #0f172a; display: block; line-height: 1.2; margin: 3px 0;">{{ $rekomendasiCount }}</strong>
                        <span style="font-size: 0.75rem; font-weight: 600; color: #7c3aed; background: #faf5ff; padding: 2px 8px; border-radius: 6px; display: inline-block;">Karir Terprediksi</span>
                    </div>
                </div>
            </div>

            <!-- Analytics Dashboard Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px; align-items: stretch;">
                <!-- Distribusi Rekomendasi Karir (Bar Chart View) -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 26px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); display: flex; flex-direction: column;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; padding-bottom: 14px; border-bottom: 1px solid #f1f5f9;">
                        <div>
                            <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">Distribusi Rekomendasi Karir</h3>
                            <p style="margin: 3px 0 0; font-size: 0.8rem; color: #64748b;">Proporsi karir terprediksi oleh algoritma C4.5</p>
                        </div>
                        <span style="background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-size: 0.75rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; display: inline-flex; align-items: center; gap: 6px;">
                            <span style="width: 7px; height: 7px; border-radius: 50%; background: #10b981; box-shadow: 0 0 6px #10b981;"></span> Real-Time
                        </span>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 16px; flex: 1; justify-content: center;">
                        @php
                            $barGradients = [
                                'linear-gradient(90deg, #0d9488, #14b8a6)',
                                'linear-gradient(90deg, #2563eb, #3b82f6)',
                                'linear-gradient(90deg, #7c3aed, #8b5cf6)',
                                'linear-gradient(90deg, #d97706, #f59e0b)',
                                'linear-gradient(90deg, #e11d48, #f43f5e)',
                                'linear-gradient(90deg, #059669, #10b981)'
                            ];
                        @endphp
                        @foreach($distribusiKarir as $idx => $karirStat)
                            @php
                                $grad = $barGradients[$idx % count($barGradients)];
                            @endphp
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px; font-size: 0.875rem;">
                                    <span style="font-weight: 700; color: #1e293b; display: flex; align-items: center; gap: 8px;">
                                        <span style="width: 20px; height: 20px; border-radius: 6px; background: #f1f5f9; color: #475569; font-size: 0.7rem; font-weight: 800; display: inline-flex; align-items: center; justify-content: center;">#{{ $idx + 1 }}</span>
                                        {{ $karirStat['nama_karir'] }}
                                    </span>
                                    <span style="font-weight: 800; color: #0f172a; font-size: 0.9rem;">
                                        {{ $karirStat['total'] }} Siswa ({{ $karirStat['persen'] }}%)
                                    </span>
                                </div>
                                <div style="width: 100%; height: 10px; background: #f1f5f9; border-radius: 6px; overflow: hidden; padding: 2px; box-sizing: border-box;">
                                    <div style="width: {{ max($karirStat['persen'], 3) }}%; height: 100%; background: {{ $grad }}; border-radius: 4px; transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Tes per Kategori (Donut Chart) -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 26px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); display: flex; flex-direction: column;">
                    <div style="margin-bottom: 22px; padding-bottom: 14px; border-bottom: 1px solid #f1f5f9;">
                        <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">Komposisi Kategori Tes</h3>
                        <p style="margin: 3px 0 0; font-size: 0.8rem; color: #64748b;">Persentase sebaran kriteria penilaian</p>
                    </div>

                    <div style="display: flex; align-items: center; justify-content: center; gap: 32px; flex-wrap: wrap; flex: 1;">
                        <!-- Pie Donut Chart -->
                        <div style="position: relative; width: 180px; height: 180px; border-radius: 50%; background: conic-gradient(#0f766e 0% {{ $minatPct }}%, #0284c7 {{ $minatPct }}% {{ $minatPct + $bakatPct }}%, #d97706 {{ $minatPct + $bakatPct }}% {{ $minatPct + $bakatPct + $kepribadianPct }}%, #7c3aed {{ $minatPct + $bakatPct + $kepribadianPct }}% 100%); display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 8px 24px rgba(0,0,0,0.08);">
                            <div style="width: 118px; height: 118px; border-radius: 50%; background: #ffffff; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: inset 0 2px 6px rgba(0,0,0,0.06);">
                                <span style="font-size: 0.7rem; color: #64748b; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">Total Tes</span>
                                <strong style="font-size: 1.5rem; color: #0f172a; font-weight: 900; line-height: 1;">{{ ($minatCount ?? 0) + ($bakatCount ?? 0) + ($kepribadianCount ?? 0) + ($kecocokanCount ?? 0) }}</strong>
                            </div>
                        </div>

                        <!-- Legend -->
                        <div style="display: flex; flex-direction: column; gap: 12px; min-width: 150px;">
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 6px 10px; background: #f8fafc; border-radius: 8px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 12px; height: 12px; border-radius: 4px; background: #0f766e; display: inline-block;"></span>
                                    <span style="font-size: 0.875rem; font-weight: 700; color: #334155;">Minat</span>
                                </div>
                                <strong style="font-size: 0.875rem; color: #0f172a; font-weight: 800;">{{ $minatCount }} ({{ $minatPct }}%)</strong>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 6px 10px; background: #f8fafc; border-radius: 8px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 12px; height: 12px; border-radius: 4px; background: #0284c7; display: inline-block;"></span>
                                    <span style="font-size: 0.875rem; font-weight: 700; color: #334155;">Bakat</span>
                                </div>
                                <strong style="font-size: 0.875rem; color: #0f172a; font-weight: 800;">{{ $bakatCount }} ({{ $bakatPct }}%)</strong>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 6px 10px; background: #f8fafc; border-radius: 8px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 12px; height: 12px; border-radius: 4px; background: #d97706; display: inline-block;"></span>
                                    <span style="font-size: 0.875rem; font-weight: 700; color: #334155;">Kepribadian</span>
                                </div>
                                <strong style="font-size: 0.875rem; color: #0f172a; font-weight: 800;">{{ $kepribadianCount }} ({{ $kepribadianPct }}%)</strong>
                            </div>
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 12px; padding: 6px 10px; background: #f8fafc; border-radius: 8px;">
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <span style="width: 12px; height: 12px; border-radius: 4px; background: #7c3aed; display: inline-block;"></span>
                                    <span style="font-size: 0.875rem; font-weight: 700; color: #334155;">Kecocokan</span>
                                </div>
                                <strong style="font-size: 0.875rem; color: #0f172a; font-weight: 800;">{{ $kecocokanCount }} ({{ $kecocokanPct }}%)</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Table & Quick Shortcuts Section -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(340px, 1fr)); gap: 24px;">
                <!-- Tes Terbaru Table Card -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 26px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); display: flex; flex-direction: column;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1px solid #f1f5f9;">
                        <div>
                            <h3 style="margin: 0; font-size: 1.15rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">Aktivitas Tes Terbaru</h3>
                            <p style="margin: 2px 0 0; font-size: 0.8rem; color: #64748b;">Pengisian kuesioner siswa terkini</p>
                        </div>
                        <a href="{{ route('admin.tes.hasil-tes') }}" style="font-size: 0.825rem; font-weight: 700; color: #0f766e; text-decoration: none; background: #f0fdf4; padding: 4px 12px; border-radius: 8px; border: 1px solid #ccfbf1; transition: all 0.2s;">
                            Lihat Semua →
                        </a>
                    </div>

                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th style="padding: 10px 12px; background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-transform: uppercase; font-weight: 800; color: #475569; font-size: 0.75rem; letter-spacing: 0.05em; border-radius: 6px 0 0 6px;">Siswa</th>
                                    <th style="padding: 10px 12px; background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-transform: uppercase; font-weight: 800; color: #475569; font-size: 0.75rem; letter-spacing: 0.05em;">Jenis Tes</th>
                                    <th style="padding: 10px 12px; background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-transform: uppercase; font-weight: 800; color: #475569; font-size: 0.75rem; letter-spacing: 0.05em;">Tanggal</th>
                                    <th style="padding: 10px 12px; background: #f8fafc; border-bottom: 2px solid #e2e8f0; text-transform: uppercase; font-weight: 800; color: #475569; font-size: 0.75rem; letter-spacing: 0.05em; text-align: right; border-radius: 0 6px 6px 0;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tesTerbaru as $test)
                                    <tr style="transition: background 0.15s;">
                                        <td style="padding: 14px 12px; border-bottom: 1px solid #f1f5f9; font-weight: 700; color: #0f172a; font-size: 0.875rem;">
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <div style="width: 32px; height: 32px; border-radius: 50%; background: #e0f2fe; color: #0369a1; font-weight: 800; font-size: 0.8rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                    {{ strtoupper(substr($test['nama_siswa'], 0, 1)) }}
                                                </div>
                                                <span>{{ $test['nama_siswa'] }}</span>
                                            </div>
                                        </td>
                                        <td style="padding: 14px 12px; border-bottom: 1px solid #f1f5f9; color: #334155; font-size: 0.875rem; font-weight: 600;">
                                            {{ $test['jenis_tes'] }}
                                        </td>
                                        <td style="padding: 14px 12px; border-bottom: 1px solid #f1f5f9; color: #64748b; font-size: 0.825rem; font-weight: 600;">
                                            {{ $test['tanggal'] }}
                                        </td>
                                        <td style="padding: 14px 12px; border-bottom: 1px solid #f1f5f9; text-align: right;">
                                            <span style="background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; padding: 4px 10px; border-radius: 20px; font-weight: 800; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 4px;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                                {{ $test['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Modul Akses Cepat & Status System -->
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <!-- Direct Navigation Shortcuts Card -->
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);">
                        <h3 style="margin: 0 0 16px; font-size: 1.15rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">Pintasan Fitur Utama</h3>
                        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
                            <a href="{{ route('admin.siswas.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; text-decoration: none; transition: all 0.2s;">
                                <div style="width: 36px; height: 36px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                </div>
                                <span style="font-weight: 700; font-size: 0.875rem; color: #1e293b;">Data Siswa</span>
                            </a>
                            <a href="{{ route('admin.kriterias.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; text-decoration: none; transition: all 0.2s;">
                                <div style="width: 36px; height: 36px; border-radius: 8px; background: #fef3c7; color: #d97706; display: flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="6" height="6" rx="1"/><path d="M13 6h8"/><path d="M13 12h8"/><rect x="3" y="11" width="6" height="6" rx="1"/></svg>
                                </div>
                                <span style="font-weight: 700; font-size: 0.875rem; color: #1e293b;">Kriteria</span>
                            </a>
                            <a href="{{ route('admin.karirs.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; text-decoration: none; transition: all 0.2s;">
                                <div style="width: 36px; height: 36px; border-radius: 8px; background: #faf5ff; color: #7c3aed; display: flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/></svg>
                                </div>
                                <span style="font-weight: 700; font-size: 0.875rem; color: #1e293b;">Alternatif Karir</span>
                            </a>
                            <a href="{{ route('admin.c45.status') }}" style="display: flex; align-items: center; gap: 12px; padding: 14px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; text-decoration: none; transition: all 0.2s;">
                                <div style="width: 36px; height: 36px; border-radius: 8px; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                                </div>
                                <span style="font-weight: 700; font-size: 0.875rem; color: #1e293b;">Status C4.5</span>
                            </a>
                        </div>
                    </div>

                    <!-- Informatif Status C4.5 Card -->
                    <div style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); border-radius: 16px; padding: 22px; color: #ffffff; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(52, 211, 153, 0.2); color: #34d399; display: flex; align-items: center; justify-content: center;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                </div>
                                <h4 style="margin: 0; font-size: 0.95rem; font-weight: 800; color: #ffffff;">Engine C4.5 FastAPI</h4>
                            </div>
                            <span style="background: rgba(52, 211, 153, 0.2); color: #34d399; border: 1px solid rgba(52, 211, 153, 0.3); font-size: 0.7rem; font-weight: 800; padding: 3px 8px; border-radius: 12px;">
                                Port 8001
                            </span>
                        </div>
                        <p style="margin: 0 0 14px; font-size: 0.825rem; color: #94a3b8; line-height: 1.5;">
                            Service pemroses algoritma C4.5 independen berjalan di Python FastAPI. Mengolah 200 data latih secara real-time.
                        </p>
                        <div style="display: flex;">
                            <a href="{{ route('admin.decision-tree.index') }}" style="width: 100%; text-align: center; background: #0f766e; color: #ffffff; padding: 10px 16px; border-radius: 8px; font-size: 0.825rem; font-weight: 800; text-decoration: none; transition: background 0.2s; box-shadow: 0 2px 8px rgba(15, 118, 110, 0.3);">
                                Rebuild Tree & Pohon Keputusan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Siswa Dashboard View -->
        <div style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Welcome Hero Banner -->
            <div style="background: linear-gradient(135deg, #0f766e 0%, #0d9488 50%, #042f2e 100%); border-radius: 16px; padding: 32px; color: #ffffff; box-shadow: 0 10px 25px -5px rgba(15, 118, 110, 0.25); position: relative; overflow: hidden;">
                <!-- Decorative Circle Elements -->
                <div style="position: absolute; right: -20px; top: -20px; width: 180px; height: 180px; background: rgba(255, 255, 255, 0.05); border-radius: 50%; pointer-events: none;"></div>
                <div style="position: absolute; right: 120px; bottom: -40px; width: 140px; height: 140px; background: rgba(20, 184, 166, 0.15); border-radius: 50%; pointer-events: none;"></div>

                <div style="position: relative; z-index: 1; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                    <div>
                        <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(8px); padding: 4px 12px; border-radius: 20px; border: 1px solid rgba(255, 255, 255, 0.25); font-size: 0.75rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: #ccfbf1; margin-bottom: 12px;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #34d399; box-shadow: 0 0 8px #34d399;"></span>
                            Portal Siswa Bimbingan Konseling
                        </div>
                        <h1 style="margin: 0 0 8px; font-size: 1.85rem; font-weight: 800; letter-spacing: -0.03em; color: #ffffff;">
                            Selamat Datang, {{ auth()->user()->name }}! 👋
                        </h1>
                        <p style="margin: 0; font-size: 0.95rem; color: #99f6e4; max-width: 620px; line-height: 1.5;">
                            Temukan rekomendasi karir dan potensi terbaikmu melalui tes kuesioner berbasis sistem pakar pohon keputusan C4.5.
                        </p>
                    </div>

                    <!-- Action Button Hero -->
                    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                        <a href="{{ route('siswa.konsultasi.index') }}" style="background: #ffffff; color: #0f766e; padding: 12px 22px; border-radius: 12px; font-weight: 800; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15); transition: transform 0.15s ease;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            <span>Mulai Tes Kuesioner</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Profile Info Card Grid -->
            @php
                $siswaProfile = auth()->user()->siswa;
            @endphp
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px;">
                <!-- Profile NIS -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; display: flex; align-items: center; gap: 14px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="width: 46px; height: 46px; border-radius: 10px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="4" width="18" height="16" rx="2"/><line x1="7" y1="8" x2="17" y2="8"/><line x1="7" y1="12" x2="13" y2="12"/></svg>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; display: block;">NIS Siswa</span>
                        <strong style="font-size: 1.1rem; font-weight: 800; color: #0f172a; font-family: monospace;">{{ $siswaProfile->nis ?? '-' }}</strong>
                    </div>
                </div>

                <!-- Profile Kelas -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; display: flex; align-items: center; gap: 14px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="width: 46px; height: 46px; border-radius: 10px; background: #f0fdf4; color: #059669; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; display: block;">Kelas</span>
                        <strong style="font-size: 1.05rem; font-weight: 800; color: #0f172a;">{{ $siswaProfile->kelas ?? 'Belum Diisi' }}</strong>
                    </div>
                </div>

                <!-- Profile Jurusan -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; display: flex; align-items: center; gap: 14px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="width: 46px; height: 46px; border-radius: 10px; background: #faf5ff; color: #7c3aed; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; display: block;">Jurusan</span>
                        <strong style="font-size: 1.05rem; font-weight: 800; color: #0f172a;">{{ $siswaProfile->jurusan ?? 'Belum Diisi' }}</strong>
                    </div>
                </div>

                <!-- Status Biodata -->
                <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; display: flex; align-items: center; gap: 14px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);">
                    <div style="width: 46px; height: 46px; border-radius: 10px; background: #fffbeb; color: #d97706; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div>
                        <span style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; display: block;">Status Biodata</span>
                        @if($siswaProfile && $siswaProfile->kelas && $siswaProfile->jurusan)
                            <span style="color: #059669; font-weight: 800; font-size: 0.85rem; background: #ecfdf5; padding: 3px 8px; border-radius: 6px; display: inline-block;">Lengkap ✓</span>
                        @else
                            <a href="{{ route('siswa.biodata') }}" style="color: #d97706; font-weight: 800; font-size: 0.825rem; text-decoration: underline;">Lengkapi Biodata →</a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Features Navigation Cards Grid -->
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 800; color: #0f172a; margin: 0 0 16px; letter-spacing: -0.02em;">Fitur Utama Siswa</h2>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                    <!-- Card 1: Konsultasi Karir -->
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s;">
                        <div>
                            <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); color: #ffffff; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; box-shadow: 0 6px 16px rgba(15, 118, 110, 0.3);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                            </div>
                            <h3 style="margin: 0 0 6px; font-size: 1.15rem; font-weight: 800; color: #0f172a;">Konsultasi & Tes Karir</h3>
                            <p style="margin: 0 0 20px; font-size: 0.875rem; color: #64748b; line-height: 1.5;">
                                Isi kuesioner minat, bakat, kepribadian, dan nilai akademik untuk mendapatkan hasil klasifikasi C4.5.
                            </p>
                        </div>
                        <a href="{{ route('siswa.konsultasi.index') }}" style="background: linear-gradient(180deg, #34d399 0%, #059669 100%); color: #ffffff; text-decoration: none; padding: 10px 18px; border-radius: 10px; font-weight: 800; font-size: 0.85rem; text-align: center; box-shadow: 0 3.5px 0 #047857, 0 6px 12px rgba(5, 150, 105, 0.3); border-top: 1px solid rgba(255,255,255,0.3); display: block; transition: all 0.15s;">
                            Mulai Kuesioner Karir →
                        </a>
                    </div>

                    <!-- Card 2: Riwayat Hasil Tes -->
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s;">
                        <div>
                            <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); color: #ffffff; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; box-shadow: 0 6px 16px rgba(2, 132, 199, 0.3);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                            </div>
                            <h3 style="margin: 0 0 6px; font-size: 1.15rem; font-weight: 800; color: #0f172a;">Riwayat & Laporan PDF</h3>
                            <p style="margin: 0 0 20px; font-size: 0.875rem; color: #64748b; line-height: 1.5;">
                                Lihat kembali hasil rekomendasi karir pribadi dan unduh laporan resmi bimbingan konseling PDF.
                            </p>
                        </div>
                        <a href="{{ route('siswa.hasil-tes.index') }}" style="background: linear-gradient(180deg, #38bdf8 0%, #0284c7 100%); color: #ffffff; text-decoration: none; padding: 10px 18px; border-radius: 10px; font-weight: 800; font-size: 0.85rem; text-align: center; box-shadow: 0 3.5px 0 #0369a1, 0 6px 12px rgba(2, 132, 199, 0.3); border-top: 1px solid rgba(255,255,255,0.3); display: block; transition: all 0.15s;">
                            Lihat Riwayat Hasil →
                        </a>
                    </div>

                    <!-- Card 3: Kelola Biodata -->
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s;">
                        <div>
                            <div style="width: 48px; height: 48px; border-radius: 12px; background: linear-gradient(135deg, #d97706 0%, #b45309 100%); color: #ffffff; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; box-shadow: 0 6px 16px rgba(217, 119, 6, 0.3);">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                            </div>
                            <h3 style="margin: 0 0 6px; font-size: 1.15rem; font-weight: 800; color: #0f172a;">Biodata Profil Siswa</h3>
                            <p style="margin: 0 0 20px; font-size: 0.875rem; color: #64748b; line-height: 1.5;">
                                Perbarui data diri, NIS, kelas, jurusan, dan jenis kelamin Anda agar tercatat dengan benar.
                            </p>
                        </div>
                        <a href="{{ route('siswa.biodata') }}" style="background: linear-gradient(180deg, #ffffff 0%, #e2e8f0 100%); color: #475569; text-decoration: none; padding: 10px 18px; border-radius: 10px; font-weight: 800; font-size: 0.85rem; text-align: center; box-shadow: 0 3.5px 0 #cbd5e1, 0 4px 10px rgba(0,0,0,0.05); border: 1px solid #cbd5e1; display: block; transition: all 0.15s;">
                            Ubah Biodata →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

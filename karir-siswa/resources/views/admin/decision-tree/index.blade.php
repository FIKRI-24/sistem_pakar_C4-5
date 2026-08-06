@extends('layouts.app', ['title' => 'Pohon Keputusan C4.5'])

@section('content')
<div style="display: flex; flex-direction: column; gap: 24px;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="margin: 0 0 4px; font-size: 1.6rem; font-weight: 800; letter-spacing: -0.025em; color: #0f172a;">Pohon Keputusan C4.5</h1>
            <p style="margin: 0; font-size: 0.95rem; color: #64748b;">Representasi model klasifikasi yang dihasilkan dari algoritme C4.5 berdasarkan data latih saat ini.</p>
        </div>
        
        <form action="{{ route('admin.decision-tree.train') }}" method="POST" style="margin: 0;">
            @csrf
            <button type="submit" style="background-color: #0f766e; color: #ffffff; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px -1px rgba(15, 118, 110, 0.15); transition: all 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21.5 2v6h-6M21.34 15.57a10 10 0 1 1-.57-8.38l5.67-5.67"/></svg>
                Latih Ulang Pohon (Rebuild Tree)
            </button>
        </form>
    </div>

    <!-- Notifications -->
    @if (session('success'))
        <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @if ($error)
        <div style="background-color: #fffbeb; border: 1px solid #fde68a; color: #92400e; padding: 12px 16px; border-radius: 8px; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            {{ $error }}
        </div>
    @endif

    @if ($activeTree)
        <!-- Model Summary Cards -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.01);">
                <div style="background: #e0f2fe; color: #0369a1; width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <div>
                    <span style="font-size: 0.85rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Model Aktif</span>
                    <h3 style="margin: 4px 0 0; font-size: 1.3rem; font-weight: 800; color: #0f172a;">Versi #{{ $activeTree->versi }}</h3>
                </div>
            </div>
            
            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.01);">
                <div style="background: #f3e8ff; color: #6b21a8; width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="18" y1="20" y2="10"/><line x1="12" x2="12" y1="20" y2="4"/><line x1="6" x2="6" y1="20" y2="14"/></svg>
                </div>
                <div>
                    <span style="font-size: 0.85rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Akurasi Model</span>
                    <h3 style="margin: 4px 0 0; font-size: 1.3rem; font-weight: 800; color: #0f172a;">{{ number_format($activeTree->akurasi * 100, 2, ',', '.') }}%</h3>
                </div>
            </div>

            <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.01);">
                <div style="background: #f0fdf4; color: #166534; width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div>
                    <span style="font-size: 0.85rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Dibuat Oleh</span>
                    <h3 style="margin: 4px 0 0; font-size: 1.1rem; font-weight: 800; color: #0f172a;">{{ $activeTree->dibuatOleh?->name ?? 'System' }}</h3>
                </div>
            </div>
        </div>

        <!-- Main Display Panel (Tabs) -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); display: flex; flex-direction: column;">
            <div style="display: flex; border-bottom: 1px solid #f1f5f9; background-color: #f8fafc; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                <button onclick="switchTab('tree-view')" id="tab-tree-view" class="tab-btn active">Struktur Pohon</button>
                <button onclick="switchTab('rules-list')" id="tab-rules-list" class="tab-btn">Daftar Aturan (IF-THEN Rules)</button>
            </div>
            
            <div id="content-tree-view" class="tab-content" style="padding: 24px;">
                <div class="tree-container">
                    @php
                    if (!function_exists('renderTreeHtml')) {
                        function renderTreeHtml($node, $careers, $indent = 0) {
                            if ($node['type'] === 'leaf') {
                                $classVal = $node['class'];
                                $careerName = $careers[$classVal] ?? "Career ID #{$classVal}";
                                return '
                                <div class="tree-leaf" style="margin-top: 4px; margin-bottom: 4px;">
                                    <span class="leaf-label">🍃 Rekomendasi:</span>
                                    <strong class="leaf-value" style="color: #0f766e;">' . e($careerName) . '</strong>
                                    <span style="color: #64748b; font-size: 0.8rem; margin-left: 6px;">(Sampel: ' . ($node['count'] ?? 0) . ')</span>
                                </div>';
                            }
                            
                            $featureLabel = [
                                'minat' => 'Minat',
                                'bakat' => 'Bakat',
                                'nilai_akademik' => 'Nilai Akademik',
                                'kepribadian' => 'Kepribadian'
                            ][$node['feature']] ?? $node['feature'];
                            
                            $html = '<div class="tree-node">';
                            $html .= '🔍 Kriteria: <span style="color: #4338ca; font-weight: 800;">' . e($featureLabel) . '</span>';
                            $html .= '</div>';
                            
                            if ($node['is_numeric']) {
                                // Left child (<= threshold)
                                $html .= '<div class="tree-branch">';
                                $html .= '<span style="font-weight: bold; color: #b45309;">⚖️ &le; ' . number_format($node['threshold'], 2, ',', '.') . '</span>:';
                                $html .= renderTreeHtml($node['left'], $careers, $indent + 1);
                                $html .= '</div>';
                                
                                // Right child (> threshold)
                                $html .= '<div class="tree-branch">';
                                $html .= '<span style="font-weight: bold; color: #b45309;">⚖️ &gt; ' . number_format($node['threshold'], 2, ',', '.') . '</span>:';
                                $html .= renderTreeHtml($node['right'], $careers, $indent + 1);
                                $html .= '</div>';
                            } else {
                                // Categorical branches
                                foreach ($node['branches'] as $val => $branch) {
                                    $html .= '<div class="tree-branch">';
                                    $html .= '<span style="font-weight: bold; color: #0284c7;">💬 ' . e($val) . '</span>:';
                                    $html .= renderTreeHtml($branch, $careers, $indent + 1);
                                    $html .= '</div>';
                                }
                            }
                            
                            return $html;
                        }
                    }
                    @endphp
                    
                    {!! renderTreeHtml($activeTree->struktur_json, $careers) !!}
                </div>
            </div>

            <div id="content-rules-list" class="tab-content" style="padding: 24px; display: none;">
                @if (empty($rules))
                    <div style="text-align: center; padding: 24px; color: #64748b;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 12px; opacity: 0.5;"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <p style="margin: 0; font-size: 0.95rem;">Aturan tidak dapat diekstraksi secara langsung (Layanan C4.5 offline).</p>
                    </div>
                @else
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach ($rules as $index => $r)
                            <div style="border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; background-color: #f8fafc; font-family: monospace; font-size: 0.9rem; line-height: 1.5; transition: border-color 0.2s;">
                                <div style="color: #64748b; font-size: 0.75rem; margin-bottom: 6px; font-weight: 700;">ATURAN #{{ $index + 1 }}</div>
                                <div>
                                    <span style="font-weight: 800; color: #0f172a;">IF</span> 
                                    @foreach ($r['conditions'] as $idx => $cond)
                                        @if ($idx > 0)
                                            <span style="font-weight: 800; color: #0ea5e9;">AND</span>
                                        @endif
                                        <span style="color: #4338ca; font-weight: 700;">{{ $cond }}</span>
                                    @endforeach
                                    <br>
                                    <span style="font-weight: 800; color: #0f172a;">THEN</span> 
                                    Rekomendasi Karir = <strong style="color: #0f766e; font-weight: 800;">'{{ $r['career_name'] }}'</strong> 
                                    <span style="color: #64748b; font-size: 0.8rem;">(Sampel: {{ $r['count'] }})</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- No tree trained yet -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 48px 24px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.02);">
            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 16px; opacity: 0.7;"><line x1="6" y1="3" x2="6" y2="15"/><circle cx="18" cy="6" r="3"/><circle cx="6" cy="18" r="3"/><path d="M18 9a9 9 0 0 1-9 9"/></svg>
            <h2 style="margin: 0 0 8px; font-size: 1.3rem; font-weight: 800; color: #0f172a;">Belum Ada Model Pohon Keputusan</h2>
            <p style="margin: 0 0 24px; font-size: 0.95rem; color: #64748b; max-width: 480px; margin-left: auto; margin-right: auto;">Sistem belum pernah dilatih menggunakan data training. Klik tombol di bawah ini untuk melatih model pertama kali.</p>
            <form action="{{ route('admin.decision-tree.train') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="background-color: #0f766e; color: #ffffff; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 700; font-size: 0.95rem; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 4px 6px -1px rgba(15, 118, 110, 0.15); transition: all 0.2s;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m12 14 4-4H8z"/><path d="M12 2v12"/></svg>
                    Latih Model Pertama Kali
                </button>
            </form>
        </div>
    @endif

    <!-- History Panel -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.02); overflow: hidden;">
        <div style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; background: #f8fafc;">
            <h3 style="margin: 0; font-size: 1rem; font-weight: 800; color: #0f172a;">Riwayat Pelatihan Pohon</h3>
        </div>
        <div style="overflow-x: auto; width: 100%;">
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem; min-width: 600px;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; width: 15%;">Versi</th>
                        <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; width: 20%;">Akurasi</th>
                        <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; width: 30%;">Dibuat Oleh</th>
                        <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; width: 20%;">Waktu Pelatihan</th>
                        <th style="padding: 14px 20px; font-weight: 750; color: #475569; font-size: 0.8rem; text-transform: uppercase; width: 15%; text-align: right;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($history as $tree)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 16px 20px; font-weight: bold; color: #0f172a;">Versi #{{ $tree->versi }}</td>
                            <td style="padding: 16px 20px; font-weight: 600; color: #0f172a;">{{ number_format($tree->akurasi * 100, 2, ',', '.') }}%</td>
                            <td style="padding: 16px 20px; color: #475569;">{{ $tree->dibuatOleh?->name ?? 'System' }}</td>
                            <td style="padding: 16px 20px; color: #475569;">{{ $tree->created_at?->translatedFormat('d M Y H:i:s') ?? '-' }}</td>
                            <td style="padding: 16px 20px; text-align: right;">
                                @if ($tree->status_aktif)
                                    <span style="background-color: #d1fae5; color: #065f46; padding: 4px 10px; border-radius: 20px; font-weight: 750; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 4px;">
                                        Aktif
                                    </span>
                                @else
                                    <span style="background-color: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 20px; font-weight: 750; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 4px;">
                                        Arsip
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 24px; text-align: center; color: #64748b;">Belum ada riwayat pelatihan model.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .tab-btn {
        background: transparent;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 14px 24px;
        font-size: 0.9rem;
        font-weight: 700;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
        box-sizing: border-box;
    }
    
    .tab-btn:hover {
        color: #0f172a;
    }
    
    .tab-btn.active {
        color: #0f766e;
        border-bottom-color: #0f766e;
    }

    .tree-container {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 24px;
        font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
        font-size: 0.9rem;
        line-height: 1.8;
        overflow-x: auto;
    }
    
    .tree-node {
        color: #0f172a;
        font-weight: bold;
        margin-bottom: 6px;
    }
    
    .tree-branch {
        color: #475569;
        border-left: 2px dashed #cbd5e1;
        margin-left: 16px;
        padding-left: 16px;
        margin-top: 6px;
        margin-bottom: 6px;
    }
    
    .tree-leaf {
        color: #0f766e;
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
        padding: 6px 12px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }
    
    .leaf-label {
        font-weight: bold;
        margin-right: 4px;
    }
</style>

<script>
    function switchTab(tabId) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(function(el) {
            el.style.display = 'none';
        });
        
        // Remove active class from buttons
        document.querySelectorAll('.tab-btn').forEach(function(el) {
            el.classList.remove('active');
        });
        
        // Show selected content
        document.getElementById('content-' + tabId).style.display = 'block';
        
        // Set active class to clicked tab button
        document.getElementById('tab-' + tabId).classList.add('active');
    }
</script>
@endsection

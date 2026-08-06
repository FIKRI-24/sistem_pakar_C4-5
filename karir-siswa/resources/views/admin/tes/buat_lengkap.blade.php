@extends('layouts.app', ['title' => 'Buat Tes Lengkap'])

@section('content')
    <div class="toolbar">
        <div>
            <p class="role-badge">Form Terintegrasi</p>
            <h1>Buat Tes Lengkap</h1>
            <p class="muted">Buat 1 Tes, semua Pertanyaan, dan Pilihan Jawabannya sekaligus dalam satu halaman.</p>
        </div>
        <a class="button secondary" href="{{ route('admin.tes.index') }}">Kembali</a>
    </div>

    @if ($errors->any())
        <div class="notice" style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; border-radius:8px; padding:16px 20px; margin-bottom:24px;">
            <h4 style="margin:0 0 8px; font-weight:700;">Gagal Menyimpan:</h4>
            <ul style="margin:0; padding-left:20px; font-size:0.9rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.tes.buat-lengkap.store') }}" id="full-test-form">
        @csrf

    <!-- Detail Tes Card -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden; margin-bottom: 28px;">
        <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
            <h2 style="margin: 0; font-size: 1.25rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
                Detail Tes / Kuesioner
            </h2>
            <p style="margin: 4px 0 0; font-size: 0.875rem; color: #64748b; font-weight: 600;">
                Tentukan nama, deskripsi instruksi, durasi, dan status aktif untuk instrumen kuesioner ini.
            </p>
        </div>
        <div style="padding: 28px 32px; display: flex; flex-direction: column; gap: 20px;">
            <div class="field" style="margin: 0;">
                <label for="nama_tes" style="font-weight: 750; color: #334155; font-size: 0.875rem; margin-bottom: 8px; display: block;">Nama Tes *</label>
                <input id="nama_tes" name="nama_tes" type="text" value="{{ old('nama_tes') }}" required placeholder="Contoh: Kuesioner Minat & Bakat Siswa v1" style="width: 100%; box-sizing: border-box; min-height: 44px; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; font-weight: 600; color: #0f172a; font-family: inherit;">
            </div>

            <div class="field" style="margin: 0;">
                <label for="deskripsi" style="font-weight: 750; color: #334155; font-size: 0.875rem; margin-bottom: 8px; display: block;">Deskripsi & Instruksi Pengerjaan</label>
                <textarea id="deskripsi" name="deskripsi" placeholder="Tulis instruksi pengerjaan tes untuk siswa..." style="width: 100%; box-sizing: border-box; min-height: 80px; padding: 12px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.925rem; font-weight: 600; color: #0f172a; line-height: 1.5; font-family: inherit;">{{ old('deskripsi') }}</textarea>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div class="field" style="margin: 0;">
                    <label for="durasi_menit" style="font-weight: 750; color: #334155; font-size: 0.875rem; margin-bottom: 8px; display: block;">Estimasi Durasi (Menit)</label>
                    <input id="durasi_menit" name="durasi_menit" type="number" min="1" value="{{ old('durasi_menit') }}" placeholder="Contoh: 15" style="width: 100%; box-sizing: border-box; min-height: 44px; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.95rem; font-weight: 600; color: #0f172a; font-family: inherit;">
                </div>

                <div class="field" style="margin: 0;">
                    <label for="status_aktif" style="font-weight: 750; color: #334155; font-size: 0.875rem; margin-bottom: 8px; display: block;">Status Aktif *</label>
                    <select id="status_aktif" name="status_aktif" required style="width: 100%; box-sizing: border-box; min-height: 44px; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; font-weight: 700; color: #0f172a; background-color: #ffffff; font-family: inherit;">
                        <option value="1" @selected(old('status_aktif', '1') == '1')>Aktif</option>
                        <option value="0" @selected(old('status_aktif') == '0')>Tidak Aktif</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Soal Header & Action Toolbar -->
    <div style="margin-bottom: 28px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; flex-wrap: wrap; gap: 14px;">
            <div>
                <h2 style="font-size: 1.3rem; font-weight: 800; color: #0f172a; margin: 0 0 4px; letter-spacing: -0.02em;">Daftar Pertanyaan & Pilihan Jawaban</h2>
                <p style="margin: 0; font-size: 0.875rem; color: #64748b; font-weight: 600;">Kelola setiap butir pertanyaan kuesioner atau ambil langsung dari Bank Soal Standar.</p>
            </div>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button type="button" class="btn-3d btn-3d-blue" id="open-bank-btn" style="min-height: 42px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    <span>Ambil dari Bank Pertanyaan</span>
                </button>
                <button type="button" class="btn-3d btn-3d-emerald" id="add-soal-btn" style="min-height: 42px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    <span>Tambah Pertanyaan Manual</span>
                </button>
            </div>
        </div>

        <!-- Generator Jumlah Soal Card -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; padding: 22px 26px; margin-bottom: 24px; display: flex; flex-wrap: wrap; align-items: flex-end; gap: 16px; box-shadow: 0 4px 16px rgba(0,0,0,0.02);">
            <div style="flex: 1; min-width: 240px; margin-bottom: 0;" class="field">
                <label for="jumlah_soal_input" style="font-weight: 750; color: #334155; font-size: 0.875rem; margin-bottom: 6px; display: block;">Buat Banyak Pertanyaan Sekaligus</label>
                <input id="jumlah_soal_input" type="number" min="1" max="50" placeholder="Masukkan jumlah kolom pertanyaan (misal: 10)" style="width: 100%; box-sizing: border-box; min-height: 42px; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; font-weight: 600; color: #0f172a; font-family: inherit;">
            </div>
            <button type="button" class="btn-3d btn-3d-secondary" id="generate-soal-btn" style="min-height: 42px; padding: 0 20px;">
                Generate Kolom Pertanyaan
            </button>
        </div>

        <!-- Kamus & Panduan Opsi Kategori Card -->
        <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; margin-bottom: 28px; box-shadow: 0 4px 16px rgba(0,0,0,0.02); overflow: hidden;">
            <div style="padding: 18px 24px;">
                <div style="display: flex; justify-content: space-between; align-items: center; cursor: pointer;" onclick="togglePanduan()">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <div style="width: 32px; height: 32px; border-radius: 8px; background: #e0f2fe; color: #0369a1; display: flex; align-items: center; justify-content: center; font-weight: 800;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        </div>
                        <h3 style="margin: 0; font-size: 1.05rem; font-weight: 800; color: #0f766e;">Kamus & Panduan Opsi Kategori (RIASEC, DAT, DISC)</h3>
                    </div>
                    <span id="toggle-icon-panduan" style="font-weight: 800; color: #0f766e; font-size: 0.85rem; background: #ffffff; padding: 4px 12px; border-radius: 20px; border: 1px solid #cbd5e1;">[ Tampilkan Panduan ]</span>
                </div>
                
                <div id="panduan-content" style="display: none; margin-top: 18px; border-top: 1px solid #e2e8f0; padding-top: 18px; font-size: 0.875rem; line-height: 1.6; color: #334155;">
                    <p style="margin-top: 0; margin-bottom: 16px; font-style: italic; color: #64748b; font-weight: 600;">Gunakan kamus ini sebagai panduan untuk memetakan setiap pilihan jawaban ke sub-kategori psikologi yang sesuai. Hal ini memastikan algoritma C4.5 dapat melakukan klasifikasi karir secara tepat.</p>
                    
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                        <!-- MINAT (RIASEC) -->
                        <div style="background: #ffffff; padding: 18px; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                            <h4 style="margin-top: 0; margin-bottom: 12px; color: #0f766e; border-bottom: 2px solid #0f766e; padding-bottom: 6px; font-weight: 800; font-size: 0.95rem;">Minat (RIASEC / Holland Code)</h4>
                            <ul style="padding-left: 18px; margin: 0; display: flex; flex-direction: column; gap: 8px; list-style-type: disc;">
                                <li><strong>Realistic (Realistis):</strong> Suka kerja praktis dengan benda, alat, mesin, atau tanaman/hewan (misal: instalasi kabel, pertukangan, hidroponik).</li>
                                <li><strong>Investigative (Penyelidikan):</strong> Suka analisis, observasi, riset ilmiah, troubleshooting eror, dan logika matematika.</li>
                                <li><strong>Artistic (Artistik):</strong> Suka seni, desain grafis/UI, menulis kreatif, musik, dan ekspresi diri bebas.</li>
                                <li><strong>Social (Sosial):</strong> Suka mengajar, membantu, konseling, atau melatih teman/kelompok.</li>
                                <li><strong>Enterprising (Giat):</strong> Suka memimpin, bisnis, wirausaha, promosi, negosiasi, dan membujuk orang lain.</li>
                                <li><strong>Conventional (Konvensional):</strong> Suka keteraturan, administrasi kantor, pembukuan uang, pencatatan data/arsip, dan kerapian.</li>
                            </ul>
                        </div>

                        <!-- BAKAT (DAT) -->
                        <div style="background: #ffffff; padding: 18px; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                            <h4 style="margin-top: 0; margin-bottom: 12px; color: #0f766e; border-bottom: 2px solid #0f766e; padding-bottom: 6px; font-weight: 800; font-size: 0.95rem;">Bakat (DAT - Differential Aptitude)</h4>
                            <ul style="padding-left: 18px; margin: 0; display: flex; flex-direction: column; gap: 8px; list-style-type: disc;">
                                <li><strong>Verbal:</strong> Kemampuan memahami/menganalisis kalimat panjang, menulis rapi, dan presentasi/debat lisan.</li>
                                <li><strong>Numerik/Logika:</strong> Kemampuan berhitung cepat, membaca grafik/tabel keuangan, dan memecahkan soal logika runut.</li>
                                <li><strong>Spasial/Visual:</strong> Kemampuan membayangkan objek 3D di kepala, menggambar peta arah, arsitektur, dan sketsa visual.</li>
                                <li><strong>Motorik/Praktikal:</strong> Kemampuan koordinasi tangan-mata, memotong/merakit benda presisi, stamina fisik di lapangan.</li>
                            </ul>
                        </div>

                        <!-- KEPRIBADIAN (DISC) -->
                        <div style="background: #ffffff; padding: 18px; border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.02);">
                            <h4 style="margin-top: 0; margin-bottom: 12px; color: #0f766e; border-bottom: 2px solid #0f766e; padding-bottom: 6px; font-weight: 800; font-size: 0.95rem;">Kepribadian Kerja (DISC)</h4>
                            <ul style="padding-left: 18px; margin: 0; display: flex; flex-direction: column; gap: 8px; list-style-type: disc;">
                                <li><strong>Dominance (Dominan):</strong> Tegas, fokus pada target cepat, menyukai tantangan/kompetisi, siap mengambil keputusan berisiko.</li>
                                <li><strong>Influence (Intuitif/Sosial):</strong> Antusias, ramah, persuasif, suka ngobrol/sosialisasi, pandai memotivasi tim.</li>
                                <li><strong>Steadiness (Stabil/Tenang):</strong> Sabar, setia kawan, pendengar baik, menyukai ritme stabil, menghindari konflik.</li>
                                <li><strong>Compliance (Patuh/Sistematis):</strong> Teliti memeriksa detail agar bebas dari salah ejaan/angka, taat aturan, bekerja terstruktur.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="soals-container" style="display: flex; flex-direction: column; gap: 24px;">
            <!-- Soal blocks will be appended here dynamically -->
        </div>
    </div>

    <!-- Tombol Aksi Form -->
    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); margin-top: 28px; display: flex; justify-content: flex-end; gap: 12px;">
        <a class="btn-3d btn-3d-secondary" href="{{ route('admin.tes.index') }}">Batal</a>
        <button class="btn-3d btn-3d-emerald" type="submit">Simpan Seluruh Tes</button>
    </div>
</form>

    <!-- Templates for Dynamic Javascript Injection -->
    <template id="soal-template">
        <div class="soal-block" data-index="{soal_index}" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden; margin-bottom: 24px;">
            <!-- Card Header -->
            <div style="padding: 18px 24px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; gap: 16px; flex-wrap: wrap;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #0f766e; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.875rem; box-shadow: 0 2px 6px rgba(15, 118, 110, 0.25);">
                        #{soal_display_number}
                    </div>
                    <h3 class="soal-number-label" style="margin: 0; font-size: 1.05rem; font-weight: 800; color: #0f172a; letter-spacing: -0.01em;">
                        Pertanyaan #{soal_display_number}
                    </h3>
                </div>
                <button type="button" class="delete-soal-btn" style="display: inline-flex; align-items: center; gap: 6px; padding: 7px 14px; background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; border-radius: 8px; font-size: 0.8rem; font-weight: 700; cursor: pointer; transition: all 0.2s;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                    <span>Hapus Pertanyaan</span>
                </button>
            </div>

            <!-- Card Body -->
            <div style="padding: 24px 28px; display: flex; flex-direction: column; gap: 20px;">
                <div class="field" style="margin: 0;">
                    <label style="font-weight: 750; color: #334155; font-size: 0.875rem; margin-bottom: 8px; display: block;">Teks Pertanyaan *</label>
                    <textarea name="soals[{soal_index}][pertanyaan]" required placeholder="Masukkan butir pertanyaan psikotes..." style="min-height: 80px; width: 100%; box-sizing: border-box; padding: 12px 16px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.925rem; font-weight: 600; color: #0f172a; line-height: 1.5; font-family: inherit;"></textarea>
                </div>
                <div class="field" style="margin: 0;">
                    <label style="font-weight: 750; color: #334155; font-size: 0.875rem; margin-bottom: 8px; display: block;">Kriteria Penilai *</label>
                    <select name="soals[{soal_index}][kriteria_id]" required class="kriteria-select" style="width: 100%; box-sizing: border-box; min-height: 44px; padding: 10px 14px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 0.9rem; font-weight: 700; color: #0f172a; background-color: #ffffff; font-family: inherit;">
                        <option value="">-- Pilih Kriteria --</option>
                        @foreach ($kriterias as $k)
                            <option value="{{ $k->id }}" data-type="{{ $k->tipe_data }}">{{ $k->nama_kriteria }} ({{ ucfirst($k->tipe_data) }})</option>
                        @endforeach
                    </select>
                    <input name="soals[{soal_index}][urutan]" type="hidden" class="soal-urutan-input">
                </div>

                <!-- Choices Container (only for Categorical) -->
                <div class="choices-section-container" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; display: none;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; flex-wrap: wrap; gap: 8px;">
                        <h4 style="margin: 0; font-size: 0.925rem; font-weight: 800; color: #1e293b;">Pilihan Jawaban (Minimal 2)</h4>
                        <button type="button" class="add-choice-btn" style="display: inline-flex; align-items: center; gap: 4px; padding: 6px 14px; background: #ffffff; border: 1px solid #cbd5e1; color: #0f766e; border-radius: 8px; font-size: 0.8rem; font-weight: 800; cursor: pointer; transition: all 0.2s; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                            + Tambah Pilihan
                        </button>
                    </div>

                    <div class="choices-list-container" style="display: flex; flex-direction: column; gap: 10px;">
                        <!-- Choice rows will be appended here -->
                    </div>
                </div>

                <!-- Info Box for Numeric Criterion -->
                <div class="numeric-info-container" style="background: #f0fdf4; border: 1px solid #ccfbf1; color: #0f766e; border-radius: 12px; padding: 16px 20px; display: none; font-size: 0.875rem; font-weight: 600; line-height: 1.5;">
                    <strong style="font-weight: 800;">Kriteria Numerik Terpilih:</strong> Siswa akan menginput nilai angka secara langsung (skala 0-100) di form kuesioner. Pilihan jawaban tidak diperlukan untuk kriteria ini.
                </div>
            </div>
        </div>
    </template>

    <template id="choice-template">
        <div class="choice-row" data-choice-index="{choice_index}" style="display: grid; grid-template-columns: 2fr 1fr 2fr auto; gap: 10px; align-items: center; background: #ffffff; padding: 10px 14px; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.02);">
            <div>
                <input type="text" name="soals[{soal_index}][pilihans][{choice_index}][pilihan]" required placeholder="Teks Pilihan (misal: Sangat Suka)" style="width: 100%; box-sizing: border-box; min-height: 40px; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.875rem; font-weight: 600; color: #0f172a; font-family: inherit;">
            </div>
            <div>
                <input type="number" name="soals[{soal_index}][pilihans][{choice_index}][skor]" required min="1" max="5" step="0.1" placeholder="Skor (1-5)" style="width: 100%; box-sizing: border-box; min-height: 40px; padding: 8px 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.875rem; font-weight: 700; color: #0f172a; font-family: inherit;">
            </div>
            <div>
                <select name="soals[{soal_index}][pilihans][{choice_index}][kriteria_opsi_id]" required style="width: 100%; box-sizing: border-box; min-height: 40px; padding: 8px 10px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.875rem; font-weight: 700; color: #0f172a; background-color: #ffffff; font-family: inherit;" class="opsi-select">
                    <option value="">-- Pilih Opsi --</option>
                </select>
            </div>
            <div>
                <button type="button" class="delete-choice-btn" style="min-height: 40px; padding: 0 12px; background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </button>
            </div>
        </div>
    </template>

    <!-- JS Logic -->
    <script>
        function togglePanduan() {
            const content = document.getElementById('panduan-content');
            const icon = document.getElementById('toggle-icon-panduan');
            if (content.style.display === 'none') {
                content.style.display = 'block';
                icon.textContent = '[ Sembunyikan Panduan ]';
            } else {
                content.style.display = 'none';
                icon.textContent = '[ Tampilkan Panduan ]';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Criteria and Options JSON data
            const masterKriterias = @json($kriterias);
            const oldSoals = @json(old('soals') ?? []);

            const soalsContainer = document.getElementById('soals-container');
            const addSoalBtn = document.getElementById('add-soal-btn');
            const soalTemplate = document.getElementById('soal-template').innerHTML;
            const choiceTemplate = document.getElementById('choice-template').innerHTML;

            let soalCounter = 0;

            // Add new question
            function addSoal(soalData = null) {
                const currentIdx = soalCounter++;
                
                let html = soalTemplate
                    .replaceAll('{soal_index}', currentIdx)
                    .replaceAll('{soal_display_number}', currentIdx + 1);

                // Insert into DOM
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;
                const soalNode = tempDiv.firstElementChild;
                soalsContainer.appendChild(soalNode);

                // Add delete listener
                soalNode.querySelector('.delete-soal-btn').addEventListener('click', function () {
                    soalNode.remove();
                    renumberSoals();
                });

                const kriteriaSelect = soalNode.querySelector('.kriteria-select');
                const choicesContainer = soalNode.querySelector('.choices-section-container');
                const numericInfo = soalNode.querySelector('.numeric-info-container');
                const addChoiceBtn = soalNode.querySelector('.add-choice-btn');
                const choicesList = soalNode.querySelector('.choices-list-container');

                let choiceCounter = 0;

                // Add choice function specific to this question
                function addChoice(choiceData = null) {
                    const cIdx = choiceCounter++;
                    let cHtml = choiceTemplate
                        .replaceAll('{soal_index}', currentIdx)
                        .replaceAll('{choice_index}', cIdx);

                    const cDiv = document.createElement('div');
                    cDiv.innerHTML = cHtml;
                    const choiceNode = cDiv.firstElementChild;
                    choicesList.appendChild(choiceNode);

                    // Add delete listener
                    choiceNode.querySelector('.delete-choice-btn').addEventListener('click', function () {
                        choiceNode.remove();
                    });

                    // Populate options based on selected kriteria
                    populateOptions(kriteriaSelect.value, choiceNode.querySelector('.opsi-select'));

                    // Populate old value if editing/repopulating
                    if (choiceData) {
                        choiceNode.querySelector('input[type="text"]').value = choiceData.pilihan || '';
                        choiceNode.querySelector('input[type="number"]').value = choiceData.skor || '';
                        const selectEl = choiceNode.querySelector('.opsi-select');
                        if (choiceData.kriteria_opsi_id) {
                            selectEl.value = choiceData.kriteria_opsi_id;
                        }
                    }
                }

                // Listen to kriteria changes
                kriteriaSelect.addEventListener('change', function () {
                    const selectedKriteriaId = this.value;
                    const selectedOption = this.options[this.selectedIndex];
                    const kType = selectedOption ? selectedOption.getAttribute('data-type') : '';

                    if (kType === 'kategorik') {
                        choicesContainer.style.display = 'block';
                        numericInfo.style.display = 'none';
                        enableInputs(choicesContainer);
                        
                        // Refilter options for all existing choices in this block
                        soalNode.querySelectorAll('.opsi-select').forEach(function (selectEl) {
                            const prevVal = selectEl.value;
                            populateOptions(selectedKriteriaId, selectEl);
                            selectEl.value = prevVal; // restore value if matches
                        });

                        // If no choices exist yet, auto add 2 default choices
                        if (choicesList.children.length === 0) {
                            addChoice();
                            addChoice();
                        }
                    } else if (kType === 'numerik') {
                        choicesContainer.style.display = 'none';
                        numericInfo.style.display = 'block';
                        disableInputs(choicesContainer);
                    } else {
                        choicesContainer.style.display = 'none';
                        numericInfo.style.display = 'none';
                        disableInputs(choicesContainer);
                    }
                });

                addChoiceBtn.addEventListener('click', function () {
                    addChoice();
                });

                // Populate with old/initial data if present
                if (soalData) {
                    soalNode.querySelector('textarea').value = soalData.pertanyaan || '';
                    kriteriaSelect.value = soalData.kriteria_id || '';
                    soalNode.querySelector('input[name*="[urutan]"]').value = soalData.urutan || '';
                    
                    // Trigger kriteria change behavior
                    kriteriaSelect.dispatchEvent(new Event('change'));

                    // Populate choices if present
                    if (soalData.pilihans && Array.isArray(Object.values(soalData.pilihans))) {
                        // Clear pre-created default choices first
                        choicesList.innerHTML = '';
                        Object.values(soalData.pilihans).forEach(function (cData) {
                            addChoice(cData);
                        });
                    }
                } else {
                    // Default state when adding a new empty question
                    kriteriaSelect.dispatchEvent(new Event('change'));
                }
                
                renumberSoals();
            }

            // Populate options select element from a selected criteria ID
            function populateOptions(kriteriaId, selectEl) {
                selectEl.innerHTML = '<option value="">-- Pilih Opsi --</option>';
                if (!kriteriaId) return;

                const kriteria = masterKriterias.find(k => k.id == kriteriaId);
                if (kriteria && kriteria.opsis) {
                    kriteria.opsis.forEach(function (opsi) {
                        const opt = document.createElement('option');
                        opt.value = opsi.id;
                        opt.textContent = opsi.label;
                        selectEl.appendChild(opt);
                    });
                }
            }

            // Disable all input fields in a container so they are not sent to server
            function disableInputs(container) {
                container.querySelectorAll('input, select').forEach(function (el) {
                    el.disabled = true;
                    el.required = false;
                });
            }

            // Enable all input fields in a container
            function enableInputs(container) {
                container.querySelectorAll('input, select').forEach(function (el) {
                    el.disabled = false;
                    el.required = true;
                });
            }

            function renumberSoals() {
                const blocks = soalsContainer.querySelectorAll('.soal-block');
                blocks.forEach(function (block, idx) {
                    const label = block.querySelector('.soal-number-label');
                    if (label) {
                        label.textContent = `Pertanyaan #${idx + 1}`;
                    }
                    const urutanInput = block.querySelector('input[name*="[urutan]"]');
                    if (urutanInput) {
                        urutanInput.value = idx + 1;
                    }
                });
            }
            // Trigger click on add question button
            addSoalBtn.addEventListener('click', function () {
                addSoal();
            });

            // Generate bulk questions logic
            const jumlahSoalInput = document.getElementById('jumlah_soal_input');
            const generateSoalBtn = document.getElementById('generate-soal-btn');

            generateSoalBtn.addEventListener('click', function () {
                const count = parseInt(jumlahSoalInput.value);
                if (isNaN(count) || count < 1 || count > 50) {
                    alert('Silakan masukkan jumlah soal yang valid antara 1 sampai 50.');
                    return;
                }

                if (soalsContainer.children.length > 0) {
                    if (!confirm('Membuat kolom baru akan menghapus soal yang saat ini tampil di halaman. Lanjutkan?')) {
                        return;
                    }
                }

                soalsContainer.innerHTML = '';
                soalCounter = 0;

                for (let i = 0; i < count; i++) {
                    addSoal();
                }
            });

            // Initialize form with old values on validation failure
            if (Object.keys(oldSoals).length > 0) {
                Object.values(oldSoals).forEach(function (soalData) {
                    addSoal(soalData);
                });
            } else {
                // Add 1 default empty question on fresh load
                addSoal();
            }
            // === BANK SOAL INTERACTIVE LOGIC ===
            const bankSoalData = @json($bankSoals);

            let activeBankTab = 'Minat';
            let selectedBankQuestions = new Set();

            const bankModal = document.getElementById('bank-soal-modal');
            const openBankBtn = document.getElementById('open-bank-btn');
            const bankSoalsList = document.getElementById('bank-soals-list');
            const selectAllBankBtn = document.getElementById('select-all-bank-btn');
            const importBankSoalBtn = document.getElementById('import-bank-soal-btn');
            const bankSoalSearch = document.getElementById('bank-soal-search');

            if (bankSoalSearch) {
                bankSoalSearch.addEventListener('input', function() {
                    renderBankQuestions();
                });
            }

            // Open Modal
            openBankBtn.addEventListener('click', function() {
                bankModal.style.display = 'flex';
                selectedBankQuestions.clear();
                if (bankSoalSearch) {
                    bankSoalSearch.value = '';
                }
                updateImportBtnCount();
                switchBankTab('Minat');
            });

            // Close Modal
            window.closeBankModal = function() {
                bankModal.style.display = 'none';
            };

            // Switch Tab
            window.switchBankTab = function(tabName) {
                activeBankTab = tabName;
                
                // Toggle active style in tabs
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    if (btn.getAttribute('data-tab') === tabName) {
                        btn.classList.add('active');
                        btn.style.color = '#0f766e';
                        btn.style.borderBottomColor = '#0f766e';
                    } else {
                        btn.classList.remove('active');
                        btn.style.color = '#64748b';
                        btn.style.borderBottomColor = 'transparent';
                    }
                });

                renderBankQuestions();
            };

            // Render Questions under Active Tab
            function renderBankQuestions() {
                bankSoalsList.innerHTML = '';
                
                const query = (document.getElementById('bank-soal-search')?.value || '').toLowerCase().trim();
                
                const filtered = bankSoalData.filter(q => {
                    const matchTab = q.kriteriaName === activeBankTab;
                    const matchQuery = !query || 
                                       q.pertanyaan.toLowerCase().includes(query) || 
                                       q.tag.toLowerCase().includes(query) ||
                                       (q.opsiLabel && q.opsiLabel.toLowerCase().includes(query));
                    return matchTab && matchQuery;
                });
                
                if (filtered.length === 0) {
                    bankSoalsList.innerHTML = '<p style="color:#64748b; font-style:italic; text-align:center; padding:20px;">Tidak ada pertanyaan yang cocok dengan pencarian Anda.</p>';
                    return;
                }

                filtered.forEach((q, idx) => {
                    const globalIndex = bankSoalData.findIndex(item => item.pertanyaan === q.pertanyaan);
                    const isChecked = selectedBankQuestions.has(globalIndex);
                    
                    // Determine badge style
                    let badgeBg = '#f1f5f9';
                    let badgeColor = '#475569';
                    if (q.tag === 'TKJ') {
                        badgeBg = '#e0f2fe';
                        badgeColor = '#0369a1';
                    } else if (q.tag === 'AKL') {
                        badgeBg = '#fef3c7';
                        badgeColor = '#b45309';
                    } else if (q.tag === 'ATPH') {
                        badgeBg = '#dcfce7';
                        badgeColor = '#15803d';
                    }
                    
                    const itemDiv = document.createElement('label');
                    itemDiv.style.display = 'flex';
                    itemDiv.style.alignItems = 'flex-start';
                    itemDiv.style.gap = '12px';
                    itemDiv.style.padding = '12px 16px';
                    itemDiv.style.border = '1px solid #e2e8f0';
                    itemDiv.style.borderRadius = '8px';
                    itemDiv.style.cursor = 'pointer';
                    itemDiv.style.transition = 'all 0.15s';
                    itemDiv.style.background = isChecked ? '#f0fdfa' : '#ffffff';
                    if (isChecked) {
                        itemDiv.style.borderColor = '#99f6e4';
                    }

                    itemDiv.innerHTML = `
                        <input type="checkbox" onchange="toggleSelectBankQuestion(${globalIndex}, this)" ${isChecked ? 'checked' : ''} style="margin-top:4px; cursor:pointer; width:16px; height:16px;">
                        <div style="flex:1;">
                            <span style="font-size:0.875rem; color:#334155; font-weight:600;">${q.pertanyaan}</span>
                            <div style="margin-top:6px; display:flex; gap:6px; align-items:center;">
                                <span style="font-size:0.7rem; font-weight:700; background:${badgeBg}; color:${badgeColor}; padding:2px 8px; border-radius:12px;">${q.tag}</span>
                                ${q.opsiLabel ? '<span style="font-size:0.7rem; font-weight:700; background:#f3e8ff; color:#6b21a8; padding:2px 8px; border-radius:12px;">Opsi: ' + q.opsiLabel + '</span>' : ''}
                            </div>
                        </div>
                    `;

                    bankSoalsList.appendChild(itemDiv);
                });

                updateSelectAllBtnState();
            }

            // Toggle Single Checkbox Selection
            window.toggleSelectBankQuestion = function(globalIndex, checkboxEl) {
                const labelEl = checkboxEl.closest('label');
                if (checkboxEl.checked) {
                    selectedBankQuestions.add(globalIndex);
                    if (labelEl) {
                        labelEl.style.background = '#f0fdfa';
                        labelEl.style.borderColor = '#99f6e4';
                    }
                } else {
                    selectedBankQuestions.delete(globalIndex);
                    if (labelEl) {
                        labelEl.style.background = '#ffffff';
                        labelEl.style.borderColor = '#e2e8f0';
                    }
                }
                updateImportBtnCount();
                updateSelectAllBtnState();
            };

            // Select All / Deselect All under current tab
            window.toggleSelectAllBankSoal = function() {
                const filteredIndices = bankSoalData
                    .map((q, idx) => ({ q, idx }))
                    .filter(item => item.q.kriteriaName === activeBankTab)
                    .map(item => item.idx);
                
                const allSelected = filteredIndices.every(idx => selectedBankQuestions.has(idx));
                
                if (allSelected) {
                    // Deselect all under active tab
                    filteredIndices.forEach(idx => selectedBankQuestions.delete(idx));
                } else {
                    // Select all under active tab
                    filteredIndices.forEach(idx => selectedBankQuestions.add(idx));
                }

                renderBankQuestions();
                updateImportBtnCount();
            };

            // Update Select All Button Text
            function updateSelectAllBtnState() {
                const filteredIndices = bankSoalData
                    .map((q, idx) => ({ q, idx }))
                    .filter(item => item.q.kriteriaName === activeBankTab)
                    .map(item => item.idx);
                
                const allSelected = filteredIndices.length > 0 && filteredIndices.every(idx => selectedBankQuestions.has(idx));
                selectAllBankBtn.textContent = allSelected ? 'Hapus Semua Pilihan' : 'Pilih Semua Kategori Ini';
            }

            // Update Import Button Text with count
            function updateImportBtnCount() {
                importBankSoalBtn.textContent = `Masukkan ${selectedBankQuestions.size} Pertanyaan Terpilih`;
                importBankSoalBtn.disabled = selectedBankQuestions.size === 0;
                importBankSoalBtn.style.opacity = selectedBankQuestions.size === 0 ? '0.5' : '1';
            }

            // Helper to find Opsi ID on client-side
            function findOpsiId(kriteriaName, label) {
                if (!label) return null;
                const kriteria = masterKriterias.find(k => k.nama_kriteria === kriteriaName);
                if (kriteria && kriteria.opsis) {
                    const opsi = kriteria.opsis.find(o => o.label === label);
                    return opsi ? opsi.id : null;
                }
                return null;
            }

            // Import Selected Questions
            window.importSelectedBankSoal = function() {
                if (selectedBankQuestions.size === 0) return;
                
                // Check if we should clear default empty questions
                const hasEmptyQuestions = soalsContainer.children.length === 1 && 
                    soalsContainer.querySelector('textarea').value.trim() === '';
                
                if (hasEmptyQuestions) {
                    soalsContainer.innerHTML = '';
                    soalCounter = 0;
                }

                selectedBankQuestions.forEach(globalIndex => {
                    const q = bankSoalData[globalIndex];
                    const kriteria = masterKriterias.find(k => k.nama_kriteria === q.kriteriaName);
                    if (!kriteria) return;

                    const opsiId = findOpsiId(q.kriteriaName, q.opsiLabel);
                    
                    let choices = [];
                    if (q.kriteriaName === 'Minat') {
                        choices = [
                            { pilihan: 'Sangat Suka', skor: 5, kriteria_opsi_id: opsiId },
                            { pilihan: 'Suka', skor: 4, kriteria_opsi_id: opsiId },
                            { pilihan: 'Biasa Saja', skor: 3, kriteria_opsi_id: opsiId },
                            { pilihan: 'Kurang Suka', skor: 2, kriteria_opsi_id: opsiId },
                            { pilihan: 'Tidak Suka', skor: 1, kriteria_opsi_id: opsiId }
                        ];
                    } else if (q.kriteriaName === 'Bakat') {
                        choices = [
                            { pilihan: 'Sangat Mampu', skor: 5, kriteria_opsi_id: opsiId },
                            { pilihan: 'Mampu', skor: 4, kriteria_opsi_id: opsiId },
                            { pilihan: 'Cukup Mampu', skor: 3, kriteria_opsi_id: opsiId },
                            { pilihan: 'Kurang Mampu', skor: 2, kriteria_opsi_id: opsiId },
                            { pilihan: 'Tidak Mampu', skor: 1, kriteria_opsi_id: opsiId }
                        ];
                    } else if (q.kriteriaName === 'Kepribadian') {
                        choices = [
                            { pilihan: 'Sangat Setuju', skor: 5, kriteria_opsi_id: opsiId },
                            { pilihan: 'Setuju', skor: 4, kriteria_opsi_id: opsiId },
                            { pilihan: 'Netral', skor: 3, kriteria_opsi_id: opsiId },
                            { pilihan: 'Kurang Setuju', skor: 2, kriteria_opsi_id: opsiId },
                            { pilihan: 'Tidak Setuju', skor: 1, kriteria_opsi_id: opsiId }
                        ];
                    }

                    const soalData = {
                        pertanyaan: q.pertanyaan,
                        kriteria_id: kriteria.id,
                        urutan: '',
                        pilihans: choices
                    };

                    addSoal(soalData);
                });

                closeBankModal();
            };
        });
    </script>

    <!-- Modal Bank Soal -->
    <div id="bank-soal-modal" style="display:none; position:fixed; inset:0; background:rgba(15, 23, 42, 0.6); z-index:9999; backdrop-filter:blur(4px); justify-content:center; align-items:center; padding:16px;">
        <div style="background:#ffffff; width:min(100% - 32px, 860px); max-height:85vh; border-radius:16px; display:flex; flex-direction:column; box-shadow:0 25px 50px -12px rgba(0, 0, 0, 0.25); overflow:hidden;">
            <!-- Header -->
            <div style="padding:20px 24px; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center; background:#f8fafc;">
                <div style="display:flex; align-items:center; gap:8px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#0284c7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    <h3 style="margin:0; font-size:1.15rem; font-weight:800; color:#0f172a;">Ambil dari Bank Soal Standar (3 Jurusan)</h3>
                </div>
                <button type="button" onclick="closeBankModal()" style="background:none; border:none; cursor:pointer; color:#94a3b8; font-size:1.5rem; line-height:1; font-weight:700;">&times;</button>
            </div>

            <!-- Search Bar -->
            <div style="padding:12px 24px; border-bottom:1px solid #e2e8f0; background:#ffffff; display:flex; gap:10px; align-items:center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#64748b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="bank-soal-search" placeholder="Cari soal berdasarkan kata kunci (misal: merakit, debit, kebun)..." style="flex:1; border:1px solid #cbd5e1; border-radius:8px; padding:8px 12px; font-size:0.85rem; min-height:36px; outline:none; box-sizing:border-box; width:100%;">
            </div>

            <!-- Tabs Navigation -->
            <div style="display:flex; background:#f1f5f9; border-bottom:1px solid #e2e8f0; padding:0 16px; overflow-x:auto;">
                <button type="button" class="tab-btn active" onclick="switchBankTab('Minat')" data-tab="Minat" style="border:none; background:none; padding:14px 20px; font-weight:700; font-size:0.875rem; color:#0f766e; border-bottom:3px solid #0f766e; cursor:pointer; transition:all 0.2s; white-space:nowrap;">Minat (RIASEC)</button>
                <button type="button" class="tab-btn" onclick="switchBankTab('Bakat')" data-tab="Bakat" style="border:none; background:none; padding:14px 20px; font-weight:600; font-size:0.875rem; color:#64748b; border-bottom:3px solid transparent; cursor:pointer; transition:all 0.2s; white-space:nowrap;">Bakat (DAT)</button>
                <button type="button" class="tab-btn" onclick="switchBankTab('Kepribadian')" data-tab="Kepribadian" style="border:none; background:none; padding:14px 20px; font-weight:600; font-size:0.875rem; color:#64748b; border-bottom:3px solid transparent; cursor:pointer; transition:all 0.2s; white-space:nowrap;">Kepribadian (DISC)</button>
                <button type="button" class="tab-btn" onclick="switchBankTab('Nilai Akademik')" data-tab="Nilai Akademik" style="border:none; background:none; padding:14px 20px; font-weight:600; font-size:0.875rem; color:#64748b; border-bottom:3px solid transparent; cursor:pointer; transition:all 0.2s; white-space:nowrap;">Nilai Akademik (Numerik)</button>
            </div>

            <!-- Content List -->
            <div id="bank-soals-list" style="padding:24px; overflow-y:auto; flex:1; display:flex; flex-direction:column; gap:12px; background:#ffffff; min-height:250px;">
                <!-- Dynamically loaded questions based on selected tab -->
            </div>

            <!-- Footer -->
            <div style="padding:16px 24px; border-top:1px solid #e2e8f0; background:#f8fafc; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                <button type="button" class="button secondary" onclick="toggleSelectAllBankSoal()" id="select-all-bank-btn" style="min-height:36px; padding:0 14px; font-size:0.85rem; font-weight:700;">Pilih Semua Kategori Ini</button>
                <div style="display:flex; gap:10px;">
                    <button type="button" class="button secondary" onclick="closeBankModal()" style="min-height:40px;">Batal</button>
                    <button type="button" class="button" onclick="importSelectedBankSoal()" id="import-bank-soal-btn" style="background-color:#0284c7; font-weight:700; min-height:40px;">Masukkan 0 Pertanyaan Terpilih</button>
                </div>
            </div>
        </div>
    </div>
@endsection

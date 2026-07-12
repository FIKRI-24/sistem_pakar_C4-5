@extends('layouts.app', ['title' => 'Buat Tes Lengkap'])

@section('content')
    <div class="toolbar">
        <div>
            <p class="role-badge">Form Terintegrasi</p>
            <h1>Buat Tes Lengkap</h1>
            <p class="muted">Buat 1 Tes, semua Soal, dan Pilihan Jawabannya sekaligus dalam satu halaman.</p>
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

        <!-- Detail Tes -->
        <section class="panel" style="margin-bottom:28px">
            <div class="panel-body">
                <h2 style="margin-top:0; font-size:1.3rem; font-weight:750; color:#1e293b; border-bottom:1px solid #e2e8f0; padding-bottom:12px; margin-bottom:20px;">
                    Detail Tes / Kuesioner
                </h2>

                <div class="field">
                    <label for="nama_tes">Nama Tes *</label>
                    <input id="nama_tes" name="nama_tes" type="text" value="{{ old('nama_tes') }}" required placeholder="Contoh: Kuesioner Minat Bakat Siswa v1">
                </div>

                <div class="field">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" placeholder="Tulis instruksi pengerjaan tes untuk siswa...">{{ old('deskripsi') }}</textarea>
                </div>

                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px;">
                    <div class="field">
                        <label for="durasi_menit">Estimasi Durasi (Menit)</label>
                        <input id="durasi_menit" name="durasi_menit" type="number" min="1" value="{{ old('durasi_menit') }}" placeholder="Contoh: 15">
                    </div>

                    <div class="field">
                        <label for="status_aktif">Status Aktif *</label>
                        <select id="status_aktif" name="status_aktif" required>
                            <option value="1" @selected(old('status_aktif', '1') == '1')>Aktif</option>
                            <option value="0" @selected(old('status_aktif') == '0')>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
        </section>

        <!-- Daftar Soal -->
        <div style="margin-bottom:28px">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
                <h2 style="font-size:1.3rem; font-weight:750; color:#1e293b; margin:0;">Daftar Pertanyaan & Pilihan Jawaban</h2>
                <button type="button" class="button" id="add-soal-btn" style="background-color:#0f766e;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:6px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Tambah Soal Manual
                </button>
            </div>

            <!-- Generator Jumlah Soal -->
            <div style="background:#ffffff; border:1px solid #e2e8f0; border-radius:12px; padding:20px; margin-bottom:20px; display:flex; flex-wrap:wrap; align-items:flex-end; gap:16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
                <div style="flex:1; min-width:200px; margin-bottom:0;" class="field">
                    <label for="jumlah_soal_input" style="font-weight:700; color:#334155;">Buat Banyak Soal Sekaligus</label>
                    <input id="jumlah_soal_input" type="number" min="1" max="50" placeholder="Masukkan jumlah kolom soal (misal: 10)" style="width:100%; box-sizing:border-box;">
                </div>
                <button type="button" class="button secondary" id="generate-soal-btn" style="min-height:42px; background:#f8fafc; font-weight:700; border: 1px solid #cbd5e1;">
                    Generate Kolom Soal
                </button>
            </div>

            <div id="soals-container" style="display:flex; flex-direction:column; gap:24px;">
                <!-- Soal blocks will be appended here dynamically -->
            </div>
        </div>

        <!-- Tombol Aksi Form -->
        <div class="panel">
            <div class="panel-body" style="padding:20px; display:flex; justify-content:flex-end; gap:12px;">
                <a class="button secondary" href="{{ route('admin.tes.index') }}">Batal</a>
                <button class="button" type="submit">Simpan Seluruh Tes</button>
            </div>
        </div>
    </form>

    <!-- Templates for Dynamic Javascript Injection -->
    <template id="soal-template">
        <div class="panel soal-block" data-index="{soal_index}" style="border-left: 4px solid #0f766e;">
            <div class="panel-body" style="padding: 24px 28px;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:16px; margin-bottom:16px;">
                    <h3 class="soal-number-label" style="margin:0; font-size:1.1rem; font-weight:700; color:#0f766e;">
                        Pertanyaan #{soal_display_number}
                    </h3>
                    <button type="button" class="button danger delete-soal-btn" style="min-height:32px; padding:0 10px; font-size:0.85rem;">
                        Hapus Soal
                    </button>
                </div>

                <div class="field">
                    <label>Teks Pertanyaan *</label>
                    <textarea name="soals[{soal_index}][pertanyaan]" required placeholder="Masukkan butir pertanyaan psikotes..." style="min-height:70px;"></textarea>
                </div>

                <div style="display:grid; grid-template-columns: 2fr 1fr; gap:16px; margin-bottom:20px;">
                    <div class="field">
                        <label>Kriteria Penilai *</label>
                        <select name="soals[{soal_index}][kriteria_id]" required class="kriteria-select">
                            <option value="">-- Pilih Kriteria --</option>
                            @foreach ($kriterias as $k)
                                <option value="{{ $k->id }}" data-type="{{ $k->tipe_data }}">{{ $k->nama_kriteria }} ({{ ucfirst($k->tipe_data) }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field">
                        <label>Urutan Tampil</label>
                        <input name="soals[{soal_index}][urutan]" type="number" min="1" placeholder="Opsional">
                    </div>
                </div>

                <!-- Choices Container (only for Categorical) -->
                <div class="choices-section-container" style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:16px; display:none;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                        <h4 style="margin:0; font-size:0.9rem; font-weight:700; color:#334155;">Pilihan Jawaban (Minimal 2)</h4>
                        <button type="button" class="button secondary add-choice-btn" style="min-height:30px; padding:0 10px; font-size:0.8rem; background:#ffffff;">
                            + Tambah Pilihan
                        </button>
                    </div>

                    <div class="choices-list-container" style="display:flex; flex-direction:column; gap:8px;">
                        <!-- Choice rows will be appended here -->
                    </div>
                </div>

                <!-- Info Box for Numeric Criterion -->
                <div class="numeric-info-container" style="background:#f0f9ff; border:1px solid #bae6fd; color:#0369a1; border-radius:8px; padding:14px; display:none; font-size:0.875rem;">
                    <strong>Kriteria Numerik Terpilih</strong>: Siswa akan menginput nilai angka secara langsung (skala 0-100) di form kuesioner. Pilihan jawaban tidak diperlukan untuk kriteria ini.
                </div>
            </div>
        </div>
    </template>

    <template id="choice-template">
        <div class="choice-row" data-choice-index="{choice_index}" style="display:grid; grid-template-columns: 2fr 1fr 2fr auto; gap:10px; align-items:center; background:#ffffff; padding:8px; border:1px solid #e2e8f0; border-radius:6px;">
            <div>
                <input type="text" name="soals[{soal_index}][pilihans][{choice_index}][pilihan]" required placeholder="Teks Pilihan (misal: Sangat Suka)" style="width:100%; box-sizing:border-box; min-height:36px; padding:0 10px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.85rem;">
            </div>
            <div>
                <input type="number" name="soals[{soal_index}][pilihans][{choice_index}][skor]" required min="1" max="5" step="0.1" placeholder="Skor (1-5)" style="width:100%; box-sizing:border-box; min-height:36px; padding:0 10px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.85rem;">
            </div>
            <div>
                <select name="soals[{soal_index}][pilihans][{choice_index}][kriteria_opsi_id]" required style="width:100%; box-sizing:border-box; min-height:36px; padding:0 8px; border:1px solid #cbd5e1; border-radius:6px; font-size:0.85rem;" class="opsi-select">
                    <option value="">-- Pilih Opsi --</option>
                </select>
            </div>
            <div>
                <button type="button" class="button danger delete-choice-btn" style="min-height:36px; padding:0 10px; background:#ef4444; border-radius:6px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                </button>
            </div>
        </div>
    </template>

    <!-- JS Logic -->
    <script>
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

            // Renumber all question display headings
            function renumberSoals() {
                const labels = soalsContainer.querySelectorAll('.soal-number-label');
                labels.forEach(function (label, idx) {
                    label.textContent = `Pertanyaan #${idx + 1}`;
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
        });
    </script>
@endsection

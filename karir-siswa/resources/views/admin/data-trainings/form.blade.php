@extends('layouts.app', ['title' => $dataTraining->exists ? 'Ubah Data Training' : 'Tambah Data Training'])

@section('content')
    <style>
        .btn-3d {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 0.875rem;
            text-decoration: none;
            cursor: pointer;
            border: none;
            outline: none;
            transition: all 0.15s ease-in-out;
            user-select: none;
            line-height: 1.2;
        }
        .btn-3d:active {
            transform: translateY(3px) !important;
        }

        .btn-3d-emerald {
            background: linear-gradient(180deg, #34d399 0%, #059669 100%);
            color: #ffffff !important;
            box-shadow: 0 4px 0 #047857, 0 6px 14px rgba(5, 150, 105, 0.35);
            border-top: 1px solid rgba(255, 255, 255, 0.3);
        }
        .btn-3d-emerald:hover {
            background: linear-gradient(180deg, #6ee7b7 0%, #047857 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 0 #047857, 0 10px 18px rgba(5, 150, 105, 0.45);
        }
        .btn-3d-emerald:active {
            box-shadow: 0 1px 0 #047857, 0 2px 4px rgba(5, 150, 105, 0.3);
        }

        .btn-3d-secondary {
            background: linear-gradient(180deg, #ffffff 0%, #e2e8f0 100%);
            color: #475569 !important;
            box-shadow: 0 3.5px 0 #cbd5e1, 0 4px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #cbd5e1;
        }
        .btn-3d-secondary:hover {
            background: linear-gradient(180deg, #ffffff 0%, #cbd5e1 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 0 #94a3b8;
            color: #0f172a !important;
        }
        .btn-3d-secondary:active {
            box-shadow: 0 1px 0 #94a3b8;
        }

        .form-input {
            width: 100%;
            min-height: 44px;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #0f172a;
            background: #ffffff;
            outline: none;
            box-sizing: border-box;
            transition: all 0.2s;
        }
        .form-input:focus {
            border-color: #0f766e;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
        }
    </style>

    <div style="max-width: 720px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px;">
        <!-- Back button & Breadcrumb -->
        <div>
            <a href="{{ route('admin.data-trainings.index') }}" style="display: inline-flex; align-items: center; gap: 6px; color: #64748b; font-size: 0.875rem; font-weight: 700; text-decoration: none; transition: color 0.2s;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Kembali ke Data Training C4.5
            </a>
        </div>

        <!-- Form Card Container -->
        <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); overflow: hidden;">
            <div style="padding: 24px 32px; border-bottom: 1px solid #f1f5f9; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);">
                <div style="display: inline-flex; align-items: center; gap: 6px; background: #f0fdf4; border: 1px solid #ccfbf1; color: #0f766e; font-size: 0.75rem; font-weight: 800; padding: 2px 10px; border-radius: 20px; text-transform: uppercase; margin-bottom: 6px;">
                    Dataset Management
                </div>
                <h1 style="margin: 0; font-size: 1.5rem; font-weight: 800; color: #0f172a; letter-spacing: -0.02em;">
                    {{ $dataTraining->exists ? 'Ubah Data Training' : 'Tambah Data Training Baru' }}
                </h1>
            </div>

            <div style="padding: 32px;">
                <form method="POST" action="{{ $dataTraining->exists ? route('admin.data-trainings.update', $dataTraining) : route('admin.data-trainings.store') }}" style="display: flex; flex-direction: column; gap: 20px;">
                    @csrf 
                    @if($dataTraining->exists) @method('PUT') @endif

                    <!-- Label Karir & Sumber -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                        <div>
                            <label for="label_karir_id" style="display: block; font-size: 0.875rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Target Label Karir <span style="color:#ef4444;">*</span></label>
                            <select id="label_karir_id" name="label_karir_id" class="form-input" required>
                                <option value="">Pilih Karir Rekomendasi</option>
                                @foreach($karirs as $karir)
                                    <option value="{{ $karir->id }}" @selected((string) old('label_karir_id', $dataTraining->label_karir_id) === (string) $karir->id)>{{ $karir->nama_karir }}</option>
                                @endforeach
                            </select>
                            @error('label_karir_id')<div style="color:#ef4444; font-size:0.8rem; font-weight:600; margin-top:4px;">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label for="sumber" style="display: block; font-size: 0.875rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Sumber Data Latih</label>
                            <input id="sumber" name="sumber" class="form-input" value="{{ old('sumber', $dataTraining->sumber) }}" placeholder="Contoh: Wawancara 2026 / Dataset Alumni">
                            @error('sumber')<div style="color:#ef4444; font-size:0.8rem; font-weight:600; margin-top:4px;">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Separator -->
                    <div style="border-top: 1px dashed #e2e8f0; margin: 4px 0;"></div>
                    <strong style="font-size: 0.95rem; font-weight: 800; color: #0f172a;">Input Nilai Atribut Kriteria:</strong>

                    <!-- Dynamic Kriterias Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                        @php($existing = $dataTraining->atributs->keyBy('kriteria_id'))
                        @foreach($kriterias as $kriteria)
                            <div>
                                <label for="atribut_{{ $kriteria->id }}" style="display: block; font-size: 0.875rem; font-weight: 700; color: #334155; margin-bottom: 6px;">
                                    {{ $kriteria->nama_kriteria }} <span style="color:#ef4444;">*</span>
                                </label>

                                @if($kriteria->tipe_data === \App\Models\Kriteria::TYPE_KATEGORIK)
                                    <select id="atribut_{{ $kriteria->id }}" name="atributs[{{ $kriteria->id }}][nilai_kategorik]" class="form-input" required>
                                        <option value="">Pilih Opsi Kategori</option>
                                        @foreach($kriteria->opsis as $opsi)
                                            <option value="{{ $opsi->label }}" @selected(old("atributs.{$kriteria->id}.nilai_kategorik", $existing->get($kriteria->id)?->nilai_kategorik) === $opsi->label)>{{ $opsi->label }}</option>
                                        @endforeach
                                    </select>
                                    @error("atributs.{$kriteria->id}.nilai_kategorik")<div style="color:#ef4444; font-size:0.8rem; font-weight:600; margin-top:4px;">{{ $message }}</div>@enderror
                                @else
                                    <input id="atribut_{{ $kriteria->id }}" type="number" name="atributs[{{ $kriteria->id }}][nilai_numerik]" min="0" max="100" step="0.01" class="form-input" value="{{ old("atributs.{$kriteria->id}.nilai_numerik", $existing->get($kriteria->id)?->nilai_numerik) }}" placeholder="Skor 0 - 100" required>
                                    @error("atributs.{$kriteria->id}.nilai_numerik")<div style="color:#ef4444; font-size:0.8rem; font-weight:600; margin-top:4px;">{{ $message }}</div>@enderror
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- 3D Action Buttons -->
                    <div style="display: flex; gap: 12px; margin-top: 8px; padding-top: 20px; border-top: 1px solid #f1f5f9;">
                        <button type="submit" class="btn-3d btn-3d-emerald">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            <span>Simpan Data Training</span>
                        </button>

                        <a href="{{ route('admin.data-trainings.index') }}" class="btn-3d btn-3d-secondary">
                            <span>Batal</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

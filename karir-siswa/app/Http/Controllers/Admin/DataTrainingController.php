<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DataTrainingRequest;
use App\Http\Requests\Admin\ImportDataTrainingRequest;
use App\Imports\DataTrainingSheetImport;
use App\Models\DataTraining;
use App\Models\Karir;
use App\Models\Kriteria;
use App\Services\DataTrainingWriter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class DataTrainingController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->string('q'));
        $dataTrainings = DataTraining::query()
            ->with(['labelKarir', 'atributs.kriteria'])
            ->when($search !== '', fn ($query) => $query
                ->where('sumber', 'like', "%{$search}%")
                ->orWhereHas('labelKarir', fn ($karir) => $karir->where('nama_karir', 'like', "%{$search}%")))
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('admin.data-trainings.index', compact('dataTrainings', 'search'));
    }

    public function create(): View
    {
        return view('admin.data-trainings.form', $this->formData(new DataTraining));
    }

    public function store(DataTrainingRequest $request, DataTrainingWriter $writer): RedirectResponse
    {
        DB::transaction(function () use ($request, $writer) {
            $writer->create(
                $request->input('sumber'),
                $request->integer('label_karir_id'),
                $request->input('atributs'),
                $this->kriterias()
            );
        });

        return to_route('admin.data-trainings.index')->with('success', 'Data training berhasil ditambahkan.');
    }

    public function edit(DataTraining $dataTraining): View
    {
        $dataTraining->load('atributs');

        return view('admin.data-trainings.form', $this->formData($dataTraining));
    }

    public function update(DataTrainingRequest $request, DataTraining $dataTraining, DataTrainingWriter $writer): RedirectResponse
    {
        DB::transaction(function () use ($request, $dataTraining, $writer) {
            $dataTraining->update($request->safe()->only(['sumber', 'label_karir_id']));
            $writer->replaceAtributs($dataTraining, $request->input('atributs'), $this->kriterias());
        });

        return to_route('admin.data-trainings.index')->with('success', 'Data training berhasil diperbarui.');
    }

    public function destroy(DataTraining $dataTraining): RedirectResponse
    {
        $dataTraining->atributs()->delete();
        $dataTraining->delete();

        return to_route('admin.data-trainings.index')->with('success', 'Data training berhasil dihapus.');
    }

    public function importForm(): View
    {
        return view('admin.data-trainings.import');
    }

    public function import(ImportDataTrainingRequest $request, DataTrainingWriter $writer): RedirectResponse
    {
        $import = new DataTrainingSheetImport;
        Excel::import($import, $request->file('file'));
        $kriterias = $this->kriterias();
        $karirs = Karir::query()->pluck('id', 'nama_karir');

        DB::transaction(function () use ($import, $kriterias, $karirs, $writer) {
            foreach ($import->rows as $rowNumber => $row) {
                $normalized = $this->normalizeImportRow($row, $rowNumber + 2, $kriterias, $karirs);
                $writer->create($normalized['sumber'], $normalized['label_karir_id'], $normalized['atributs'], $kriterias);
            }
        });

        return to_route('admin.data-trainings.index')->with('success', count($import->rows).' data training berhasil diimpor.');
    }

    /** @return array<string, mixed> */
    private function formData(DataTraining $dataTraining): array
    {
        return [
            'dataTraining' => $dataTraining,
            'kriterias' => $this->kriterias(),
            'karirs' => Karir::orderBy('nama_karir')->get(),
        ];
    }

    /** @return Collection<int, Kriteria> */
    private function kriterias()
    {
        return Kriteria::with('opsis')->orderBy('id')->get();
    }

    /**
     * @param  array<string, mixed>  $row
     * @param  Collection<int, Kriteria>  $kriterias
     * @param  Collection<string, int>  $karirs
     * @return array{sumber: string|null, label_karir_id: int, atributs: array<int, array<string, mixed>>}
     */
    private function normalizeImportRow(array $row, int $rowNumber, $kriterias, $karirs): array
    {
        $label = trim((string) ($row['label_karir'] ?? ''));
        $labelKarirId = $karirs->get($label);
        if (! $labelKarirId) {
            throw ValidationException::withMessages(['file' => ["Baris {$rowNumber}: label_karir tidak valid."]]);
        }

        $atributs = [];
        foreach ($kriterias as $kriteria) {
            $column = Str::snake($kriteria->nama_kriteria);
            $value = $row[$column] ?? null;
            if ($kriteria->tipe_data === Kriteria::TYPE_KATEGORIK) {
                $labelValue = trim((string) $value);
                if ($labelValue === '' || ! $kriteria->opsis->contains('label', $labelValue)) {
                    throw ValidationException::withMessages(['file' => ["Baris {$rowNumber}: {$column} tidak valid."]]);
                }
                $atributs[$kriteria->id] = ['nilai_kategorik' => $labelValue];
            } elseif (! is_numeric($value) || $value < 0 || $value > 100) {
                throw ValidationException::withMessages(['file' => ["Baris {$rowNumber}: {$column} harus berada pada rentang 0-100."]]);
            } else {
                $atributs[$kriteria->id] = ['nilai_numerik' => (float) $value];
            }
        }

        return [
            'sumber' => filled($row['sumber'] ?? null) ? trim((string) $row['sumber']) : null,
            'label_karir_id' => $labelKarirId,
            'atributs' => $atributs,
        ];
    }
}

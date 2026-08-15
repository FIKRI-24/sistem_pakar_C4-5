<?php

namespace Tests\Feature\Admin;

use App\Models\DataTraining;
use App\Models\Karir;
use App\Models\Kriteria;
use App\Models\User;
use Database\Seeders\KarirFinalSeeder;
use Database\Seeders\KriteriaFinalSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class DataTrainingCrudTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([KriteriaFinalSeeder::class, KarirFinalSeeder::class]);
    }

    public function test_only_admin_can_access_data_training_routes(): void
    {
        $siswa = User::factory()->create(['role' => User::ROLE_SISWA]);

        $this->actingAs($siswa)->get(route('admin.data-trainings.index'))->assertForbidden();
        $this->actingAs($siswa)->get(route('admin.data-trainings.import.form'))->assertForbidden();
    }

    public function test_admin_can_create_update_and_delete_data_training_with_all_final_attributes(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $attributes = $this->attributes('Investigative', 'Numerik/Logika', 88, 'Compliance');

        $this->actingAs($admin)->post(route('admin.data-trainings.store'), [
            'sumber' => 'Wawancara internal',
            'label_karir_id' => Karir::where('nama_karir', 'Network Administrator')->firstOrFail()->id,
            'atributs' => $attributes,
        ])->assertRedirect(route('admin.data-trainings.index'));

        $training = DataTraining::with('atributs')->firstOrFail();
        $this->assertCount(4, $training->atributs);

        $this->actingAs($admin)->put(route('admin.data-trainings.update', $training), [
            'sumber' => 'Wawancara diperbarui',
            'label_karir_id' => Karir::where('nama_karir', 'Network Administrator')->firstOrFail()->id,
            'atributs' => $this->attributes('Investigative', 'Numerik/Logika', 92, 'Compliance'),
        ])->assertRedirect(route('admin.data-trainings.index'));
        $this->assertDatabaseHas('data_training_atributs', ['data_training_id' => $training->id, 'nilai_numerik' => 92]);

        $this->actingAs($admin)->delete(route('admin.data-trainings.destroy', $training));
        $this->assertDatabaseMissing('data_trainings', ['id' => $training->id]);
    }

    public function test_admin_can_import_valid_csv_and_xlsx_rows(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $csv = implode("\n", [
            'sumber,label_karir,minat,bakat,nilai_akademik,kepribadian',
            'Import CSV,Network Administrator,Investigative,Numerik/Logika,89,Compliance',
        ]);
        $csvFile = UploadedFile::fake()->createWithContent('training.csv', $csv);

        $this->actingAs($admin)->post(route('admin.data-trainings.import'), ['file' => $csvFile])
            ->assertRedirect(route('admin.data-trainings.index'));
        $this->assertDatabaseCount('data_trainings', 1);

        $path = tempnam(sys_get_temp_dir(), 'training-');
        $spreadsheet = new Spreadsheet;
        $spreadsheet->getActiveSheet()->fromArray([
            ['sumber', 'label_karir', 'minat', 'bakat', 'nilai_akademik', 'kepribadian'],
            ['Import XLSX', 'Desainer Bangunan', 'Artistic', 'Spasial/Visual', 82, 'Influence'],
        ]);
        (new Xlsx($spreadsheet))->save($path);
        $xlsxFile = new UploadedFile(
            $path,
            'training.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $this->actingAs($admin)->post(route('admin.data-trainings.import'), ['file' => $xlsxFile])
            ->assertRedirect(route('admin.data-trainings.index'));
        $this->assertDatabaseCount('data_trainings', 2);
        $this->assertDatabaseCount('data_training_atributs', 8);
    }

    public function test_import_rolls_back_all_rows_when_any_row_is_invalid(): void
    {
        $admin = User::factory()->create(['role' => User::ROLE_ADMIN]);
        $csv = implode("\n", [
            'label_karir,minat,bakat,nilai_akademik,kepribadian',
            'Network Administrator,Investigative,Numerik/Logika,89,Compliance',
            'Karir Salah,Realistic,Motorik/Praktikal,75,Steadiness',
        ]);

        $this->actingAs($admin)->post(route('admin.data-trainings.import'), [
            'file' => UploadedFile::fake()->createWithContent('invalid.csv', $csv),
        ])->assertSessionHasErrors('file');
        $this->assertDatabaseCount('data_trainings', 0);
    }

    /** @return array<int, array<string, string|int>> */
    private function attributes(string $minat, string $bakat, int $nilaiAkademik, string $kepribadian): array
    {
        $ids = Kriteria::query()->pluck('id', 'nama_kriteria');

        return [
            $ids['Minat'] => ['nilai_kategorik' => $minat],
            $ids['Bakat'] => ['nilai_kategorik' => $bakat],
            $ids['Nilai Akademik'] => ['nilai_numerik' => $nilaiAkademik],
            $ids['Kepribadian'] => ['nilai_kategorik' => $kepribadian],
        ];
    }
}

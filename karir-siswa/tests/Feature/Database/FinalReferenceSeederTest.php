<?php

namespace Tests\Feature\Database;

use App\Models\DataTraining;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinalReferenceSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_final_reference_seeders_create_the_locked_criteria_options_and_careers(): void
    {
        $this->seed();

        $this->assertDatabaseCount('kriterias', 4);
        $this->assertDatabaseCount('kriteria_opsis', 14);
        $this->assertDatabaseCount('karirs', 8);
        $this->assertDatabaseHas('kriteria_opsis', ['label' => 'Investigative']);
        $this->assertDatabaseHas('kriteria_opsis', ['label' => 'Compliance']);
        $this->assertDatabaseMissing('kriteria_opsis', ['label' => 'Nilai Akademik']);
        $this->assertDatabaseHas('karirs', ['nama_karir' => 'Pendidik/Guru']);
        $this->assertDatabaseCount('data_trainings', 64);
        $this->assertDatabaseCount('data_training_atributs', 256);
        $this->assertSame(8, DataTraining::query()->distinct('label_karir_id')->count('label_karir_id'));
        $this->assertDatabaseCount('tes', 1);
        $this->assertDatabaseCount('soals', 41);
        $this->assertDatabaseCount('pilihan_jawabans', 190);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Sistem',
                'username' => 'admin_sistem',
                'email' => 'admin@karirsiswa.test',
                'role' => User::ROLE_ADMIN,
            ],
            [
                'name' => 'Guru BK',
                'username' => 'guru_bk',
                'email' => 'guru@karirsiswa.test',
                'role' => User::ROLE_GURU_BK,
            ],
            [
                'name' => 'Siswa Demo',
                'username' => 'siswa_demo',
                'email' => 'siswa@karirsiswa.test',
                'role' => User::ROLE_SISWA,
            ],
        ];

        foreach ($users as $user) {
            $savedUser = User::updateOrCreate(
                ['email' => $user['email']],
                $user + ['password' => Hash::make('password')]
            );

            if ($savedUser->isRole(User::ROLE_SISWA)) {
                $siswa = Siswa::withTrashed()->firstOrNew(['nis' => 'SISWA001']);
                $siswa->fill([
                    'user_id' => $savedUser->id,
                    'kelas' => 'XII',
                    'jurusan' => 'Teknik Komputer dan Jaringan',
                    'jenis_kelamin' => 'L',
                ]);
                $siswa->save();
                $siswa->restore();
            }
        }

        $this->call([
            KriteriaFinalSeeder::class,
            KarirFinalSeeder::class,
            DataTrainingDemoSeeder::class,
            KuesionerDemoSeeder::class,
        ]);
    }
}

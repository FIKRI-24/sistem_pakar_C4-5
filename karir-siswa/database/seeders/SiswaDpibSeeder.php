<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaDpibSeeder extends Seeder
{
    /**
     * Run the database seeds for 11 DPIB Students.
     */
    public function run(): void
    {
        $defaultPassword = Hash::make('password123');

        $students = [
            ['name' => 'Abdul Fathir Al-Azzam', 'nis' => '0087339494', 'gender' => 'L'],
            ['name' => 'Affa Raysi', 'nis' => '0082965989', 'gender' => 'L'],
            ['name' => 'Ega Wilaswal', 'nis' => '0087394470', 'gender' => 'L'],
            ['name' => 'Farel Adika Putra', 'nis' => '0076952601', 'gender' => 'L'],
            ['name' => 'Farel Saputra', 'nis' => '0083270623', 'gender' => 'L'],
            ['name' => 'Hendra Putra', 'nis' => '3090922787', 'gender' => 'L'],
            ['name' => 'Khalid Gaza Hamudah', 'nis' => '0096713020', 'gender' => 'L'],
            ['name' => 'Latif Ulfa Ulqolbi', 'nis' => '0089145745', 'gender' => 'L'],
            ['name' => 'Luthfiyana Azizi', 'nis' => '0098369424', 'gender' => 'P'],
            ['name' => 'M. Alif Akbar', 'nis' => '0083693535', 'gender' => 'L'],
            ['name' => 'Nabil Muhammad Al Hadi', 'nis' => '0083753218', 'gender' => 'L'],
        ];

        foreach ($students as $data) {
            $username = $data['nis'];
            $email = $data['nis'] . '@siswa.smkn1hilirangumanti.sch.id';

            // 1. Create or update user account
            $user = User::firstOrNew(['username' => $username]);
            $user->name = $data['name'];
            $user->email = $email;
            $user->role = User::ROLE_SISWA;
            if (! $user->exists) {
                $user->password = $defaultPassword;
            }
            $user->save();

            // 2. Create or update profile siswa
            $siswa = Siswa::withTrashed()->firstOrNew(['nis' => $data['nis']]);
            $siswa->fill([
                'user_id' => $user->id,
                'kelas' => 'XII DPIB',
                'jurusan' => Siswa::JURUSAN_DPIB,
                'jenis_kelamin' => $data['gender'],
            ]);
            $siswa->save();

            if ($siswa->trashed()) {
                $siswa->restore();
            }
        }
    }
}

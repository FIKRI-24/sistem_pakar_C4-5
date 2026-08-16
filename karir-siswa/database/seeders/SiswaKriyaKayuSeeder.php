<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaKriyaKayuSeeder extends Seeder
{
    /**
     * Run the database seeds for 9 Kriya Kayu Students.
     */
    public function run(): void
    {
        $defaultPassword = Hash::make('password123');

        $students = [
            ['name' => 'Adrizal', 'nis' => '0088723052', 'gender' => 'L'],
            ['name' => 'Hamdan Fadli', 'nis' => '0094170939', 'gender' => 'L'],
            ['name' => 'Hanifal Putra', 'nis' => '0089202227', 'gender' => 'L'],
            ['name' => 'Hidayat Tulhah', 'nis' => '0087872161', 'gender' => 'L'],
            ['name' => 'Julio Rahman', 'nis' => '0085376488', 'gender' => 'L'],
            ['name' => 'M Aman Alfarut', 'nis' => '0089100363', 'gender' => 'L'],
            ['name' => 'Muzatul Al Faris', 'nis' => '0085490449', 'gender' => 'L'],
            ['name' => 'Taufiq Agusta', 'nis' => '0084836789', 'gender' => 'L'],
            ['name' => 'Zikril Hakim', 'nis' => '3098786552', 'gender' => 'L'],
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
                'kelas' => 'XII Kriya Kayu',
                'jurusan' => Siswa::JURUSAN_KRIYA_KAYU,
                'jenis_kelamin' => $data['gender'],
            ]);
            $siswa->save();

            if ($siswa->trashed()) {
                $siswa->restore();
            }
        }
    }
}

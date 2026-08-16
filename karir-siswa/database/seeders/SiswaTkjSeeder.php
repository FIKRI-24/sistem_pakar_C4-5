<?php

namespace Database\Seeders;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaTkjSeeder extends Seeder
{
    /**
     * Run the database seeds for 29 TKJ Students.
     */
    public function run(): void
    {
        $defaultPassword = Hash::make('password123');

        $students = [
            ['name' => 'Agustia Firmansyah', 'nis' => '0089808703', 'gender' => 'L'],
            ['name' => 'Alber Bunasra', 'nis' => '0089170547', 'gender' => 'L'],
            ['name' => 'Alziah Salsabila', 'nis' => '0081648250', 'gender' => 'P'],
            ['name' => 'Azzammuddin', 'nis' => '3084560149', 'gender' => 'L'],
            ['name' => 'Fabio Agusta Fayad', 'nis' => '0089014329', 'gender' => 'L'],
            ['name' => 'Gaulan Fadila Sabilillah', 'nis' => '0089941642', 'gender' => 'L'],
            ['name' => 'Gina Dai Datul Janah', 'nis' => '0094533563', 'gender' => 'P'],
            ['name' => 'Izzatul Muslimah', 'nis' => '0086459262', 'gender' => 'P'],
            ['name' => "Jannatul Ma'wa", 'nis' => '0081376488', 'gender' => 'P'],
            ['name' => 'Julkhairi', 'nis' => '3071699539', 'gender' => 'L'],
            ['name' => 'Juwita Siska Amelia', 'nis' => '0098002542', 'gender' => 'P'],
            ['name' => 'Kurnia Hasani', 'nis' => '0086331212', 'gender' => 'P'],
            ['name' => 'Lusi Febriati Kasma', 'nis' => '0087343762', 'gender' => 'P'],
            ['name' => 'M. Fadhil Alfurqan', 'nis' => '0084917923', 'gender' => 'L'],
            ['name' => 'Maizatul Husni', 'nis' => '0082133012', 'gender' => 'P'],
            ['name' => 'Marsya Arifvia', 'nis' => '0099694719', 'gender' => 'P'],
            ['name' => 'Mira Lola Novia', 'nis' => '0084736604', 'gender' => 'P'],
            ['name' => 'Muhammad Fadli', 'nis' => '0099497934', 'gender' => 'L'],
            ['name' => 'Muhammad Lutfi Farel', 'nis' => '0088872838', 'gender' => 'L'],
            ['name' => 'Niko Pratama Efendi', 'nis' => '0077329151', 'gender' => 'L'],
            ['name' => 'Rahmad Hidayat', 'nis' => '0098347832', 'gender' => 'L'],
            ['name' => 'Rana Radiatul Fitri', 'nis' => '0099201037', 'gender' => 'P'],
            ['name' => 'Rasyad Fathur Rahman', 'nis' => '0081264171', 'gender' => 'L'],
            ['name' => 'Salmi Wahyuni', 'nis' => '0095997200', 'gender' => 'P'],
            ['name' => 'Saskia Elsa Adiva', 'nis' => '0087656137', 'gender' => 'P'],
            ['name' => 'Sri Fuan Tasri', 'nis' => '0101591298', 'gender' => 'P'],
            ['name' => "Viky There's Ramadhan", 'nis' => '0096861639', 'gender' => 'L'],
            ['name' => 'Witri', 'nis' => '0076428403', 'gender' => 'P'],
            ['name' => 'Zikra Zamzami', 'nis' => '0086439718', 'gender' => 'L'],
        ];

        foreach ($students as $data) {
            $username = $data['nis'];
            $email = $data['nis'] . '@siswa.smkn1hilirangumanti.sch.id';

            // 1. Create or update user account
            $user = User::firstOrNew(['username' => $username]);
            $user->name = $data['name'];
            $user->email = $email;
            $user->role = User::ROLE_SISWA;
            $user->password = Hash::make($data['nis']);
            $user->save();

            // 2. Create or update profile siswa
            $siswa = Siswa::withTrashed()->firstOrNew(['nis' => $data['nis']]);
            $siswa->fill([
                'user_id' => $user->id,
                'kelas' => 'XII TKJ',
                'jurusan' => Siswa::JURUSAN_TKJ,
                'jenis_kelamin' => $data['gender'],
            ]);
            $siswa->save();

            if ($siswa->trashed()) {
                $siswa->restore();
            }
        }
    }
}

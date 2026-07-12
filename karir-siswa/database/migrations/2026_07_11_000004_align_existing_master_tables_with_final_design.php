<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username', 50)->nullable()->unique()->after('name');
            });

            foreach (DB::table('users')->select('id', 'name')->orderBy('id')->get() as $user) {
                $base = Str::limit(Str::slug($user->name, '_'), 40, '');
                DB::table('users')->where('id', $user->id)->update([
                    'username' => ($base !== '' ? $base : 'user').'_'.$user->id,
                ]);
            }
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('name', 100)->change();
            $table->string('email', 100)->nullable()->change();
            $table->enum('role', ['admin', 'guru_bk', 'siswa'])->default('siswa')->change();
            $table->string('username', 50)->nullable(false)->change();
        });

        Schema::table('siswas', function (Blueprint $table) {
            $table->string('nis', 20)->change();
            $table->string('kelas', 20)->change();
            $table->string('jurusan', 50)->change();
            $table->softDeletes();
        });

        Schema::table('kriterias', function (Blueprint $table) {
            $table->string('nama_kriteria', 100)->change();
            $table->enum('tipe_data', ['kategorik', 'numerik'])->change();
            $table->softDeletes();
        });

        Schema::table('karirs', function (Blueprint $table) {
            $table->string('nama_karir', 100)->change();
            $table->string('bidang_pekerjaan', 100)->nullable()->change();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('karirs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('kriterias', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        Schema::table('siswas', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};

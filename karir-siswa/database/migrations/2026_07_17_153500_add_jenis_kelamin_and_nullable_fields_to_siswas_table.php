<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('jurusan');
            $table->string('kelas', 50)->nullable()->change();
            $table->string('jurusan', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn('jenis_kelamin');
            $table->string('kelas', 50)->nullable(false)->change();
            $table->string('jurusan', 100)->nullable(false)->change();
        });
    }
};

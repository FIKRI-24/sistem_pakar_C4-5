<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kriteria_opsis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')->constrained('kriterias');
            $table->string('label', 100);
            $table->integer('urutan')->nullable();
        });

        Schema::create('tes', function (Blueprint $table) {
            $table->id();
            $table->string('nama_tes', 100);
            $table->text('deskripsi')->nullable();
            $table->integer('durasi_menit')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tes_id')->constrained('tes');
            $table->foreignId('kriteria_id')->constrained('kriterias');
            $table->text('pertanyaan');
            $table->integer('urutan')->nullable();
        });

        Schema::create('pilihan_jawabans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('soal_id')->constrained('soals');
            $table->string('pilihan', 150);
            $table->double('skor');
            $table->foreignId('kriteria_opsi_id')->nullable()->constrained('kriteria_opsis');
        });

        Schema::create('hasil_tes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas');
            $table->foreignId('tes_id')->constrained('tes');
            $table->dateTime('tanggal_tes');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('hasil_tes_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hasil_tes_id')->constrained('hasil_tes');
            $table->foreignId('kriteria_id')->constrained('kriterias');
            $table->string('nilai_kategorik', 100)->nullable();
            $table->double('nilai_numerik')->nullable();
        });

        Schema::create('rekomendasi_karirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hasil_tes_id')->constrained('hasil_tes');
            $table->foreignId('karir_id')->constrained('karirs');
            $table->double('persen_kecocokan');
            $table->text('alasan');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('data_trainings', function (Blueprint $table) {
            $table->id();
            $table->string('sumber', 100)->nullable();
            $table->foreignId('label_karir_id')->constrained('karirs');
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::create('data_training_atributs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_training_id')->constrained('data_trainings');
            $table->foreignId('kriteria_id')->constrained('kriterias');
            $table->string('nilai_kategorik', 100)->nullable();
            $table->double('nilai_numerik')->nullable();
        });

        Schema::create('decision_trees', function (Blueprint $table) {
            $table->id();
            $table->integer('versi');
            $table->json('struktur_json');
            $table->double('akurasi')->nullable();
            $table->foreignId('dibuat_oleh')->constrained('users');
            $table->boolean('status_aktif')->default(true);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('decision_trees');
        Schema::dropIfExists('data_training_atributs');
        Schema::dropIfExists('data_trainings');
        Schema::dropIfExists('rekomendasi_karirs');
        Schema::dropIfExists('hasil_tes_detail');
        Schema::dropIfExists('hasil_tes');
        Schema::dropIfExists('pilihan_jawabans');
        Schema::dropIfExists('soals');
        Schema::dropIfExists('tes');
        Schema::dropIfExists('kriteria_opsis');
    }
};

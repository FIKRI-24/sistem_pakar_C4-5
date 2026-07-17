<?php

use App\Http\Controllers\Admin\C45HealthController;
use App\Http\Controllers\Admin\DataTrainingController;
use App\Http\Controllers\Admin\KarirController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\PilihanJawabanController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\SoalController;
use App\Http\Controllers\Admin\TesController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DecisionTreeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Siswa\HasilTesController;
use App\Http\Controllers\Siswa\KonsultasiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.store');

    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'redirect'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::get('/c45/status', C45HealthController::class)->name('c45.status');
        Route::resource('siswas', SiswaController::class)->except('show');
        Route::resource('kriterias', KriteriaController::class)->except('show');
        Route::resource('karirs', KarirController::class)->except('show');
        Route::get('data-trainings/import', [DataTrainingController::class, 'importForm'])->name('data-trainings.import.form');
        Route::post('data-trainings/import', [DataTrainingController::class, 'import'])->name('data-trainings.import');
        Route::resource('data-trainings', DataTrainingController::class)->except('show');
    });

    Route::prefix('admin')->name('admin.')->middleware('role:admin,guru_bk')->group(function () {
        Route::get('tes/buat-lengkap', [\App\Http\Controllers\Admin\TesLengkapController::class, 'create'])->name('tes.buat-lengkap');
        Route::post('tes/buat-lengkap', [\App\Http\Controllers\Admin\TesLengkapController::class, 'store'])->name('tes.buat-lengkap.store');

        Route::get('hasil-tes', [TesController::class, 'hasilTes'])->name('tes.hasil-tes');
        Route::get('hasil-tes/{hasilTes}', [TesController::class, 'showHasilTes'])->name('tes.hasil-tes.show');
        Route::get('rekomendasi-karir', [TesController::class, 'rekomendasiKarir'])->name('tes.rekomendasi-karir');

        Route::resource('tes', TesController::class)->except('show');
        Route::resource('soals', SoalController::class)->except('show');
        Route::resource('pilihan-jawabans', PilihanJawabanController::class)->except('show');

        Route::get('decision-tree', [DecisionTreeController::class, 'index'])->name('decision-tree.index');
        Route::post('decision-tree/train', [DecisionTreeController::class, 'train'])->name('decision-tree.train');
    });

    Route::get('/guru-bk/dashboard', [DashboardController::class, 'guruBk'])
        ->middleware('role:guru_bk')
        ->name('guru-bk.dashboard');

    Route::prefix('siswa')->name('siswa.')->middleware('role:siswa')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'siswa'])->name('dashboard');
        
        Route::get('/biodata', [\App\Http\Controllers\Siswa\BiodataController::class, 'edit'])->name('biodata');
        Route::post('/biodata', [\App\Http\Controllers\Siswa\BiodataController::class, 'update'])->name('biodata.update');

        Route::middleware('complete_biodata')->group(function () {
            Route::get('/konsultasi', [KonsultasiController::class, 'index'])->name('konsultasi.index');
            Route::get('/konsultasi/{tes}', [KonsultasiController::class, 'show'])->name('konsultasi.show');
            Route::post('/konsultasi/{tes}', [KonsultasiController::class, 'store'])->name('konsultasi.store');
        });

        Route::get('/hasil-tes', [HasilTesController::class, 'index'])->name('hasil-tes.index');
        Route::get('/hasil-tes/{hasilTes}', [HasilTesController::class, 'show'])->name('hasil-tes.show');
    });
});

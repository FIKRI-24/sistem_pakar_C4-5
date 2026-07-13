<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tes extends Model
{
    use SoftDeletes;

    protected $fillable = ['nama_tes', 'deskripsi', 'durasi_menit', 'status_aktif'];

    protected function casts(): array
    {
        return ['status_aktif' => 'boolean'];
    }

    public function soals(): HasMany
    {
        return $this->hasMany(Soal::class);
    }

    public function hasilTes(): HasMany
    {
        return $this->hasMany(HasilTes::class);
    }

    protected static function booted()
    {
        static::deleting(function ($tes) {
            if ($tes->isForceDeleting()) {
                foreach ($tes->soals as $soal) {
                    $soal->delete();
                }
                foreach ($tes->hasilTes as $hasil) {
                    $hasil->delete();
                }
            }
        });
    }
}

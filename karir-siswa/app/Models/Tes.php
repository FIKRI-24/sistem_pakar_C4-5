<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tes extends Model
{
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
}

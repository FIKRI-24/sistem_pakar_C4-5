<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HasilTes extends Model
{
    protected $table = 'hasil_tes';

    protected $fillable = ['siswa_id', 'tes_id', 'tanggal_tes', 'catatan'];

    protected function casts(): array
    {
        return ['tanggal_tes' => 'datetime'];
    }

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class);
    }
    public function tes(): BelongsTo
    {
        return $this->belongsTo(Tes::class)->withTrashed();
    }
    public function details(): HasMany
    {
        return $this->hasMany(HasilTesDetail::class);
    }

    public function rekomendasis(): HasMany
    {
        return $this->hasMany(RekomendasiKarir::class);
    }

    protected static function booted()
    {
        static::deleting(function ($hasilTes) {
            $hasilTes->details()->delete();
            $hasilTes->rekomendasis()->delete();
        });
    }
}

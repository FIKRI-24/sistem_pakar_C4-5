<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Soal extends Model
{
    public $timestamps = false;

    protected $fillable = ['tes_id', 'kriteria_id', 'pertanyaan', 'urutan'];

    public function tes(): BelongsTo
    {
        return $this->belongsTo(Tes::class);
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }

    public function pilihanJawabans(): HasMany
    {
        return $this->hasMany(PilihanJawaban::class);
    }
}

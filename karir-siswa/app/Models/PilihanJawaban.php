<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PilihanJawaban extends Model
{
    public $timestamps = false;

    protected $fillable = ['soal_id', 'pilihan', 'skor', 'kriteria_opsi_id'];

    protected function casts(): array
    {
        return ['skor' => 'float'];
    }

    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class);
    }

    public function kriteriaOpsi(): BelongsTo
    {
        return $this->belongsTo(KriteriaOpsi::class);
    }
}

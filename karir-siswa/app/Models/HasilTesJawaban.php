<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilTesJawaban extends Model
{
    protected $table = 'hasil_tes_jawabans';

    protected $fillable = [
        'hasil_tes_id',
        'soal_id',
        'pilihan_jawaban_id',
        'jawaban_teks',
        'skor',
    ];

    protected function casts(): array
    {
        return ['skor' => 'float'];
    }

    public function hasilTes(): BelongsTo
    {
        return $this->belongsTo(HasilTes::class);
    }

    public function soal(): BelongsTo
    {
        return $this->belongsTo(Soal::class);
    }

    public function pilihanJawaban(): BelongsTo
    {
        return $this->belongsTo(PilihanJawaban::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilTesDetail extends Model
{
    protected $table = 'hasil_tes_detail';

    public $timestamps = false;

    protected $fillable = ['hasil_tes_id', 'kriteria_id', 'nilai_kategorik', 'nilai_numerik'];

    protected function casts(): array
    {
        return ['nilai_numerik' => 'float'];
    }

    public function hasilTes(): BelongsTo
    {
        return $this->belongsTo(HasilTes::class);
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RekomendasiKarir extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['hasil_tes_id', 'karir_id', 'persen_kecocokan', 'alasan'];

    protected function casts(): array
    {
        return ['persen_kecocokan' => 'float'];
    }

    public function hasilTes(): BelongsTo
    {
        return $this->belongsTo(HasilTes::class);
    }

    public function karir(): BelongsTo
    {
        return $this->belongsTo(Karir::class);
    }
}

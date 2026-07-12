<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DataTrainingAtribut extends Model
{
    public $timestamps = false;

    protected $fillable = ['data_training_id', 'kriteria_id', 'nilai_kategorik', 'nilai_numerik'];

    protected function casts(): array
    {
        return ['nilai_numerik' => 'float'];
    }

    public function dataTraining(): BelongsTo
    {
        return $this->belongsTo(DataTraining::class);
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(Kriteria::class);
    }
}

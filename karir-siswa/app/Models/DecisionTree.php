<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DecisionTree extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['versi', 'struktur_json', 'akurasi', 'dibuat_oleh', 'status_aktif'];

    protected function casts(): array
    {
        return ['struktur_json' => 'array', 'akurasi' => 'float', 'status_aktif' => 'boolean'];
    }

    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }
}

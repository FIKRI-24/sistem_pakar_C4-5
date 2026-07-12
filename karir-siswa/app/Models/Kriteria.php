<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kriteria extends Model
{
    use HasFactory, SoftDeletes;

    public const TYPE_KATEGORIK = 'kategorik';

    public const TYPE_NUMERIK = 'numerik';

    public const TYPES = [self::TYPE_KATEGORIK, self::TYPE_NUMERIK];

    protected $fillable = ['nama_kriteria', 'tipe_data', 'keterangan'];

    public function opsis(): HasMany
    {
        return $this->hasMany(KriteriaOpsi::class)->orderBy('urutan');
    }
}

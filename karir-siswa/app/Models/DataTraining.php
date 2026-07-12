<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DataTraining extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = ['sumber', 'label_karir_id'];

    public function labelKarir(): BelongsTo
    {
        return $this->belongsTo(Karir::class, 'label_karir_id');
    }

    public function atributs(): HasMany
    {
        return $this->hasMany(DataTrainingAtribut::class);
    }
}

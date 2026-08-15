<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;

    public const JURUSAN_TKJ = 'Teknik Komputer dan Jaringan';
    public const JURUSAN_DPIB = 'Desain Pemodelan dan Informasi Bangunan';
    public const JURUSAN_KRIYA_KAYU = 'Kriya Kreatif Kayu dan Rotan';

    public const JURUSAN_OPTIONS = [
        'Teknik Komputer dan Jaringan' => 'Teknik Komputer dan Jaringan (TKJ)',
        'Desain Pemodelan dan Informasi Bangunan' => 'Desain Pemodelan dan Informasi Bangunan (DPIB)',
        'Kriya Kreatif Kayu dan Rotan' => 'Kriya Kreatif Kayu dan Rotan (Kriya Kayu)',
    ];

    protected $fillable = ['user_id', 'nis', 'kelas', 'jurusan', 'jenis_kelamin'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function hasilTes(): HasMany
    {
        return $this->hasMany(HasilTes::class);
    }
}

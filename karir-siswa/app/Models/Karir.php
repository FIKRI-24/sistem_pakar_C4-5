<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karir extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_karir',
        'deskripsi',
        'bidang_pekerjaan',
        'informasi_pendukung',
    ];
}

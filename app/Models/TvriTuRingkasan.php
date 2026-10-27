<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TvriTuRingkasan extends Model
{
    use HasFactory;

    protected $table = 'tvri_tu_ringkasans';

    protected $guarded = ['id'];

    protected $casts = [
        'kpi_json' => 'array',
        'notifikasi_json' => 'array',
    ];
}

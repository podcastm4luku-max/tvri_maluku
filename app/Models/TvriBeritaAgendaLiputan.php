<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TvriBeritaAgendaLiputan extends Model
{
    protected $table = 'tvri_berita_agenda_liputans';

    protected $fillable = [
        'waktu',
        'agenda',
        'lokasi',
        'pic',
        'status',
        'urutan',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Main;

class Perpanjangan extends Main
{
    protected $table = 'perpanjangans';

    protected $fillable = [
        'uuid_pegadaian',
        'tanggal_perpanjangan',
        'tanggal_perpanjangan_jatuh_tempo',
        'denda_sebelumnya'
    ];

    public function pegadaian()
    {
        return $this->belongsTo(Pegadaian::class, 'uuid_pegadaian', 'uuid');
    }
}

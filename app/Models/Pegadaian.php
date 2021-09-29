<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Main;
use Illuminate\Database\Eloquent\Model;

class Pegadaian extends Main
{
    protected $table = 'pegadaians';

    protected $fillable = [
        'nik_peminjam',
        'nama_peminjam',
        'alamat_peminjam',
        'no_telepon',
        'tanggal_masuk_pinjaman',
        'tanggal_jatuh_tempo',
        'jumlah_pinjaman',
        'jumlah_tebusan',
        'keterangan_jaminan',
        'status'
    ];
}

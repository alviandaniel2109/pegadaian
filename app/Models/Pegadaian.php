<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Main;
use Illuminate\Database\Eloquent\Model;
use App\Models\Perpanjangan;
use Illuminate\Support\Carbon;

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
        'status',
    ];

    public static function denda($uuid)
    {
        $check_pegadaian = self::where('uuid', $uuid)->first();

        $check_perpanjangan = Perpanjangan::where('uuid_pegadaian', '=', $uuid)->orderByDesc('id')->limit(1)->get();

        foreach ($check_perpanjangan as $key => $value) {
            $tanggal_perpanjangan = $value->tanggal_perpanjangan;
            $tanggal_jatuh_tempo = $value->tanggal_perpanjangan_jatuh_tempo;
        }

        if (empty($tanggal_perpanjangan)) {
            if (date('Y-m-d') > $check_pegadaian->tanggal_jatuh_tempo) {
                $diff = Carbon::parse(date('Y-m-d'));
                $denda = $diff->diffInDays($check_pegadaian->tanggal_jatuh_tempo) * 10000;
            } else {
                $denda = 0;
            }
        } else {
            if($tanggal_perpanjangan > $check_pegadaian->tanggal_jatuh_tempo) {
                $diff = Carbon::parse($tanggal_perpanjangan);
                $denda_lalu = $diff->diffInDays($check_pegadaian->tanggal_jatuh_tempo) * 10000;
                if(date('Y-m-d') > $tanggal_jatuh_tempo) {
                    $diff_sekarang = Carbon::parse(date('Y-m-d'));
                    $denda = $diff_sekarang->diffInDays($tanggal_jatuh_tempo) * 10000;
                    $denda = $denda + $denda_lalu;
                } else {
                    $denda = $denda_lalu;
                }
            } else {
                if(date('Y-m-d') > $tanggal_jatuh_tempo) {
                    $diff = Carbon::parse(date('Y-m-d'));
                    $denda = $diff->diffInDays($tanggal_jatuh_tempo) * 10000;
                    $denda = $denda;
                } else {
                    $denda = 0;
                }
            }
        }
        
        return $denda;
    }

    public static function telat($uuid)
    {
        $check_pegadaian = self::where('uuid', $uuid)->first();

        $check_perpanjangan = Perpanjangan::where('uuid_pegadaian', '=', $uuid)->orderByDesc('id')->limit(1)->get();

        foreach ($check_perpanjangan as $key => $value) {
            $tanggal_perpanjangan = $value->tanggal_perpanjangan;
            $tanggal_jatuh_tempo = $value->tanggal_perpanjangan_jatuh_tempo;
        }

        if (empty($tanggal_perpanjangan)) {
            if (date('Y-m-d') > $check_pegadaian->tanggal_jatuh_tempo) {
                $date = Carbon::parse(date('Y-m-d'));
                $diff = $date->diffInDays($check_pegadaian->tanggal_jatuh_tempo);
            } else {
                $diff = 0;
            }
        } else {
            if($tanggal_perpanjangan > $check_pegadaian->tanggal_jatuh_tempo) {
                $date = Carbon::parse($tanggal_perpanjangan);
                $diff_lalu = $date->diffInDays($check_pegadaian->tanggal_jatuh_tempo);
                if(date('Y-m-d') > $tanggal_jatuh_tempo) {
                    $date_sekarang = Carbon::parse(date('Y-m-d'));
                    $diff = $date_sekarang->diffInDays($tanggal_jatuh_tempo);
                    $diff = $diff + $diff_lalu;
                } else {
                    $diff = $diff_lalu;
                }
            } else {
                if(date('Y-m-d') > $tanggal_jatuh_tempo) {
                    $date = Carbon::parse(date('Y-m-d'));
                    $diff = $date->diffInDays($tanggal_jatuh_tempo) * 10000;
                    $diff = $diff;
                } else {
                    $diff = 0;
                }
            }
        }
        
        return $diff;
    }
}

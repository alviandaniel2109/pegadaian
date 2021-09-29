<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    static public function ValidationMessage()
    {

        $message = [
            'required'  => ':attribute Tidak Boleh Kosong',
            'email'     => 'Format email salah',
            'confirmed' => 'Tidak sama',
            'min'       => ':attribute Minimal :min Karakter',
            'max'       => ':attribute Maximal :max Karakter',
            'unique'    => ':attribute Sudah digunakan',
            'mimes'     => 'Format file salah',
            'numeric'   => ':attribute harus berupa angka',
            'same'      => ':other dan :attribute harus sama',
            'image'     => ':attribute harus gambar',
        ];

        return $message;
    }
}

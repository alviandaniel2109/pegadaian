<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegadaiansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegadaians', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 36)->unique();
            $table->char('nik_peminjam', 16);
            $table->string('nama_peminjam');
            $table->text('alamat_peminjam');
            $table->string('no_telepon');
            $table->date('tanggal_masuk_pinjaman');
            $table->date('tanggal_jatuh_tempo');
            $table->integer('jumlah_pinjaman');
            $table->integer('jumlah_tebusan')->nullable();
            $table->string('keterangan_jaminan');
            $table->char('status', 1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pegadaians');
    }
}

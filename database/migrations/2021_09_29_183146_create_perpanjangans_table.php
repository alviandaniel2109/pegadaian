<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerpanjangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perpanjangans', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 36)->unique();
            $table->char('uuid_pegadaian', 36);
            $table->date('tanggal_perpanjangan');
            $table->date('tanggal_perpanjangan_jatuh_tempo');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('uuid_pegadaian')
            ->references('uuid')
            ->on('pegadaians')
            ->onDelete('cascade')
            ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perpanjangans');
    }
}

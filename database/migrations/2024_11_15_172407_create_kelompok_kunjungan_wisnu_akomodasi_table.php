<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelompokKunjunganWisnuAkomodasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelompok_kunjungan_wisnu_akomodasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('kelompok_kunjungan_id');
            $table->foreign('kelompok_kunjungan_id')->references('id')->on('kelompokKunjungan')->onDelete('cascade');
            $table->unsignedInteger('wisnu_akomodasi_id');
            $table->foreign('wisnu_akomodasi_id')->references('id')->on('wisnuakomodasi')->onDelete('cascade');

           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelompok_kunjungan_wisnu_akomodasi');
    }
}

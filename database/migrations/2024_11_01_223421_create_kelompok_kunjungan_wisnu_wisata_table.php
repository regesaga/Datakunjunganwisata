<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelompokKunjunganWisnuWisataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelompok_kunjungan_wisnu_wisata', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('kelompok_kunjungan_id');
            $table->foreign('kelompok_kunjungan_id')->references('id')->on('kelompokKunjungan')->onDelete('cascade');
            $table->unsignedInteger('wisnu_wisata_id');
            $table->foreign('wisnu_wisata_id')->references('id')->on('wisnuwisata')->onDelete('cascade');

           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelompok_kunjungan_wisnu_wisata');
    }
}

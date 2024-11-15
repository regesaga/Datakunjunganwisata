<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWismanakomodasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wismanakomodasi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('akomodasi_id'); // Relasi ke tabel wisata
            $table->date('tanggal_kunjungan');
            
            // Wisatawan Mancanegara (WISMAN)
            $table->unsignedInteger('wismannegara_id');
            $table->integer('jml_wisman_laki')->default(0);
            $table->integer('jml_wisman_perempuan')->default(0);


            $table->timestamps();

            // Foreign key ke tabel akomodasis
            $table->foreign('akomodasi_id')->references('id')->on('akomodasi')->onDelete('cascade');
             // Foreign key ke tabel wismannegara
             $table->foreign('wismannegara_id')->references('id')->on('wismannegara')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wismanakomodasi');
    }
}

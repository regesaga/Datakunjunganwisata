<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWismankulinerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wismankuliner', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('kuliner_id'); // Relasi ke tabel wisata
            $table->date('tanggal_kunjungan');
            
            // Wisatawan Mancanegara (WISMAN)
            $table->unsignedInteger('wismannegara_id');
            $table->integer('jml_wisman_laki')->default(0);
            $table->integer('jml_wisman_perempuan')->default(0);


            $table->timestamps();

            // Foreign key ke tabel wisatas
            $table->foreign('kuliner_id')->references('id')->on('wisatas')->onDelete('cascade');
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
        Schema::dropIfExists('wismankuliner');
    }
}

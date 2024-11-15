<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWisnukulinerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wisnukuliner', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('kuliner_id'); // Relasi ke tabel wisata
            $table->date('tanggal_kunjungan');
            
            // Wisatawan Nusantara (WISNU)
            $table->unsignedInteger('kelompok_kunjungan_id'); // Relasi ke tabel wisata
            $table->integer('jumlah_laki_laki')->default(0);
            $table->integer('jumlah_perempuan')->default(0);
         
            $table->timestamps();

            // Foreign key ke tabel kuliners
            $table->foreign('kuliner_id')->references('id')->on('kuliners')->onDelete('cascade');
            
            // Foreign key ke tabel kelompokKunjungan
            $table->foreign('kelompok_kunjungan_id')->references('id')->on('kelompokKunjungan')->onDelete('cascade');
        });
 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wisnukuliner');
    }
}

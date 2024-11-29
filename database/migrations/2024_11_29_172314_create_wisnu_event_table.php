<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWisnuEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wisnu_event', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_calendar_id')->references('id')->on('event_calendar')->onDelete('cascade');
            $table->date('tanggal_kunjungan');
            
            // Wisatawan Nusantara (WISNU)
            $table->unsignedInteger('kelompok_kunjungan_id'); // Relasi ke tabel wisata
            $table->integer('jumlah_laki_laki')->default(0);
            $table->integer('jumlah_perempuan')->default(0);
         
            $table->timestamps();

            // Foreign key ke tabel kuliners
            $table->foreign('event_calendar_id')->references('id')->on('event_calendar')->onDelete('cascade');
            
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
        Schema::dropIfExists('wisnu_event');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWismanEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wisman_event', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_calendar_id')->references('id')->on('event_calendar')->onDelete('cascade');
            $table->date('tanggal_kunjungan');
            
            // Wisatawan Mancanegara (WISMAN)
            $table->unsignedInteger('wismannegara_id');
            $table->integer('jml_wisman_laki')->default(0);
            $table->integer('jml_wisman_perempuan')->default(0);


            $table->timestamps();

            // Foreign key ke tabel akomodasis
            $table->foreign('event_calendar_id')->references('id')->on('event_calendar')->onDelete('cascade');
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
        Schema::dropIfExists('wisman_event');
    }
}

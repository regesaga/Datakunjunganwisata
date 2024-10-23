<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJamOperasionalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('JamOperasional', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('wisata_id');
            $table->foreign('wisata_id')->references('id')->on('wisatas')->onDelete('cascade');
            $table->string('hari')->nullable();
            $table->time('jam_buka');
            $table->time('jam_tutup');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('JamOperasional');
    }
}

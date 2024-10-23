<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFasilitasWisataVipot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fasilitas_wisata', function (Blueprint $table) {
            $table->unsignedInteger('wisata_id');

            $table->foreign('wisata_id')->references('id')->on('wisatas')->onDelete('cascade');

            $table->unsignedInteger('fasilitas_id');

            $table->foreign('fasilitas_id')->references('id')->on('fasilitas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fasilitas__wisata_vipot');
    }
}

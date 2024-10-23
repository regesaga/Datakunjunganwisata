<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Fasilitasrooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fasilitas_rooms', function (Blueprint $table) {
            $table->unsignedInteger('rooms_id');

            $table->foreign('rooms_id')->references('id')->on('rooms')->onDelete('cascade');

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
        Schema::dropIfExists('fasilitas_rooms_vipot');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWismanNegaraWismanWisataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('wisman_negara_wisman_wisata', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('wismannegara_id');
            $table->foreign('wismannegara_id')->references('id')->on('wismannegara')->onDelete('cascade');
            $table->unsignedInteger('wisman_wisata_id');
            $table->foreign('wisman_wisata_id')->references('id')->on('wismanwisata')->onDelete('cascade');

           

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wisman_negara_wisman_wisata');
    }

}

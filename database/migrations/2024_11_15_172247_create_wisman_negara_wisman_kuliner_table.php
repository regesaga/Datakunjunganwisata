<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWismanNegaraWismanKulinerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wisman_negara_wisman_kuliner', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('wismannegara_id');
                $table->foreign('wismannegara_id')->references('id')->on('wismannegara')->onDelete('cascade');
                $table->unsignedInteger('wisman_kuliner_id');
                $table->foreign('wisman_kuliner_id')->references('id')->on('wismankuliner')->onDelete('cascade');
    
               
    
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wisman_negara_wisman_kuliner');
    }
}

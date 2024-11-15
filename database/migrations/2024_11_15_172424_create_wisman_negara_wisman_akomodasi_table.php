<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWismanNegaraWismanAkomodasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wisman_negara_wisman_akomodasi', function (Blueprint $table) {
            $table->id();
                $table->unsignedInteger('wismannegara_id');
                $table->foreign('wismannegara_id')->references('id')->on('wismannegara')->onDelete('cascade');
                $table->unsignedInteger('wisman_akomodasi_id');
                $table->foreign('wisman_akomodasi_id')->references('id')->on('wismanakomodasi')->onDelete('cascade');
    
               
    
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wisman_negara_wisman_akomodasi');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Paketwisata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paketwisata', function (Blueprint $table) {
            $table->increments('id');
            $table->string('namapaketwisata');
            $table->longText('kegiatan');
            $table->longText('htm');
            $table->longText('nohtm');
            $table->longText('destinasiwisata');
            $table->string('telpon');
            $table->boolean('active')->default(0);
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
        //
    }
}

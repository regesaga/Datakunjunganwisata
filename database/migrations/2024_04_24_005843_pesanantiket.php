<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pesanantiket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesantiket', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kodetiket')->unique();
            $table->unsignedInteger('wisatawan_id');
            $table->unsignedInteger('wisata_id')->nullable();
            $table->integer('totalHarga');
            $table->string('snap_token')->nullable();
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
        Schema::dropIfExists('pesantiket');
    }
}

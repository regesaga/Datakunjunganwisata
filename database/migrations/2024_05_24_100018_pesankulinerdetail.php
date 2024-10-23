<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pesankulinerdetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesankulinerdetail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pesankuliner_id');
            $table->unsignedBigInteger('kulinerproduk_id');
            $table->string('nama');
            $table->integer('harga');
            $table->integer('jumlah');
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
        Schema::dropIfExists('pesankulinerdetail');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class pesantiketdetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesantiketdetail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pesantiket_id');
            $table->unsignedBigInteger('harga_tiket_id');
            $table->string('kategori');
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
        Schema::dropIfExists('pesantiketdetail');
    }
}

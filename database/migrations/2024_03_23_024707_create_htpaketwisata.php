<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHtpaketwisata extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('htpaketwisata', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('paketwisata_id');
            $table->foreign('paketwisata_id')->references('id')->on('paketwisata')->onDelete('cascade');
            $table->string('jenis');
            $table->Integer('harga');
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
        Schema::dropIfExists('htpaketwisata');
    }
}

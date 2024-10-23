<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHargaTiketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_tikets', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('wisata_id');
            $table->foreign('wisata_id')->references('id')->on('wisatas')->onDelete('cascade');
            $table->string('kategori');
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
        Schema::dropIfExists('harga_tikets');
    }
}
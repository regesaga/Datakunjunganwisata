<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FasilitasAkomodasiVipot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akomodasi_fasilitas', function (Blueprint $table) {
            $table->unsignedInteger('akomodasi_id');

            $table->foreign('akomodasi_id')->references('id')->on('akomodasi')->onDelete('cascade');

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
        Schema::dropIfExists('fasilitas__akomodasi_vipot');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetKunjunganTable extends Migration
{
    public function up()
    {
        Schema::create('target_kunjungan', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun');
            $table->integer('bulan');
            $table->integer('target_kunjungan_wisata')->default(0);  // Target kunjungan wisata secara umum
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('target_kunjungan');
    }
}
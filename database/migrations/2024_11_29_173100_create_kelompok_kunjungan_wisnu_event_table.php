<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelompokKunjunganWisnuEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kelompok_kunjungan_wisnu_event', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('kelompok_kunjungan_id'); // Matches kelompokKunjungan table
            $table->foreign('kelompok_kunjungan_id')
                ->references('id')
                ->on('kelompokKunjungan')
                ->onDelete('cascade');
        
            $table->unsignedBigInteger('wisnu_event_id'); // Matches wisnu_event table
            $table->foreign('wisnu_event_id')
                ->references('id')
                ->on('wisnu_event')
                ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelompok_kunjungan_wisnu_event');
    }
}

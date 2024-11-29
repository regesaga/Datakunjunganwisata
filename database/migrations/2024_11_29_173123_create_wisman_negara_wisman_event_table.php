<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWismanNegaraWismanEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wisman_negara_wisman_event', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('wismannegara_id'); // Matches kelompokKunjungan table
            $table->foreign('wismannegara_id')
                ->references('id')
                ->on('wismannegara')
                ->onDelete('cascade');
        
            $table->unsignedBigInteger('wisman_event_id'); // Matches wisman_event table
            $table->foreign('wisman_event_id')
                ->references('id')
                ->on('wisman_event')
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
        Schema::dropIfExists('wisman_negara_wisman_event');
    }
}

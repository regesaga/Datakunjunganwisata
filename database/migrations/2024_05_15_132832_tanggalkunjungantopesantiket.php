<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Tanggalkunjungantopesantiket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::table('pesantiket', function (Blueprint $table) {
            $table->timestamp('tanggalkunjungan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pesantiket', function (Blueprint $table) {
            //
        });
    }

    
}

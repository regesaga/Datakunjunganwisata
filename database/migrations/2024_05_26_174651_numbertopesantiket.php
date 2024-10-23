<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Numbertopesantiket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    Public function up()
    {
        Schema::table('pesantiket', function (Blueprint $table) {
            $table->string('number', 8);
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

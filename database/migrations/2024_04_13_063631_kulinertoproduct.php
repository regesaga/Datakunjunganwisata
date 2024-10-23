<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Kulinertoproduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kulinerproduk', function (Blueprint $table) {
            $table->unsignedInteger('kuliner_id');
            $table->foreign('kuliner_id')->references('id')->on('kuliners')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kulinerproduk', function (Blueprint $table) {
            $table->dropForeign(['kuliner_id']);
            $table->dropColumn('kuliner_id');
        });
    }
}

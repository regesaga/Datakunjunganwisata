<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Ekraf extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ekraf', function (Blueprint $table) {
            $table->increments('id');
            $table->string('namaekraf');
            $table->unsignedInteger('sektorekraf_id');
            $table->longText('deskripsi');
            $table->string('alamat');
            $table->unsignedInteger('kecamatan_id');
            $table->string('instagram');
            $table->string('web');
            $table->string('telpon');
            $table->boolean('active')->default(0);
            $table->decimal('latitude', 9, 6);
            $table->decimal('longitude', 9, 6);
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
        //
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Akomodasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akomodasi', function (Blueprint $table) {
            $table->increments('id');
            $table->string('namaakomodasi');
            $table->unsignedInteger('categoryakomodasi_id');
            $table->longText('deskripsi');
            $table->string('alamat');
            $table->unsignedInteger('kecamatan_id');
            $table->string('instagram');
            $table->string('web');
            $table->string('telpon');
            $table->string('jambuka', 5); // Mengubah tipe data menjadi varchar dengan panjang 5 karakter
            $table->string('jamtutup', 5);
            $table->Integer('kapasitas');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKunjunganwisataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kunjunganwisata', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wisata_id'); // Relasi ke tabel wisata
            $table->date('tanggal_kunjungan');
            
            // Wisatawan Nusantara (WISNU)
            $table->integer('wisnu_umum_laki')->default(0);
            $table->integer('wisnu_umum_perempuan')->default(0);
            $table->integer('wisnu_pelajar_laki')->default(0);
            $table->integer('wisnu_pelajar_perempuan')->default(0);
            $table->integer('wisnu_instansi_laki')->default(0);
            $table->integer('wisnu_instansi_perempuan')->default(0);
            $table->integer('jml_wisnu_perempuan')->default(0);
            $table->integer('jml_wisnu_laki')->default(0);
            $table->integer('total_wisnu')->default(0);

            // Wisatawan Mancanegara (WISMAN)
            $table->string('wisman_negara')->nullable();
            $table->integer('wisman_laki')->default(0);
            $table->integer('wisman_perempuan')->default(0);
            $table->integer('jml_wisman_laki')->default(0);
            $table->integer('jml_wisman_perempuan')->default(0);
            $table->integer('total_wisman')->default(0);


            $table->timestamps();

            // Foreign key ke tabel wisatas
            $table->foreign('wisata_id')->references('id')->on('wisatas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kunjunganwisata');
    }
}

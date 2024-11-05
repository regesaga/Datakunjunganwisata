<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PesanKuliner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pesankuliner', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kodepesanan')->unique();
            $table->unsignedInteger('wisatawan_id');
            $table->unsignedInteger('kuliner_id')->nullable();
            $table->integer('totalHarga');
            $table->enum('statuspesanan', ['00', '11', '22'])
                  ->default('00'); // Set the default value as '00'
            $table->string('metodepembayaran');
            $table->timestamp('tanggalkunjungan')->nullable();
            $table->string('snap_token')->nullable();
            $table->enum('payment_status', ['00', '11', '22', '33'])
                  ->default('00')
                  ->comment('00=menunggu pembayaran, 11=sudah dibayar, 22=kadaluarsa, 33=cancel');
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
        Schema::dropIfExists('pesankuliner');
    }
}

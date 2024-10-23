<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Reservakomodsi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserv', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kodeboking')->unique();
            $table->unsignedInteger('wisatawan_id');
            $table->unsignedInteger('akomodasi_id')->nullable();
            $table->integer('totalHarga');
            $table->string('snap_token')->nullable();
            $table->string('metodepembayaran');
            $table->enum('statuspemakaian',[00,11,22])->default(00);
            $table->enum('payment_status', ['00','11', '22', '33'])->comment('00=menunggu pembayaran, 11=sudah dibayar, 22=kadaluarsa, 33=cancel')->default(00);

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
        Schema::dropIfExists('resereve');
    }
}

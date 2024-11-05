<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentStatusToPesanTiket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pesantiket', function (Blueprint $table) {
            $table->enum('payment_status', ['00', '11', '22', '33'])
                  ->default('00')
                  ->comment('00=menunggu pembayaran, 11=sudah dibayar, 22=kadaluarsa, 33=cancel');
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
            $table->dropColumn('payment_status');
        });
    }
}

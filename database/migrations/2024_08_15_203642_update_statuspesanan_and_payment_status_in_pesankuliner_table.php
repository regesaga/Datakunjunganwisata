<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatuspesananAndPaymentStatusInPesankulinerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update statuspemakaian column with ENUM and comment
        DB::statement("ALTER TABLE pesankuliner MODIFY COLUMN statuspesanan ENUM('00', '11', '22') DEFAULT '00' COMMENT '00=Belum terpakai, 11=Sudah terpakai, 22=Kadaluarsa'");

        // Update payment_status column with ENUM and comment
        DB::statement("ALTER TABLE pesankuliner MODIFY COLUMN payment_status ENUM('00', '11', '22', '33') DEFAULT '00' COMMENT '00=menunggu pembayaran, 11=sudah dibayar, 22=kadaluarsa, 33=cancel'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revert statuspemakaian column to previous state
        DB::statement("ALTER TABLE pesankuliner MODIFY COLUMN statuspemakaian ENUM('0', '1', '2') DEFAULT '0' COMMENT '0=Belum terpakai, 1=Sudah terpakai, 2=Kadaluarsa'");

        // Revert payment_status column to previous state
        DB::statement("ALTER TABLE pesankuliner MODIFY COLUMN payment_status ENUM('0', '1', '2', '3') DEFAULT '0' COMMENT '0=menunggu pembayaran, 1=sudah dibayar, 2=kadaluarsa, 3=cancel'");
    }
}
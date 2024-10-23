    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class StatustiketToPesantiket extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::table('pesantiket', function (Blueprint $table) {
                $table->enum('statuspemakaian',[00,11,22])->default(00);
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

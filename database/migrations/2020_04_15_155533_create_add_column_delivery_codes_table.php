<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateaddColumnDeliveryCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_codes', function (Blueprint $table) {
            $table->string('order_code')->nullable();
            $table->string('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_codes', function (Blueprint $table) {
            $table->dropColumn('order_code');
            $table->dropColumn('note');

        });
    }
}

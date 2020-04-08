<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string("code");
            $table->integer("deliveried_money");
            $table->integer("total_money");
            $table->bigInteger("customer_id");
            $table->datetime('time')->nullable();


            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('orders', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

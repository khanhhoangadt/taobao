<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateordersDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_deliveries', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger("order_id")->default(0);
            $table->bigInteger("delivery_code_id")->default(0);

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('orders_deliveries', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders_deliveries');
    }
}

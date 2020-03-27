<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatepricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id');
            $table->integer('qty');
            $table->integer('price');
            // Add some more columns

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('prices', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}

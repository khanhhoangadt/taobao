<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatedeliveryCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->float('weight')->nullable();
            $table->bigInteger("customer_id")->default(0);
            $table->bigInteger("staff_id")->default(0);
            $table->integer('status')->default(1);
            // Add some more columns

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('delivery_codes', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_codes');
    }
}

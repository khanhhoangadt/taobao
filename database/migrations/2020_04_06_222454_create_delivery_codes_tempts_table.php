<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreatedeliveryCodesTemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_codes_tempts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable();
            $table->string('code')->nullable();

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('delivery_codes_tempts', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_codes_tempts');
    }
}

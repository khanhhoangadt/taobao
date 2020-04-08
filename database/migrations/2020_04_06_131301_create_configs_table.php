<?php

use Illuminate\Database\Schema\Blueprint;
use \App\Database\Migration;

class CreateconfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('value');

            $table->timestamps();
        });

        $this->updateTimestampDefaultValue('configs', ['updated_at'], ['created_at']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}

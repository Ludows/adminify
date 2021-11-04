<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormTraces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_traces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('label');
            $table->bigInteger('form_id')->unsigned();
            $table->datetime('send_time');
            $table->foreign('form_id')->references('id')->on('forms');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_traces');
    }
}
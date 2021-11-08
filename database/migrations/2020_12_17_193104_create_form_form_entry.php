<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFormEntry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_form_entry', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('trace_id')->unsigned();
            $table->bigInteger('form_entries_id')->unsigned();
            $table->foreign('trace_id')->references('id')->on('form_traces');
            $table->foreign('form_entries_id')->references('id')->on('form_entries');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_form_entry');
    }
}

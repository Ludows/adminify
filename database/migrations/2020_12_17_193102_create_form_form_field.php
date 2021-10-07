<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFormField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_form_field', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('form_id')->unsigned();
            $table->string('validation_name');
            $table->bigInteger('form_field_id')->unsigned();
            $table->foreign('form_id')->references('id')->on('forms');
            $table->foreign('form_field_id')->references('id')->on('form_fields');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_form_field');
    }
}
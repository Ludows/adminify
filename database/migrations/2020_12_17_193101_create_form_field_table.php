<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('site-settings.multilang') == true) {
            Schema::create('form_fields', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->json('label');
                $table->boolean('required');
                $table->string('max_length');
                $table->boolean('label_show');
                $table->string('label_attr');
                $table->string('attr');
                $table->string('wrapper');
                $table->timestamps();
            });
        }
        else {
            Schema::create('form_fields', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('label');
                $table->boolean('required');
                $table->string('max_length');
                $table->boolean('label_show');
                $table->string('label_attr');
                $table->string('attr');
                $table->string('wrapper');
                $table->timestamps();
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_fields');
    }
}

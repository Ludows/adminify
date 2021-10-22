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
                $table->string('field_type');
                $table->boolean('expanded');
                $table->boolean('multiple');
                $table->boolean('required');
                $table->json('selected');
                $table->json('custom_error_message');
                $table->json('content');
                $table->boolean('checked');
                $table->string('max_length');
                $table->json('choices');
                $table->json('value');
                $table->json('default_value');
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
                $table->string('field_type');
                $table->boolean('expanded');
                $table->boolean('multiple');
                $table->longText('custom_error_message');
                $table->longText('content');
                $table->boolean('required');
                $table->json('selected');
                $table->boolean('checked');
                $table->string('value');
                $table->string('default_value');
                $table->json('choices');
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

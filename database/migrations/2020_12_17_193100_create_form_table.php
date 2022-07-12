<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('site-settings.multilang') == true) {
            Schema::create('forms', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->json('title');
                $table->json('slug');
                $table->string('model_class');
                $table->bigInteger('user_id')->default(0)->unsigned();
                $table->timestamps();
            });
        }
        else {
            Schema::create('forms', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('title');
                $table->string('slug');
                $table->string('model_class');
                $table->bigInteger('user_id')->default(0)->unsigned();
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
        Schema::dropIfExists('forms');
    }
}

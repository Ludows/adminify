<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('urls');
        
        if(config('site-settings.multilang') == true) {
            Schema::create('urls', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('model_name', 255);
                $table->bigInteger('model_id');
                $table->timestamps();
            });
        }
        else {
            Schema::create('urls', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('model_name', 255);
                $table->bigInteger('model_id');
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
        Schema::dropIfExists('urls');
    }
}

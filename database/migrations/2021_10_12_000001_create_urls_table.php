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
        
        Schema::create('urls', function (Blueprint $table) {
            $table->string('from_model', 255);
            $table->string('from_model_id', 255);
            $table->string('model_name', 255);
            $table->bigInteger('model_id');
            $table->bigInteger('order');
            $table->boolean('is_homepage');
            $table->boolean('is_blogpage');
            $table->timestamps();
        });
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

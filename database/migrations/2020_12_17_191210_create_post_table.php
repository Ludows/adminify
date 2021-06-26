<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if(config('site-settings.multilang') == true) {
            Schema::create('posts', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->timestamps();
                $table->json('title');
                $table->json('slug');
                $table->json('content')->nullable();
                $table->bigInteger('media_id')->default(0)->unsigned();
            });
        }
        else {
            Schema::create('posts', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->timestamps();
                $table->string('title', 255);
                $table->string('slug', 255);
                $table->json('content')->nullable();
                $table->bigInteger('media_id')->default(0)->unsigned();
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
        Schema::dropIfExists('posts');
    }
}

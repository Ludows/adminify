<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('site-settings.multilang') == true) {
            Schema::create('categories', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->json('title');
                $table->json('slug');
                $table->bigInteger('media_id')->default(0)->unsigned();
                $table->bigInteger('parent_id')->default(0)->unsigned();
                $table->bigInteger('user_id')->default(0)->unsigned();
                $table->timestamps();
            });
        }
        else {
            Schema::create('categories', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('title', 255);
                $table->string('slug', 255);
                $table->bigInteger('media_id')->default(0)->unsigned();
                $table->bigInteger('parent_id')->default(0)->unsigned();
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
        Schema::dropIfExists('categories');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('site-settings.multilang') == true) {
            Schema::create('menu_items', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('model');
                $table->string('model_id')->default(null)->nullable();
                $table->string('type')->default(null)->nullable();
                $table->json('overwrite_title');
                $table->unsignedBigInteger('parent_id')->default(0);
                $table->bigInteger('media_id')->default(0)->unsigned();
                $table->string('class')->nullable();
                $table->boolean('open_new_tab')->default(false);
                // $table->integer('depth')->default(0);
                $table->timestamps();
            });
        }
        else {
            Schema::create('menu_items', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('model');
                $table->string('model_id')->default(null)->nullable();
                $table->string('type')->default(null)->nullable();
                $table->string('overwrite_title')->default(null)->nullable();
                $table->unsignedBigInteger('parent_id')->default(0);
                $table->bigInteger('media_id')->default(0)->unsigned();
                $table->string('class')->nullable();
                $table->boolean('open_new_tab')->default(false);
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
        Schema::dropIfExists('menu_items');
    }
}

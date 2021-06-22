<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('site-settings.multilang') == true) {
            Schema::create('menus', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->json('title');
                $table->json('slug');
                $table->timestamps();
            });
        }
        else {
            Schema::create('menus', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title');
                $table->string('slug');
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
        Schema::dropIfExists('menus');
    }
}

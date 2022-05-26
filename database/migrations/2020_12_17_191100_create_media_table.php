<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('site-settings.multilang') == true) {
            Schema::create('medias', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('src');
                $table->json('alt');
                $table->json('description');
                $table->bigInteger('user_id')->default(0)->unsigned();
                $table->timestamps();
            });
        }
        else {
            Schema::create('medias', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('src');
                $table->string('alt')->nullable();
                $table->text('description')->nullable();
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
        Schema::dropIfExists('medias');
    }
}

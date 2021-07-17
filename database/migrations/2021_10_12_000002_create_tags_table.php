<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tags');
        
        if(config('site-settings.multilang') == true) {
            Schema::create('tags', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->json('title');
                $table->json('slug');
                $table->timestamps();
            });
        }
        else {
            Schema::create('tags', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('title', 255);
                $table->string('slug', 255);
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
        Schema::dropIfExists('tags');
    }
}

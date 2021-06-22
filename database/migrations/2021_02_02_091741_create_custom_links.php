<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomLinks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('site-settings.multilang') == true) {
            Schema::create('custom_links', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->json('title');
                $table->json('slug');
                // $table->integer('depth')->default(0);
                $table->timestamps();
            });
        }
        else {
            Schema::create('custom_links', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title');
                $table->string('slug');
                // $table->integer('depth')->default(0);
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
        Schema::dropIfExists('custom_links');
    }
}

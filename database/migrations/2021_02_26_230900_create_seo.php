<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('site-settings.multilang') == true) {
            Schema::create('seo', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('model_name', 255);
                $table->bigInteger('model_id');
                $table->string('type', 255);
                $table->json('data', 255);
                $table->timestamps();
            });
        }
        else {
            Schema::create('seo', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('model_name', 255);
                $table->bigInteger('model_id');
                $table->string('type', 255);
                $table->string('data', 255);
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
        Schema::dropIfExists('seo');
    }
}

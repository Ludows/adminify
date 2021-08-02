<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('site-settings.multilang') == true) {
            Schema::create('pages', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->timestamps();
                $table->json('title');
                $table->json('slug');
                $table->json('content')->nullable();
                $table->bigInteger('media_id')->default(0)->unsigned();
                $table->bigInteger('parent_id')->unsigned()->default(0);
                $table->bigInteger('user_id')->default(0)->unsigned();
                $table->bigInteger('status_id')->unsigned();

            });
        }
        else {
            Schema::create('pages', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->timestamps();
                $table->string('title', 255);
                $table->string('slug', 255);
                $table->text('content')->nullable();
                $table->bigInteger('media_id')->default(0)->unsigned();
                $table->bigInteger('parent_id')->unsigned()->default(0);
                $table->bigInteger('user_id')->default(0)->unsigned();
                $table->bigInteger('status_id')->unsigned();
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
        Schema::dropIfExists('pages');
    }
}

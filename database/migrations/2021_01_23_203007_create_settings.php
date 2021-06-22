<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('site-settings.multilang') == true) {
            Schema::create('settings', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('type', 255);
                $table->json('data', 255);
                // $table->json('site_name');
                // $table->json('site_slogan');
                // $table->bigInteger('logo_id')->unsigned()->default(null);
                $table->timestamps();
            });
        }
        else {
            Schema::create('settings', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('type', 255);
                $table->string('data', 255);
                // $table->string('site_name')->default('');
                // $table->string('site_slogan')->default('');
                // $table->bigInteger('logo_id')->unsigned()->default(null);
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
        Schema::dropIfExists('settings');
    }
}

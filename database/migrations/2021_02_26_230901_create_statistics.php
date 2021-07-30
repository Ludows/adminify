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

        // url 
        // type => event / view 
        // eventName => null,
        // browser
        // browser version
        // navigator type
        // date

        Schema::create('statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url', 255);
            $table->string('type', 255);
            $table->string('event_name', 255)->nullable();
            $table->string('browser', 255);
            $table->string('browser_version', 255);
            $table->string('device_type', 255);
            $table->date('visited_at');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistics');
    }
}

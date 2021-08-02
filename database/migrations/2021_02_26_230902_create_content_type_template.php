<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentTypeTemplate extends Migration
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

        Schema::create('content_type_template', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('content')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('content_type_template');
    }
}

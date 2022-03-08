<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupMetasTable extends Migration
{
    public function up()
    {
        Schema::create('groupmetas', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->timestamps();
            if(config('site-settings.multilang') == true) {
                $table->json('title');
                $table->json('slug');
            }
            else {
                $table->string('title', 255);
                $table->string('slug', 255);
            }
            $table->string('named_class', 255);
            $table->string('view_name', 255);
            $table->bigInteger('user_id')->unsigned();
        });
    }

    public function down()
    {
        Schema::dropIfExists('groupmetas');
    }
}
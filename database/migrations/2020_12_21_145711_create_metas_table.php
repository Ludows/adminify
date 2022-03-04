<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMetasTable extends Migration
{
    public function up()
    {
        Schema::create('metas', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('key');
            if(config('site-settings.multilang') == true) {
                $table->json('value');
            }
            else {
                $table->text('value');
            }
            $table->string('model_type');
            $table->integer('model_id')->unsigned();
        });
    }

    public function down()
    {
        Schema::dropIfExists('metas');
    }
}
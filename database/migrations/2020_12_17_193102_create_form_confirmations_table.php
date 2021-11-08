<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormConfirmationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(config('site-settings.multilang') == true) {
            Schema::create('form_confirmations', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('type'); //page , redirect, samepage
                $table->bigInteger('page_id')->nullable()->unsigned();
                $table->string('redirect_url')->nullable();
                $table->json('content');
                $table->timestamps();
            });
        }
        else {
            Schema::create('form_confirmations', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->string('type');
                $table->bigInteger('page_id')->nullable()->unsigned();
                $table->string('redirect_url')->nullable();
                $table->string('content');
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
        Schema::dropIfExists('form_confirmations');
    }
}

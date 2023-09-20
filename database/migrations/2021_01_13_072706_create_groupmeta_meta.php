<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupMetaMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupmeta_meta', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('groupmeta_id')->unsigned();
            $table->bigInteger('meta_id')->unsigned();
            $table->foreign('groupmeta_id')->references('id')->on('groupmetas');
            $table->foreign('meta_id')->references('id')->on('metas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupmeta_meta');
    }
}

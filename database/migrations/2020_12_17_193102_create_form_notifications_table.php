<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('form_notifications', function (Blueprint $table) {
                $table->bigIncrements('id')->unsigned();
                $table->boolean('active')->default(0);
                $table->string('send_to');
                $table->string('expeditor_name');
                $table->string('expeditor_mail');
                $table->string('respond_to');
                $table->string('cci');
                $table->timestamps();
            });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_notifications');
    }
}

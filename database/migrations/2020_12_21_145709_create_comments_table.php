<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            
            if(config('site-settings.multilang') == true) {
                $table->json('comment');
            }
            else {
                $table->string('comment', 255);
            }
            $table->bigInteger('parent_id')->unsigned()->default(0);
            $table->bigInteger('model_id')->unsigned();
            $table->string('model_class', 255);
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->boolean('is_moderated')->default(false);
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
        Schema::dropIfExists('comments');
    }
}

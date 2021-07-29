<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailTemplatesTable extends Migration
{
    public function up()
    {

        if(config('site-settings.multilang') == true) {
            Schema::create('mail_templates', function (Blueprint $table) {
                $table->increments('id');
                $table->string('mailable');
                $table->json('subject');
                $table->json('html_template');
                $table->longtext('text_template')->nullable();
                $table->timestamps();
            });
        }
        else {
            Schema::create('mail_templates', function (Blueprint $table) {
                $table->increments('id');
                $table->string('mailable');
                $table->text('subject')->nullable();
                $table->longtext('html_template');
                $table->longtext('text_template')->nullable();
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
        Schema::dropIfExists('mail_templates');
    }
}